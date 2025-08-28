<?php

namespace App\Services;

use App\Models\Content as Model;
use App\Models\Relation;
use App\Models\Text;
use App\Models\File;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\Report;

class Content
{
    use Report;
    protected Model $model;
    protected $content;
    protected ?string $type = null;
    protected bool $getIndex = false;
    protected int $limit = 25;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public static function make()
    {
        return new static();
    }

    public function type(?string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function index($request = null)
    {
        $request = $request ?? request();
        $this->getIndex = true;
        $type = $this->type;
        return $this->model->when($type, function ($query) {
            $query->where('type', $this->type);
        })->select('contents.*')->distinct();
    }

    public function getIndex()
    {
        if (!$this->getIndex) {
            $this->index();
        }
        return $this->model;
    }

    public function find($id)
    {
        return $this->getIndex()->with('relations')->with('parents')->findOrFail($id);
    }

    public function createText($label, $text, $lang, $is_main = false)
    {
        return $this->content->setText([
            "label" => $label,
            "text" => $text,
            "lang" => $lang,
            'is_main' => $is_main
        ]);
    }

    public function createTexts(array $data)
    {
        if (isset($data['texts']) && isset($data['lang']))
            collect($data['texts'])->map(function ($item) use ($data) {
                $type = collect(types())->where('type', $data['type'])->first();
                return $this->createText($item['label'], $item['text'], $data['lang'], array_keys($type['label'])[0] == $item['label']);
            });
    }

    public function createPrice(array $data)
    {
        $this->content->setPrice([
            "price" => $data['price'] ?? 0,
            "currency" => $data['currency'] ?? defaultCurrency(),
            "discount" => $data['discount'] ?? 0,
        ]);
    }

    public function createFile(array $files = [])
    {
        $this->content->setFiles($files);
    }

    public function removeInfo()
    {
        Text::where('content_id', $this->content->id)->delete();
        Price::where('content_id', $this->content->id)->delete();
        File::where('content_id', $this->content->id)->update([
            "content_id" => null
        ]);
    }

    public function update(Model $content, array $data)
    {
        DB::transaction(function () use ($data, $content) {
            $content->update([
                'type' => $data['type'] ?? $content['type'],
                'stock' => $data['stock'] ?? $content['stock'],
                'status' => $data['status'] ?? $content['status'],
            ]);
            $this->content = $content;
            $this->removeInfo();
            $this->createTexts($data);
            $this->createPrice($data);
            $this->createFile($data['files'] ?? []);
            $this->createRelations($data['relations'] ?? []);
            siteSetting()['afterContentUpdate']($this->content);
        });
        return $this->content;
    }

    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            $this->content = $this->model->create([
                'type' => $data['type'],
                'stock' => $data['stock'] ?? 0,
                'status' => $data['status'],
            ]);
            $this->createTexts($data);
            $this->createPrice($data);
            $this->createFile($data['files'] ?? []);
            $this->createRelations($data['relations'] ?? []);
            siteSetting()['afterContentStore']($this->content);
        });
        return $this;
    }

    public function getId()
    {
        return $this->content->id;
    }

    public function createRelations(array $data)
    {
        $sync = collect();
        foreach ($data as $value => $keys) {
            foreach ($keys as $key) {
                if ($key != $this->content->id && !Relation::where('child_id', $key)->where('parent_id', $this->content->id)->exists()) {
                    $sync->push([
                        "type" => $value,
                        "parent_id" => $key
                    ]);
                }
            }
        }
        return $this->content->parents()->sync($sync->toArray());
    }

    public function show()
    {
        $this->content;
        $this->content->texts;
        $this->content->prices;
        $this->content->files;
        $this->parse($this->content);
        return $this->content;
    }

    public function relations(int $id)
    {
        $result = $this->
            model->
            join('relations', 'relations.parent_id', '=', 'contents.id')->
            where('contents.id', $id)->
            select('contents.*');
        return $result->count() > 0 ? $result->get() : [];
    }

    public function parse($content)
    {
        $type = collect(types())->where('type', $content->type)->first();
        $labels = $type['label'] ?? [];
        $files = $type['files'] ?? [];
        $info = [];
        $info['type_name'] = $type['name'];
        $info['type_title'] = null;
        $info['media'] = [];
        $info['type_icon'] = asset('/assets/images/placeholder.png');
        foreach ($labels as $label => $key) {
            $info[$label] = null;
        }
        foreach ($files as $file) {
            $info[$file] = asset('/assets/images/placeholder.png');
        }
        if (isset($type['price']) && $type['price'] == true) {
            $info['price'] = 0;
            $info['currency'] = defaultCurrency();
            $info['discount'] = 0;
            $info['final_price'] = 0;
        }
        foreach ($content->texts as $text) {
            if (isset($labels) && isset(array_keys($labels)[0]) && array_keys($labels)[0] == $text->label) {
                $info['type_title'] = $text->text;
            }
            $info[$text->label] = $text->text;
        }
        foreach ($content->prices as $price) {
            $info['price'] = (int) $price->price;
            $info['currency'] = $price->currency;
            $info['currency_label'] = collect(currencies())->where('currency', $price->currency)->first()['name'];
            $info['discount'] = $price->discount;
            $info['final_price'] = $price->price - ($price->price * $price->discount / 100);
        }
        foreach ($content->files as $file) {
            $info[$file->type] = $file->link;
        }
        $info['created_at'] = [
            'date' => siteSetting()['dateFunction']($content->created_at)->format('Y-m-d'),
            'time' => siteSetting()['dateFunction']($content->created_at)->format('H:i:s'),
        ];

        return $info;
    }

    public function deleteRelation(int $parent_id = null, int $child_id = null)
    {
        return Relation::when($child_id, function ($query) use ($child_id) {
            $query->where('child_id', $child_id);
        })->when($parent_id, function ($query) use ($parent_id) {
            $query->where('parent_id', $parent_id);
        })->delete();
    }

    public function delete(int $id)
    {
        return DB::transaction(function () use ($id) {
            //$this->deleteRelation($id);
            $find = $this->model->findOrFail($id);
            siteSetting()['afterContentDelete']($find);
            $find->delete();
        });
    }

}

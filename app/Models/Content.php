<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Text;
use App\Traits\Price;
use App\Traits\File;
use App\Services\Content as ContentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use Text, Price, File, SoftDeletes;

    protected $table = "contents";

    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected $fillable = [
        "type",
        "status",
        "stock"
    ];

    public function getPriceAttribute($price)
    {
        return (int) $price;
    }

    protected $appends = ["info", "status_message"];

    public function getStatusMessageAttribute()
    {
        return trans("message." . $this->status);
    }

    public function children()
    {
        return $this->belongsToMany(
            Content::class,
            'relations',
            'parent_id',
            'child_id'
        )->where('contents.type', 'category');
    }

    public function parents()
    {
        return $this->belongsToMany(
            Content::class,
            'relations',
            'child_id',
            'parent_id'
        )->where('contents.type', 'category');
    }

    public function relations()
    {
        return $this->children()->with('relations');
    }

    public function allChildren()
    {
        $all = collect();

        $this->load('children');
        foreach ($this->children as $child) {
            $all->push($child);
            $all = $all->merge($child->allChildren());
        }

        return $all;
    }

    public function getInfoAttribute()
    {
        return app(ContentService::class)->parse($this);
    }

    protected function scopeFilter(Builder $query, ?Request $request = null): void
    {
        $request = $request ?? request();
        $type = $request->type;
        $status = $request->status;
        $parent = $request->parent;

        $query
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($parent, function ($query) use ($parent) {
                $query->parent()->with('relations');
            })
        ;
    }

    protected function scopeAdminSort(Builder $query, ?Request $request = null): void
    {
        $request = $request ?? request();
        try {
            $order = [$request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir']];
            switch ($order[0]) {
                case 'info.type_title':
                    $order[0] = 'texts.text';
                    break;
                case 'status_message':
                    $order[0] = 'status';
                    break;
                case 'info.type_name':
                    $order[0] = 'type';
                    break;
                case 'info.created_at.date':
                    $order[0] = 'created_at';
                    break;
                case 'info.created_at.time':
                    $order[0] = 'created_at';
                    break;
                case 'info.final_price':
                    $order[0] = 'price';
                    $query
                        ->addSelect('prices.price')
                        ->join('prices', 'prices.content_id', '=', 'contents.id');
                    break;
                default:
                    $order[0] = 'id';
            }
        } catch (\Exception $e) {
            $order = ['id', 'asc'];
        }
        $query->orderBy($order[0], $order[1]);
    }

    protected function scopeWithTexts(Builder $query)
    {
        $query->addSelect('texts.text')->distinct()->join('texts', function ($join) {
            $join->on('contents.id', '=', 'texts.content_id')->where('texts.is_main', true);
        });
    }

    protected function scopeAdminSearch(Builder $query, ?Request $request = null): void
    {
        $request = $request ?? request();
        try {
            $search = $request->search['value'];
        } catch (\Exception $e) {
            $search = null;
        }
        $query->where('texts.text', 'like', "%$search%");
    }

    protected function scopeAdminPaginate(Builder $query, ?Request $request = null)
    {
        $request = $request ?? request();
        $start = $request->start;
        $length = $request->length;

        $query->offset($start)->limit($length);
    }

    protected function scopeParent(Builder $query): void
    {
        $query->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('relations')
                ->whereColumn('relations.child_id', 'contents.id');
        });
    }

    protected function scopePublish(Builder $query, $status = "publish"): void
    {
        $query->where('status', $status);
    }

}

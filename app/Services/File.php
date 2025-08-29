<?php

namespace App\Services;

use App\Models\File as Model;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class File
{
    public Model $model;
    public $result;
    protected $file;
    protected string $path;
    protected string $type;
    protected array $info;
    protected string $baseFolder = 'public/assets';
    protected $content;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function type(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function file($file)
    {
        $this->file = $file;
        $this->info = [
            "format" => $this->file->getClientOriginalExtension(),
            "mime" => $this->file->getMimeType(),
            "size" => $this->file->getSize()
        ];
        return $this;
    }

    public function optimize()
    {
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize(storage_path('app/' . $this->path));
        return $optimizerChain;
    }

    public function save()
    {
        $this->path = $this->file->store('images');
        return $this->path;
    }

    public function delete()
    {
        Storage::disk(siteSetting()['storage_driver'])->delete($this->path);
    }

    public function move()
    {
        $path = Str::uuid() . '.' . $this->file->getClientOriginalExtension();
        /*
        $this->file->move(storage_path('app/' . $this->baseFolder), $path);
        $this->delete();
        */
        $folder = siteSetting()['storage_folder'] . "/assets/images";
        Storage::disk(siteSetting()['storage_driver'])->put("$folder/$path", file_get_contents($this->file->getRealPath()));
        $this->path = $path;
        return $this->path;
    }

    public function create()
    {
        $this->result = $this->model->create(
            array_merge($this->info, [
                "type" => $this->type,
                "path" => $this->path
            ])
        );
        return $this->result;
    }


    public function remove(string $path)
    {
        $find = $this->model->where('path', $path)->first();
        $this->result = $find;
        $find->delete();
        return $this->result;
    }

    public function destroy(string $path)
    {
        $this->path = "public_html/assets/images/$path";
        $this->remove($path);
        $this->delete();
        return $this;
    }

    public function store()
    {
        //$this->save();
        //$this->optimize();
        $this->move();
        $this->create();
        return $this;
    }

}

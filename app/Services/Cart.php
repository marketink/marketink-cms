<?php

namespace App\Services;

use App\Models\Cart as Model;
use App\Models\Relation;
use App\Models\Text;
use App\Models\File;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\Report;

class Cart
{
    use Report;
    protected Model $model;
    protected $content;
    protected ?string $type = null;
    protected bool $getIndex = false;
    protected int $limit = 25;
    public array $where = [];

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

    public function where($col, $oper, $value){
        $this->where = collect($this->where)->push([$col, $oper, $value])->toArray();
        return $this;
    }

    public function find($id)
    {
        return $this->getIndex()->with('user')->with('address')->findOrFail($id);
    }

    
}

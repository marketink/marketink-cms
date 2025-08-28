<?php

namespace App\Traits;

use App\Models\Text as Model;

trait Text 
{
    public function texts(){
        return $this->morphMany(Model::class, 'content');
    }   

    public function setText(array $data){
        $this->texts()->create($data);
    }

}

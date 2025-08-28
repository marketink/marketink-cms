<?php

namespace App\Traits;

use App\Models\Price as Model;

trait Price 
{
    public function prices(){
        return $this->morphMany(Model::class, 'content');
    }   

    public function setPrice(array $data){
        $this->prices()->create($data);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    protected $table = "setting";

    public function getOptionAttribute($option){
        return $option ? json_decode($option) : null;
    }

}

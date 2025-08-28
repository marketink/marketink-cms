<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    protected $table = "relations";

    protected $fillable = [
        "parent_id",
        "child_id",
        "type"
    ];
}

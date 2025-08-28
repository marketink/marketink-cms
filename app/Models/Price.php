<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = "prices";

    protected $fillable = [
        'currency',
        'price',
        'discount'
    ];

    protected $hidden = [
        "content_type",
        "content_id",
        "created_at",
        "updated_at",
        "id"
    ];

}

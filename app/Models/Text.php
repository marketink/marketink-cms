<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $table = "texts";

    protected $fillable = [
        'label',
        'lang',
        'text',
        'is_main'
    ];

    protected $hidden = [
        "content_type",
        "content_id",
        "created_at",
        "updated_at",
        "id"
    ];

}

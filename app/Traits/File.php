<?php

namespace App\Traits;

use App\Models\File as Model;

trait File
{
    public function files()
    {
        return $this->morphMany(Model::class, 'content');
    }

    public function setFiles(array $keys)
    {
        return Model::whereIn('id', $keys)
            ->update([
                'content_type' => 'App\Models\Content',
                'content_id' => $this->id
            ]);
    }

}

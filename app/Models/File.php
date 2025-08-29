<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Text;
use App\Traits\Price;

class File extends Model
{
    use Text;
    use Price;
    protected $table = "files";

    protected $fillable = [
        "type",
        "path",
        "format",
        "mime",
        "size",
        'content_type',
        'content_id'
    ];
    
    protected $appends = ["link"];

    public function getLinkAttribute(){
        //return asset('/assets/images/' . $this->path);
        return siteSetting()['storage_url'] . '/' . $this->path;
    }
}

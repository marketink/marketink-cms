<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory,SoftDeletes;
	
    protected $guarded = [];
	protected $appends = ["trans_type", "trans_status", "trans_created_at"];
	
	public function getTransTypeAttribute(){
		return trans('message.' . $this->type);
	}
		
	public function getTransStatusAttribute(){
		return trans('message.' . $this->status);
	}
		
	public function getTransCreatedAtAttribute(){
		return siteSetting()['dateFunction']($this->created_at)->format('Y-m-d');
	}
	
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function statuses(){
        return $this->morphMany(Status::class, 'content');
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }
	
    public function user(){
        return $this->belongsTo(User::class);
    }
	
	
	
}

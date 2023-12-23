<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable=[
    	'name',
    	'region_code',
    	'description'];

    public function branch(){
        return $this->hasMany(Branch::class,'id','region_id');
    }  	
}

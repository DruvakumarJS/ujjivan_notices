<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
    	'action' ,
    	'user_id',
    	'module',
    	'operation',
        'track_id',
        'pan_india',
        'regions',
        'states',
        'branch'];

    public function user(){
	 return $this->belongsTo(User::class,'user_id', 'id');
    } 
}

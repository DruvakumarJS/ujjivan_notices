<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
    	'lang',
    	'name',
    	'code',
    	'font'
    ];

     public function notice(){
        return $this->hasMany(notice::class,'code','lang_code');
      }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonIdleDevice extends Model
{
    use HasFactory;

    protected $fillable=[
    	'mac_id',
    	'elapsed_time',
    	'temperature',
    	'app_version'
    ];
}

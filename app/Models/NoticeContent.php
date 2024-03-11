<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeContent extends Model
{
    use HasFactory;

    protected $fillable = [
    	'notice_id',
    	'template_id',
        'lang_code',
        'lang_name',
        'notice_group',
        'c11',
        'c12',
        'c13',
        'c14',

        'c21',
        'c22',
        'c23',
        'c24',

        'c31',
        'c32',
        'c33',
        'c34',

        'c41',
        'c42',
        'c43',
        'c44',

        'c51',
        'c52',
        'c53',
        'c54',

        'c61',
        'c62',
        'c63',
        'c64',
    ];

    public function noticeContent(){
        return $this->belongsTo(Notice::class,'notice_group','notice_group');
    }

     public function langauge(){
        return $this->belongsTo(Language::class,'notice_group','notice_group');
    } 
}

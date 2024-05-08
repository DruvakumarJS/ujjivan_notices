<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
            'name',
            'description',
            'path',
            'filename',
            'is_pan_india',
            'is_region_wise',
            'regions',
            'is_state_wise',
            'states',
            'branch_code',
            'status',
            'published_date',
            'expiry_date',
            'available_languages',
            'template_id',
            'creator',
            'voiceover',
            'lang_code',
            'lang_name',
            'notice_group',
            'notice_type',
            'version',
            'document_id'];

      public function noticeContent(){
        return $this->hasMany(NoticeContent::class,'notice_group','notice_group');
      } 

      public function langauge(){
        return $this->belongsTo(Language::class,'lang_code','code');
      } 

      public function branch(){
        return $this->belongsTo(Branch::class,'branch_code','id');
      }     
}

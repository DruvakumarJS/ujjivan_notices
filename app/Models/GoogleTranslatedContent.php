<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleTranslatedContent extends Model
{
    use HasFactory;

    protected $fillable = [
    	'language',
    	'lang_code',
    	'original_content',
    	'temp_conetnt',
    	'final_content',
    	'character_count',
    	'translated_by',
        'initial_characters',
        'final_characters',
    	'reviewer_email',
    	'status'];
}

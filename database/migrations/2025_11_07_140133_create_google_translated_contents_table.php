<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleTranslatedContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_translated_contents', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->string('lang_code');
            $table->longText('original_content');
            $table->longText('temp_conetnt');
            $table->integer('character_count');
            $table->longText('final_content');
            $table->integer('initial_characters')->nullable();
            $table->integer('final_characters')->nullable();
            $table->string('translated_by');
            $table->string('reviewer_email');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('google_translated_contents');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('language_code', 10);
            $table->longText('token')->nullable();
            $table->longText('translated_content')->nullable();
            $table->integer('character_count');
            $table->string('userID');
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
        Schema::dropIfExists('translation_logs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('path');
            $table->string('filename');
            $table->string('is_pan_india');
            $table->string('is_region_wise')->nullable();
            $table->string('regions')->nullable();
            $table->string('is_state_wise')->nullable();
            $table->string('states')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('status');
            $table->string('published_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('available_languages');
            $table->string('template_id')->nullable();
            $table->string('creator');
            $table->string('voiceover');
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
        Schema::dropIfExists('notices');
    }
}

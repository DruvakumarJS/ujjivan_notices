<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoticeGroupColToNoticeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notice_contents', function (Blueprint $table) {
            $table->string('lang_code');
            $table->string('lang_name');
            $table->string('notice_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notice_contents', function (Blueprint $table) {
            //
        });
    }
}

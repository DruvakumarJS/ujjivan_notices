<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeContentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_content_histories', function (Blueprint $table) {
            
            $table->id();
            $table->integer('notice_id');
            $table->integer('template_id');
            $table->longText('c11')->nullable();
            $table->longText('c12')->nullable();
            $table->longText('c13')->nullable();
            $table->longText('c14')->nullable();

            $table->longText('c21')->nullable();
            $table->longText('c22')->nullable();
            $table->longText('c23')->nullable();
            $table->longText('c24')->nullable();

            $table->longText('c31')->nullable();
            $table->longText('c32')->nullable();
            $table->longText('c33')->nullable();
            $table->longText('c34')->nullable();

            $table->longText('c41')->nullable();
            $table->longText('c42')->nullable();
            $table->longText('c43')->nullable();
            $table->longText('c44')->nullable();

            $table->longText('c51')->nullable();
            $table->longText('c52')->nullable();
            $table->longText('c53')->nullable();
            $table->longText('c54')->nullable();

            $table->longText('c61')->nullable();
            $table->longText('c62')->nullable();
            $table->longText('c63')->nullable();
            $table->longText('c64')->nullable();

            $table->string('lang_code');
            $table->string('lang_name');
            $table->string('notice_group');
            
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
        Schema::dropIfExists('notice_content_histories');
    }
}

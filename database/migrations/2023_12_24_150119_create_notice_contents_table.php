<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('notice_id');
            $table->integer('template_id');
            $table->string('c11')->nullable();
            $table->string('c12')->nullable();
            $table->string('c13')->nullable();
            $table->string('c14')->nullable();

            $table->string('c21')->nullable();
            $table->string('c22')->nullable();
            $table->string('c23')->nullable();
            $table->string('c24')->nullable();

            $table->string('c31')->nullable();
            $table->string('c32')->nullable();
            $table->string('c33')->nullable();
            $table->string('c34')->nullable();

            $table->string('c41')->nullable();
            $table->string('c42')->nullable();
            $table->string('c43')->nullable();
            $table->string('c44')->nullable();

            $table->string('c51')->nullable();
            $table->string('c52')->nullable();
            $table->string('c53')->nullable();
            $table->string('c54')->nullable();

            $table->string('c61')->nullable();
            $table->string('c62')->nullable();
            $table->string('c63')->nullable();
            $table->string('c64')->nullable();
            
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
        Schema::dropIfExists('notice_contents');
    }
}

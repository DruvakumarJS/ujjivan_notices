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
            $table->text('c11')->nullable();
            $table->text('c12')->nullable();
            $table->text('c13')->nullable();
            $table->text('c14')->nullable();

            $table->text('c21')->nullable();
            $table->text('c22')->nullable();
            $table->text('c23')->nullable();
            $table->text('c24')->nullable();

            $table->text('c31')->nullable();
            $table->text('c32')->nullable();
            $table->text('c33')->nullable();
            $table->text('c34')->nullable();

            $table->text('c41')->nullable();
            $table->text('c42')->nullable();
            $table->text('c43')->nullable();
            $table->text('c44')->nullable();

            $table->text('c51')->nullable();
            $table->text('c52')->nullable();
            $table->text('c53')->nullable();
            $table->text('c54')->nullable();

            $table->text('c61')->nullable();
            $table->text('c62')->nullable();
            $table->text('c63')->nullable();
            $table->text('c64')->nullable();
            
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankingOmbudsmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banking_ombudsments', function (Blueprint $table) {
            $table->id();
            $table->string('state')->nullable();
            $table->string('lang_code')->nullable();
            $table->string('banking_ombudsment')->nullable();
            $table->string('banking_ombudsment_name')->nullable();
            $table->string('center')->nullable();
            $table->string('center_name')->nullable();
            $table->text('area')->nullable();
            $table->text('area_name')->nullable();
            $table->text('address')->nullable();
            $table->text('full_address')->nullable();
            $table->string('tel')->nullable();
            $table->string('tel_number')->nullable();
            $table->string('fax')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('email')->nullable();
            $table->string('email_id')->nullable();
            $table->string('toll_free')->nullable();
            $table->string('toll_free_number')->nullable();
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
        Schema::dropIfExists('banking_ombudsments');
    }
}

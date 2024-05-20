<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_information', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('bm_name')->nullable();
            $table->string('bm_number')->nullable();
            $table->string('bm_email')->nullable();
            $table->string('bm_designation')->nullable();
            $table->string('bo_name')->nullable();
            $table->string('bo_number')->nullable();
            $table->string('bo_email')->nullable();
            $table->string('bo_designation')->nullable();
            $table->string('medical')->nullable();
            $table->string('ambulance')->nullable();
            $table->string('fire')->nullable();
            $table->string('police')->nullable();
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
        Schema::dropIfExists('branch_information');
    }
}

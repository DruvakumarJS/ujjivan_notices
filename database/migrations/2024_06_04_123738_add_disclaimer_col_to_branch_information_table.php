<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisclaimerColToBranchInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_information', function (Blueprint $table) {
            $table->text('disclaimer1')->nullable();
            $table->text('disclaimer2')->nullable();
            $table->integer('announcement')->default('0');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_information', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->integer('region_id');
            $table->integer('branch_id');
            $table->integer('bank_id');
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('mac_id');
            $table->string('device_details')->nullable();
            $table->string('status')->nullable();
            $table->string('date_of_install')->nullable();
            $table->string('last_updated_date')->nullable();
            $table->string('apk_version')->nullable();
            $table->string('remote_id')->nullable();
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
        Schema::dropIfExists('devices');
    }
}

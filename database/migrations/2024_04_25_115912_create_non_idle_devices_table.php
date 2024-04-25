<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonIdleDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_idle_devices', function (Blueprint $table) {
            $table->id();
            $table->string('mac_id');
            $table->string('elapsed_time');
            $table->string('temperature')->nullable();
            $table->string('app_version');
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
        Schema::dropIfExists('non_idle_devices');
    }
}

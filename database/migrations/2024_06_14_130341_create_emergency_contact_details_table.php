<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyContactDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_contact_details', function (Blueprint $table) {
            $table->id();
            $table->text('branch_id');
            $table->text('lang_code');
            $table->text('police')->nullable();
            $table->text('police_contact')->nullable();
            $table->text('medical')->nullable();
            $table->text('medical_contact')->nullable();
            $table->text('ambulance')->nullable();
            $table->text('ambulance_contact')->nullable();
            $table->text('fire')->nullable();
            $table->text('fire_contact')->nullable();
            $table->text('manager')->nullable();
            $table->text('manager_contact')->nullable();
            $table->text('rno')->nullable();
            $table->text('rno_contact')->nullable();
            $table->text('pno')->nullable();
            $table->text('pno_contact')->nullable();
            $table->text('contact_center')->nullable();
            $table->text('contact_center_number')->nullable();
            $table->text('cyber_dost')->nullable();
            $table->text('cyber_dost_number')->nullable();
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
        Schema::dropIfExists('emergency_contact_details');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Whatsapp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('whatsapp', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('msidn')->nullable();
            $table->string('doctor_diagnosis')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('hids')->nullable();
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
        //

                Schema::dropIfExists('whatsapp');

    }
}

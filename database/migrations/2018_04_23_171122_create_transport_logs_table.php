<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location_name');
            $table->string('client_name');
            $table->string('equipment');
            $table->boolean('equipment_secured');
            $table->string('signature');
            $table->timestamp('date');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('facility_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('facility_id')->references('id')->on('facilities');
            $table->softDeletes();
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
        Schema::dropIfExists('transport_logs');
    }
}

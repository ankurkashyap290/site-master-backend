<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_billing_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location_name');
            $table->string('client_name');
            $table->string('destination_type');
            $table->string('transport_type');
            $table->string('equipment');
            $table->integer('mileage_to_start');
            $table->integer('mileage_to_end');
            $table->integer('mileage_return_start');
            $table->integer('mileage_return_end');
            $table->float('fee', 8, 2);
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
        Schema::dropIfExists('transport_billing_logs');
    }
}

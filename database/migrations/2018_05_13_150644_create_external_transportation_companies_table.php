<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalTransportationCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_transportation_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('color_id');
            $table->text('emails');
            $table->string('phone')->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->integer('facility_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
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
        Schema::table('external_transportation_companies', function (Blueprint $table) {
            $table->dropForeign('external_transportation_companies_location_id_foreign');
            $table->dropForeign('external_transportation_companies_facility_id_foreign');
        });
        Schema::dropIfExists('external_transportation_companies');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveTimezoneFromOrganizationsToFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->string('timezone')->after('name')->default('America/Los_Angeles');
        });

        DB::statement(
            'UPDATE facilities SET timezone = (SELECT timezone from organizations where id = facilities.organization_id)'
        );

        Schema::table('organizations', function (Blueprint $table) {
           $table->dropColumn('timezone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('timezone')->default('America/Los_Angeles');
        });

        DB::statement(
            'UPDATE organizations SET timezone = (SELECT timezone FROM facilities WHERE organization_id = organizations.id LIMIT 1)'
        );

        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn('timezone');
        });
    }
}

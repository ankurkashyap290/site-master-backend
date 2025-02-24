<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeUniqueEmailWithDeletedAtInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropForeign('password_resets_email_foreign');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->unique(['email', 'deleted_at']);
        });

        Schema::table('password_resets', function (Blueprint $table) {
            $table->foreign('email')->references('email')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropForeign('password_resets_email_foreign');
        });

        Schema::table('users', function (Blueprint $table) {
            //$table->dropUnique(['email', 'deleted_at']);
            $table->unique('email');
        });

        Schema::table('password_resets', function (Blueprint $table) {
            $table->foreign('email')->references('email')->on('users');
        });
    }
}

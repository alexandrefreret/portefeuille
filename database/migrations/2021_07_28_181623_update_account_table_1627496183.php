<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAccountTable1627496183 extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->table('account', function (Blueprint $table) {
            $table->unsignedInteger("account_user");
        });

        // Adding foreign keys
        Schema::connection('mysql')->table('account', function (Blueprint $table) {
            $table->foreign('account_user')->references('user_id')->on('user');
        });
    }

    public function down()
    {
        Schema::connection('mysql')->table('account', function (Blueprint $table) {
            Schema::connection('mysql')->disableForeignKeyConstraints();
            $table->dropForeign(['account_user']);
            Schema::connection('mysql')->enableForeignKeyConstraints();
            $table->dropColumn('user');
        });
    }
}

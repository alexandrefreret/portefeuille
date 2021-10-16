<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePairTable1628674104 extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->table('pair', function (Blueprint $table) {
            $table->unsignedInteger("pair_account");
        });

        // Adding foreign keys
        Schema::connection('mysql')->table('pair', function (Blueprint $table) {
            $table->foreign('pair_account')->references('account_id')->on('account');
        });
    }

    public function down()
    {
        Schema::connection('mysql')->table('pair', function (Blueprint $table) {
            Schema::connection('mysql')->disableForeignKeyConstraints();
            $table->dropForeign(['pair_account']);
            Schema::connection('mysql')->enableForeignKeyConstraints();
            $table->dropColumn('account');
        });
    }
}

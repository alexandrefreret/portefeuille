<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesPairAccountConfigurationTables1627499583 extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->create('trades', function (Blueprint $table) {
            $table->increments("trades_id");
            $table->timestamp("trades_inserted")->useCurrent();
            $table->timestamp("trades_updated")->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->boolean("trades_valide")->index(true)->default(true);
            $table->decimal("trades_amount", 14, 8);
            $table->decimal("trades_fees_amount", 14, 8);
            $table->decimal("trades_pru", 14, 8);
            $table->decimal("trades_qte", 14, 8);
            $table->boolean("trades_direction")->default(1);
            $table->unsignedInteger("trades_pair");
            $table->unsignedInteger("trades_user");
        });

        Schema::connection('mysql')->create('pair', function (Blueprint $table) {
            $table->increments("pair_id");
            $table->timestamp("pair_inserted")->useCurrent();
            $table->timestamp("pair_updated")->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->boolean("pair_valide")->index(true)->default(true);
            $table->string("pair_name");
            $table->string("pair_position");
            $table->unsignedInteger("pair_user");
        });

        Schema::connection('mysql')->table('account_configuration', function (Blueprint $table) {
            $table->decimal("accountconfiguration_fees", 10, 4)->change();
        });

        // Adding foreign keys
        Schema::connection('mysql')->table('trades', function (Blueprint $table) {
            $table->foreign('trades_pair')->references('pair_id')->on('pair');
            $table->foreign('trades_user')->references('user_id')->on('user');
        });
        Schema::connection('mysql')->table('pair', function (Blueprint $table) {
            $table->foreign('pair_user')->references('user_id')->on('user');
        });
    }

    public function down()
    {
        Schema::connection('mysql')->table('account_configuration', function (Blueprint $table) {
            $table->decimal("accountconfiguration_fees", 10, 2)->change();
        });

        Schema::connection('mysql')->disableForeignKeyConstraints();
        Schema::connection('mysql')->drop('trades');
        Schema::connection('mysql')->enableForeignKeyConstraints();

        Schema::connection('mysql')->disableForeignKeyConstraints();
        Schema::connection('mysql')->drop('pair');
        Schema::connection('mysql')->enableForeignKeyConstraints();
    }
}

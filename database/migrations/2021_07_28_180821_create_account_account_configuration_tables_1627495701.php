<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountAccountConfigurationTables1627495701 extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->create('account', function (Blueprint $table) {
            $table->increments("account_id");
            $table->timestamp("account_inserted")->useCurrent();
            $table->timestamp("account_updated")->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->boolean("account_valide")->index(true)->default(true);
            $table->string("account_name");
            $table->decimal("account_fees", 10, 2);
            $table->string("account_type");
        });

        Schema::connection('mysql')->create('account_configuration', function (Blueprint $table) {
            $table->increments("accountconfiguration_id");
            $table->timestamp("accountconfiguration_inserted")->useCurrent();
            $table->timestamp("accountconfiguration_updated")->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->boolean("accountconfiguration_valide")->index(true)->default(true);
            $table->string("accountconfiguration_title");
            $table->decimal("accountconfiguration_fees", 10, 2);
            $table->enum("accountconfiguration_type", ["pourcentage", "numeraire"]);
        });
    }

    public function down()
    {
        Schema::connection('')->disableForeignKeyConstraints();
        Schema::connection('')->drop('account');
        Schema::connection('')->enableForeignKeyConstraints();

        Schema::connection('')->disableForeignKeyConstraints();
        Schema::connection('')->drop('account_configuration');
        Schema::connection('')->enableForeignKeyConstraints();
    }
}

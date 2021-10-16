<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTradesTable1628674533 extends Migration
{
    public function up()
    {
        Schema::connection('mysql')->table('trades', function (Blueprint $table) {
            $table->dropColumn('trades_amount');
        });
    }

    public function down()
    {
        Schema::connection('mysql')->table('trades', function (Blueprint $table) {
            $table->decimal("trades_amount", 14, 8);
        });
    }
}

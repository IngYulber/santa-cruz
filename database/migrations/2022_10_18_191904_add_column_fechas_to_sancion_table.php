<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFechasToSancionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sancion', function (Blueprint $table) {
            $table->tinyInteger('dias_sancion');
            $table->boolean('estado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sancion', function (Blueprint $table) {
            $table->dropColumn('dias_sancion');
            $table->dropColumn('estado');
        });
    }
}

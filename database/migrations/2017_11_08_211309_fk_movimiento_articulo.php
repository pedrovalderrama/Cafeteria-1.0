<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FkMovimientoArticulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento_articulos', function (Blueprint $table) {
            $table->foreign('idProductos')->references('idProductos')->on('productos');
            $table->foreign('Local')->references('idLocales')->on('locals');
            $table->foreign('RutProveedor')->references('id')->on('proveedors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimiento_articulos', function (Blueprint $table) {
            //
        });
    }
}

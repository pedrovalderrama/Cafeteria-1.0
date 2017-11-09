<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FkMovimientoVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento_ventas', function (Blueprint $table) {
            $table->foreign('NumeroVentas')->references('NumeroVentas')->on('ventas');
            $table->foreign('idProductos')->references('idProductos')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimiento_ventas', function (Blueprint $table) {
            //
        });
    }
}

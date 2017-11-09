<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FkMovimientoCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimiento_compras', function (Blueprint $table) {
            $table->foreign('NumeroCompra')->references('NumeroCompra')->on('compras');
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
        Schema::table('movimiento_compras', function (Blueprint $table) {
            //
        });
    }
}

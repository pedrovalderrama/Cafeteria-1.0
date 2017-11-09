<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('NumeroVentas')->unsigned();
            $table->integer('idProductos')->unsigned();
            $table->integer('Cantidad');
            $table->integer('Precio');
            $table->integer('SubTotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimiento_ventas');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_articulos', function (Blueprint $table) {
            $table->increments('idMovArt');
            $table->integer('idProductos')->unsigned();
            $table->dateTime('Fecha');
            $table->string('TipoMov',1);
            $table->integer('Numero');
            $table->integer('Cantidad');
            $table->integer('Precio');
            $table->integer('Local')->unsigned();
            $table->integer('RutProveedor')->unsigned();
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
        Schema::dropIfExists('movimiento_articulos');
    }
}

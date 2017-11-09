<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_compras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('NumeroCompra')->unsigned();
            $table->integer('idProductos')->unsigned();
            $table->integer('Cantidad');
            $table->integer('Costo');
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
        Schema::dropIfExists('movimiento_compras');
    }
}

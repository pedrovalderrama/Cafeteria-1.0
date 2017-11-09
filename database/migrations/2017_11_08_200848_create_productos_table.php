<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('idProductos');
            $table->string('CodigoBarra',25);
            $table->string('Descripcion',100);
            $table->string('UMedida',20);
            $table->integer('Precio1');
            $table->integer('Precio2');
            $table->integer('Precio3');
            $table->integer('Precio4');
            $table->integer('Cantidad');
            $table->integer('StockMinimo');
            $table->integer('Costo');
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
        Schema::dropIfExists('productos');
    }
}

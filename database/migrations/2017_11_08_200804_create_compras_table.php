<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('NumeroCompra'); 
            $table->dateTime('Fecha');
            $table->integer('RutProveedor')->unsigned();
            $table->integer('Neto');
            $table->integer('Iva');
            $table->integer('Adicional');
            $table->integer('Total');
            $table->integer('Local');
            






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
        Schema::dropIfExists('compras');
    }
}

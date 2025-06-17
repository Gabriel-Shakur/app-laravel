<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();

            $table->string('codigo');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->text('imagen')->nullable();
            $table->integer('stock');
            $table->integer('stock_minimo');
            $table->integer('stock_maximo');
            $table->decimal('precio_compra',8,2);
            $table->decimal('precio_venta',8,2);
            $table->date('fecha_ingreso');

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');


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

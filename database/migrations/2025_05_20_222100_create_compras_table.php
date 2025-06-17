<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();

            $table->date('fecha');
            $table->string('comprobante');
            $table->decimal('precio_total',8,2);
            

           

            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('proveedores_id');
            $table->foreign('proveedores_id')->references('id')->on('proveedores')->onDelete('cascade');
           

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

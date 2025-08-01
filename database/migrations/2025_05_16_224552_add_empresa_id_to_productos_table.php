<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpresaIdToProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('productos', function (Blueprint $table) {
        $table->unsignedBigInteger('empresa_id')->after('categoria_id');

          // Si tienes una tabla `empresas` relacionada:
          $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
   {
       Schema::table('productos', function (Blueprint $table) {
          $table->dropForeign(['empresa_id']);
          $table->dropColumn('empresa_id');
        });
   }
}

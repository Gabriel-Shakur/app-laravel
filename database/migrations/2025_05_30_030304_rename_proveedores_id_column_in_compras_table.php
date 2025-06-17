<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameProveedoresIdColumnInComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   {
      Schema::table('compras', function (Blueprint $table) {
          $table->renameColumn('proveedores_id', 'proveedor_id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
          $table->renameColumn('proveedor_id', 'proveedor_id');
        });
    }
}

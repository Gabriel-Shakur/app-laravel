<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSesionIdToSessionIdInTmpComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tmp_compras', function (Blueprint $table) {
           $table->renameColumn('sesion_id', 'session_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('tmp_compras', function (Blueprint $table) {
          $table->renameColumn('session_id', 'sesion_id');
        });
    }
}

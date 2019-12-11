<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inter_entradas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('cod_prod');
            $table->float('qtd', 6, 2)->default(0);
            $table->string('un_medida');
            $table->float('preco', 6, 2);
            $table->string('ean')->nullable();
            $table->string('ncm')->nullable();
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
        Schema::dropIfExists('inter_entradas');
    }
}

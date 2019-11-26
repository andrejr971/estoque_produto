<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstoqueGeralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque_geral', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descricao');
            $table->string('cod_item');
            $table->string('ean_item')->nullable();
            $table->string('ncm_item')->nullable();
            $table->string('estante')->nullable();
            $table->string('un_medida');
            $table->integer('qtd');
            $table->integer('estoque_min');
            $table->integer('estoque_max');
            $table->float('vol')->nullable();
            $table->string('espessura')->nullable();
            $table->integer('largura')->nullable();
            $table->integer('altura')->nullable();
            $table->float('area')->nullable();
            $table->integer('reservado')->nullable();
            $table->integer('pedido')->nullable();
            $table->float('metragem')->nullable();
            $table->float('preco');
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
        Schema::dropIfExists('estoque_geral');
    }
}

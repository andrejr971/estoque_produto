<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaSaidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_saidas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estoque_geral_id');
            $table->foreign('estoque_geral_id')->references('id')->on('estoque_geral');
            $table->unsignedBigInteger('fornecedor_id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->float('qtd', 8, 2);
            $table->unsignedBigInteger('tipo_estoque_id');
            $table->foreign('tipo_estoque_id')->references('id')->on('tipo_estoques');
            $table->enum('situacao', ['0', '1']);
            $table->string('nota')->nullable();
            $table->string('nfe')->nullable();
            $table->integer('dia');
            $table->integer('mes');
            $table->integer('ano');
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
        Schema::dropIfExists('entrada_saidas');
    }
}

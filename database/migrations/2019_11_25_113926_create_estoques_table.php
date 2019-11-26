<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstoquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoques', function (Blueprint $table) {
            $table->unsignedBigInteger('fornecedor_id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->unsignedBigInteger('estoque_geral_id');
            $table->foreign('estoque_geral_id')->references('id')->on('estoque_geral');
            $table->unsignedBigInteger('tipo_estoque_id');
            $table->foreign('tipo_estoque_id')->references('id')->on('tipo_estoques');
            $table->primary(['fornecedor_id', 'estoque_geral_id']);
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
        Schema::dropIfExists('estoques');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstoqueProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque_produtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('estoque_geral_id')->nullable();
            $table->foreign('estoque_geral_id')->references('id')->on('estoque_geral');
            $table->string('nome')->nullable();
            $table->string('descricao')->nullable();
            $table->unsignedBigInteger('fornecedor_id')->nullable();
            $table->string('descricao')->nullable();
            $table->float('qtdItem')->default(0);
            $table->float('qtd')->default(0);
            $table->float('largura')->nullable();
            $table->float('altura')->nullable();
            $table->float('profundidade')->nullable();
            $table->double('preco');
            $table->string('un_medida');
            $table->integer('estoque')->default(0);
            $table->float('larguraMaterial')->nullable();
            $table->float('alturaMaterial')->nullable();
            $table->float('profundidadeMaterial')->nullable();
            $table->timestamps();

            $table->foreign('produto_id')->references('id')
                    ->on('produtos');
            $table->foreign('fornecedor_id')->references('id')
                    ->on('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estoque_produtos');
    }
}

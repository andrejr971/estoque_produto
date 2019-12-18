<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('preco', 8, 2)->nullable();
            $table->string('descricao');
            $table->string('img01');
            $table->string('img02')->nullable();
            $table->integer('quantidade');
            $table->integer('posicao')->default(0);
            $table->string('sku')->nullable();
            $table->text('observacao')->nullable();
            $table->integer('qtd_entregue')->default('0');
            $table->unsignedBigInteger('orcamento_id')->nullable();
            $table->unsignedBigInteger('categoria_produto_id');
            $table->unsignedBigInteger('tipo_produto_id');
            $table->timestamps();

            $table->foreign('orcamento_id')->references('id')->on('orcamentos');
            $table->foreign('categoria_produto_id')->references('id')->on('categoria_produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->boolean('is_pedido')->default(false);
            $table->string('frete')->nullable();
            $table->string('desconto')->nullable();
            $table->string('sti')->nullable();
            $table->unsignedBigInteger('tipo_orcamento_id');
            $table->foreign('tipo_orcamento_id')->references('id')->on('tipo_orcamentos');
            $table->unsignedBigInteger('status_orcamento_id');
            $table->foreign('status_orcamento_id')->references('id')->on('status_orcamentos');
            $table->text('observacao')->nullable();
            $table->date('novo_pedido_em')->nullable();
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
        Schema::dropIfExists('orcamentos');
    }
}

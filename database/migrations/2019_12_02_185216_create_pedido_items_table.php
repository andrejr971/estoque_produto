<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pedido_estoque_id');
            $table->foreign('pedido_estoque_id')->references('id')->on('pedido_estoques');
            $table->unsignedBigInteger('estoque_geral_id');
            $table->foreign('estoque_geral_id')->references('id')->on('estoque_geral');
            $table->integer('qtd')->default(1);
            $table->decimal('valor', 6, 2)->default(0);
            $table->enum('status', ['RE','EN','CL','CP','FP','OK']);
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
        Schema::dropIfExists('pedido_items');
    }
}

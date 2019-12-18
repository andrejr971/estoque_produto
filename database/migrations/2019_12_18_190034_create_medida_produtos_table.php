<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedidaProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medida_produtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('largura')->nullable();
            $table->string('altura')->nullable();
            $table->string('profundidade')->nullable();
            $table->unsignedBigInteger('produto_id');
            $table->timestamps();

            $table->foreign('produto_id')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medida_produtos');
    }
}

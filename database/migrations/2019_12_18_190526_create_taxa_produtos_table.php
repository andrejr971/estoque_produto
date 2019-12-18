<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxaProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxa_produtos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ipi')->nullable();
            $table->string('frete')->nullable();
            $table->string('markup');
            $table->unsignedBigInteger('produto_id');

            $table->foreign('produto_id')->references('id')->on('produtos');
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
        Schema::dropIfExists('taxa_produtos');
    }
}

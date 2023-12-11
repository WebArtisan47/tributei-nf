<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosSaidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_saidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->bigInteger('pedido_id');
            $table->string('ipi')->nullable();
            $table->string('cOutro')->nullable();
            $table->string('produto_id');
            $table->string('quantidade')->nullable();
            $table->string('vDescC')->nullable();
            $table->string('vDescIC')->nullable();
            $table->string('vFrete')->nullable();
            $table->string('vICMS')->nullable();
            $table->string('vSeg')->nullable();
            $table->string('vUnit')->nullable();
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
        Schema::dropIfExists('pedidos_saidas');
    }
}

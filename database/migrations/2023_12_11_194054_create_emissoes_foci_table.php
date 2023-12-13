<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmissoesFociTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emissoes_foci', function (Blueprint $table) {
           
                $table->id();
                $table->string('empresa');
                $table->string('fornecedor');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('pedido_id');
                $table->string('ref');
                $table->string('status')->nullable();
                $table->text('mensagem')->nullable();
                $table->string('link_xml')->nullable();
                $table->string('link_danfe')->nullable();
                $table->timestamps();
    
                // Relacionamentos (se necessário)
                $table->foreign('user_id')->references('id')->on('users');
                // Adicione mais relacionamentos conforme necessário
    
                // Índices (se necessário)
                $table->index('empresa');
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emissoes_foci');
    }
}

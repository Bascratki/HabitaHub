<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcao_id')->references('id')->on('funcoes');
            $table->foreignId('empresa_id')->references('id')->on('empresas');
            $table->foreignId('usuario_id')->references('id')->on('usuarios');
            $table->foreignId('condominio_id')->references('id')->on('condominios')->nullable();
            $table->string('token');
            $table->date('ultimo_acesso');
            $table->enum('status', ['pendente', 'ativo', 'inativo'])->default('pendente');
            $table->timestamps();       
            $table->softDeletes();     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas_usuarios');
    }
};

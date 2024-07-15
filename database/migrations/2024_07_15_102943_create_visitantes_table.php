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
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartamento_id')->nullable()->references('id')->on('apartamentos');
            $table->foreignId('condominio_id')->references('id')->on('unidades');
            $table->string('nome');
            $table->enum('tipo', ['visitante', 'prestador']);
            $table->enum('documento_tipo', ['cpf', 'rg']);
            $table->integer('documento_numero');
            $table->enum('stastus', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitantes');
    }
};

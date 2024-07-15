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
        Schema::create('visitantes_detalhes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitante_id')->references('id')->on('visitantes');
            $table->date('data_entrada');
            $table->date('data_saida');
            $table->string('descrição');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitantes_detalhes');
    }
};

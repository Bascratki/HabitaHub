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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->nullable()->references('id')->on('apartments');
            $table->foreignId('condominium_id')->references('id')->on('condominiums');
            $table->string('name');
            $table->enum('type', ['visitor', 'provider']);
            $table->enum('document_type', ['cpf', 'rg']);
            $table->integer('document_number');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};

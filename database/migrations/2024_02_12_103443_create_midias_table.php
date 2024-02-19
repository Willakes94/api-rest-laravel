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
        Schema::create('midias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->foreignId('empresa_id')->constrained()->onDelete('cascade');
            $table->foreignId('terminal_id')->constrained()->onDelete('cascade');
            $table->string('categoria');
            $table->string('path_imagem')->nullable();
            $table->string('path_video')->nullable();
            $table->string('orientacao'); // Horizontal ou Vertical
            $table->time('horario_inicio_exibicao')->nullable();
            $table->time('horario_fim_exibicao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midias');
    }
};

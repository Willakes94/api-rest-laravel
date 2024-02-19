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
        Schema::create('terminais', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Obrigatório
            $table->foreignId('empresa_id')->constrained()->onDelete('cascade');
            $table->string('segmento'); // Obrigatório
            $table->string('endereco');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('cep');
            $table->string('bairro');
            $table->string('estado');
            $table->string('cidade');
            $table->string('telefone1')->nullable();
            $table->string('telefone2')->nullable();
            $table->string('periodo_funcionamento');
            $table->string('dias_semana');
            $table->integer('fluxo_pessoas')->nullable();
            $table->string('orientacao_terminal'); // Horizontal ou Vertical
            $table->boolean('som_terminal')->default(false);
            $table->dateTime('ciclo_atualizacao'); // Obrigatório
            $table->string('fuso_horario');
            $table->string('status_terminal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminais');
    }
};

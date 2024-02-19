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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Obrigatório
            $table->string('nome_fantasia'); // Obrigatório
            $table->string('tipo_empresa'); // Física ou Jurídica
            $table->string('apelido')->nullable();
            $table->string('cpf_cnpj')->unique();
            $table->string('endereco');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('cep');
            $table->string('bairro');
            $table->string('estado');
            $table->string('cidade');
            $table->string('email')->unique();
            $table->string('telefone1')->nullable();
            $table->string('telefone2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};

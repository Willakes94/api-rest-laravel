<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidiaTerminalTable extends Migration
{
    public function up()
    {
        Schema::create('midia_terminal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('midia_id');
            $table->unsignedBigInteger('terminal_id');
            $table->timestamps();

            $table->foreign('midia_id')->references('id')->on('midias')->onDelete('cascade');
            $table->foreign('terminal_id')->references('id')->on('terminais')->onDelete('cascade');

            // Evita duplicatas para a mesma combinação de midia_id e terminal_id
            $table->unique(['midia_id', 'terminal_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('midia_terminal');
    }
}

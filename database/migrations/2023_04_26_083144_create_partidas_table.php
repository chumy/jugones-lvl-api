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
        Schema::create('Partides', function (Blueprint $table) {
            $table->uuid('partidaId')->primary();
            $table->datetime('data')->nullable();
            $table->integer('numJugadors')->nullable();
            $table->integer('bggId')->nullable();
            $table->string('organitzador');
            $table->tinyinteger('oberta')->default(1);
            $table->text('comentaris')->nullable();
            $table->timestamps();

            $table->foreign('bggId')->references('bggId')->on('Jocs');
            $table->foreign('organitzador')->references('uid')->on('Usuaris');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Partides');
    }
};

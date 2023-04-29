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
        Schema::create('Jocs', function (Blueprint $table) {
            $table->integer('bggId')->primary();
            $table->string('name');
            $table->tinyInteger('expansio')->default(0);
            $table->integer('minJugadors');
            $table->integer('maxJugadors')->nullable();
            $table->decimal('dificultat', 5, 4);
            $table->integer('duracio');
            $table->integer('edat');
            $table->string('imatge');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Jocs');
    }
};

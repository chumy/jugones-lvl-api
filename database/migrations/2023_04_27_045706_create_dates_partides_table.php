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
        Schema::create('DatesPartides', function (Blueprint $table) {
            $table->id('dataId');
            $table->string('partidaId');
            $table->datetime('data');
            $table->timestamps();

            $table->foreign('partidaId')->references('partidaId')->on('Partides')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DatesPartides');
    }
};

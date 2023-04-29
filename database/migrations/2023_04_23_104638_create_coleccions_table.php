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
        Schema::create('Coleccio', function (Blueprint $table) {
            $table->uuid(column : 'jocId')->primary();
            $table->string('joc');
            $table->integer('bggId')->nullable();
            $table->string('tipologia')->nullable();
            $table->string('ambit')->nullable();
            $table->text('comentaris')->nullable();
            $table->timestamps();

            //$table->foreign('bggId')->references('bggId')->on('Jocs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Coleccio');
    }
};

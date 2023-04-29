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
        Schema::create('Prestecs', function (Blueprint $table) {
            $table->uuid(column : 'prestecId')->primary();
            $table->string('uid');
            $table->string('jocId');
            $table->date('dataInici');
            $table->date('dataFi')->nullable();
            $table->text('comentaris')->nullable();
            $table->timestamps();

            $table->foreign('jocId')->references('jocId')->on('Coleccio');
            $table->foreign('uid')->references('uid')->on('Usuaris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Prestecs');
    }
};

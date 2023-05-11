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
        Schema::create('DatesParticipants', function (Blueprint $table) {
            $table->unsignedBigInteger('dataId');
            $table->string('uid');
            $table->timestamps();

            $table->primary(['dataId', 'uid']);
            $table->foreign('dataId')->references('dataId')->on('DatesPartides')->onDelete('cascade');
            $table->foreign('uid')->references('uid')->on('Usuaris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DatesParticipants');
    }
};

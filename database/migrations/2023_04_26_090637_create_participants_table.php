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
        Schema::create('Participants', function (Blueprint $table) {
            $table->string('partidaId');
            $table->string('soci');
            $table->tinyinteger('propietario')->default(0);
            $table->tinyinteger('explicador')->default(0);
            $table->tinyinteger('need_explicacion')->default(0);
            $table->timestamps();

            $table->primary(['partidaId', 'soci']);
            $table->foreign('partidaId')->references('partidaId')->on('Partides')->onDelete('cascade');
            $table->foreign('soci')->references('uid')->on('Usuaris');
        

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};

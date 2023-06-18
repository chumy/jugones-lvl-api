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
        Schema::create('Usuaris', function (Blueprint $table) {
            $table->uuid(column : 'uid')->primary();
            $table->string('displayName');
            $table->string('email')->unique();
            /*$table->timestamp('email_verified_at')->nullable();
            $table->string('password');*/
            $table->integer('rol')->default(0);
            $table->string('photoURL')->nullable();
            $table->string('parella')->nullable();
            $table->boolean('avisos')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Usuaris');
    }
};

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
    Schema::create('bahasa_pemrograman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_instruktur')->constrained('users')->onDelete('cascade');
        $table->string('nama_bahasa');
        $table->text('deskripsi')->nullable();
        $table->boolean('status')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahasa_pemrogramen');
    }
};

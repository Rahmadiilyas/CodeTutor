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
    Schema::create('jawaban_pelajar', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_pengerjaan')->constrained('pengerjaan_evaluasi')->onDelete('cascade');
        $table->foreignId('id_soal')->constrained('soal')->onDelete('cascade');
        $table->foreignId('id_pilihan')->nullable()->constrained('pilihan_jawaban')->onDelete('set null');
        $table->text('jawaban_teks')->nullable();
        $table->boolean('benar')->nullable();
        $table->integer('nilai')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_pelajars');
    }
};

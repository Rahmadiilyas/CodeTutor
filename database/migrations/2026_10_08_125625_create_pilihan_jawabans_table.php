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
    Schema::create('pilihan_jawaban', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_soal')->constrained('soal')->onDelete('cascade');
        $table->text('teks_pilihan');
        $table->boolean('adalah_jawaban_benar')->default(false);
        $table->integer('urutan')->default(0);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilihan_jawabans');
    }
};

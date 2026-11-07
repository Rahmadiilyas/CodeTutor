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
    Schema::create('soal', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_evaluasi')->constrained('evaluasi')->onDelete('cascade');
        $table->text('pertanyaan');
        $table->enum('jenis_soal', ['pilihan_ganda', 'essay', 'coding']);
        $table->integer('bobot')->default(10);
        $table->integer('urutan')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soals');
    }
};

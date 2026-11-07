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
    Schema::create('evaluasi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_modul')->constrained('modul')->onDelete('cascade');
        $table->foreignId('id_instruktur')->constrained('users')->onDelete('cascade');
        $table->string('judul_evaluasi');
        $table->enum('jenis_evaluasi', ['pretest', 'kuis', 'posttest']);
        $table->text('deskripsi')->nullable();
        $table->integer('nilai_minimal')->default(70);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};

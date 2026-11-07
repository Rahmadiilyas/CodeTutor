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
    Schema::create('sertifikat', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_pelajar')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_instruktur')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_modul')->constrained('modul')->onDelete('cascade');
        $table->string('judul_sertifikat');
        $table->string('nomor_sertifikat')->unique();
        $table->date('tanggal_terbit');
        $table->string('lokasi_file')->nullable();
        $table->string('status')->default('terbit');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
    }
};

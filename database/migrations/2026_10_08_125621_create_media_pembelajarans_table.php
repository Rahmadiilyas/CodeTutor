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
    Schema::create('media_pembelajaran', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_materi')->constrained('materi')->onDelete('cascade');
        $table->string('judul_media');
        $table->enum('jenis_media', ['pdf', 'ppt', 'video', 'youtube', 'animasi', 'game', 'lainnya']);
        $table->string('lokasi_file')->nullable();
        $table->string('tautan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_pembelajarans');
    }
};

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
    Schema::create('materi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_modul')->constrained('modul')->onDelete('cascade');
        $table->string('judul_materi');
        $table->text('deskripsi')->nullable();
        $table->longText('isi_materi')->nullable();
        $table->integer('urutan')->default(0);
        $table->boolean('status')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};

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
    Schema::create('progres_belajar', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_pelajar')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_modul')->constrained('modul')->onDelete('cascade');
        $table->integer('total_materi')->default(0);
        $table->integer('materi_selesai')->default(0);
        $table->decimal('presentase_progres', 5, 2)->default(0);
        $table->string('status')->default('belum_mulai');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_belajar');
    }
};

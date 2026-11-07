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
    Schema::create('pengerjaan_evaluasi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_evaluasi')->constrained('evaluasi')->onDelete('cascade');
        $table->foreignId('id_pelajar')->constrained('users')->onDelete('cascade');
        $table->timestamp('waktu_mulai')->nullable();
        $table->timestamp('waktu_selesai')->nullable();
        $table->string('status')->default('belum_selesai');
        $table->integer('nilai')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengerjaan_evaluasis');
    }
};

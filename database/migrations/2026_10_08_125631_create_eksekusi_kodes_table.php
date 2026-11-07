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
    Schema::create('eksekusi_kode', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_pelajar')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_contoh_kode')->constrained('contoh_kode')->onDelete('cascade');
        $table->foreignId('id_bahasa')->constrained('bahasa_pemrograman')->onDelete('cascade');
        $table->longText('kode_program');
        $table->text('hasil_output')->nullable();
        $table->text('pesan_error')->nullable();
        $table->string('status_eksekusi')->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eksekusi_kodes');
    }
};

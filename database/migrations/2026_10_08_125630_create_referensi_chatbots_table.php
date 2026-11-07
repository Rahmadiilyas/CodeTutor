<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referensi_chatbot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_materi')->nullable()->constrained('materi')->onDelete('set null');
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->longText('jawaban_referensi');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referensi_chatbot');
    }
};
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferensiChatbot extends Model
{
    protected $table = 'referensi_chatbot';

    protected $fillable = [
        'id_materi', 'id_pengguna', 'pertanyaan', 'jawaban_referensi', 'status'
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }
}
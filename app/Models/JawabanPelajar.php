<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanPelajar extends Model
{
    protected $table = 'jawaban_pelajar';

    protected $fillable = [
        'id_pengerjaan', 'id_soal', 'id_pilihan', 'jawaban_teks', 'benar', 'nilai'
    ];

    public function pengerjaan()
    {
        return $this->belongsTo(PengerjaanEvaluasi::class, 'id_pengerjaan');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal');
    }

    public function pilihan()
    {
        return $this->belongsTo(PilihanJawaban::class, 'id_pilihan');
    }
}
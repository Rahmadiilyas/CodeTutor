<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PilihanJawaban extends Model
{
    protected $table = 'pilihan_jawaban';
    public $timestamps = false;

    protected $fillable = [
        'id_soal', 'teks_pilihan', 'adalah_jawaban_benar', 'urutan'
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'id_soal');
    }
}
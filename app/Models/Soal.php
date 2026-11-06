<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';

    protected $fillable = [
        'id_evaluasi', 'pertanyaan', 'jenis_soal', 'bobot', 'urutan'
    ];

    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class, 'id_evaluasi');
    }

    public function pilihan()
    {
        return $this->hasMany(PilihanJawaban::class, 'id_soal');
    }
}
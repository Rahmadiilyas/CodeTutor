<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengerjaanEvaluasi extends Model
{
    protected $table = 'pengerjaan_evaluasi';

    protected $fillable = [
        'id_evaluasi', 'id_pelajar', 'waktu_mulai', 'waktu_selesai', 'status', 'nilai'
    ];

    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class, 'id_evaluasi');
    }

    public function pelajar()
    {
        return $this->belongsTo(User::class, 'id_pelajar');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanPelajar::class, 'id_pengerjaan');
    }
}
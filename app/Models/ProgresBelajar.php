<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresBelajar extends Model
{
    protected $table = 'progres_belajar';

    protected $fillable = [
        'id_pelajar', 'id_modul', 'total_materi', 'materi_selesai', 'presentase_progres', 'status'
    ];

    public function pelajar()
    {
        return $this->belongsTo(User::class, 'id_pelajar');
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahasaPemrograman extends Model
{
    protected $table = 'bahasa_pemrograman';

    protected $fillable = [
        'id_instruktur', 'nama_bahasa', 'deskripsi', 'status'
    ];

    public function instruktur()
    {
        return $this->belongsTo(User::class, 'id_instruktur');
    }

    public function modul()
    {
        return $this->hasMany(Modul::class, 'id_bahasa');
    }

    public function contohKode()
    {
        return $this->hasMany(ContohKode::class, 'id_bahasa');
    }
}
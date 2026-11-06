<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'username', 'email', 'kata_sandi', 'peran', 'status', 'foto'
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    // Relasi
    public function bahasaPemrograman()
    {
        return $this->hasMany(BahasaPemrograman::class, 'id_instruktur');
    }

    public function modul()
    {
        return $this->hasMany(Modul::class, 'id_instruktur');
    }

    public function contohKode()
    {
        return $this->hasMany(ContohKode::class, 'id_instruktur');
    }

    public function evaluasi()
    {
        return $this->hasMany(Evaluasi::class, 'id_instruktur');
    }

    public function progresBelajar()
    {
        return $this->hasMany(ProgresBelajar::class, 'id_pelajar');
    }

    public function pengerjaanEvaluasi()
    {
        return $this->hasMany(PengerjaanEvaluasi::class, 'id_pelajar');
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'id_pelajar');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'id_user');
    }
}
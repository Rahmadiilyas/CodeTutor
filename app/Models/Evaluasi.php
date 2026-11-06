<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $table = 'evaluasi';

    protected $fillable = [
        'id_modul',
        'id_instruktur',
        'judul_evaluasi',
        'jenis_evaluasi',
        'deskripsi',
        'nilai_minimal',
    ];

    /**
     * Durasi disimpan sebagai metadata tersembunyi di kolom deskripsi yang sudah ada.
     * Format internal: <!--CODETUTOR_DURASI:60-->
     * Tidak membutuhkan kolom atau migration baru.
     */
    public function setDeskripsiDanDurasi(?string $deskripsi, int $durasiMenit): void
    {
        $teks = trim((string) $deskripsi);
        $durasiMenit = max(1, min(600, $durasiMenit));
        $metadata = "<!--CODETUTOR_DURASI:{$durasiMenit}-->";

        $this->attributes['deskripsi'] = $teks === ''
            ? $metadata
            : $teks . "\n" . $metadata;
    }

    /** Tampilkan deskripsi tanpa metadata durasi. */
    public function getDeskripsiAttribute($value): ?string
    {
        $teks = preg_replace(
            '/(?:\r?\n)?<!--CODETUTOR_DURASI:\d+-->\s*$/',
            '',
            (string) $value
        );

        $teks = trim((string) $teks);

        return $teks === '' ? null : $teks;
    }

    /**
     * Accessor virtual, bukan kolom database.
     * Evaluasi lama yang belum mempunyai metadata memakai default 60 menit.
     */
    public function getDurasiMenitAttribute(): int
    {
        $deskripsiMentah = (string) ($this->attributes['deskripsi'] ?? '');

        if (preg_match('/<!--CODETUTOR_DURASI:(\d+)-->\s*$/', $deskripsiMentah, $cocok)) {
            return max(1, min(600, (int) $cocok[1]));
        }

        return 60;
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'id_modul');
    }

    public function instruktur()
    {
        return $this->belongsTo(User::class, 'id_instruktur');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'id_evaluasi');
    }

    public function pengerjaan()
    {
        return $this->hasMany(PengerjaanEvaluasi::class, 'id_evaluasi');
    }
}

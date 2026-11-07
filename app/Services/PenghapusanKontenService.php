<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Menghapus satu modul atau satu bahasa beserta data turunannya.
 * Riwayat log_aktivitas tetap dipertahankan sebagai audit trail.
 */
class PenghapusanKontenService
{
    public function hapusModul(int $idModul, ?callable $sebelumHapus = null): void
    {
        $this->hapusBerdasarkanModul($idModul, null, $sebelumHapus);
    }

    public function hapusBahasa(int $idBahasa, ?callable $sebelumHapus = null): void
    {
        $this->hapusBerdasarkanModul(null, $idBahasa, $sebelumHapus);
    }

    /**
     * Penghapusan database dilakukan dalam satu transaksi.
     * File fisik dihapus setelah transaksi berhasil agar file tidak hilang
     * ketika transaksi database mengalami rollback.
     */
    private function hapusBerdasarkanModul(
        ?int $idModulTunggal,
        ?int $idBahasa,
        ?callable $sebelumHapus
    ): void {
        $daftarFile = DB::transaction(function () use (
            $idBahasa,
            $idModulTunggal,
            $sebelumHapus
        ) {
            if ($idBahasa !== null) {
                $modulIds = DB::table('modul')
                    ->where('id_bahasa', $idBahasa)
                    ->pluck('id');
            } else {
                $modulIds = collect([$idModulTunggal]);
            }

            $materiIds = DB::table('materi')
                ->whereIn('id_modul', $modulIds)
                ->pluck('id');

            $evaluasiIds = DB::table('evaluasi')
                ->whereIn('id_modul', $modulIds)
                ->pluck('id');

            $soalIds = DB::table('soal')
                ->whereIn('id_evaluasi', $evaluasiIds)
                ->pluck('id');

            $pengerjaanIds = DB::table('pengerjaan_evaluasi')
                ->whereIn('id_evaluasi', $evaluasiIds)
                ->pluck('id');

            $contohQuery = DB::table('contoh_kode')->where(function ($query) use ($idBahasa, $materiIds) {
                $adaKondisi = false;

                if ($idBahasa !== null) {
                    $query->where('id_bahasa', $idBahasa);
                    $adaKondisi = true;
                }

                if ($materiIds->isNotEmpty()) {
                    if ($adaKondisi) {
                        $query->orWhereIn('id_materi', $materiIds);
                    } else {
                        $query->whereIn('id_materi', $materiIds);
                    }
                    $adaKondisi = true;
                }

                if (!$adaKondisi) {
                    $query->whereRaw('1 = 0');
                }
            });

            $contohKodeIds = $contohQuery->pluck('id');

            $fileMedia = DB::table('media_pembelajaran')
                ->whereIn('id_materi', $materiIds)
                ->whereNotNull('lokasi_file')
                ->where('lokasi_file', '!=', '')
                ->pluck('lokasi_file')
                ->all();

            $fileSertifikat = DB::table('sertifikat')
                ->whereIn('id_modul', $modulIds)
                ->whereNotNull('lokasi_file')
                ->where('lokasi_file', '!=', '')
                ->pluck('lokasi_file')
                ->all();

            if ($sebelumHapus !== null) {
                $sebelumHapus();
            }

            // Hapus jawaban terlebih dahulu karena terhubung ke pengerjaan dan soal.
            if ($pengerjaanIds->isNotEmpty() || $soalIds->isNotEmpty()) {
                DB::table('jawaban_pelajar')->where(function ($query) use ($pengerjaanIds, $soalIds) {
                    if ($pengerjaanIds->isNotEmpty()) {
                        $query->whereIn('id_pengerjaan', $pengerjaanIds);
                    }

                    if ($soalIds->isNotEmpty()) {
                        if ($pengerjaanIds->isNotEmpty()) {
                            $query->orWhereIn('id_soal', $soalIds);
                        } else {
                            $query->whereIn('id_soal', $soalIds);
                        }
                    }
                })->delete();
            }

            DB::table('pilihan_jawaban')
                ->whereIn('id_soal', $soalIds)
                ->delete();

            DB::table('pengerjaan_evaluasi')
                ->whereIn('id', $pengerjaanIds)
                ->delete();

            DB::table('soal')
                ->whereIn('id', $soalIds)
                ->delete();

            DB::table('evaluasi')
                ->whereIn('id', $evaluasiIds)
                ->delete();

            DB::table('progres_belajar')
                ->whereIn('id_modul', $modulIds)
                ->delete();

            DB::table('sertifikat')
                ->whereIn('id_modul', $modulIds)
                ->delete();

            DB::table('media_pembelajaran')
                ->whereIn('id_materi', $materiIds)
                ->delete();

            // Saat modul saja yang dihapus, riwayat eksekusi tetap disimpan,
            // tetapi tautannya ke contoh kode yang dihapus dilepas.
            if (Schema::hasTable('eksekusi_kode')) {
                if ($idBahasa !== null && Schema::hasColumn('eksekusi_kode', 'id_bahasa')) {
                    DB::table('eksekusi_kode')
                        ->where('id_bahasa', $idBahasa)
                        ->delete();
                }

                if ($contohKodeIds->isNotEmpty() && Schema::hasColumn('eksekusi_kode', 'id_contoh_kode')) {
                    DB::table('eksekusi_kode')
                        ->whereIn('id_contoh_kode', $contohKodeIds)
                        ->update(['id_contoh_kode' => null]);
                }
            }

            DB::table('contoh_kode')
                ->whereIn('id', $contohKodeIds)
                ->delete();

            // Referensi chatbot yang terkait materi dibiarkan tersimpan;
            // foreign key id_materi pada tabel referensi_chatbot akan menjadi NULL.
            DB::table('materi')
                ->whereIn('id', $materiIds)
                ->delete();

            DB::table('modul')
                ->whereIn('id', $modulIds)
                ->delete();

            if ($idBahasa !== null) {
                DB::table('bahasa_pemrograman')
                    ->where('id', $idBahasa)
                    ->delete();
            }

            return [
                'media' => $fileMedia,
                'sertifikat' => $fileSertifikat,
            ];
        });

        foreach ($daftarFile['media'] as $path) {
            $this->hapusFileJikaAman($path, 'media-pembelajaran/', 'public');
        }

        foreach ($daftarFile['sertifikat'] as $path) {
            $this->hapusFileJikaAman($path, 'certificates/', 'local');
        }
    }

    private function hapusFileJikaAman(?string $path, string $folderYangDiizinkan, string $disk): void
    {
        $path = ltrim(str_replace('\\', '/', (string) $path), '/');

        if ($path === '' || !str_starts_with($path, $folderYangDiizinkan)) {
            return;
        }

        Storage::disk($disk)->delete($path);
    }
}

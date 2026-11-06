<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use App\Models\Sertifikat;
use App\Models\LogAktivitas;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class SertifikatController extends Controller
{
    private function pastikanPelajar(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'pelajar',
            403,
            'Halaman ini hanya dapat diakses oleh Pelajar.'
        );
    }

    public function index()
    {
        $this->pastikanPelajar();

        $sertifikat = Sertifikat::query()
            ->with(['modul.bahasa', 'instruktur'])
            ->where('id_pelajar', auth()->id())
            ->where('status', 'terbit')
            ->orderByDesc('tanggal_terbit')
            ->orderByDesc('id')
            ->get();

        return view('pelajar.sertifikat.index', compact('sertifikat'));
    }

    private function fileSertifikat(Sertifikat $sertifikat): string
    {
        abort_unless(
            (int) $sertifikat->id_pelajar === (int) auth()->id()
                && $sertifikat->status === 'terbit',
            404,
            'Sertifikat tidak ditemukan.'
        );

        $path = (string) $sertifikat->lokasi_file;
        abort_if(
            $path === ''
                || !str_starts_with($path, 'certificates/')
                || dirname($path) !== 'certificates'
                || str_contains($path, '..')
                || str_contains($path, '\\')
                || pathinfo($path, PATHINFO_EXTENSION) !== 'pdf',
            404,
            'File sertifikat tidak tersedia.'
        );

        abort_unless(
            Storage::disk('local')->exists($path),
            404,
            'File sertifikat tidak ditemukan pada penyimpanan.'
        );

        return $path;
    }

    public function preview(Sertifikat $sertifikat): BinaryFileResponse
    {
        $this->pastikanPelajar();
        $path = $this->fileSertifikat($sertifikat);
        $filename = Str::slug($sertifikat->judul_sertifikat ?: 'sertifikat') . '.pdf';

        return response()->file(Storage::disk('local')->path($path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function download(Sertifikat $sertifikat): BinaryFileResponse
    {
        $this->pastikanPelajar();
        $path = $this->fileSertifikat($sertifikat);
        $filename = Str::slug($sertifikat->judul_sertifikat ?: 'sertifikat') . '.pdf';

        try {
            LogAktivitas::create([
                'id_user' => auth()->id(),
                'jenis_aktivitas' => 'Unduh Sertifikat',
                'deskripsi' => 'Pelajar mengunduh sertifikat '
                    . $sertifikat->nomor_sertifikat
                    . ' untuk modul '
                    . ($sertifikat->modul->nama_modul ?? 'pembelajaran')
                    . '.',
                'entitas' => 'sertifikat',
                'id_entitas' => $sertifikat->id,
                'waktu_aktivitas' => now(),
            ]);
        } catch (Throwable $exception) {
            // Pencatatan aktivitas tidak boleh menggagalkan proses unduh.
            Log::warning('Pencatatan aktivitas unduh sertifikat gagal.', [
                'user_id' => auth()->id(),
                'sertifikat_id' => $sertifikat->id,
                'exception' => class_basename($exception),
            ]);
        }

        return response()->download(Storage::disk('local')->path($path), $filename, [
            'Content-Type' => 'application/pdf',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}

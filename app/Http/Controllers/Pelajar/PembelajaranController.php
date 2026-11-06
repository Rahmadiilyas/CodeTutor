<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use App\Models\BahasaPemrograman;
use App\Models\ProgresBelajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

use App\Models\LogAktivitas;
use App\Models\Materi;
use App\Models\Modul;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


class PembelajaranController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'pelajar',
            403,
            'Halaman pembelajaran hanya tersedia untuk Pelajar.'
        );

        $bahasa = BahasaPemrograman::query()
            ->where('status', true)
            ->with([
                'modul' => function ($modulQuery) {
                    $modulQuery
                        ->where('status', true)
                        ->orderBy('urutan')
                        ->orderBy('nama_modul')
                        ->with([
                            'materi' => function ($materiQuery) {
                                $materiQuery
                                    ->where('status', true)
                                    ->orderBy('urutan')
                                    ->orderBy('judul_materi')
                                    ->with(['media', 'contohKode']);
                            },
                        ]);
                },
            ])
            ->orderBy('nama_bahasa')
            ->get();

        $progressByModule = ProgresBelajar::query()
            ->where('id_pelajar', auth()->id())
            ->get()
            ->keyBy('id_modul');

        // Ambil materi yang benar-benar selesai dari log aktivitas Pelajar.
        // Data ini dipakai oleh Learning Path dan tombol status materi.
        $materiSelesaiIds = LogAktivitas::query()
            ->where('id_user', auth()->id())
            ->where('jenis_aktivitas', 'Materi Selesai')
            ->where('entitas', 'materi')
            ->whereNotNull('id_entitas')
            ->distinct()
            ->pluck('id_entitas')
            ->map(fn ($id) => (int) $id)
            ->all();

        $catalog = $bahasa->map(function ($itemBahasa) use ($progressByModule, $materiSelesaiIds) {
            $modules = $itemBahasa->modul->map(function ($modul) use ($progressByModule, $itemBahasa, $materiSelesaiIds) {
                $progressRecord = $progressByModule->get($modul->id);
                $totalMateri = $modul->materi->count();
                $materiSelesai = min(
                    $totalMateri,
                    max(0, (int) ($progressRecord->materi_selesai ?? 0))
                );

                $percentage = $progressRecord
                    ? max(0, min(100, (float) $progressRecord->presentase_progres))
                    : 0;

                $media = $modul->materi->flatMap(function ($materi) {
                    return $materi->media->map(function ($itemMedia) use ($materi) {
                        return [
                            'id' => $itemMedia->id,
                            'id_materi' => $materi->id,
                            'judul' => $itemMedia->judul_media,
                            'jenis' => $itemMedia->jenis_media,
                            'url' => $this->mediaUrl($itemMedia->tautan, $itemMedia->lokasi_file),
                        ];
                    });
                })->values();

                $materials = $modul->materi->map(function ($materi) use ($modul, $itemBahasa, $materiSelesaiIds) {
                    $examples = $materi->contohKode
                        ->where('id_bahasa', $itemBahasa->id)
                        ->map(function ($example) {
                            return [
                                'id' => $example->id,
                                'judul' => $example->judul,
                                'deskripsi' => $example->deskripsi ?? '',
                                'kode_program' => $example->kode_program ?? '',
                            ];
                        })->values();

                    return [
                        'id' => $materi->id,
                        'judul' => $materi->judul_materi,
                        'deskripsi' => $materi->deskripsi ?? '',
                        'isi' => $materi->isi_materi ?? '',
                        'urutan' => (int) $materi->urutan,
                        'selesai' => in_array((int) $materi->id, $materiSelesaiIds, true),
                        'media' => $materi->media->map(function ($itemMedia) {
                            return [
                                'id' => $itemMedia->id,
                                'judul' => $itemMedia->judul_media,
                                'jenis' => $itemMedia->jenis_media,
                                'url' => $this->mediaUrl($itemMedia->tautan, $itemMedia->lokasi_file),
                            ];
                        })->values(),
                        'contoh_kode' => $examples,
                    ];
                })->values();

                return [
                    'id' => $modul->id,
                    'nama' => $modul->nama_modul,
                    'deskripsi' => $modul->deskripsi ?? '',
                    'urutan' => (int) $modul->urutan,
                    'total_materi' => $totalMateri,
                    'materi_selesai' => $materiSelesai,
                    'progres' => $percentage,
                    'status_progres' => $progressRecord->status ?? 'belum_mulai',
                    'materi' => $materials,
                ];
            })->values();

            return [
                'id' => $itemBahasa->id,
                'nama' => $itemBahasa->nama_bahasa,
                'deskripsi' => $itemBahasa->deskripsi ?? '',
                'editor_language' => $this->editorLanguage($itemBahasa->nama_bahasa),
                'modul' => $modules,
            ];
        })->values();

        $selectedBahasaId = (int) $request->query(
            'bahasa',
            (int) ($catalog->first()['id'] ?? 0)
        );
        $selectedBahasa = $catalog->firstWhere('id', $selectedBahasaId)
            ?? $catalog->first();

        $requestedModulId = (int) $request->query(
            'modul',
            (int) ($selectedBahasa['modul'][0]['id'] ?? 0)
        );
        $selectedModul = collect($selectedBahasa['modul'] ?? [])
            ->firstWhere('id', $requestedModulId)
            ?? collect($selectedBahasa['modul'] ?? [])->first();

        $requestedMateriId = (int) $request->query(
            'materi',
            (int) ($selectedModul['materi'][0]['id'] ?? 0)
        );
        $selectedMateri = collect($selectedModul['materi'] ?? [])
            ->firstWhere('id', $requestedMateriId)
            ?? collect($selectedModul['materi'] ?? [])->first();

        return view('materi', compact(
            'catalog',
            'selectedBahasa',
            'selectedModul',
            'selectedMateri'
        ));
    }

    private function mediaUrl(?string $tautan, ?string $lokasiFile): ?string
    {
        if ($tautan && filter_var($tautan, FILTER_VALIDATE_URL)) {
            $scheme = strtolower((string) parse_url($tautan, PHP_URL_SCHEME));
            if (in_array($scheme, ['http', 'https'], true)) {
                return $tautan;
            }
        }

        if ($lokasiFile) {
            $path = ltrim(str_replace('\\', '/', $lokasiFile), '/');
            if ($path !== '' && !str_contains($path, '..')) {
                return Storage::disk('public')->url($path);
            }
        }

        return null;
    }

    private function editorLanguage(string $name): ?string
    {
        $normalized = strtolower(trim($name));
        $normalized = preg_replace('/[^a-z0-9+#.]/', '', $normalized);

        return match ($normalized) {
            'java' => 'java',
            'python', 'python3' => 'python',
            'javascript', 'js', 'nodejs' => 'javascript',
            'php' => 'php',
            'c++', 'cpp' => 'cpp',
            'c' => 'c',
            'c#', 'csharp' => 'csharp',
            'dart' => 'dart',
            'go', 'golang' => 'go',
            'kotlin', 'kt' => 'kotlin',
            default => null,
        };
    }

    
public function selesaikanMateri(Materi $materi): JsonResponse|RedirectResponse
{
    abort_unless(
        auth()->check() && auth()->user()->peran === 'pelajar',
        403,
        'Fitur ini hanya dapat digunakan oleh Pelajar.'
    );

    $idPelajar = (int) auth()->id();

    $hasil = DB::transaction(function () use ($materi, $idPelajar) {
        // Mengunci modul untuk mencegah penghitungan ganda
        // saat beberapa permintaan penyelesaian masuk bersamaan.
        $modul = Modul::query()
            ->whereKey($materi->id_modul)
            ->lockForUpdate()
            ->firstOrFail();

        abort_unless(
            (bool) $modul->status,
            404,
            'Modul tidak tersedia.'
        );

        $bahasaAktif = BahasaPemrograman::query()
            ->whereKey($modul->id_bahasa)
            ->where('status', true)
            ->exists();

        abort_unless(
            $bahasaAktif,
            404,
            'Bahasa pemrograman tidak tersedia.'
        );

        $materiAktif = Materi::query()
            ->whereKey($materi->id)
            ->where('id_modul', $modul->id)
            ->where('status', true)
            ->firstOrFail();

        $idMateriAktif = Materi::query()
            ->where('id_modul', $modul->id)
            ->where('status', true)
            ->pluck('id');

        $totalMateri = $idMateriAktif->count();

        abort_if(
            $totalMateri === 0,
            422,
            'Modul belum memiliki materi aktif.'
        );

        // Log khusus menjadi penanda bahwa materi telah selesai.
        $logSelesai = LogAktivitas::query()
            ->where('id_user', $idPelajar)
            ->where('jenis_aktivitas', 'Materi Selesai')
            ->where('entitas', 'materi')
            ->where('id_entitas', $materiAktif->id);

        $sudahSelesai = (clone $logSelesai)->exists();

        if (!$sudahSelesai) {
            LogAktivitas::create([
                'id_user' => $idPelajar,
                'jenis_aktivitas' => 'Materi Selesai',
                'deskripsi' => 'Pelajar menyelesaikan materi: '
                    . $materiAktif->judul_materi,
                'entitas' => 'materi',
                'id_entitas' => $materiAktif->id,
                'waktu_aktivitas' => now(),
            ]);
        }

        // Hitung materi selesai yang unik untuk Pelajar dan modul ini.
        $materiSelesai = LogAktivitas::query()
            ->where('id_user', $idPelajar)
            ->where('jenis_aktivitas', 'Materi Selesai')
            ->where('entitas', 'materi')
            ->whereIn('id_entitas', $idMateriAktif)
            ->distinct()
            ->count('id_entitas');

        $materiSelesai = min($totalMateri, $materiSelesai);

        $persentase = round(
            ($materiSelesai / $totalMateri) * 100,
            2
        );

        $status = $materiSelesai >= $totalMateri
            ? 'selesai'
            : ($materiSelesai > 0 ? 'berlangsung' : 'belum_mulai');

        // Perbarui catatan progres yang ada, atau buat jika belum ada.
        $progres = ProgresBelajar::query()
            ->where('id_pelajar', $idPelajar)
            ->where('id_modul', $modul->id)
            ->lockForUpdate()
            ->first();

        $dataProgres = [
            'total_materi' => $totalMateri,
            'materi_selesai' => $materiSelesai,
            'presentase_progres' => $persentase,
            'status' => $status,
        ];

        if ($progres) {
            $progres->update($dataProgres);
        } else {
            ProgresBelajar::create(array_merge(
                $dataProgres,
                [
                    'id_pelajar' => $idPelajar,
                    'id_modul' => $modul->id,
                ]
            ));
        }

        return [
            'sudah_selesai' => $sudahSelesai,
            'bahasa_id' => (int) $modul->id_bahasa,
            'modul_id' => (int) $modul->id,
            'materi_id' => (int) $materiAktif->id,
            'total_materi' => (int) $totalMateri,
            'materi_selesai' => (int) $materiSelesai,
            'presentase_progres' => (float) $persentase,
            'status' => $status,
        ];
    });

    $pesan = $hasil['sudah_selesai']
        ? 'Materi ini sudah ditandai selesai. Progres tetap diperbarui tanpa menghitung materi dua kali.'
        : 'Materi berhasil ditandai selesai. Progres pembelajaran telah diperbarui.';

    // Permintaan AJAX dari halaman materi membutuhkan JSON agar
    // tombol, label selesai, dan progress bar dapat diperbarui tanpa reload.
    if (request()->expectsJson()) {
        return response()->json([
            'message' => $pesan,
            'sudah_selesai' => true,
            'total_materi' => $hasil['total_materi'],
            'materi_selesai' => $hasil['materi_selesai'],
            'presentase_progres' => $hasil['presentase_progres'],
            'status' => $hasil['status'],
        ]);
    }

    // Form biasa tetap diarahkan kembali ke materi yang baru diselesaikan.
    return redirect()
        ->route('materi', [
            'bahasa' => $hasil['bahasa_id'],
            'modul' => $hasil['modul_id'],
            'materi' => $hasil['materi_id'],
        ])
        ->with('success', $pesan);
}

}

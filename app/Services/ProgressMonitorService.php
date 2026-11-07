<?php

namespace App\Services;

use App\Models\LogAktivitas;
use App\Models\Materi;
use App\Models\PengerjaanEvaluasi;
use App\Models\ProgresBelajar;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Menghimpun progres modul, materi yang benar-benar ditandai selesai,
 * serta hasil Posttest tanpa menambah atau mengubah kolom database.
 */
class ProgressMonitorService
{
    /**
     * Menambahkan ringkasan progres ke setiap model Pelajar.
     * $instrukturId null berarti seluruh modul (akses Admin).
     */
    public function attachSummaries(Collection $pelajar, ?int $instrukturId = null): Collection
    {
        if ($pelajar->isEmpty()) {
            return $pelajar;
        }

        $pelajarIds = $pelajar->pluck('id')->map(fn ($id) => (int) $id)->all();

        $progresQuery = ProgresBelajar::query()
            ->with(['modul.bahasa'])
            ->whereIn('id_pelajar', $pelajarIds)
            ->whereHas('modul', function ($query) use ($instrukturId) {
                if ($instrukturId !== null) {
                    $query->where('id_instruktur', $instrukturId);
                }
            });

        $progresByPelajar = $progresQuery->get()->groupBy('id_pelajar');
        $moduleIds = $progresByPelajar->flatten(1)
            ->pluck('id_modul')->filter()->unique()->values();

        $materiByModul = $moduleIds->isEmpty()
            ? collect()
            : Materi::query()
                ->whereIn('id_modul', $moduleIds)
                ->where('status', true)
                ->orderBy('urutan')
                ->orderBy('id')
                ->get()
                ->groupBy('id_modul');

        $aktivitasSelesai = LogAktivitas::query()
            ->whereIn('id_user', $pelajarIds)
            ->where('jenis_aktivitas', 'Materi Selesai')
            ->where('entitas', 'materi')
            ->get(['id_user', 'id_entitas'])
            ->groupBy('id_user')
            ->map(fn ($items) => $items->pluck('id_entitas')->map(fn ($id) => (int) $id)->unique()->all());

        $posttestQuery = PengerjaanEvaluasi::query()
            ->with(['evaluasi.modul'])
            ->whereIn('id_pelajar', $pelajarIds)
            ->whereNotNull('waktu_selesai')
            ->whereHas('evaluasi', function ($query) use ($instrukturId) {
                $query->where('jenis_evaluasi', 'posttest');
                if ($instrukturId !== null) {
                    $query->whereHas('modul', function ($modulQuery) use ($instrukturId) {
                        $modulQuery->where('id_instruktur', $instrukturId);
                    });
                }
            })
            ->orderByDesc('waktu_selesai')
            ->orderByDesc('id');

        $posttestByPelajar = $posttestQuery->get()->groupBy('id_pelajar');

        foreach ($pelajar as $akun) {
            $idPelajar = (int) $akun->id;
            $idMateriSelesai = $aktivitasSelesai->get($idPelajar, []);
            $barisProgres = $progresByPelajar->get($idPelajar, collect());
            $rincianModul = [];

            foreach ($barisProgres as $progres) {
                $modul = $progres->modul;
                if (!$modul) {
                    continue;
                }

                $daftarMateri = $materiByModul->get($modul->id, collect());
                $materiDenganStatus = $daftarMateri->map(function ($materi) use ($idMateriSelesai) {
                    $materi->setAttribute('sudah_selesai', in_array((int) $materi->id, $idMateriSelesai, true));
                    return $materi;
                });

                $totalMateri = $materiDenganStatus->count();
                $jumlahSelesai = $materiDenganStatus->where('sudah_selesai', true)->count();
                $persentase = $totalMateri > 0
                    ? round(($jumlahSelesai / $totalMateri) * 100, 1)
                    : min(100, max(0, (float) ($progres->presentase_progres ?? 0)));

                $rincianModul[] = [
                    'progres' => $progres,
                    'modul' => $modul,
                    'bahasa' => $modul->bahasa,
                    'nama_bahasa' => $modul->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia',
                    'materi' => $materiDenganStatus,
                    'jumlah_materi' => $totalMateri,
                    'materi_selesai' => $jumlahSelesai,
                    'persentase' => $persentase,
                    'status' => $jumlahSelesai >= $totalMateri && $totalMateri > 0
                        ? 'selesai'
                        : ($jumlahSelesai > 0 ? 'berlangsung' : 'belum_mulai'),
                ];
            }

            $daftarPosttest = $posttestByPelajar->get($idPelajar, collect())->values();
            $nilaiPosttest = $daftarPosttest
                ->pluck('nilai')
                ->filter(fn ($nilai) => $nilai !== null)
                ->map(fn ($nilai) => (float) $nilai);

            $jumlahModul = count($rincianModul);
            $rataProgres = $jumlahModul > 0
                ? round(collect($rincianModul)->avg('persentase'), 1)
                : 0.0;

            $akun->setAttribute('rincian_progres_modul', collect($rincianModul));
            $akun->setAttribute('rincian_posttest', $daftarPosttest);
            $akun->setAttribute('ringkasan_progres', [
                'jumlah_modul' => $jumlahModul,
                'jumlah_modul_selesai' => collect($rincianModul)->where('status', 'selesai')->count(),
                'total_materi' => collect($rincianModul)->sum('jumlah_materi'),
                'materi_selesai' => collect($rincianModul)->sum('materi_selesai'),
                'rata_progres' => $rataProgres,
                'jumlah_posttest' => $daftarPosttest->count(),
                'rata_nilai_posttest' => $nilaiPosttest->isNotEmpty() ? round($nilaiPosttest->avg(), 1) : null,
            ]);
        }

        return $pelajar;
    }

    public function studentEvaluations(User $pelajar, string $jenis): Collection
    {
        abort_unless(in_array($jenis, ['pretest', 'posttest'], true), 400);

        return PengerjaanEvaluasi::query()
            ->with(['evaluasi.modul.bahasa'])
            ->where('id_pelajar', $pelajar->id)
            ->whereHas('evaluasi', fn ($query) => $query->where('jenis_evaluasi', $jenis))
            ->orderByDesc('waktu_selesai')
            ->orderByDesc('id')
            ->get();
    }
}

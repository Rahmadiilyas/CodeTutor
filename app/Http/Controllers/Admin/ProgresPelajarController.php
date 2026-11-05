<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgresBelajar;
use App\Models\PengerjaanEvaluasi;
use App\Models\User;
use App\Services\ProgressMonitorService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgresPelajarController extends Controller
{
    public function index(Request $request, ProgressMonitorService $monitor)
    {
        abort_unless(auth()->check() && auth()->user()->peran === 'admin', 403);

        $filter = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status_akun' => ['nullable', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $query = User::query()->where('peran', 'pelajar');
        if (!empty($filter['q'])) {
            $keyword = trim($filter['q']);
            $query->where(function ($builder) use ($keyword) {
                $builder->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }
        if (($filter['status_akun'] ?? '') === 'aktif') {
            $query->where('status', true);
        } elseif (($filter['status_akun'] ?? '') === 'nonaktif') {
            $query->where('status', false);
        }

        $pelajar = $query->orderBy('nama')->paginate(12)->withQueryString();
        $monitor->attachSummaries($pelajar->getCollection());

        $totalPelajar = User::query()->where('peran', 'pelajar')->count();
        $pelajarAktif = User::query()->where('peran', 'pelajar')->where('status', true)->count();
        $pelajarMemilikiProgres = ProgresBelajar::query()->distinct()->count('id_pelajar');
        $rataRataProgres = (float) (ProgresBelajar::query()->avg('presentase_progres') ?? 0);
        $totalModulSelesai = ProgresBelajar::query()->where('status', 'selesai')->count();
        $totalEvaluasiSelesai = PengerjaanEvaluasi::query()
            ->whereNotNull('waktu_selesai')
            ->whereHas('evaluasi', fn ($q) => $q->where('jenis_evaluasi', 'posttest'))
            ->count();

        return view('admin.progres-pelajar.index', compact(
            'pelajar', 'totalPelajar', 'pelajarAktif', 'pelajarMemilikiProgres',
            'rataRataProgres', 'totalModulSelesai', 'totalEvaluasiSelesai'
        ));
    }

    public function show(User $pelajar, ProgressMonitorService $monitor)
    {
        abort_unless(auth()->check() && auth()->user()->peran === 'admin', 403);
        abort_unless($pelajar->peran === 'pelajar', 404);

        $monitor->attachSummaries(collect([$pelajar]));
        $ringkasan = $pelajar->ringkasan_progres;

        return view('admin.progres-pelajar.show', compact('pelajar', 'ringkasan'));
    }
}

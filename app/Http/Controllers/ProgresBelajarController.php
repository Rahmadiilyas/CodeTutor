<?php

namespace App\Http\Controllers;

use App\Models\BahasaPemrograman;
use App\Models\Modul;
use App\Models\ProgresBelajar;
use App\Models\User;
use App\Services\ProgressMonitorService;
use Illuminate\Http\Request;

class ProgresBelajarController extends Controller
{
    public function index(Request $request, ProgressMonitorService $monitor)
    {
        $user = auth()->user();
        abort_unless($user, 403);

        if ($user->peran === 'pelajar') {
            $monitor->attachSummaries(collect([$user]));
            $ringkasan = $user->ringkasan_progres;
            $modul = $user->rincian_progres_modul;
            $pretest = $monitor->studentEvaluations($user, 'pretest');
            $posttest = $monitor->studentEvaluations($user, 'posttest');

            return view('progres.index', compact('user', 'ringkasan', 'modul', 'pretest', 'posttest'));
        }

        if ($user->peran === 'instruktur') {
            return $this->indexInstruktur($request, $monitor, $user);
        }

        if ($user->peran === 'admin') {
            return redirect()->route('admin.progres-pelajar.index');
        }

        abort(403, 'Halaman progres tidak tersedia untuk peran ini.');
    }

    private function indexInstruktur(Request $request, ProgressMonitorService $monitor, User $instruktur)
    {
        $filter = $request->validate(['q' => ['nullable', 'string', 'max:100']]);

        $idPelajar = ProgresBelajar::query()
            ->whereHas('modul', fn ($query) => $query->where('id_instruktur', $instruktur->id))
            ->distinct()
            ->pluck('id_pelajar');

        $query = User::query()->where('peran', 'pelajar')->whereIn('id', $idPelajar);
        if (!empty($filter['q'])) {
            $keyword = trim($filter['q']);
            $query->where(function ($builder) use ($keyword) {
                $builder->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        $pelajar = $query->orderBy('nama')->paginate(12)->withQueryString();
        $monitor->attachSummaries($pelajar->getCollection(), (int) $instruktur->id);

        $totalModul = Modul::query()->where('id_instruktur', $instruktur->id)->count();
        $totalPelajar = $idPelajar->count();
        $rataProgres = (float) (ProgresBelajar::query()
            ->whereHas('modul', fn ($query) => $query->where('id_instruktur', $instruktur->id))
            ->avg('presentase_progres') ?? 0);
        $modulSelesai = ProgresBelajar::query()
            ->where('status', 'selesai')
            ->whereHas('modul', fn ($query) => $query->where('id_instruktur', $instruktur->id))
            ->count();

        return view('instruktur.progres-pelajar.index', compact(
            'pelajar', 'totalModul', 'totalPelajar', 'rataProgres', 'modulSelesai'
        ));
    }

    public function showPelajar(User $pelajar, ProgressMonitorService $monitor)
    {
        $instruktur = auth()->user();
        abort_unless($instruktur && $instruktur->peran === 'instruktur', 403);
        abort_unless($pelajar->peran === 'pelajar', 404);

        $terpantau = ProgresBelajar::query()
            ->where('id_pelajar', $pelajar->id)
            ->whereHas('modul', fn ($query) => $query->where('id_instruktur', $instruktur->id))
            ->exists();
        abort_unless($terpantau, 404, 'Pelajar ini tidak memiliki progres pada modul yang Anda kelola.');

        $monitor->attachSummaries(collect([$pelajar]), (int) $instruktur->id);
        $ringkasan = $pelajar->ringkasan_progres;

        return view('instruktur.progres-pelajar.show', compact('pelajar', 'ringkasan'));
    }
}

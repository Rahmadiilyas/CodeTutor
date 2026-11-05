<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    /**
     * Menampilkan riwayat aktivitas sistem untuk Admin.
     */
    public function index(Request $request)
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'admin',
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'jenis_aktivitas' => ['nullable', 'string', 'max:150'],
            'peran_user' => ['nullable', 'in:admin,instruktur,pelajar'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => [
                'nullable',
                'date',
                'after_or_equal:tanggal_mulai',
            ],
        ]);

        $query = LogAktivitas::query()
            ->with('user:id,nama,email,peran')
            ->orderByDesc('waktu_aktivitas');

        if (!empty($validated['q'])) {
            $kataKunci = trim($validated['q']);

            $query->where(function ($builder) use ($kataKunci) {
                $builder
                    ->where('jenis_aktivitas', 'like', "%{$kataKunci}%")
                    ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                    ->orWhere('entitas', 'like', "%{$kataKunci}%")
                    ->orWhereHas('user', function ($userQuery) use ($kataKunci) {
                        $userQuery
                            ->where('nama', 'like', "%{$kataKunci}%")
                            ->orWhere('email', 'like', "%{$kataKunci}%");
                    });
            });
        }

        if (!empty($validated['jenis_aktivitas'])) {
            $query->where('jenis_aktivitas', $validated['jenis_aktivitas']);
        }

        if (!empty($validated['peran_user'])) {
            $peran = $validated['peran_user'];
            $query->whereHas('user', function ($userQuery) use ($peran) {
                $userQuery->where('peran', $peran);
            });
        }

        if (!empty($validated['tanggal_mulai'])) {
            $query->whereDate('waktu_aktivitas', '>=', $validated['tanggal_mulai']);
        }

        if (!empty($validated['tanggal_selesai'])) {
            $query->whereDate('waktu_aktivitas', '<=', $validated['tanggal_selesai']);
        }

        $totalAktivitas = LogAktivitas::count();

        $aktivitasHariIni = LogAktivitas::query()
            ->whereDate('waktu_aktivitas', now()->toDateString())
            ->count();

        $jenisAktivitas = LogAktivitas::query()
            ->whereNotNull('jenis_aktivitas')
            ->where('jenis_aktivitas', '!=', '')
            ->select('jenis_aktivitas')
            ->distinct()
            ->orderBy('jenis_aktivitas')
            ->pluck('jenis_aktivitas');

        $aktivitas = $query
            ->paginate(15)
            ->withQueryString();

        return view('admin.aktivitas.index', compact(
            'aktivitas',
            'totalAktivitas',
            'aktivitasHariIni',
            'jenisAktivitas'
        ));
    }
}

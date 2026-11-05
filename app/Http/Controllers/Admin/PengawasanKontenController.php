<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahasaPemrograman;
use App\Models\ContohKode;
use App\Models\Evaluasi;
use App\Models\Materi;
use App\Models\MediaPembelajaran;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PengawasanKontenController extends Controller
{
    /**
     * Halaman pemantauan konten pembelajaran untuk Admin.
     * Halaman ini bersifat read-only: data konten tidak diubah dari sini.
     */
    public function index(Request $request)
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'admin',
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );

        $validated = $request->validate([
            'jenis' => ['nullable', 'string', Rule::in(['bahasa', 'modul', 'materi', 'media', 'kode', 'evaluasi'])],
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $jenis = $validated['jenis'] ?? 'modul';
        $kataKunci = trim($validated['q'] ?? '');
        $status = $validated['status'] ?? '';

        $totalBahasa = BahasaPemrograman::count();
        $totalModul = Modul::count();
        $totalMateri = Materi::count();
        $totalMedia = MediaPembelajaran::count();
        $totalContohKode = ContohKode::count();
        $totalEvaluasi = Evaluasi::count();

        $query = match ($jenis) {
            'bahasa' => BahasaPemrograman::query()
                ->with(['instruktur:id,nama,email'])
                ->withCount(['modul', 'contohKode']),
            'modul' => Modul::query()
                ->with(['bahasa:id,nama_bahasa', 'instruktur:id,nama,email'])
                ->withCount(['materi', 'evaluasi']),
            'materi' => Materi::query()
                ->with(['modul.bahasa'])
                ->withCount(['media', 'contohKode']),
            'media' => MediaPembelajaran::query()
                ->with(['materi.modul.bahasa']),
            'kode' => ContohKode::query()
                ->with(['bahasa', 'materi', 'instruktur:id,nama,email']),
            'evaluasi' => Evaluasi::query()
                ->with(['modul.bahasa', 'instruktur:id,nama,email'])
                ->withCount(['soal', 'pengerjaan']),
        };

        if ($kataKunci !== '') {
            $query->where(function ($builder) use ($jenis, $kataKunci) {
                switch ($jenis) {
                    case 'bahasa':
                        $builder->where('nama_bahasa', 'like', "%{$kataKunci}%")
                            ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                            ->orWhereHas('instruktur', function ($userQuery) use ($kataKunci) {
                                $userQuery->where('nama', 'like', "%{$kataKunci}%")
                                    ->orWhere('email', 'like', "%{$kataKunci}%");
                            });
                        break;

                    case 'modul':
                        $builder->where('nama_modul', 'like', "%{$kataKunci}%")
                            ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                            ->orWhereHas('bahasa', function ($bahasaQuery) use ($kataKunci) {
                                $bahasaQuery->where('nama_bahasa', 'like', "%{$kataKunci}%");
                            })
                            ->orWhereHas('instruktur', function ($userQuery) use ($kataKunci) {
                                $userQuery->where('nama', 'like', "%{$kataKunci}%")
                                    ->orWhere('email', 'like', "%{$kataKunci}%");
                            });
                        break;

                    case 'materi':
                        $builder->where('judul_materi', 'like', "%{$kataKunci}%")
                            ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                            ->orWhereHas('modul', function ($modulQuery) use ($kataKunci) {
                                $modulQuery->where('nama_modul', 'like', "%{$kataKunci}%")
                                    ->orWhereHas('bahasa', function ($bahasaQuery) use ($kataKunci) {
                                        $bahasaQuery->where('nama_bahasa', 'like', "%{$kataKunci}%");
                                    });
                            });
                        break;

                    case 'media':
                        $builder->where('judul_media', 'like', "%{$kataKunci}%")
                            ->orWhere('jenis_media', 'like', "%{$kataKunci}%")
                            ->orWhere('tautan', 'like', "%{$kataKunci}%")
                            ->orWhereHas('materi', function ($materiQuery) use ($kataKunci) {
                                $materiQuery->where('judul_materi', 'like', "%{$kataKunci}%");
                            });
                        break;

                    case 'kode':
                        $builder->where('judul', 'like', "%{$kataKunci}%")
                            ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                            ->orWhere('kode_program', 'like', "%{$kataKunci}%")
                            ->orWhereHas('bahasa', function ($bahasaQuery) use ($kataKunci) {
                                $bahasaQuery->where('nama_bahasa', 'like', "%{$kataKunci}%");
                            })
                            ->orWhereHas('materi', function ($materiQuery) use ($kataKunci) {
                                $materiQuery->where('judul_materi', 'like', "%{$kataKunci}%");
                            })
                            ->orWhereHas('instruktur', function ($userQuery) use ($kataKunci) {
                                $userQuery->where('nama', 'like', "%{$kataKunci}%")
                                    ->orWhere('email', 'like', "%{$kataKunci}%");
                            });
                        break;

                    case 'evaluasi':
                        $builder->where('judul_evaluasi', 'like', "%{$kataKunci}%")
                            ->orWhere('jenis_evaluasi', 'like', "%{$kataKunci}%")
                            ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                            ->orWhereHas('modul', function ($modulQuery) use ($kataKunci) {
                                $modulQuery->where('nama_modul', 'like', "%{$kataKunci}%")
                                    ->orWhereHas('bahasa', function ($bahasaQuery) use ($kataKunci) {
                                        $bahasaQuery->where('nama_bahasa', 'like', "%{$kataKunci}%");
                                    });
                            })
                            ->orWhereHas('instruktur', function ($userQuery) use ($kataKunci) {
                                $userQuery->where('nama', 'like', "%{$kataKunci}%")
                                    ->orWhere('email', 'like', "%{$kataKunci}%");
                            });
                        break;
                }
            });
        }

        // Kolom status hanya tersedia pada tabel bahasa_pemrograman, modul, dan materi.
        if ($status !== '' && in_array($jenis, ['bahasa', 'modul', 'materi'], true)) {
            $query->where('status', $status === 'aktif');
        }

        $kolomUrutan = match ($jenis) {
            'bahasa' => 'nama_bahasa',
            'modul' => 'urutan',
            'materi' => 'urutan',
            'media' => 'judul_media',
            'kode' => 'judul',
            'evaluasi' => 'judul_evaluasi',
        };

        $items = $query
            ->orderBy($kolomUrutan)
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.pengawasan-konten.index', compact(
            'jenis',
            'kataKunci',
            'status',
            'items',
            'totalBahasa',
            'totalModul',
            'totalMateri',
            'totalMedia',
            'totalContohKode',
            'totalEvaluasi'
        ));
    }
}

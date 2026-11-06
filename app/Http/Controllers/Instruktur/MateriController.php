<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Materi;
use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Models\ProgresBelajar;

class MateriController extends Controller
{
    private function pastikanInstruktur(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'instruktur',
            403,
            'Halaman ini hanya dapat diakses oleh Instruktur.'
        );
    }

    private function pastikanMilikInstruktur(Materi $materi): void
    {
        abort_unless(
            $materi->modul()->where('id_instruktur', auth()->id())->exists(),
            404,
            'Materi tidak ditemukan.'
        );
    }

    private function catatAktivitas(string $jenis, string $deskripsi, ?int $idEntitas): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => $jenis,
            'deskripsi' => $deskripsi,
            'entitas' => 'materi',
            'id_entitas' => $idEntitas,
            'waktu_aktivitas' => now(),
        ]);



    }
private function sinkronkanProgresModul(int $idModul): void
{
    $idMateriAktif = Materi::query()
        ->where('id_modul', $idModul)
        ->where('status', true)
        ->pluck('id');

    $totalMateri = $idMateriAktif->count();

    $daftarProgres = ProgresBelajar::query()
        ->where('id_modul', $idModul)
        ->get();

    foreach ($daftarProgres as $progres) {
        $materiSelesai = 0;

        if ($totalMateri > 0) {
            $materiSelesai = LogAktivitas::query()
                ->where('id_user', $progres->id_pelajar)
                ->where('jenis_aktivitas', 'Materi Selesai')
                ->where('entitas', 'materi')
                ->whereIn('id_entitas', $idMateriAktif)
                ->distinct()
                ->count('id_entitas');
        }

        $persentase = $totalMateri > 0
            ? round(($materiSelesai / $totalMateri) * 100, 2)
            : 0;

        if ($materiSelesai === 0) {
            $statusProgres = 'belum_mulai';
        } elseif ($materiSelesai >= $totalMateri) {
            $statusProgres = 'selesai';
        } else {
            $statusProgres = 'berlangsung';
        }

        $progres->update([
            'total_materi' => $totalMateri,
            'materi_selesai' => $materiSelesai,
            'presentase_progres' => $persentase,
            'status' => $statusProgres,
        ]);
    }
}
    private function queryMateriMilikInstruktur()
    {
        return Materi::query()->whereHas('modul', function ($query) {
            $query->where('id_instruktur', auth()->id());
        });
    }

    public function index(Request $request)
    {
        $this->pastikanInstruktur();

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['0', '1'])],
            'modul' => [
                'nullable',
                'integer',
                Rule::exists('modul', 'id')->where(function ($query) {
                    $query->where('id_instruktur', auth()->id());
                }),
            ],
        ]);

        $query = $this->queryMateriMilikInstruktur()
            ->with(['modul.bahasa', 'media', 'contohKode'])
            ->withCount(['media', 'contohKode'])
            ->orderBy('urutan')
            ->orderByDesc('created_at');

        if (!empty($validated['q'])) {
            $kataKunci = trim($validated['q']);
            $query->where(function ($builder) use ($kataKunci) {
                $builder->where('judul_materi', 'like', "%{$kataKunci}%")
                    ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                    ->orWhere('isi_materi', 'like', "%{$kataKunci}%")
                    ->orWhereHas('modul', function ($modulQuery) use ($kataKunci) {
                        $modulQuery->where('nama_modul', 'like', "%{$kataKunci}%")
                            ->where('id_instruktur', auth()->id());
                    });
            });
        }

        if (isset($validated['status']) && $validated['status'] !== '') {
            $query->where('status', (int) $validated['status']);
        }

        if (!empty($validated['modul'])) {
            $query->where('id_modul', (int) $validated['modul']);
        }

        $materi = $query->paginate(10)->withQueryString();

        // Siapkan alamat media agar Instruktur dapat membukanya dari popup.
        $materi->getCollection()->each(function ($itemMateri) {
            $itemMateri->media->each(function ($media) {
                $urlMedia = null;

                if ($media->tautan && filter_var($media->tautan, FILTER_VALIDATE_URL)) {
                    $skema = strtolower((string) parse_url($media->tautan, PHP_URL_SCHEME));

                    if (in_array($skema, ['http', 'https'], true)) {
                        $urlMedia = $media->tautan;
                    }
                } elseif ($media->lokasi_file) {
                    $lokasiFile = ltrim(str_replace('\\', '/', $media->lokasi_file), '/');

                    if ($lokasiFile !== '' && !str_contains($lokasiFile, '..')) {
                        $urlMedia = \Illuminate\Support\Facades\Storage::disk('public')->url($lokasiFile);
                    }
                }

                $media->setAttribute('url_tampilan', $urlMedia);
            });
        });

        $modulFilter = Modul::query()
            ->where('id_instruktur', auth()->id())
            ->with('bahasa:id,nama_bahasa')
            ->orderBy('urutan')
            ->orderBy('nama_modul')
            ->get(['id', 'id_bahasa', 'nama_modul', 'status', 'urutan']);

        $statistik = $this->queryMateriMilikInstruktur()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as aktif')
            ->selectRaw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as nonaktif')
            ->first();

        return view('instruktur.materi.index', [
            'materi' => $materi,
            'modulFilter' => $modulFilter,
            'totalMateri' => (int) ($statistik->total ?? 0),
            'materiAktif' => (int) ($statistik->aktif ?? 0),
            'materiNonaktif' => (int) ($statistik->nonaktif ?? 0),
        ]);
    }

    public function create()
    {
        $this->pastikanInstruktur();

        $modul = Modul::query()
            ->where('id_instruktur', auth()->id())
            ->where('status', true)
            ->with('bahasa:id,nama_bahasa')
            ->orderBy('urutan')
            ->orderBy('nama_modul')
            ->get(['id', 'id_bahasa', 'nama_modul', 'status', 'urutan']);

        return view('instruktur.materi.create', compact('modul'));
    }

    public function store(Request $request)
    {
        
        $this->pastikanInstruktur();

        // Bersihkan spasi pada judul sebelum validasi dan penyimpanan.
        $request->merge([
            'judul_materi' => trim((string) $request->input('judul_materi')),
        ]);

        $validated = $request->validate([
            'id_modul' => [
                'required',
                'integer',
                Rule::exists('modul', 'id')->where(function ($query) {
                    $query->where('id_instruktur', auth()->id())
                        ->where('status', true);
                }),
            ],
            'judul_materi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'isi_materi' => ['nullable', 'string'],
            'urutan' => ['required', 'integer', 'min:0', 'max:99999'],
        ], [
            'id_modul.required' => 'Pilih modul pembelajaran terlebih dahulu.',
            'id_modul.exists' => 'Modul tidak aktif atau bukan milik akunmu.',
            'judul_materi.required' => 'Judul materi wajib diisi.',
            'urutan.required' => 'Urutan materi wajib diisi.',
            'urutan.min' => 'Urutan materi tidak boleh kurang dari 0.',
        ]);

        $materi = Materi::create([
            'id_modul' => (int) $validated['id_modul'],
            'judul_materi' => trim($validated['judul_materi']),
            'deskripsi' => isset($validated['deskripsi']) ? trim($validated['deskripsi']) : null,
            'isi_materi' => $validated['isi_materi'] ?? null,
            'urutan' => (int) $validated['urutan'],
            'status' => true,
        ]);

        $this->catatAktivitas(
            'Tambah Materi Pembelajaran',
            'Instruktur menambahkan materi: ' . $materi->judul_materi,
            (int) $materi->id
        );
        $this->sinkronkanProgresModul((int) $materi->id_modul);

        return redirect()->route('instruktur.materi.index')
            ->with('success', 'Materi pembelajaran berhasil ditambahkan.');
    }

    public function edit(Materi $materi)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($materi);

        $modul = Modul::query()
            ->where('id_instruktur', auth()->id())
            ->with('bahasa:id,nama_bahasa')
            ->orderBy('urutan')
            ->orderBy('nama_modul')
            ->get(['id', 'id_bahasa', 'nama_modul', 'status', 'urutan']);

        return view('instruktur.materi.edit', compact('materi', 'modul'));
    }

    public function update(Request $request, Materi $materi)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($materi);

        // Bersihkan spasi pada judul sebelum validasi dan penyimpanan.
        $request->merge([
            'judul_materi' => trim((string) $request->input('judul_materi')),
        ]);

        $validated = $request->validate([
            'id_modul' => [
                'required',
                'integer',
                Rule::exists('modul', 'id')->where(function ($query) {
                    $query->where('id_instruktur', auth()->id());
                }),
            ],
            'judul_materi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'isi_materi' => ['nullable', 'string'],
            'urutan' => ['required', 'integer', 'min:0', 'max:99999'],
            'status' => ['required', Rule::in(['0', '1', 0, 1])],
        ], [
            'id_modul.required' => 'Pilih modul pembelajaran terlebih dahulu.',
            'id_modul.exists' => 'Modul yang dipilih tidak valid atau bukan milik akunmu.',
            'judul_materi.required' => 'Judul materi wajib diisi.',
            'urutan.required' => 'Urutan materi wajib diisi.',
            'status.required' => 'Pilih status materi.',
        ]);
$idModulLama = (int) $materi->id_modul;
$idModulBaru = (int) $validated['id_modul'];

if (
    $idModulLama !== $idModulBaru &&
    LogAktivitas::query()
        ->where('jenis_aktivitas', 'Materi Selesai')
        ->where('entitas', 'materi')
        ->where('id_entitas', (int) $materi->id)
        ->exists()
) {
    return back()
        ->withInput()
        ->with(
            'error',
            'Materi tidak dapat dipindahkan ke modul lain karena sudah memiliki riwayat penyelesaian oleh Pelajar.'
        );
}
        $judulLama = $materi->judul_materi;
        $materi->update([
            'id_modul' => (int) $validated['id_modul'],
            'judul_materi' => trim($validated['judul_materi']),
            'deskripsi' => isset($validated['deskripsi']) ? trim($validated['deskripsi']) : null,
            'isi_materi' => $validated['isi_materi'] ?? null,
            'urutan' => (int) $validated['urutan'],
            'status' => (bool) $validated['status'],
        ]);

        $this->catatAktivitas(
            'Perbarui Materi Pembelajaran',
            'Instruktur memperbarui materi: ' . $judulLama . ' menjadi ' . $materi->judul_materi,
            (int) $materi->id
        );
$this->sinkronkanProgresModul($idModulLama);

if ($idModulBaru !== $idModulLama) {
    $this->sinkronkanProgresModul($idModulBaru);
}
        return redirect()->route('instruktur.materi.index')
            ->with('success', 'Materi pembelajaran berhasil diperbarui.');
    }

    public function toggleStatus(Materi $materi)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($materi);

        $materi->status = ! (bool) $materi->status;
        $materi->save();

        $jenis = $materi->status ? 'Aktifkan Materi Pembelajaran' : 'Nonaktifkan Materi Pembelajaran';
        $aksi = $materi->status ? 'mengaktifkan' : 'menonaktifkan';
        $this->catatAktivitas(
            $jenis,
            'Instruktur ' . $aksi . ' materi: ' . $materi->judul_materi,
            (int) $materi->id
        );
$this->sinkronkanProgresModul((int) $materi->id_modul);
        return redirect()->route('instruktur.materi.index')
            ->with('success', $materi->status
                ? 'Materi berhasil diaktifkan.'
                : 'Materi berhasil dinonaktifkan.');
    }

    public function destroy(Materi $materi)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($materi);

        $judulMateri = $materi->judul_materi;
        $idMateri = (int) $materi->id;
        $idModul = (int) $materi->id_modul;

        // Simpan lokasi file sebelum data media dihapus dari database.
        $daftarFileMedia = $materi->media()
            ->whereNotNull('lokasi_file')
            ->where('lokasi_file', '!=', '')
            ->pluck('lokasi_file')
            ->filter()
            ->values()
            ->all();

        // Hapus seluruh data terkait dan materi dalam satu transaksi.
        DB::transaction(function () use ($materi, $judulMateri, $idMateri) {
            $this->catatAktivitas(
                'Hapus Materi Pembelajaran',
                'Instruktur menghapus materi beserta media dan contoh kode terkait: ' . $judulMateri,
                $idMateri
            );

            $materi->media()->delete();
            $materi->contohKode()->delete();
            $materi->delete();
        });

        // Hapus file fisik setelah transaksi database berhasil.
        foreach ($daftarFileMedia as $lokasiFile) {
            $lokasiFile = ltrim(str_replace('\\', '/', (string) $lokasiFile), '/');

            // Batasi penghapusan hanya pada folder media yang digunakan aplikasi.
            if (str_starts_with($lokasiFile, 'media-pembelajaran/')) {
                Storage::disk('public')->delete($lokasiFile);
            }
        }

        $this->sinkronkanProgresModul($idModul);

        return redirect()->route('instruktur.materi.index')
            ->with('success', 'Materi beserta media pembelajaran dan contoh kode terkait berhasil dihapus.');
    }
}

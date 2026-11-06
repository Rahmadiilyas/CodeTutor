<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\BahasaPemrograman;
use App\Models\LogAktivitas;
use App\Models\Modul;
use App\Services\PenghapusanKontenService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModulController extends Controller
{
    private function pastikanInstruktur(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'instruktur',
            403,
            'Halaman ini hanya dapat diakses oleh Instruktur.'
        );
    }

    private function pastikanMilikInstruktur(Modul $modul): void
    {
        abort_unless(
            (int) $modul->id_instruktur === (int) auth()->id(),
            404,
            'Data modul tidak ditemukan.'
        );
    }

    private function catatAktivitas(string $jenis, string $deskripsi, ?int $idEntitas): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => $jenis,
            'deskripsi' => $deskripsi,
            'entitas' => 'modul',
            'id_entitas' => $idEntitas,
            'waktu_aktivitas' => now(),
        ]);
    }

    public function index(Request $request)
    {
        $this->pastikanInstruktur();

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['0', '1'])],
            'bahasa' => ['nullable', 'integer'],
        ]);

        $query = Modul::query()
            ->where('id_instruktur', auth()->id())
            ->with('bahasa:id,nama_bahasa,status')
            ->withCount(['materi', 'evaluasi', 'progresBelajar', 'sertifikat'])
            ->orderBy('urutan')
            ->orderByDesc('created_at');

        if (!empty($validated['q'])) {
            $kataKunci = trim($validated['q']);
            $query->where(function ($builder) use ($kataKunci) {
                $builder->where('nama_modul', 'like', "%{$kataKunci}%")
                    ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                    ->orWhereHas('bahasa', function ($bahasaQuery) use ($kataKunci) {
                        $bahasaQuery->where('nama_bahasa', 'like', "%{$kataKunci}%");
                    });
            });
        }

        if (isset($validated['status']) && $validated['status'] !== '') {
            $query->where('status', (int) $validated['status']);
        }

        if (!empty($validated['bahasa'])) {
            $query->whereHas('bahasa', function ($bahasaQuery) use ($validated) {
                $bahasaQuery->where('id', (int) $validated['bahasa'])
                    ->where('id_instruktur', auth()->id());
            });
        }

        $modul = $query->paginate(10)->withQueryString();
        $bahasa = BahasaPemrograman::query()
            ->where('id_instruktur', auth()->id())
            ->orderBy('nama_bahasa')
            ->get(['id', 'nama_bahasa', 'status']);

        $statistik = Modul::query()
            ->where('id_instruktur', auth()->id())
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as aktif')
            ->selectRaw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as nonaktif')
            ->first();

        return view('instruktur.modul.index', [
            'modul' => $modul,
            'bahasa' => $bahasa,
            'totalModul' => (int) ($statistik->total ?? 0),
            'modulAktif' => (int) ($statistik->aktif ?? 0),
            'modulNonaktif' => (int) ($statistik->nonaktif ?? 0),
        ]);
    }

    public function create()
    {
        $this->pastikanInstruktur();

        $bahasa = BahasaPemrograman::query()
            ->where('id_instruktur', auth()->id())
            ->where('status', true)
            ->orderBy('nama_bahasa')
            ->get(['id', 'nama_bahasa', 'status']);

        return view('instruktur.modul.create', compact('bahasa'));
    }

    public function store(Request $request)
    {
        $this->pastikanInstruktur();

        $request->merge([
            'nama_modul' => trim((string) $request->input('nama_modul')),
        ]);

        $validated = $request->validate([
            'id_bahasa' => [
                'required', 'integer',
                Rule::exists('bahasa_pemrograman', 'id')->where(function ($query) {
                    $query->where('id_instruktur', auth()->id())->where('status', true);
                }),
            ],
            'nama_modul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'urutan' => ['required', 'integer', 'min:0', 'max:99999'],
        ], [
            'id_bahasa.required' => 'Pilih bahasa pemrograman terlebih dahulu.',
            'id_bahasa.exists' => 'Bahasa pemrograman tidak valid, tidak aktif, atau bukan milik akunmu.',
            'nama_modul.required' => 'Nama modul wajib diisi.',
            'urutan.required' => 'Urutan modul wajib diisi.',
            'urutan.min' => 'Urutan modul tidak boleh kurang dari 0.',
        ]);

        $modul = Modul::create([
            'id_bahasa' => (int) $validated['id_bahasa'],
            'id_instruktur' => auth()->id(),
            'nama_modul' => trim($validated['nama_modul']),
            'deskripsi' => $validated['deskripsi'] ?? null,
            'urutan' => (int) $validated['urutan'],
            'status' => true,
        ]);

        $this->catatAktivitas(
            'Tambah Modul Pembelajaran',
            'Instruktur menambahkan modul pembelajaran: ' . $modul->nama_modul,
            (int) $modul->id
        );

        return redirect()->route('instruktur.modul.index')
            ->with('success', 'Modul pembelajaran berhasil ditambahkan.');
    }

    public function edit(Modul $modul)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($modul);

        $bahasa = BahasaPemrograman::query()
            ->where('id_instruktur', auth()->id())
            ->orderBy('nama_bahasa')
            ->get(['id', 'nama_bahasa', 'status']);

        return view('instruktur.modul.edit', compact('modul', 'bahasa'));
    }

    public function update(Request $request, Modul $modul)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($modul);

        $request->merge([
            'nama_modul' => trim((string) $request->input('nama_modul')),
        ]);

        $validated = $request->validate([
            'id_bahasa' => [
                'required', 'integer',
                Rule::exists('bahasa_pemrograman', 'id')->where(function ($query) {
                    $query->where('id_instruktur', auth()->id());
                }),
            ],
            'nama_modul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'urutan' => ['required', 'integer', 'min:0', 'max:99999'],
            'status' => ['required', Rule::in(['0', '1', 0, 1])],
        ], [
            'id_bahasa.required' => 'Pilih bahasa pemrograman terlebih dahulu.',
            'id_bahasa.exists' => 'Bahasa pemrograman tidak valid atau bukan milik akunmu.',
            'nama_modul.required' => 'Nama modul wajib diisi.',
            'urutan.required' => 'Urutan modul wajib diisi.',
            'status.required' => 'Pilih status modul.',
        ]);
// Cegah perubahan bahasa jika modul sudah memiliki data terkait.
if ((int) $modul->id_bahasa !== (int) $validated['id_bahasa']) {
    $memilikiRelasi = $modul->materi()->exists()
        || $modul->evaluasi()->exists()
        || $modul->progresBelajar()->exists()
        || $modul->sertifikat()->exists();

    if ($memilikiRelasi) {
        return redirect()
            ->route('instruktur.modul.index')
            ->with(
                'error',
                'Bahasa pemrograman tidak dapat diubah karena modul '
                . 'sudah memiliki materi, evaluasi, progres belajar, '
                . 'atau sertifikat. Buat modul baru jika ingin '
                . 'menggunakan bahasa pemrograman yang berbeda.'
            );
    }
}
        $namaLama = $modul->nama_modul;
        $modul->update([
            'id_bahasa' => (int) $validated['id_bahasa'],
            'nama_modul' => trim($validated['nama_modul']),
            'deskripsi' => $validated['deskripsi'] ?? null,
            'urutan' => (int) $validated['urutan'],
            'status' => (bool) $validated['status'],
        ]);

        $this->catatAktivitas(
            'Perbarui Modul Pembelajaran',
            'Instruktur memperbarui modul: ' . $namaLama . ' menjadi ' . $modul->nama_modul,
            (int) $modul->id
        );

        return redirect()->route('instruktur.modul.index')
            ->with('success', 'Modul pembelajaran berhasil diperbarui.');
    }

    public function toggleStatus(Modul $modul)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($modul);

        $modul->status = ! (bool) $modul->status;
        $modul->save();

        $aksi = $modul->status ? 'Aktifkan Modul Pembelajaran' : 'Nonaktifkan Modul Pembelajaran';
        $kataKerja = $modul->status ? 'mengaktifkan' : 'menonaktifkan';
        $this->catatAktivitas(
            $aksi,
            'Instruktur ' . $kataKerja . ' modul pembelajaran: ' . $modul->nama_modul,
            (int) $modul->id
        );

        return redirect()->route('instruktur.modul.index')
            ->with('success', $modul->status
                ? 'Modul berhasil diaktifkan.'
                : 'Modul berhasil dinonaktifkan.');
    }

    public function destroy(Modul $modul)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($modul);

        $idModul = (int) $modul->id;
        $namaModul = $modul->nama_modul;

        app(PenghapusanKontenService::class)->hapusModul(
            $idModul,
            function () use ($idModul, $namaModul) {
                $this->catatAktivitas(
                    'Hapus Modul Pembelajaran',
                    'Instruktur menghapus modul beserta materi, media, contoh kode, evaluasi, progres, dan sertifikat terkait: ' . $namaModul,
                    $idModul
                );
            }
        );

        return redirect()->route('instruktur.modul.index')
            ->with('success', 'Modul beserta seluruh konten dan riwayat turunannya berhasil dihapus.');
    }
}

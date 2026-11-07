<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\BahasaPemrograman;
use App\Models\LogAktivitas;
use App\Services\PenghapusanKontenService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BahasaPemrogramanController extends Controller
{
    /** Pastikan semua operasi hanya dapat dilakukan oleh Instruktur. */
    private function pastikanInstruktur(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'instruktur',
            403,
            'Halaman ini hanya dapat diakses oleh Instruktur.'
        );
    }

    /** Pastikan bahasa yang diakses memang dimiliki Instruktur yang login. */
    private function pastikanMilikInstruktur(BahasaPemrograman $bahasa): void
    {
        abort_unless(
            (int) $bahasa->id_instruktur === (int) auth()->id(),
            404,
            'Data bahasa pemrograman tidak ditemukan.'
        );
    }

    private function catatAktivitas(string $jenis, string $deskripsi, ?int $idEntitas): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => $jenis,
            'deskripsi' => $deskripsi,
            'entitas' => 'bahasa_pemrograman',
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
        ]);

        $query = BahasaPemrograman::query()
            ->where('id_instruktur', auth()->id())
            ->withCount(['modul', 'contohKode'])
            ->orderBy('nama_bahasa');

        if (!empty($validated['q'])) {
            $kataKunci = trim($validated['q']);
            $query->where(function ($builder) use ($kataKunci) {
                $builder->where('nama_bahasa', 'like', "%{$kataKunci}%")
                    ->orWhere('deskripsi', 'like', "%{$kataKunci}%");
            });
        }

        if (array_key_exists('status', $validated) && $validated['status'] !== null && $validated['status'] !== '') {
            $query->where('status', (int) $validated['status']);
        }

        $bahasa = $query->paginate(10)->withQueryString();

        $statistik = BahasaPemrograman::query()
            ->where('id_instruktur', auth()->id())
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as aktif')
            ->selectRaw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as nonaktif')
            ->first();

        return view('instruktur.bahasa.index', [
            'bahasa' => $bahasa,
            'totalBahasa' => (int) ($statistik->total ?? 0),
            'bahasaAktif' => (int) ($statistik->aktif ?? 0),
            'bahasaNonaktif' => (int) ($statistik->nonaktif ?? 0),
        ]);
    }

    public function create()
    {
        $this->pastikanInstruktur();

        return view('instruktur.bahasa.create');
    }

    public function store(Request $request)
    {
        $this->pastikanInstruktur();

        $request->merge([
            'nama_bahasa' => trim((string) $request->input('nama_bahasa')),
        ]);

        $validated = $request->validate([
            'nama_bahasa' => [
                'required', 'string', 'max:100',
                Rule::unique('bahasa_pemrograman', 'nama_bahasa')
                    ->where(fn ($query) => $query->where('id_instruktur', auth()->id())),
            ],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
        ], [
            'nama_bahasa.required' => 'Nama bahasa pemrograman wajib diisi.',
            'nama_bahasa.unique' => 'Kamu sudah memiliki bahasa pemrograman dengan nama tersebut.',
            'nama_bahasa.max' => 'Nama bahasa maksimal 100 karakter.',
        ]);

        $bahasa = BahasaPemrograman::create([
            'id_instruktur' => auth()->id(),
            'nama_bahasa' => trim($validated['nama_bahasa']),
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => true,
        ]);

        $this->catatAktivitas(
            'Tambah Bahasa Pemrograman',
            'Instruktur menambahkan bahasa pemrograman: ' . $bahasa->nama_bahasa,
            (int) $bahasa->id
        );

        return redirect()->route('instruktur.bahasa.index')
            ->with('success', 'Bahasa pemrograman berhasil ditambahkan.');
    }

    public function edit(BahasaPemrograman $bahasa)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($bahasa);

        return view('instruktur.bahasa.edit', compact('bahasa'));
    }

    public function update(Request $request, BahasaPemrograman $bahasa)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($bahasa);

        $request->merge([
            'nama_bahasa' => trim((string) $request->input('nama_bahasa')),
        ]);

        $validated = $request->validate([
            'nama_bahasa' => [
                'required', 'string', 'max:100',
                Rule::unique('bahasa_pemrograman', 'nama_bahasa')
                    ->ignore($bahasa->id)
                    ->where(fn ($query) => $query->where('id_instruktur', auth()->id())),
            ],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::in(['0', '1', 0, 1])],
        ], [
            'nama_bahasa.required' => 'Nama bahasa pemrograman wajib diisi.',
            'nama_bahasa.unique' => 'Kamu sudah memiliki bahasa pemrograman dengan nama tersebut.',
            'status.required' => 'Status bahasa pemrograman wajib dipilih.',
        ]);

        $namaLama = $bahasa->nama_bahasa;
        $bahasa->update([
            'nama_bahasa' => trim($validated['nama_bahasa']),
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => (bool) $validated['status'],
        ]);

        $this->catatAktivitas(
            'Perbarui Bahasa Pemrograman',
            'Instruktur memperbarui bahasa pemrograman: ' . $namaLama . ' menjadi ' . $bahasa->nama_bahasa,
            (int) $bahasa->id
        );

        return redirect()->route('instruktur.bahasa.index')
            ->with('success', 'Bahasa pemrograman berhasil diperbarui.');
    }

    public function toggleStatus(BahasaPemrograman $bahasa)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($bahasa);

        $bahasa->status = ! (bool) $bahasa->status;
        $bahasa->save();

        $aksi = $bahasa->status ? 'Aktifkan Bahasa Pemrograman' : 'Nonaktifkan Bahasa Pemrograman';
        $kataKerja = $bahasa->status ? 'mengaktifkan' : 'menonaktifkan';

        $this->catatAktivitas(
            $aksi,
            'Instruktur ' . $kataKerja . ' bahasa pemrograman: ' . $bahasa->nama_bahasa,
            (int) $bahasa->id
        );

        return redirect()->route('instruktur.bahasa.index')
            ->with('success', $bahasa->status
                ? 'Bahasa pemrograman berhasil diaktifkan.'
                : 'Bahasa pemrograman berhasil dinonaktifkan.');
    }

    public function destroy(BahasaPemrograman $bahasa)
    {
        $this->pastikanInstruktur();
        $this->pastikanMilikInstruktur($bahasa);

        $idBahasa = (int) $bahasa->id;
        $namaBahasa = $bahasa->nama_bahasa;

        app(PenghapusanKontenService::class)->hapusBahasa(
            $idBahasa,
            function () use ($idBahasa, $namaBahasa) {
                $this->catatAktivitas(
                    'Hapus Bahasa Pemrograman',
                    'Instruktur menghapus bahasa pemrograman beserta seluruh modul dan konten terkait: ' . $namaBahasa,
                    $idBahasa
                );
            }
        );

        return redirect()->route('instruktur.bahasa.index')
            ->with('success', 'Bahasa pemrograman beserta seluruh modul dan konten turunannya berhasil dihapus.');
    }
}

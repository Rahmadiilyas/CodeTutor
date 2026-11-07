<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\BahasaPemrograman;
use App\Models\ContohKode;
use App\Models\LogAktivitas;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CodeLabController extends Controller
{
    private function pastikanInstruktur(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'instruktur',
            403,
            'Halaman ini hanya dapat diakses oleh Instruktur.'
        );
    }

    private function queryKodeMilikInstruktur()
    {
        return ContohKode::query()
            ->where('id_instruktur', auth()->id());
    }

    private function pastikanKodeMilikInstruktur(ContohKode $contohKode): void
    {
        abort_unless(
            (int) $contohKode->id_instruktur === (int) auth()->id(),
            404,
            'Contoh kode tidak ditemukan.'
        );
    }

    private function catatAktivitas(string $jenis, string $deskripsi, ?int $idEntitas): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => $jenis,
            'deskripsi' => $deskripsi,
            'entitas' => 'contoh_kode',
            'id_entitas' => $idEntitas,
            'waktu_aktivitas' => now(),
        ]);
    }

    private function bahasaMilikInstruktur()
    {
        return BahasaPemrograman::query()
            ->where('id_instruktur', auth()->id())
            ->orderBy('nama_bahasa')
            ->get();
    }

    private function materiMilikInstruktur()
    {
        return Materi::query()
            ->whereHas('modul', function ($query) {
                $query->where('id_instruktur', auth()->id());
            })
            ->with(['modul:id,id_bahasa,nama_modul', 'modul.bahasa:id,nama_bahasa'])
            ->orderBy('judul_materi')
            ->get();
    }

    public function index(Request $request)
    {
        $this->pastikanInstruktur();

        $dataFilter = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'id_bahasa' => ['nullable', 'integer'],
        ]);

        $query = $this->queryKodeMilikInstruktur()
            ->with(['bahasa', 'materi.modul.bahasa'])
            ->orderByDesc('updated_at')
            ->orderByDesc('id');

        if (!empty($dataFilter['q'])) {
            $kataKunci = trim($dataFilter['q']);
            $query->where(function ($builder) use ($kataKunci) {
                $builder->where('judul', 'like', "%{$kataKunci}%")
                    ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                    ->orWhere('kode_program', 'like', "%{$kataKunci}%")
                    ->orWhereHas('bahasa', function ($bahasaQuery) use ($kataKunci) {
                        $bahasaQuery->where('nama_bahasa', 'like', "%{$kataKunci}%");
                    })
                    ->orWhereHas('materi', function ($materiQuery) use ($kataKunci) {
                        $materiQuery->where('judul_materi', 'like', "%{$kataKunci}%");
                    });
            });
        }

        if (!empty($dataFilter['id_bahasa'])) {
            $query->where('id_bahasa', $dataFilter['id_bahasa']);
        }

        $kode = $query->paginate(10)->withQueryString();
        $bahasa = $this->bahasaMilikInstruktur();

        $totalKode = $this->queryKodeMilikInstruktur()->count();
        $kodeTerhubungMateri = $this->queryKodeMilikInstruktur()->whereNotNull('id_materi')->count();
        $kodeTanpaMateri = $this->queryKodeMilikInstruktur()->whereNull('id_materi')->count();
        $jumlahBahasaDigunakan = $this->queryKodeMilikInstruktur()->distinct()->count('id_bahasa');

        return view('instruktur.code-lab.index', compact(
            'kode',
            'bahasa',
            'totalKode',
            'kodeTerhubungMateri',
            'kodeTanpaMateri',
            'jumlahBahasaDigunakan'
        ));
    }

    public function create()
    {
        $this->pastikanInstruktur();

        return view('instruktur.code-lab.create', [
            'contohKode' => new ContohKode(),
            'bahasa' => $this->bahasaMilikInstruktur(),
            'materiList' => $this->materiMilikInstruktur(),
        ]);
    }

    public function store(Request $request)
    {
        $this->pastikanInstruktur();
        $data = $this->validasiData($request);

        $contohKode = $this->queryKodeMilikInstruktur()->create([
            'id_bahasa' => $data['id_bahasa'],
            'id_materi' => $data['id_materi'] ?? null,
            'id_instruktur' => auth()->id(),
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'kode_program' => $data['kode_program'],
            'hasil_diharapkan' => $data['hasil_diharapkan'] ?? null,
        ]);

        $this->catatAktivitas(
            'Tambah Contoh Kode',
            'Instruktur menambahkan contoh kode: ' . $contohKode->judul,
            $contohKode->id
        );

        return redirect()->route('instruktur.code-lab.index')
            ->with('success', 'Contoh kode berhasil ditambahkan.');
    }

    public function edit(ContohKode $contohKode)
    {
        $this->pastikanInstruktur();
        $this->pastikanKodeMilikInstruktur($contohKode);

        return view('instruktur.code-lab.edit', [
            'contohKode' => $contohKode->load(['bahasa', 'materi.modul']),
            'bahasa' => $this->bahasaMilikInstruktur(),
            'materiList' => $this->materiMilikInstruktur(),
        ]);
    }

    public function update(Request $request, ContohKode $contohKode)
    {
        $this->pastikanInstruktur();
        $this->pastikanKodeMilikInstruktur($contohKode);
        $data = $this->validasiData($request);

        $judulLama = $contohKode->judul;

        $contohKode->update([
            'id_bahasa' => $data['id_bahasa'],
            'id_materi' => $data['id_materi'] ?? null,
            'judul' => $data['judul'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'kode_program' => $data['kode_program'],
            'hasil_diharapkan' => $data['hasil_diharapkan'] ?? null,
        ]);

        $this->catatAktivitas(
            'Edit Contoh Kode',
            'Instruktur memperbarui contoh kode: ' . $judulLama . ' menjadi ' . $contohKode->judul,
            $contohKode->id
        );

        return redirect()->route('instruktur.code-lab.index')
            ->with('success', 'Contoh kode berhasil diperbarui.');
    }

    public function destroy(ContohKode $contohKode)
    {
        $this->pastikanInstruktur();
        $this->pastikanKodeMilikInstruktur($contohKode);

        if ($contohKode->eksekusi()->exists()) {
            return redirect()->route('instruktur.code-lab.index')
                ->with('error', 'Contoh kode ini sudah memiliki riwayat eksekusi. Hapus atau arsipkan riwayat terkait terlebih dahulu sesuai kebijakan sistem.');
        }

        $idEntitas = $contohKode->id;
        $judul = $contohKode->judul;

        $this->catatAktivitas(
            'Hapus Contoh Kode',
            'Instruktur menghapus contoh kode: ' . $judul,
            $idEntitas
        );

        $contohKode->delete();

        return redirect()->route('instruktur.code-lab.index')
            ->with('success', 'Contoh kode berhasil dihapus.');
    }

    private function validasiData(Request $request): array
{
    $request->merge([
        'judul' => trim((string) $request->input('judul')),
    ]);
        $data = $request->validate([
            'id_bahasa' => [
                'required',
                'integer',
                Rule::exists('bahasa_pemrograman', 'id')
                    ->where(fn ($query) => $query->where('id_instruktur', auth()->id())),
            ],
            'id_materi' => ['nullable', 'integer'],
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:5000'],
            'kode_program' => ['required', 'string', 'max:100000'],
            'hasil_diharapkan' => ['nullable', 'string', 'max:20000'],
        ], [
            'id_bahasa.required' => 'Pilih bahasa pemrograman terlebih dahulu.',
            'id_bahasa.exists' => 'Bahasa pemrograman tidak valid atau bukan milik akun Instruktur ini.',
            'judul.required' => 'Judul contoh kode wajib diisi.',
            'kode_program.required' => 'Kode program wajib diisi.',
        ]);

        if (!empty($data['id_materi'])) {
            $materi = Materi::query()
                ->whereKey($data['id_materi'])
                ->whereHas('modul', function ($query) {
                    $query->where('id_instruktur', auth()->id());
                })
                ->with('modul:id,id_bahasa,id_instruktur,nama_modul')
                ->first();

            if (!$materi) {
                throw ValidationException::withMessages([
                    'id_materi' => 'Materi tidak ditemukan atau bukan milik akun Instruktur ini.',
                ]);
            }

            if ((int) $materi->modul->id_bahasa !== (int) $data['id_bahasa']) {
                throw ValidationException::withMessages([
                    'id_materi' => 'Materi yang dipilih harus berasal dari bahasa pemrograman yang dipilih.',
                ]);
            }
        }

        return $data;
    }
}

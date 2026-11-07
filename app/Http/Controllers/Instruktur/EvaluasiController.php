<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\LogAktivitas;
use App\Models\Modul;
use App\Models\PengerjaanEvaluasi;
use App\Models\JawabanPelajar;
use App\Models\PilihanJawaban;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;



class EvaluasiController extends Controller
{
    private function pastikanInstruktur(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'instruktur',
            403,
            'Halaman ini hanya dapat diakses oleh Instruktur.'
        );
    }

    private function evaluasiMilikInstruktur()
    {
        return Evaluasi::query()
            ->where('id_instruktur', auth()->id())
            ->whereIn('jenis_evaluasi', ['pretest', 'posttest']);
    }

    private function pastikanEvaluasiMilikInstruktur(Evaluasi $evaluasi): void
    {
        abort_unless(
            (int) $evaluasi->id_instruktur === (int) auth()->id(),
            404,
            'Evaluasi tidak ditemukan.'
        );
    }

    private function modulMilikInstruktur()
    {
        return Modul::query()
            ->where('id_instruktur', auth()->id())
            ->with('bahasa:id,nama_bahasa')
            ->orderBy('urutan')
            ->orderBy('nama_modul')
            ->get();
    }

    private function catatAktivitas(string $jenis, string $deskripsi, ?int $idEntitas): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => $jenis,
            'deskripsi' => $deskripsi,
            'entitas' => 'evaluasi',
            'id_entitas' => $idEntitas,
            'waktu_aktivitas' => now(),
        ]);
    }

    public function index(Request $request)
    {
        $this->pastikanInstruktur();

        $filter = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'jenis_evaluasi' => ['nullable', Rule::in(['pretest', 'posttest'])],
            'id_modul' => ['nullable', 'integer'],
        ]);

        $query = $this->evaluasiMilikInstruktur()
            ->with(['modul:id,id_bahasa,nama_modul', 'modul.bahasa:id,nama_bahasa'])
            ->withCount(['soal', 'pengerjaan'])
            ->orderByDesc('updated_at')
            ->orderByDesc('id');

        if (!empty($filter['q'])) {
            $keyword = trim($filter['q']);
            $query->where(function ($builder) use ($keyword) {
                $builder->where('judul_evaluasi', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%")
                    ->orWhereHas('modul', function ($modulQuery) use ($keyword) {
                        $modulQuery->where('nama_modul', 'like', "%{$keyword}%");
                    });
            });
        }

        if (!empty($filter['jenis_evaluasi'])) {
            $query->where('jenis_evaluasi', $filter['jenis_evaluasi']);
        }

        if (!empty($filter['id_modul'])) {
            $query->where('id_modul', $filter['id_modul']);
        }

        $evaluasi = $query->paginate(10)->withQueryString();
        $modul = $this->modulMilikInstruktur();
        $totalEvaluasi = $this->evaluasiMilikInstruktur()->count();
        $totalSoal = Soal::query()->whereHas('evaluasi', function ($q) {
            $q->where('id_instruktur', auth()->id());
        })->count();
        // Statistik hasil Instruktur hanya menghitung Posttest.
        $totalPengerjaan = PengerjaanEvaluasi::query()
            ->whereHas('evaluasi', function ($query) {
                $query->where('id_instruktur', auth()->id())
                    ->where('jenis_evaluasi', 'posttest');
            })
            ->count();
        $evaluasiDenganPengerjaan = $this->evaluasiMilikInstruktur()
            ->where('jenis_evaluasi', 'posttest')
            ->whereHas('pengerjaan')
            ->count();

        return view('instruktur.evaluasi.index', compact(
            'evaluasi', 'modul', 'totalEvaluasi', 'totalSoal', 'totalPengerjaan', 'evaluasiDenganPengerjaan'
        ));
    }

    public function create(Request $request)
    {
        $this->pastikanInstruktur();
        $modul = $this->modulMilikInstruktur();

        // Jenis ditentukan oleh tombol "Buat Pretest" atau "Buat Posttest".
        // Form tidak lagi menampilkan dropdown jenis evaluasi.
        $jenis = $request->query('jenis_evaluasi', 'pretest');
        abort_unless(in_array($jenis, ['pretest', 'posttest'], true), 404, 'Jenis evaluasi tidak valid.');

        $evaluasi = new Evaluasi();
        $evaluasi->jenis_evaluasi = $jenis;

        return view('instruktur.evaluasi.create', [
            'evaluasi' => $evaluasi,
            'modul' => $modul,
        ]);
    }

    public function store(Request $request)
    {
        $this->pastikanInstruktur();

        // Jenis Post/Pretest dikunci berdasarkan konteks menu saat form dibuka.
        $jenisDariMenu = (string) $request->query('jenis_evaluasi', '');
        abort_unless(in_array($jenisDariMenu, ['pretest', 'posttest'], true), 404, 'Jenis evaluasi tidak valid. Buka formulir dari menu Buat Pretest atau Buat Posttest.');
        $request->merge(['jenis_evaluasi' => $jenisDariMenu]);
        $data = $this->validasiData($request, $jenisDariMenu);

        $evaluation = DB::transaction(function () use ($data) {
            $evaluation = Evaluasi::create([
                'id_modul' => $data['id_modul'],
                'id_instruktur' => auth()->id(),
                'judul_evaluasi' => $data['judul_evaluasi'],
                'jenis_evaluasi' => $data['jenis_evaluasi'],
                'deskripsi' => null,
                'nilai_minimal' => $data['nilai_minimal'],
            ]);

            // Durasi disimpan di kolom deskripsi yang sudah ada; tidak ada kolom baru.
            $evaluation->setDeskripsiDanDurasi(
                $data['deskripsi'] ?? null,
                (int) $data['durasi_menit']
            );
            $evaluation->save();

            $this->simpanSoal($evaluation, $data['soal']);

            $this->catatAktivitas(
                'Tambah Evaluasi',
                'Instruktur menambahkan evaluasi: ' . $evaluation->judul_evaluasi,
                $evaluation->id
            );

            return $evaluation;
        });

        return redirect()->route('instruktur.evaluasi.show', $evaluation)
            ->with('success', 'Evaluasi dan soal berhasil dibuat.');
    }

    public function show(Evaluasi $evaluasi)
    {
        $this->pastikanInstruktur();
        $this->pastikanEvaluasiMilikInstruktur($evaluasi);

        // Riwayat Pretest tidak ditampilkan/diteruskan ke area Instruktur.
        // Namun jumlah riwayat tetap diperiksa secara internal untuk mengunci edit.
        $adaRiwayatPengerjaan = $evaluasi->pengerjaan()->exists();

        $evaluasi->load([
            'modul.bahasa',
            'soal' => fn ($query) => $query->orderBy('urutan')->orderBy('id'),
            'soal.pilihan' => fn ($query) => $query->orderBy('urutan')->orderBy('id'),
        ])->loadCount('soal');

        if ($evaluasi->jenis_evaluasi === 'posttest') {
            $evaluasi->load([
                'pengerjaan' => fn ($query) => $query
                    ->with('pelajar:id,nama,email')
                    ->orderByDesc('updated_at')
                    ->orderByDesc('id'),
            ])->loadCount('pengerjaan');
        } else {
            $evaluasi->setRelation('pengerjaan', collect());
            $evaluasi->setAttribute('pengerjaan_count', 0);
        }

        return view('instruktur.evaluasi.show', compact('evaluasi', 'adaRiwayatPengerjaan'));
    }

    public function edit(Evaluasi $evaluasi)
    {
        $this->pastikanInstruktur();
        $this->pastikanEvaluasiMilikInstruktur($evaluasi);

        if ($evaluasi->pengerjaan()->exists()) {
            return redirect()->route('instruktur.evaluasi.show', $evaluasi)
                ->with('error', 'Evaluasi tidak dapat diedit karena sudah memiliki riwayat pengerjaan Pelajar. Ini untuk menjaga konsistensi nilai dan riwayat yang sudah tercatat.');
        }

        $evaluasi->load(['soal' => fn ($query) => $query->orderBy('urutan')->orderBy('id'), 'soal.pilihan']);

        return view('instruktur.evaluasi.edit', [
            'evaluasi' => $evaluasi,
            'modul' => $this->modulMilikInstruktur(),
        ]);
    }

    public function update(Request $request, Evaluasi $evaluasi)
    {
        $this->pastikanInstruktur();
        $this->pastikanEvaluasiMilikInstruktur($evaluasi);

        if ($evaluasi->pengerjaan()->exists()) {
            return redirect()->route('instruktur.evaluasi.show', $evaluasi)
                ->with('error', 'Evaluasi tidak dapat diperbarui karena sudah memiliki riwayat pengerjaan Pelajar.');
        }

        $data = $this->validasiData($request, $evaluasi->jenis_evaluasi);
        $judulLama = $evaluasi->judul_evaluasi;

        DB::transaction(function () use ($evaluasi, $data, $judulLama) {
            $evaluasi->update([
                'id_modul' => $data['id_modul'],
                'judul_evaluasi' => $data['judul_evaluasi'],
                'jenis_evaluasi' => $data['jenis_evaluasi'],
                'deskripsi' => null,
                'nilai_minimal' => $data['nilai_minimal'],
            ]);
            $evaluasi->setDeskripsiDanDurasi(
                $data['deskripsi'] ?? null,
                (int) $data['durasi_menit']
            );
            $evaluasi->save();

            // Aman dilakukan karena update diblokir apabila evaluasi sudah memiliki pengerjaan.
            $evaluasi->soal()->delete();
            $this->simpanSoal($evaluasi, $data['soal']);

            $this->catatAktivitas(
                'Edit Evaluasi',
                'Instruktur memperbarui evaluasi: ' . $judulLama . ' menjadi ' . $evaluasi->judul_evaluasi,
                $evaluasi->id
            );
        });

        return redirect()->route('instruktur.evaluasi.show', $evaluasi)
            ->with('success', 'Evaluasi berhasil diperbarui.');
    }

    public function destroy(Evaluasi $evaluasi)
    {
        $this->pastikanInstruktur();
        $this->pastikanEvaluasiMilikInstruktur($evaluasi);

        if ($evaluasi->pengerjaan()->exists()) {
            return redirect()->route('instruktur.evaluasi.index')
                ->with('error', 'Evaluasi tidak dapat dihapus karena sudah memiliki riwayat pengerjaan Pelajar.');
        }

        $id = $evaluasi->id;
        $judul = $evaluasi->judul_evaluasi;

        DB::transaction(function () use ($evaluasi, $id, $judul) {
            $this->catatAktivitas('Hapus Evaluasi', 'Instruktur menghapus evaluasi: ' . $judul, $id);
            $evaluasi->delete();
        });

        return redirect()->route('instruktur.evaluasi.index')
            ->with('success', 'Evaluasi berhasil dihapus.');
    }

    /**
     * Menampilkan lembar penilaian jawaban essay/coding yang dikumpulkan Pelajar.
     * Menggunakan kolom dan relasi database yang sudah ada.
     */
    public function showPenilaian(Evaluasi $evaluasi, PengerjaanEvaluasi $pengerjaan)
    {
        $this->pastikanInstruktur();
        $this->pastikanEvaluasiMilikInstruktur($evaluasi);
        abort_unless($evaluasi->jenis_evaluasi === 'posttest', 404, 'Hasil Pretest tidak ditampilkan pada area Instruktur.');

        abort_unless((int) $pengerjaan->id_evaluasi === (int) $evaluasi->id, 404, 'Pengerjaan tidak ditemukan pada evaluasi ini.');

        $pengerjaan->load([
            'pelajar:id,nama,email',
            'evaluasi.soal',
            'jawaban.soal',
        ]);

        $menungguPenilaian = $pengerjaan->status === 'menunggu_penilaian'
            || ($pengerjaan->waktu_selesai !== null && $pengerjaan->nilai === null);

        if (!$menungguPenilaian) {
            return redirect()->route('instruktur.evaluasi.show', $evaluasi)
                ->with('info', 'Pengerjaan ini tidak lagi menunggu penilaian.');
        }

        $jawabanSubjektif = $pengerjaan->jawaban
            ->filter(function ($jawaban) {
                return $jawaban->soal && in_array($jawaban->soal->jenis_soal, ['essay', 'coding'], true);
            })
            ->sortBy(function ($jawaban) {
                return $jawaban->soal->urutan ?? $jawaban->id;
            })
            ->values();

        if ($jawabanSubjektif->isEmpty()) {
            return redirect()->route('instruktur.evaluasi.show', $evaluasi)
                ->with('info', 'Pengerjaan ini tidak memiliki jawaban essay/coding yang perlu dinilai.');
        }

        return view('instruktur.evaluasi.penilaian', compact(
            'evaluasi', 'pengerjaan', 'jawabanSubjektif'
        ));
    }

    /**
     * Menyimpan seluruh nilai subjektif, menghitung nilai akhir dari total bobot,
     * lalu menandai pengerjaan selesai setelah semua jawaban diperiksa.
     */
    public function simpanPenilaian(Request $request, Evaluasi $evaluasi, PengerjaanEvaluasi $pengerjaan)
    {
        $this->pastikanInstruktur();
        $this->pastikanEvaluasiMilikInstruktur($evaluasi);
        abort_unless($evaluasi->jenis_evaluasi === 'posttest', 404, 'Hasil Pretest tidak ditampilkan pada area Instruktur.');

        abort_unless((int) $pengerjaan->id_evaluasi === (int) $evaluasi->id, 404, 'Pengerjaan tidak ditemukan pada evaluasi ini.');

        $pengerjaan->load(['evaluasi.soal', 'jawaban.soal']);
        $menungguPenilaian = $pengerjaan->status === 'menunggu_penilaian'
            || ($pengerjaan->waktu_selesai !== null && $pengerjaan->nilai === null);

        if (!$menungguPenilaian) {
            return redirect()->route('instruktur.evaluasi.show', $evaluasi)
                ->with('info', 'Pengerjaan ini sudah dinilai atau tidak menunggu penilaian.');
        }

        $jawabanSubjektif = $pengerjaan->jawaban
            ->filter(function ($jawaban) {
                return $jawaban->soal && in_array($jawaban->soal->jenis_soal, ['essay', 'coding'], true);
            })
            ->values();

        if ($jawabanSubjektif->isEmpty()) {
            return redirect()->route('instruktur.evaluasi.show', $evaluasi)
                ->with('info', 'Tidak ada jawaban essay/coding yang perlu dinilai.');
        }

        $rules = ['nilai_jawaban' => ['required', 'array']];
        $messages = [
            'nilai_jawaban.required' => 'Nilai untuk setiap jawaban essay/coding wajib diisi.',
        ];
        foreach ($jawabanSubjektif as $jawaban) {
            $field = 'nilai_jawaban.' . $jawaban->id;
            $bobot = max(0, (int) $jawaban->soal->bobot);
            $rules[$field] = ['required', 'integer', 'min:0', 'max:' . $bobot];
            $messages[$field . '.required'] = 'Nilai wajib diisi untuk soal ini.';
            $messages[$field . '.integer'] = 'Nilai harus berupa bilangan bulat.';
            $messages[$field . '.min'] = 'Nilai tidak boleh kurang dari 0.';
            $messages[$field . '.max'] = 'Nilai tidak boleh melebihi bobot soal (' . $bobot . ').';
        }

        $validated = $request->validate($rules, $messages);
        $nilaiInput = $validated['nilai_jawaban'];
        $idJawabanSubjektif = $jawabanSubjektif->pluck('id')->map(fn ($id) => (int) $id)->all();

        DB::transaction(function () use ($evaluasi, $pengerjaan, $nilaiInput, $idJawabanSubjektif) {
            $terkunci = PengerjaanEvaluasi::query()
                ->whereKey($pengerjaan->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless((int) $terkunci->id_evaluasi === (int) $evaluasi->id, 404, 'Pengerjaan tidak ditemukan pada evaluasi ini.');

            $masihMenunggu = $terkunci->status === 'menunggu_penilaian'
                || ($terkunci->waktu_selesai !== null && $terkunci->nilai === null);
            abort_unless($masihMenunggu, 409, 'Pengerjaan ini sudah dinilai. Muat ulang halaman untuk melihat status terbaru.');

            $jawabanValid = JawabanPelajar::query()
                ->where('id_pengerjaan', $terkunci->id)
                ->whereIn('id', $idJawabanSubjektif)
                ->with('soal')
                ->get();

            abort_unless($jawabanValid->count() === count($idJawabanSubjektif), 409, 'Daftar jawaban berubah. Muat ulang halaman penilaian.');

            foreach ($jawabanValid as $jawaban) {
                abort_unless(
                    $jawaban->soal && in_array($jawaban->soal->jenis_soal, ['essay', 'coding'], true),
                    409,
                    'Jawaban yang dipilih bukan jawaban essay/coding.'
                );
                $jawaban->update([
                    'nilai' => (int) $nilaiInput[$jawaban->id],
                ]);
            }

            $totalBobot = (int) $evaluasi->soal()->sum('bobot');
            $totalDiperoleh = (int) JawabanPelajar::query()
                ->where('id_pengerjaan', $terkunci->id)
                ->sum('nilai');
            $nilaiAkhir = $totalBobot > 0
                ? (int) round(($totalDiperoleh / $totalBobot) * 100)
                : 0;
            $nilaiAkhir = max(0, min(100, $nilaiAkhir));

            $terkunci->update([
                'nilai' => $nilaiAkhir,
                'status' => 'selesai',
            ]);

            LogAktivitas::create([
                'id_user' => auth()->id(),
                'jenis_aktivitas' => 'Penilaian Evaluasi',
                'deskripsi' => 'Instruktur menilai evaluasi "' . $evaluasi->judul_evaluasi
                    . '" untuk Pelajar ID ' . $terkunci->id_pelajar
                    . '. Nilai akhir: ' . $nilaiAkhir . '/100.',
                'entitas' => 'pengerjaan_evaluasi',
                'id_entitas' => $terkunci->id,
                'waktu_aktivitas' => now(),
            ]);
        });

        return redirect()->route('instruktur.evaluasi.show', $evaluasi)
            ->with('success', 'Penilaian tersimpan. Nilai akhir Pelajar sudah dihitung dan status pengerjaan menjadi selesai.');
    }

    private function validasiData(Request $request, ?string $jenisTetap = null): array
    {
$request->merge([
    'judul_evaluasi' => trim(
        (string) $request->input('judul_evaluasi')
    ),
]);

$soal = $request->input('soal', []);

if (is_array($soal)) {
    foreach ($soal as $index => $item) {
        if (
            is_array($item) &&
            array_key_exists('pertanyaan', $item)
        ) {
            $soal[$index]['pertanyaan'] = trim(
                (string) $item['pertanyaan']
            );
        }
    }

    $request->merge(['soal' => $soal]);
}


        $data = $request->validate([
            'id_modul' => [
                'required', 'integer',
                Rule::exists('modul', 'id')->where(fn ($query) => $query->where('id_instruktur', auth()->id())),
            ],
            'judul_evaluasi' => ['required', 'string', 'max:255'],
            'jenis_evaluasi' => ['required', Rule::in($jenisTetap ? [$jenisTetap] : ['pretest', 'posttest'])],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'nilai_minimal' => ['required', 'integer', 'min:0', 'max:100'],
            'durasi_menit' => ['required', 'integer', 'min:1', 'max:600'],
            'soal' => ['required', 'array', 'min:1'],
            'soal.*.pertanyaan' => ['required', 'string', 'max:10000'],
            'soal.*.jenis_soal' => ['required', Rule::in(['pilihan_ganda', 'essay', 'coding'])],
            'soal.*.bobot' => ['required', 'integer', 'min:1', 'max:1000'],
            'soal.*.pilihan' => ['nullable', 'array'],
            'soal.*.pilihan.*.teks_pilihan' => ['nullable', 'string', 'max:5000'],
            'soal.*.pilihan.*.adalah_jawaban_benar' => ['nullable', 'boolean'],
        ], [
            'id_modul.required' => 'Pilih modul untuk evaluasi ini.',
            'id_modul.exists' => 'Modul tidak valid atau bukan milik akun Instruktur ini.',
            'judul_evaluasi.required' => 'Judul evaluasi wajib diisi.',
            'jenis_evaluasi.required' => 'Jenis evaluasi tidak ditemukan. Buka formulir dari menu Pretest atau Posttest.',
            'nilai_minimal.required' => 'Nilai minimal wajib diisi.',
            'nilai_minimal.max' => 'Nilai minimal tidak boleh melebihi 100.',
            'durasi_menit.required' => 'Durasi pengerjaan wajib diisi.',
            'durasi_menit.integer' => 'Durasi pengerjaan harus berupa angka bulat dalam menit.',
            'durasi_menit.min' => 'Durasi minimal adalah 1 menit.',
            'durasi_menit.max' => 'Durasi maksimal adalah 600 menit.',
            'soal.required' => 'Tambahkan setidaknya satu soal.',
            'soal.min' => 'Tambahkan setidaknya satu soal.',
            'soal.*.pertanyaan.required' => 'Teks pertanyaan wajib diisi.',
        ]);

        foreach ($data['soal'] as $index => $question) {
            if ($data['jenis_evaluasi'] === 'pretest' && ($question['jenis_soal'] ?? null) !== 'pilihan_ganda') {
                throw ValidationException::withMessages([
                    "soal.{$index}.jenis_soal" => 'Semua soal Pretest wajib menggunakan jenis pilihan ganda.',
                ]);
            }

            if (($question['jenis_soal'] ?? null) !== 'pilihan_ganda') {
                continue;
            }

            $choices = $question['pilihan'] ?? [];
            $filledChoices = array_values(array_filter($choices, function ($choice) {
                return isset($choice['teks_pilihan']) && trim((string) $choice['teks_pilihan']) !== '';
            }));

            if (count($filledChoices) < 2) {
                throw ValidationException::withMessages([
                    "soal.{$index}.pilihan" => 'Soal pilihan ganda harus memiliki minimal dua pilihan jawaban yang terisi.',
                ]);
            }

            $correctChoices = array_filter($filledChoices, function ($choice) {
                return filter_var($choice['adalah_jawaban_benar'] ?? false, FILTER_VALIDATE_BOOLEAN);
            });

            if (count($correctChoices) !== 1) {
                throw ValidationException::withMessages([
                    "soal.{$index}.pilihan" => 'Setiap soal pilihan ganda harus memiliki tepat satu jawaban benar.',
                ]);
            }
        }

        return $data;
    }

    private function simpanSoal(Evaluasi $evaluasi, array $daftarSoal): void
    {
        foreach (array_values($daftarSoal) as $indexSoal => $dataSoal) {
            $soal = Soal::create([
                'id_evaluasi' => $evaluasi->id,
                'pertanyaan' => trim($dataSoal['pertanyaan']),
                'jenis_soal' => $dataSoal['jenis_soal'],
                'bobot' => $dataSoal['bobot'],
                'urutan' => $indexSoal + 1,
            ]);

            if ($dataSoal['jenis_soal'] !== 'pilihan_ganda') {
                continue;
            }

            $pilihan = array_values(array_filter($dataSoal['pilihan'] ?? [], function ($choice) {
                return isset($choice['teks_pilihan']) && trim((string) $choice['teks_pilihan']) !== '';
            }));

            foreach ($pilihan as $indexPilihan => $dataPilihan) {
                PilihanJawaban::create([
                    'id_soal' => $soal->id,
                    'teks_pilihan' => trim($dataPilihan['teks_pilihan']),
                    'adalah_jawaban_benar' => filter_var($dataPilihan['adalah_jawaban_benar'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'urutan' => $indexPilihan + 1,
                ]);
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\JawabanPelajar;
use App\Models\LogAktivitas;
use App\Models\PengerjaanEvaluasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PengerjaanEvaluasiController extends Controller
{
    private function pastikanPelajar(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'pelajar',
            403,
            'Halaman ini hanya dapat diakses oleh Pelajar.'
        );
    }

    /** Evaluasi yang tersedia hanya Pretest dan Posttest pada modul/bahasa aktif. */
    private function queryEvaluasiTersedia()
    {
        return Evaluasi::query()
            ->whereIn('jenis_evaluasi', ['pretest', 'posttest'])
            ->whereHas('modul', function ($modulQuery) {
                $modulQuery->where('status', true)
                    ->whereHas('bahasa', function ($bahasaQuery) {
                        $bahasaQuery->where('status', true);
                    });
            });
    }

    private function pastikanPengerjaanMilikPelajar(PengerjaanEvaluasi $pengerjaan): void
    {
        abort_unless(
            (int) $pengerjaan->id_pelajar === (int) auth()->id(),
            404,
            'Data pengerjaan tidak ditemukan.'
        );
    }

    private function catatAktivitas(string $jenis, string $deskripsi, int $idEntitas): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => $jenis,
            'deskripsi' => $deskripsi,
            'entitas' => 'pengerjaan_evaluasi',
            'id_entitas' => $idEntitas,
            'waktu_aktivitas' => now(),
        ]);
    }

    private function batasWaktu(PengerjaanEvaluasi $pengerjaan, Evaluasi $evaluasi): Carbon
    {
        $mulai = $pengerjaan->waktu_mulai
            ? Carbon::parse($pengerjaan->waktu_mulai)
            : Carbon::parse($pengerjaan->created_at ?? now());

        return $mulai->copy()->addMinutes(max(1, (int) $evaluasi->durasi_menit));
    }

    private function halamanJenis(string $jenis)
    {
        return redirect()->route('pelajar.evaluasi.index', [
            'jenis_evaluasi' => in_array($jenis, ['pretest', 'posttest'], true) ? $jenis : 'pretest',
        ]);
    }

    /**
     * Satu view dipakai untuk dua menu. Parameter jenis_evaluasi dari sidebar
     * menentukan konteks Pretest atau Posttest; tidak ada dropdown jenis di halaman.
     */
    public function index(Request $request)
    {
        $this->pastikanPelajar();

        $jenisMenu = (string) $request->query('jenis_evaluasi', 'pretest');
        abort_unless(in_array($jenisMenu, ['pretest', 'posttest'], true), 404, 'Menu evaluasi tidak ditemukan.');

        $filter = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $query = $this->queryEvaluasiTersedia()
            ->where('jenis_evaluasi', $jenisMenu)
            ->with(['modul:id,nama_modul,id_bahasa,status', 'modul.bahasa:id,nama_bahasa,status'])
            ->withCount('soal')
            ->orderBy('id_modul')
            ->orderBy('id');

        if (!empty($filter['q'])) {
            $kataKunci = trim($filter['q']);
            $query->where(function ($builder) use ($kataKunci) {
                $builder->where('judul_evaluasi', 'like', "%{$kataKunci}%")
                    ->orWhere('deskripsi', 'like', "%{$kataKunci}%")
                    ->orWhereHas('modul', function ($modulQuery) use ($kataKunci) {
                        $modulQuery->where('nama_modul', 'like', "%{$kataKunci}%");
                    });
            });
        }

        $evaluasi = $query->paginate(10)->withQueryString();
        $pengerjaanPelajar = PengerjaanEvaluasi::query()
            ->where('id_pelajar', auth()->id())
            ->whereIn('id_evaluasi', $evaluasi->getCollection()->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->unique('id_evaluasi')
            ->keyBy('id_evaluasi');

        $attemptsMenu = fn () => PengerjaanEvaluasi::query()
            ->where('id_pelajar', auth()->id())
            ->whereHas('evaluasi', fn ($q) => $q->where('jenis_evaluasi', $jenisMenu));

        $totalTersedia = $this->queryEvaluasiTersedia()
            ->where('jenis_evaluasi', $jenisMenu)
            ->count();
        $totalSelesai = $attemptsMenu()
            ->whereIn('status', ['selesai', 'menunggu_penilaian'])
            ->count();
        $totalMenungguPenilaian = $jenisMenu === 'posttest'
            ? $attemptsMenu()->where('status', 'menunggu_penilaian')->count()
            : 0;

        return view('pelajar.evaluasi.index', compact(
            'evaluasi',
            'pengerjaanPelajar',
            'totalTersedia',
            'totalSelesai',
            'totalMenungguPenilaian',
            'jenisMenu'
        ));
    }

    public function start(Evaluasi $evaluasi)
    {
        $this->pastikanPelajar();

        $evaluasi = $this->queryEvaluasiTersedia()
            ->with(['modul.bahasa', 'soal'])
            ->findOrFail($evaluasi->id);

        if ($evaluasi->soal->isEmpty()) {
            return $this->halamanJenis($evaluasi->jenis_evaluasi)
                ->with('error', 'Evaluasi ini belum memiliki soal, sehingga belum dapat dikerjakan.');
        }

        // Pencegahan di sisi server: seluruh soal Pretest wajib pilihan ganda.
        if ($evaluasi->jenis_evaluasi === 'pretest' && $evaluasi->soal->contains(fn ($soal) => $soal->jenis_soal !== 'pilihan_ganda')) {
            return $this->halamanJenis('pretest')
                ->with('error', 'Pretest ini memiliki jenis soal yang tidak sesuai. Hubungi Instruktur untuk memperbaikinya.');
        }

        $idPelajar = (int) auth()->id();

        $hasil = DB::transaction(function () use ($evaluasi, $idPelajar) {
            $evaluasiTerkunci = Evaluasi::query()
                ->whereKey($evaluasi->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                $this->queryEvaluasiTersedia()->whereKey($evaluasiTerkunci->id)->exists(),
                404,
                'Evaluasi tidak tersedia.'
            );

            $pengerjaan = PengerjaanEvaluasi::query()
                ->where('id_evaluasi', $evaluasiTerkunci->id)
                ->where('id_pelajar', $idPelajar)
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if ($pengerjaan) {
                return [
                    'status' => ($pengerjaan->status === 'belum_selesai' && !$pengerjaan->waktu_selesai)
                        ? 'lanjut'
                        : 'sudah_dikirim',
                    'pengerjaan' => $pengerjaan,
                ];
            }

            $pengerjaanBaru = PengerjaanEvaluasi::create([
                'id_evaluasi' => $evaluasiTerkunci->id,
                'id_pelajar' => $idPelajar,
                'waktu_mulai' => now(),
                'status' => 'belum_selesai',
                'nilai' => null,
            ]);

            $this->catatAktivitas(
                'Mulai Evaluasi',
                'Pelajar memulai ' . ucfirst($evaluasiTerkunci->jenis_evaluasi) . ': ' . $evaluasiTerkunci->judul_evaluasi,
                $pengerjaanBaru->id
            );

            return ['status' => 'baru', 'pengerjaan' => $pengerjaanBaru];
        });

        if ($hasil['status'] === 'lanjut') {
            return redirect()->route('pelajar.evaluasi.kerjakan', $hasil['pengerjaan']);
        }

        if ($hasil['status'] === 'sudah_dikirim') {
            return $this->halamanJenis($evaluasi->jenis_evaluasi)
                ->with('info', 'Kamu sudah mengumpulkan evaluasi ini. Status pengerjaan: '
                    . str_replace('_', ' ', $hasil['pengerjaan']->status) . '.');
        }

        return redirect()->route('pelajar.evaluasi.kerjakan', $hasil['pengerjaan'])
            ->with('success', ucfirst($evaluasi->jenis_evaluasi) . ' dimulai. Timer berjalan sesuai durasi yang ditentukan Instruktur.');
    }

    public function show(PengerjaanEvaluasi $pengerjaan)
    {
        $this->pastikanPelajar();
        $this->pastikanPengerjaanMilikPelajar($pengerjaan);
        $pengerjaan->loadMissing('evaluasi');
        $jenisEvaluasi = $pengerjaan->evaluasi?->jenis_evaluasi ?? 'pretest';

        if ($pengerjaan->status !== 'belum_selesai' || $pengerjaan->waktu_selesai) {
            return $this->halamanJenis($jenisEvaluasi)
                ->with('info', 'Evaluasi ini sudah dikumpulkan dan tidak dapat diubah lagi.');
        }

        $pengerjaan->load([
            'evaluasi.modul.bahasa',
            'evaluasi.soal' => fn ($query) => $query->orderBy('urutan')->orderBy('id'),
            'evaluasi.soal.pilihan' => fn ($query) => $query->orderBy('urutan')->orderBy('id'),
        ]);

        abort_if(!$pengerjaan->evaluasi, 404, 'Evaluasi tidak ditemukan.');

        $durasiMenit = max(1, (int) $pengerjaan->evaluasi->durasi_menit);
        $batasWaktu = $this->batasWaktu($pengerjaan, $pengerjaan->evaluasi);
        $sisaDetik = max(0, $batasWaktu->timestamp - now()->timestamp);

        return view('pelajar.evaluasi.kerjakan', compact(
            'pengerjaan', 'durasiMenit', 'sisaDetik', 'batasWaktu'
        ));
    }

    public function submit(Request $request, PengerjaanEvaluasi $pengerjaan)
    {
        $this->pastikanPelajar();
        $this->pastikanPengerjaanMilikPelajar($pengerjaan);
        $pengerjaan->loadMissing('evaluasi');
        $jenisEvaluasi = $pengerjaan->evaluasi?->jenis_evaluasi ?? 'pretest';

        if ($pengerjaan->status !== 'belum_selesai' || $pengerjaan->waktu_selesai) {
            return $this->halamanJenis($jenisEvaluasi)
                ->with('error', 'Evaluasi ini sudah pernah dikumpulkan. Jawaban tidak dapat dikirim ulang.');
        }

        $pengerjaan->load([
            'evaluasi.soal' => fn ($query) => $query->orderBy('urutan')->orderBy('id'),
            'evaluasi.soal.pilihan',
        ]);

        $evaluasi = $pengerjaan->evaluasi;
        abort_if(!$evaluasi, 404, 'Evaluasi tidak ditemukan.');

        $soalList = $evaluasi->soal;
        if ($soalList->isEmpty()) {
            return $this->halamanJenis($jenisEvaluasi)
                ->with('error', 'Evaluasi tidak memiliki soal dan tidak dapat dikumpulkan.');
        }

        if ($evaluasi->jenis_evaluasi === 'pretest' && $soalList->contains(fn ($soal) => $soal->jenis_soal !== 'pilihan_ganda')) {
            return $this->halamanJenis('pretest')
                ->with('error', 'Pretest harus berisi soal pilihan ganda. Hubungi Instruktur untuk memperbaiki evaluasi ini.');
        }

        $rules = ['jawaban' => ['nullable', 'array']];
        foreach ($soalList as $soal) {
            if ($soal->jenis_soal === 'pilihan_ganda') {
                $rules["jawaban.{$soal->id}.pilihan"] = [
                    'nullable',
                    'integer',
                    Rule::exists('pilihan_jawaban', 'id')->where(fn ($query) => $query->where('id_soal', $soal->id)),
                ];
            } else {
                $rules["jawaban.{$soal->id}.teks"] = ['nullable', 'string', 'max:50000'];
            }
        }

        $validated = $request->validate($rules);
        $jawabanInput = $validated['jawaban'] ?? [];

        // Hanya Posttest yang boleh memiliki essay/coding dan menunggu penilaian Instruktur.
        $adaSoalSubjektif = $evaluasi->jenis_evaluasi === 'posttest'
            && $soalList->contains(fn ($soal) => in_array($soal->jenis_soal, ['essay', 'coding'], true));

        $pengirimanFinal = $request->boolean('pengiriman_final');
        $waktuHabisSaatDikirim = false;
        $waktuSelesaiTersimpan = null;

        $berhasilDikirim = DB::transaction(function () use (
            $soalList,
            $jawabanInput,
            $pengerjaan,
            $evaluasi,
            $adaSoalSubjektif,
            $pengirimanFinal,
            &$waktuHabisSaatDikirim,
            &$waktuSelesaiTersimpan
        ) {
            $pengerjaanTerkunci = PengerjaanEvaluasi::query()
                ->whereKey($pengerjaan->id)
                ->where('id_pelajar', auth()->id())
                ->lockForUpdate()
                ->firstOrFail();

            if ($pengerjaanTerkunci->status !== 'belum_selesai' || $pengerjaanTerkunci->waktu_selesai) {
                return false;
            }

            $waktuMulai = $pengerjaanTerkunci->waktu_mulai
                ? Carbon::parse($pengerjaanTerkunci->waktu_mulai)
                : Carbon::parse($pengerjaanTerkunci->created_at ?? now());
            $batasWaktu = $waktuMulai->copy()->addMinutes(max(1, (int) $evaluasi->durasi_menit));
            $waktuHabisSaatDikirim = now()->greaterThanOrEqualTo($batasWaktu);

            // Jika kiriman terlambat bukan dari timer halaman yang aktif, abaikan jawaban yang baru dikirim.
            if ($waktuHabisSaatDikirim && !$pengirimanFinal) {
                $jawabanInput = [];
            }

            $totalBobot = (int) $soalList->sum('bobot');
            $totalDiperoleh = 0;

            foreach ($soalList as $soal) {
                $isian = $jawabanInput[$soal->id] ?? [];
                $pilihanId = null;
                $teks = null;
                $benar = null;
                $nilaiJawaban = null;

                if ($soal->jenis_soal === 'pilihan_ganda') {
                    $pilihanId = isset($isian['pilihan']) && $isian['pilihan'] !== ''
                        ? (int) $isian['pilihan']
                        : null;
                    $pilihanTerpilih = $pilihanId ? $soal->pilihan->firstWhere('id', $pilihanId) : null;
                    $benar = (bool) ($pilihanTerpilih && $pilihanTerpilih->adalah_jawaban_benar);
                    $nilaiJawaban = $benar ? max(0, (int) $soal->bobot) : 0;
                    $totalDiperoleh += $nilaiJawaban;
                } else {
                    $teks = isset($isian['teks']) ? trim((string) $isian['teks']) : null;
                    if ($teks === '') {
                        $teks = null;
                    }
                }

                JawabanPelajar::create([
                    'id_pengerjaan' => $pengerjaanTerkunci->id,
                    'id_soal' => $soal->id,
                    'id_pilihan' => $pilihanId,
                    'jawaban_teks' => $teks,
                    'benar' => $soal->jenis_soal === 'pilihan_ganda' ? $benar : null,
                    'nilai' => $nilaiJawaban,
                ]);
            }

            $nilaiAkhir = null;
            if (!$adaSoalSubjektif) {
                $nilaiAkhir = $totalBobot > 0
                    ? (int) round(($totalDiperoleh / $totalBobot) * 100)
                    : 0;
            }

            $waktuSelesaiTersimpan = $waktuHabisSaatDikirim ? $batasWaktu : now();
            $pengerjaanTerkunci->update([
                'waktu_selesai' => $waktuSelesaiTersimpan,
                'status' => $adaSoalSubjektif ? 'menunggu_penilaian' : 'selesai',
                'nilai' => $nilaiAkhir,
            ]);

            LogAktivitas::create([
                'id_user' => auth()->id(),
                'jenis_aktivitas' => 'Kumpulkan Evaluasi',
                'deskripsi' => ucfirst($evaluasi->jenis_evaluasi) . ' dikumpulkan: ' . $evaluasi->judul_evaluasi
                    . ($waktuHabisSaatDikirim ? ' (waktu habis)' : ''),
                'entitas' => 'pengerjaan_evaluasi',
                'id_entitas' => $pengerjaanTerkunci->id,
                'waktu_aktivitas' => now(),
            ]);

            return true;
        });

        if (!$berhasilDikirim) {
            return $this->halamanJenis($jenisEvaluasi)
                ->with('error', 'Evaluasi sudah dikumpulkan. Jawaban tidak dapat dikirim ulang.');
        }

        if ($waktuHabisSaatDikirim) {
            $pesan = 'Waktu habis. Sistem telah mengumpulkan jawaban terakhir yang dikirim dari halaman evaluasi.';
        } elseif ($evaluasi->jenis_evaluasi === 'pretest') {
            $pesan = 'Latihan Pretest berhasil dikumpulkan. Nilai latihan dapat kamu lihat di halaman hasil dan tidak ditampilkan pada penilaian Instruktur.';
        } elseif ($adaSoalSubjektif) {
            $pesan = 'Jawaban Posttest berhasil dikumpulkan. Essay atau coding akan menunggu penilaian Instruktur.';
        } else {
            $pesan = 'Jawaban Posttest berhasil dikumpulkan. Nilai pilihan ganda sudah dihitung dan hasilnya tersedia untuk Instruktur.';
        }

        return $this->halamanJenis($jenisEvaluasi)->with('success', $pesan);
    }
}

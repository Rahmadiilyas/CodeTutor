<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use App\Models\PengerjaanEvaluasi;

class HasilEvaluasiController extends Controller
{
    /** Menampilkan hasil evaluasi milik Pelajar yang sedang login. */
    public function show(PengerjaanEvaluasi $pengerjaan)
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'pelajar',
            403,
            'Halaman ini hanya dapat diakses oleh Pelajar.'
        );

        abort_unless(
            (int) $pengerjaan->id_pelajar === (int) auth()->id(),
            404,
            'Hasil evaluasi tidak ditemukan.'
        );

        $pengerjaan->loadMissing('evaluasi');
        abort_if(!$pengerjaan->evaluasi, 404, 'Evaluasi tidak ditemukan.');
        $jenisEvaluasi = $pengerjaan->evaluasi->jenis_evaluasi;

        if (!$pengerjaan->waktu_selesai || $pengerjaan->status === 'belum_selesai') {
            return redirect()
                ->route('pelajar.evaluasi.kerjakan', $pengerjaan)
                ->with('info', 'Evaluasi belum dikumpulkan. Selesaikan dan kumpulkan jawaban terlebih dahulu.');
        }

        $pengerjaan->load([
            'evaluasi.modul.bahasa',
            'evaluasi.soal' => fn ($query) => $query->orderBy('urutan')->orderBy('id'),
            'evaluasi.soal.pilihan' => fn ($query) => $query->orderBy('urutan')->orderBy('id'),
            'jawaban.pilihan',
        ]);

        $evaluasi = $pengerjaan->evaluasi;
        $jawabanPerSoal = $pengerjaan->jawaban->keyBy('id_soal');
        $menungguPenilaian = $pengerjaan->status === 'menunggu_penilaian' || is_null($pengerjaan->nilai);
        $nilaiMinimal = (int) ($evaluasi->nilai_minimal ?? 70);
        $nilai = is_null($pengerjaan->nilai) ? null : (float) $pengerjaan->nilai;
        $lulus = !$menungguPenilaian && $nilai !== null && $nilai >= $nilaiMinimal;

        $rincianSoal = $evaluasi->soal->map(function ($soal) use ($jawabanPerSoal, $pengerjaan) {
            $jawaban = $jawabanPerSoal->get($soal->id);
            $pilihanBenar = $soal->pilihan->first(fn ($pilihan) => (bool) $pilihan->adalah_jawaban_benar);

            return [
                'soal' => $soal,
                'jawaban' => $jawaban,
                'pilihan_benar' => $pilihanBenar,
                'poin_diperoleh' => $jawaban && $jawaban->nilai !== null ? (int) $jawaban->nilai : null,
                'menunggu_penilaian' => in_array($soal->jenis_soal, ['essay', 'coding'], true)
                    && ($pengerjaan->status === 'menunggu_penilaian' || !$jawaban || $jawaban->nilai === null),
            ];
        });

        return view('pelajar.evaluasi.hasil', compact(
            'pengerjaan',
            'evaluasi',
            'rincianSoal',
            'menungguPenilaian',
            'nilaiMinimal',
            'nilai',
            'lulus'
        ));
    }
}

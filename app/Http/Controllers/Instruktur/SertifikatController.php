<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Evaluasi;
use App\Models\LogAktivitas;
use App\Models\Modul;
use App\Models\ProgresBelajar;
use App\Models\Sertifikat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class SertifikatController extends Controller
{
    private function pastikanInstruktur(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'instruktur',
            403,
            'Halaman sertifikat hanya dapat diakses oleh Instruktur.'
        );
    }

    public function index(Request $request)
    {
        $this->pastikanInstruktur();

        $modulList = Modul::query()
            ->where('id_instruktur', auth()->id())
            ->with('bahasa:id,nama_bahasa')
            ->orderBy('nama_modul')
            ->get();

        $requestedId = $request->query('modul');
        $selectedModul = $requestedId
            ? $modulList->firstWhere('id', (int) $requestedId)
            : $modulList->first();

        if ($requestedId && !$selectedModul) {
            abort(404, 'Modul tidak ditemukan atau bukan milik akun Instruktur ini.');
        }

        $rows = collect();
        if ($selectedModul) {
            $students = User::query()
                ->where('peran', 'pelajar')
                ->where('status', true)
                ->orderBy('nama')
                ->get();

            $progressByStudent = ProgresBelajar::query()
                ->where('id_modul', $selectedModul->id)
                ->get()
                ->keyBy('id_pelajar');

            $postTests = $this->postTestsForModule($selectedModul);

            $certificatesByStudent = Sertifikat::query()
                ->where('id_modul', $selectedModul->id)
                ->where('status', 'terbit')
                ->get()
                ->keyBy('id_pelajar');

            $rows = $students->map(function (User $student) use ($progressByStudent, $postTests, $certificatesByStudent) {
                $progress = $progressByStudent->get($student->id);
                $percent = (float) ($progress->presentase_progres ?? 0);

                $testResults = $postTests->map(function (Evaluasi $evaluation) use ($student) {
                    $latest = $evaluation->pengerjaan
                        ->where('id_pelajar', $student->id)
                        ->sortByDesc('id')
                        ->first();

                    $passed = $latest
                        && $latest->status === 'selesai'
                        && $latest->nilai !== null
                        && (int) $latest->nilai >= (int) $evaluation->nilai_minimal;

                    return [
                        'title' => $evaluation->judul_evaluasi,
                        'nilai' => $latest?->nilai,
                        'nilai_minimal' => (int) $evaluation->nilai_minimal,
                        'status' => $latest?->status ?? 'belum_dikerjakan',
                        'passed' => (bool) $passed,
                    ];
                })->values();

                $allTestsPassed = $postTests->isNotEmpty()
                    && $testResults->every(fn ($item) => $item['passed']);
                $eligible = $percent >= 100 && $allTestsPassed;
                $certificate = $certificatesByStudent->get($student->id);

                if ($certificate) {
                    $reason = 'Sertifikat sudah diterbitkan.';
                } elseif ($percent < 100) {
                    $reason = 'Progres modul harus mencapai 100%.';
                } elseif ($postTests->isEmpty()) {
                    $reason = 'Modul ini belum memiliki post-test.';
                } elseif (!$allTestsPassed) {
                    $reason = 'Semua post-test harus selesai dan mencapai nilai minimum.';
                } else {
                    $reason = 'Memenuhi kriteria penerbitan.';
                }

                return [
                    'pelajar' => $student,
                    'progres' => $percent,
                    'status_progres' => $progress?->status ?? 'belum_mulai',
                    'post_tests' => $testResults,
                    'jumlah_posttest' => $postTests->count(),
                    'posttest_lulus' => $testResults->where('passed', true)->count(),
                    'layak' => $eligible,
                    'alasan' => $reason,
                    'sertifikat' => $certificate,
                ];
            });
        }

        $totalModul = $modulList->count();
        $totalTerbit = Sertifikat::query()
            ->where('id_instruktur', auth()->id())
            ->where('status', 'terbit')
            ->count();

        return view('instruktur.sertifikat.index', compact(
            'modulList', 'selectedModul', 'rows', 'totalModul', 'totalTerbit'
        ));
    }

    /**
     * Tanda tangan disimpan di public storage dengan nama berdasarkan ID instruktur.
     * Dengan pola ini tidak diperlukan kolom/migration database baru.
     */
    public function uploadSignature(Request $request): RedirectResponse
    {
        $this->pastikanInstruktur();

        $validated = $request->validate([
            'tanda_tangan' => ['required', 'file', 'mimes:png', 'image', 'max:2048'],
        ], [
            'tanda_tangan.required' => 'Pilih gambar tanda tangan terlebih dahulu.',
            'tanda_tangan.mimes' => 'Tanda tangan harus berupa file PNG.',
            'tanda_tangan.image' => 'File yang dipilih harus berupa gambar.',
            'tanda_tangan.max' => 'Ukuran tanda tangan maksimal 2 MB.',
        ]);

        $directory = 'signatures/instructors';
        $filename = auth()->id() . '.png';
        $stored = Storage::disk('local')->putFileAs(
            $directory,
            $validated['tanda_tangan'],
            $filename
        );

        if (!$stored) {
            return back()->with('error', 'Tanda tangan gagal disimpan. Silakan coba lagi.');
        }

        return back()->with('success', 'Tanda tangan instruktur berhasil disimpan. Sertifikat yang diterbitkan berikutnya akan menggunakannya.');
    }

    private function tandaTanganDataUri(int $instrukturId): ?string
    {
        $path = 'signatures/instructors/' . $instrukturId . '.png';

        if (!Storage::disk('local')->exists($path)) {
            return null;
        }

        $contents = Storage::disk('local')->get($path);
        if ($contents === '') {
            return null;
        }

        return 'data:image/png;base64,' . base64_encode($contents);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->pastikanInstruktur();

        $data = $request->validate([
            'id_modul' => ['required', 'integer'],
            'id_pelajar' => ['required', 'integer'],
        ]);

        $modul = Modul::query()
            ->where('id', $data['id_modul'])
            ->where('id_instruktur', auth()->id())
            ->firstOrFail();

        $pelajar = User::query()
            ->where('id', $data['id_pelajar'])
            ->where('peran', 'pelajar')
            ->where('status', true)
            ->firstOrFail();

        $alreadyIssued = Sertifikat::query()
            ->where('id_pelajar', $pelajar->id)
            ->where('id_modul', $modul->id)
            ->where('status', 'terbit')
            ->exists();

        if ($alreadyIssued) {
            return back()->with('info', 'Sertifikat untuk Pelajar dan modul tersebut sudah diterbitkan.');
        }

        $eligibility = $this->checkEligibility($pelajar, $modul);
        if (!$eligibility['eligible']) {
            return back()->with('error', 'Sertifikat belum dapat diterbitkan: ' . $eligibility['reason']);
        }

        $nomor = $this->generateNomorSertifikat();
        $tanggal = now();
        $path = 'certificates/' . $nomor . '.pdf';
        $instruktur = auth()->user();

        try {
            $pdfBytes = Pdf::loadView('pdf.sertifikat', [
                'pelajar' => $pelajar,
                'instruktur' => $instruktur,
                'modul' => $modul->load('bahasa'),
                'nomorSertifikat' => $nomor,
                'tanggalTerbit' => $tanggal,
                'tandaTanganDataUri' => $this->tandaTanganDataUri((int) $instruktur->id),
            ])->setPaper('a4', 'landscape')->output();

            if (!Storage::disk('local')->put($path, $pdfBytes)) {
                throw new \RuntimeException('File PDF gagal disimpan.');
            }

            DB::transaction(function () use ($pelajar, $modul, $nomor, $tanggal, $path) {
                Sertifikat::create([
                    'id_pelajar' => $pelajar->id,
                    'id_instruktur' => auth()->id(),
                    'id_modul' => $modul->id,
                    'judul_sertifikat' => 'Sertifikat Penyelesaian Modul ' . $modul->nama_modul,
                    'nomor_sertifikat' => $nomor,
                    'tanggal_terbit' => $tanggal->toDateString(),
                    'lokasi_file' => $path,
                    'status' => 'terbit',
                ]);

                LogAktivitas::create([
                    'id_user' => auth()->id(),
                    'jenis_aktivitas' => 'Terbitkan Sertifikat',
                    'deskripsi' => 'Instruktur menerbitkan sertifikat untuk ' . $pelajar->nama . ' pada modul ' . $modul->nama_modul,
                    'entitas' => 'sertifikat',
                    'id_entitas' => null,
                    'waktu_aktivitas' => now(),
                ]);
            });
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($path);
            Log::error('Penerbitan sertifikat gagal.', [
                'instruktur_id' => auth()->id(),
                'pelajar_id' => $pelajar->id,
                'modul_id' => $modul->id,
                'error' => $exception->getMessage(),
            ]);

            return back()->with('error', 'Sertifikat belum diterbitkan karena PDF atau penyimpanan data gagal. Periksa log Laravel.');
        }

        return redirect()
            ->route('instruktur.sertifikat.index', ['modul' => $modul->id])
            ->with('success', 'Sertifikat berhasil diterbitkan dan tersimpan.');
    }

    /**
     * Buat ulang PDF sertifikat yang sudah terbit dengan desain terbaru.
     * Nomor, tanggal, dan baris sertifikat lama tetap dipertahankan.
     */
    public function regenerate(Sertifikat $sertifikat): RedirectResponse
    {
        $this->pastikanInstruktur();

        abort_unless(
            $sertifikat->status === 'terbit'
                && (int) $sertifikat->id_instruktur === (int) auth()->id(),
            404,
            'Sertifikat tidak ditemukan atau bukan diterbitkan oleh akun ini.'
        );

        $sertifikat->load(['pelajar', 'modul.bahasa']);
        $pelajar = $sertifikat->pelajar;
        $modul = $sertifikat->modul;

        abort_unless(
            $pelajar && $modul && (int) $modul->id_instruktur === (int) auth()->id(),
            404,
            'Data penerima atau modul sertifikat tidak tersedia.'
        );

        $nomor = $sertifikat->nomor_sertifikat;
        $tanggal = Carbon::parse($sertifikat->tanggal_terbit);
        $safeNumber = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $nomor);
        abort_if($safeNumber === '', 404, 'Nomor sertifikat tidak valid.');
        $path = 'certificates/' . $safeNumber . '.pdf';

        try {
            $pdfBytes = Pdf::loadView('pdf.sertifikat', [
                'pelajar' => $pelajar,
                'instruktur' => auth()->user(),
                'modul' => $modul,
                'nomorSertifikat' => $nomor,
                'tanggalTerbit' => $tanggal,
                'tandaTanganDataUri' => $this->tandaTanganDataUri((int) auth()->id()),
            ])->setPaper('a4', 'landscape')->output();

            if (!Storage::disk('local')->put($path, $pdfBytes)) {
                throw new \RuntimeException('File PDF gagal disimpan.');
            }

            $sertifikat->update(['lokasi_file' => $path]);
        } catch (Throwable $exception) {
            Log::error('Regenerasi sertifikat gagal.', [
                'sertifikat_id' => $sertifikat->id,
                'instruktur_id' => auth()->id(),
                'error' => $exception->getMessage(),
            ]);

            return back()->with('error', 'PDF sertifikat gagal diperbarui. Periksa log Laravel.');
        }

        return back()->with('success', 'PDF sertifikat berhasil diperbarui dengan desain terbaru.');
    }

    private function postTestsForModule(Modul $modul): Collection
    {
        return Evaluasi::query()
            ->where('id_modul', $modul->id)
            ->where('id_instruktur', auth()->id())
            ->where('jenis_evaluasi', 'posttest')
            ->with(['pengerjaan' => fn ($query) => $query->orderByDesc('id')])
            ->orderBy('id')
            ->get();
    }

    private function checkEligibility(User $pelajar, Modul $modul): array
    {
        $progress = ProgresBelajar::query()
            ->where('id_pelajar', $pelajar->id)
            ->where('id_modul', $modul->id)
            ->first();

        $percent = (float) ($progress->presentase_progres ?? 0);
        if ($percent < 100) {
            return ['eligible' => false, 'reason' => 'Progres modul belum mencapai 100%.'];
        }

        $postTests = $this->postTestsForModule($modul);
        if ($postTests->isEmpty()) {
            return ['eligible' => false, 'reason' => 'Modul ini belum memiliki post-test.'];
        }

        foreach ($postTests as $evaluation) {
            $latest = $evaluation->pengerjaan
                ->where('id_pelajar', $pelajar->id)
                ->sortByDesc('id')
                ->first();

            if (!$latest || $latest->status !== 'selesai' || $latest->nilai === null || (int) $latest->nilai < (int) $evaluation->nilai_minimal) {
                return ['eligible' => false, 'reason' => 'Semua post-test harus selesai dan mencapai nilai minimum.'];
            }
        }

        return ['eligible' => true, 'reason' => 'Memenuhi kriteria.'];
    }

    private function generateNomorSertifikat(): string
    {
        do {
            $number = 'MK-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (Sertifikat::query()->where('nomor_sertifikat', $number)->exists());

        return $number;
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\AktivitasController;
use App\Http\Controllers\Admin\PengawasanKontenController;
use App\Http\Controllers\Admin\ProgresPelajarController;
use App\Http\Controllers\Admin\ReferensiChatbotController;
use App\Http\Controllers\Instruktur\BahasaPemrogramanController;
use App\Http\Controllers\Instruktur\ModulController;
use App\Http\Controllers\Instruktur\MateriController;
use App\Http\Controllers\Instruktur\MediaPembelajaranController;
use App\Http\Controllers\Instruktur\CodeLabController;
use App\Http\Controllers\Instruktur\EvaluasiController;
use App\Http\Controllers\Pelajar\PengerjaanEvaluasiController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Pelajar\HasilEvaluasiController;
use App\Http\Controllers\Pelajar\ChatbotController;
use App\Http\Controllers\Pelajar\PembelajaranController;
use App\Http\Controllers\Pelajar\CodeExecutionController;
use App\Http\Controllers\Pelajar\CodeEditorController;
use App\Http\Controllers\Instruktur\SertifikatController as InstrukturSertifikatController;
use App\Http\Controllers\Pelajar\SertifikatController as PelajarSertifikatController;
use App\Http\Controllers\Pelajar\ProfilController;
use App\Http\Controllers\ProgresBelajarController;
use App\Http\Controllers\Instruktur\ReferensiChatbotController as InstrukturReferensiChatbotController;


/*
|--------------------------------------------------------------------------
| GUEST
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('guest');
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login',[LoginController::class, 'showLogin'])->name('login');
Route::post('/login',[LoginController::class, 'login'])->name('login.process');
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.store');

Route::get('/verifikasi-otp', [RegisterController::class, 'showOtp'])
    ->name('otp.show');

Route::post('/verifikasi-otp', [RegisterController::class, 'verifyOtp'])
    ->middleware('throttle:5,1')
    ->name('otp.verify');

Route::post('/verifikasi-otp/kirim-ulang', [RegisterController::class, 'resendOtp'])
    ->middleware('throttle:3,1')
    ->name('otp.resend');

    Route::get('/lupa-password', [LoginController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('/lupa-password', [LoginController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])
    ->name('password.update');
/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->peran === 'admin') {
            $totalInstruktur = \App\Models\User::where('peran', 'instruktur')->count();
            $instrukturAktif = \App\Models\User::where('peran', 'instruktur')
                ->where('status', true)
                ->count();
            $totalPelajar = \App\Models\User::where('peran', 'pelajar')->count();
            $pelajarAktif = \App\Models\User::where('peran', 'pelajar')
                ->where('status', true)
                ->count();
            $aktivitasTerbaru = \App\Models\LogAktivitas::query()
                ->orderByDesc('waktu_aktivitas')
                ->limit(8)
                ->get();
            $aktivitasHariIni = \App\Models\LogAktivitas::query()
                ->whereDate('waktu_aktivitas', now()->toDateString())
                ->count();

            return view('admin.dashboard', compact(
                'totalInstruktur',
                'instrukturAktif',
                'totalPelajar',
                'pelajarAktif',
                'aktivitasTerbaru',
                'aktivitasHariIni'
            ));
        }

        if ($user->peran === 'instruktur') {
            $instrukturId = (int) $user->id;

            $bahasaInstruktur = \App\Models\BahasaPemrograman::query()
                ->where('id_instruktur', $instrukturId)
                ->where('status', true)
                ->orderBy('nama_bahasa')
                ->get();

            $modulIdsInstruktur = \App\Models\Modul::query()
                ->where('id_instruktur', $instrukturId)
                ->pluck('id');

            $totalModulInstruktur = \App\Models\Modul::query()
                ->where('id_instruktur', $instrukturId)
                ->where('status', true)
                ->count();

            $modulInstruktur = \App\Models\Modul::query()
                ->where('id_instruktur', $instrukturId)
                ->where('status', true)
                ->with('bahasa')
                ->withCount(['materi' => function ($query) {
                    $query->where('status', true);
                }])
                ->orderBy('urutan')
                ->orderBy('nama_modul')
                ->limit(8)
                ->get();

            $totalMateriInstruktur = \App\Models\Materi::query()
                ->where('status', true)
                ->whereHas('modul', function ($query) use ($instrukturId) {
                    $query->where('id_instruktur', $instrukturId)
                        ->where('status', true);
                })
                ->count();

            // Dashboard Instruktur hanya menghitung evaluasi Posttest.
            $totalEvaluasiInstruktur = \App\Models\Evaluasi::query()
                ->where('id_instruktur', $instrukturId)
                ->where('jenis_evaluasi', 'posttest')
                ->count();

            $totalPelajarTerpantau = \App\Models\ProgresBelajar::query()
                ->whereIn('id_modul', $modulIdsInstruktur)
                ->whereNotNull('id_pelajar')
                ->distinct()
                ->count('id_pelajar');

            $totalPengerjaanEvaluasi = \App\Models\PengerjaanEvaluasi::query()
                ->whereHas('evaluasi', function ($query) use ($instrukturId) {
                    $query->where('id_instruktur', $instrukturId)
                        ->where('jenis_evaluasi', 'posttest');
                })
                ->count();

            $menungguPenilaian = \App\Models\PengerjaanEvaluasi::query()
                ->whereHas('evaluasi', function ($query) use ($instrukturId) {
                    $query->where('id_instruktur', $instrukturId)
                        ->where('jenis_evaluasi', 'posttest');
                })
                ->where('status', 'menunggu_penilaian')
                ->count();

            $rataProgresInstruktur = \App\Models\ProgresBelajar::query()
                ->whereIn('id_modul', $modulIdsInstruktur)
                ->avg('presentase_progres');
            $rataProgresInstruktur = min(100, max(0, (float) ($rataProgresInstruktur ?? 0)));

            $progresPelajarTerbaru = \App\Models\ProgresBelajar::query()
                ->whereIn('id_modul', $modulIdsInstruktur)
                ->with(['pelajar:id,nama,email', 'modul:id,nama_modul,id_instruktur'])
                ->orderByDesc('updated_at')
                ->limit(8)
                ->get();

            $aktivitasInstruktur = \App\Models\LogAktivitas::query()
                ->where('id_user', $instrukturId)
                ->orderByDesc('waktu_aktivitas')
                ->limit(5)
                ->get();

            return view('instruktur.dashboard', compact(
                'bahasaInstruktur',
                'modulInstruktur',
                'totalModulInstruktur',
                'totalMateriInstruktur',
                'totalEvaluasiInstruktur',
                'totalPelajarTerpantau',
                'totalPengerjaanEvaluasi',
                'menungguPenilaian',
                'rataProgresInstruktur',
                'progresPelajarTerbaru',
                'aktivitasInstruktur'
            ));
        }

        abort_unless($user->peran === 'pelajar', 403, 'Peran pengguna tidak dikenali.');

        $pelajarId = (int) $user->id;

        // Styling logo hanya untuk tampilan; seluruh nama dan daftar bahasa berasal dari database.
        $languageStyles = [
            'python' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/python/python-original.svg', 'brand' => '#3776AB', 'bg' => 'bg-blue-50'],
            'java' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/java/java-original.svg', 'brand' => '#007396', 'bg' => 'bg-orange-50'],
            'javascript' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg', 'brand' => '#F7DF1E', 'bg' => 'bg-yellow-50'],
            'js' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg', 'brand' => '#F7DF1E', 'bg' => 'bg-yellow-50'],
            'php' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg', 'brand' => '#777BB4', 'bg' => 'bg-purple-50'],
            'c++' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/cplusplus/cplusplus-original.svg', 'brand' => '#00599C', 'bg' => 'bg-sky-50'],
            'cpp' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/cplusplus/cplusplus-original.svg', 'brand' => '#00599C', 'bg' => 'bg-sky-50'],
            'c' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/c/c-original.svg', 'brand' => '#A8B9CC', 'bg' => 'bg-slate-100'],
            'c#' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/csharp/csharp-original.svg', 'brand' => '#512BD4', 'bg' => 'bg-violet-50'],
            'csharp' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/csharp/csharp-original.svg', 'brand' => '#512BD4', 'bg' => 'bg-violet-50'],
            'dart' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/dart/dart-original.svg', 'brand' => '#0175C2', 'bg' => 'bg-sky-50'],
            'go' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/go/go-original.svg', 'brand' => '#00ADD8', 'bg' => 'bg-cyan-50'],
            'golang' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/go/go-original.svg', 'brand' => '#00ADD8', 'bg' => 'bg-cyan-50'],
            'kotlin' => ['logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/kotlin/kotlin-original.svg', 'brand' => '#7F52FF', 'bg' => 'bg-violet-50'],
        ];

        $styleForLanguage = function (?string $name) use ($languageStyles): array {
            $key = strtolower(trim((string) $name));
            return $languageStyles[$key] ?? ['logo' => null, 'brand' => '#64748B', 'bg' => 'bg-slate-100'];
        };

        $activeModules = \App\Models\Modul::query()
            ->where('status', true)
            ->whereHas('bahasa', function ($query) {
                $query->where('status', true);
            })
            ->with('bahasa')
            ->withCount(['materi' => function ($query) {
                $query->where('status', true);
            }])
            ->orderBy('urutan')
            ->orderBy('nama_modul')
            ->get();

        $progressByModule = \App\Models\ProgresBelajar::query()
            ->where('id_pelajar', $pelajarId)
            ->get()
            ->keyBy('id_modul');

        $totalMateriTersedia = (int) $activeModules->sum('materi_count');
        $totalMateriSelesai = (int) $activeModules->sum(function ($modul) use ($progressByModule) {
            $progress = $progressByModule->get($modul->id);
            return min((int) $modul->materi_count, max(0, (int) ($progress?->materi_selesai ?? 0)));
        });

        $overallProgress = $totalMateriTersedia > 0
            ? round(($totalMateriSelesai / $totalMateriTersedia) * 100, 1)
            : 0;
        $overallProgress = min(100, max(0, $overallProgress));

        $bahasaAktif = \App\Models\BahasaPemrograman::query()
            ->where('status', true)
            ->orderBy('nama_bahasa')
            ->get();

        $languages = $bahasaAktif->map(function ($bahasa) use ($activeModules, $progressByModule, $styleForLanguage) {
            $modules = $activeModules->where('id_bahasa', $bahasa->id);
            $totalMateri = (int) $modules->sum('materi_count');
            $completedMateri = (int) $modules->sum(function ($modul) use ($progressByModule) {
                $progress = $progressByModule->get($modul->id);
                return min((int) $modul->materi_count, max(0, (int) ($progress?->materi_selesai ?? 0)));
            });
            $style = $styleForLanguage($bahasa->nama_bahasa);

            return [
                'id' => $bahasa->id,
                'key' => strtolower((string) $bahasa->nama_bahasa),
                'name' => $bahasa->nama_bahasa,
                'desc' => $bahasa->deskripsi ?: 'Bahasa pemrograman',
                'logo' => $style['logo'],
                'brand' => $style['brand'],
                'bg' => $style['bg'],
                'progress' => $totalMateri > 0 ? round(($completedMateri / $totalMateri) * 100) : 0,
                'level' => $totalMateri > 0 ? 'Materi tersedia' : 'Belum ada materi aktif',
                'lessons' => $totalMateri,
            ];
        })->values()->all();

        $recentProgress = \App\Models\ProgresBelajar::query()
            ->where('id_pelajar', $pelajarId)
            ->whereHas('modul', function ($query) {
                $query->where('status', true)
                    ->whereHas('bahasa', function ($bahasaQuery) {
                        $bahasaQuery->where('status', true);
                    });
            })
            ->with('modul.bahasa')
            ->orderByDesc('updated_at')
            ->first();

        $recentModuleSummary = $recentProgress
            ? $activeModules->firstWhere('id', $recentProgress->id_modul)
            : null;
        $recentModuleMaterialsTotal = (int) ($recentModuleSummary->materi_count ?? 0);
        $recentModuleMaterialsDone = min(
            $recentModuleMaterialsTotal,
            max(0, (int) ($recentProgress?->materi_selesai ?? 0))
        );
        $recentProgressPercent = min(100, max(0, (float) ($recentProgress?->presentase_progres ?? 0)));
        $recentLanguageName = $recentProgress?->modul?->bahasa?->nama_bahasa;
        $recentModuleLogo = $recentLanguageName
            ? ($styleForLanguage($recentLanguageName)['logo'] ?? null)
            : null;

        $recommendationBase = $activeModules->filter(function ($modul) use ($recentProgress) {
            return (int) $modul->materi_count > 0
                && (!$recentProgress || (int) $modul->id !== (int) $recentProgress->id_modul);
        });
        if ($recommendationBase->isEmpty()) {
            $recommendationBase = $activeModules->filter(fn ($modul) => (int) $modul->materi_count > 0);
        }
        $recommendedModules = $recommendationBase->take(2)->map(function ($modul) use ($styleForLanguage) {
            $style = $styleForLanguage($modul->bahasa?->nama_bahasa);
            $modul->setAttribute('dashboard_logo', $style['logo']);
            $modul->setAttribute('dashboard_bg', $style['bg']);
            return $modul;
        })->values();

        // Statistik evaluasi Pelajar pada dashboard hanya menggunakan hasil Posttest.
        $completedEvaluationsQuery = \App\Models\PengerjaanEvaluasi::query()
            ->where('id_pelajar', $pelajarId)
            ->where('status', 'selesai')
            ->whereNotNull('waktu_selesai')
            ->whereHas('evaluasi', function ($query) {
                $query->where('jenis_evaluasi', 'posttest');
            });
        $totalEvaluasiSelesai = (clone $completedEvaluationsQuery)->count();
        $rataNilai = (clone $completedEvaluationsQuery)
            ->whereNotNull('nilai')
            ->avg('nilai');

        $totalEksekusiKode = \App\Models\EksekusiKode::query()
            ->where('id_pelajar', $pelajarId)
            ->count();

        $recentActivities = \App\Models\LogAktivitas::query()
            ->where('id_user', $pelajarId)
            ->orderByDesc('waktu_aktivitas')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'languages',
            'overallProgress',
            'totalMateriSelesai',
            'totalMateriTersedia',
            'totalEvaluasiSelesai',
            'rataNilai',
            'totalEksekusiKode',
            'recentProgress',
            'recentLanguageName',
            'recentModuleLogo',
            'recentModuleMaterialsTotal',
            'recentModuleMaterialsDone',
            'recentProgressPercent',
            'recommendedModules',
            'recentActivities'
        ));
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Materi
    |--------------------------------------------------------------------------
    */

    Route::get('/materi', [PembelajaranController::class, 'index'])
    ->name('materi');


    /*
    |--------------------------------------------------------------------------
    | Latihan
    |--------------------------------------------------------------------------
    */
    Route::get('/latihan', function () {
    abort_unless(
        auth()->user()->peran === 'pelajar',
        403,
        'Halaman latihan hanya untuk pelajar.'
    );

    return redirect()->route('pelajar.evaluasi.index', [
        'jenis_evaluasi' => 'pretest',
    ]);
})->name('latihan');
    /*
    |--------------------------------------------------------------------------
    | Code Editor
    |--------------------------------------------------------------------------
    */

    

Route::get('/code-editor', [CodeEditorController::class, 'index'])
    ->name('code-editor');


    Route::post('/code-editor/execute', [CodeExecutionController::class, 'execute'])
    ->middleware('throttle:10,1')
    ->name('code-editor.execute');

    /*
    |--------------------------------------------------------------------------
    | Test
    |--------------------------------------------------------------------------
    */

    Route::get('/test', function () {
    abort_unless(
        app()->environment('local'),
        404,
        'Halaman tidak ditemukan.'
    );

    return view('test');
})->name('test');


    /*
    |--------------------------------------------------------------------------
    | Progress
    |--------------------------------------------------------------------------
    */

    Route::get('/progress', [ProgresBelajarController::class, 'index'])
    ->middleware('auth')
    ->name('progress');

    Route::get('/progress/pelajar/{pelajar}', [ProgresBelajarController::class, 'showPelajar'])
        ->middleware('auth')
        ->name('progress.pelajar.show');


    /*
    |--------------------------------------------------------------------------
    | Riwayat
    |--------------------------------------------------------------------------
    */

    Route::get('/riwayat', function () {
    abort_unless(
        auth()->user()->peran === 'pelajar',
        403,
        'Halaman riwayat hanya untuk pelajar.'
    );

    return view('riwayat');
})->name('riwayat');

});




Route::get('/register', [RegisterController::class, 'showRegister'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest')
    ->name('register.store');
/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| Kelola Akun
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    
    ->group(function () {


Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');

Route::get('/pengawasan-konten',[PengawasanKontenController::class, 'index'])->name('pengawasan-konten.index');

Route::get('/progres-pelajar',[ProgresPelajarController::class, 'index'])->name('progres-pelajar.index');

Route::get('/progres-pelajar/{pelajar}', [ProgresPelajarController::class, 'show'])->name('progres-pelajar.show');

Route::get('/referensi-chatbot', [ReferensiChatbotController::class, 'index'])
    ->name('referensi-chatbot.index');
Route::get('/referensi-chatbot/create', [ReferensiChatbotController::class, 'create'])
    ->name('referensi-chatbot.create');
Route::post('/referensi-chatbot', [ReferensiChatbotController::class, 'store'])
    ->name('referensi-chatbot.store');
Route::get('/referensi-chatbot/{referensiChatbot}/edit', [ReferensiChatbotController::class, 'edit'])
    ->name('referensi-chatbot.edit');
Route::put('/referensi-chatbot/{referensiChatbot}', [ReferensiChatbotController::class, 'update'])
    ->name('referensi-chatbot.update');
Route::patch('/referensi-chatbot/{referensiChatbot}/status', [ReferensiChatbotController::class, 'toggleStatus'])
    ->name('referensi-chatbot.status');
Route::delete('/referensi-chatbot/{referensiChatbot}', [ReferensiChatbotController::class, 'destroy'])
    ->name('referensi-chatbot.destroy');

        /*
        |--------------------------------------------------------------------------
        | HALAMAN UTAMA KELOLA AKUN
        |--------------------------------------------------------------------------
        */

        Route::get('/akun',[AkunController::class,'index'])->name('akun.index');

        /*
        |--------------------------------------------------------------------------
        | AKUN INSTRUKTUR
        |--------------------------------------------------------------------------
        */
        // Form tambah instruktur
        Route::get('/akun/instruktur/create',[AkunController::class,'createInstruktur'])->name('akun.instruktur.create');


        // Simpan instruktur
        Route::post(
            '/akun/instruktur',
            [
                AkunController::class,
                'storeInstruktur'
            ]
        )->name('akun.instruktur.store');


        // Form edit instruktur
        Route::get(
            '/akun/instruktur/{akun}/edit',
            [
                AkunController::class,
                'editInstruktur'
            ]
        )->name('akun.instruktur.edit');


        // Update instruktur
        Route::put(
            '/akun/instruktur/{akun}',
            [
                AkunController::class,
                'updateInstruktur'
            ]
        )->name('akun.instruktur.update');


        // Hapus instruktur
        Route::delete(
            '/akun/instruktur/{akun}',
            [
                AkunController::class,
                'destroyInstruktur'
            ]
        )->name('akun.instruktur.destroy');


        /*
        |--------------------------------------------------------------------------
        | AKUN PELAJAR
        |--------------------------------------------------------------------------
        |
        | Admin TIDAK mempunyai route:
        | - create
        | - store
        | - edit
        | - update
        |
        | Admin hanya:
        | - show
        | - delete
        |--------------------------------------------------------------------------
        */


        // Hapus pelajar
        Route::delete(
            '/akun/pelajar/{akun}',
            [
                AkunController::class,
                'destroyPelajar'
            ]
        )->name('akun.pelajar.destroy');

        // Aktifkan/nonaktifkan akun pelajar tanpa menghapus data
        Route::patch(
            '/akun/pelajar/{akun}/status',
            [
                AkunController::class,
                'toggleStatusPelajar'
            ]
        )->name('akun.pelajar.status');


        /*
        |--------------------------------------------------------------------------
        | DETAIL AKUN
        |--------------------------------------------------------------------------
        |
        | Berlaku untuk instruktur dan pelajar.
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/akun/{akun}',
            [
                AkunController::class,
                'show'
            ]
        )->name('akun.show');

    });


/*
|--------------------------------------------------------------------------
| INSTRUKTUR - BAHASA PEMROGRAMAN
|--------------------------------------------------------------------------
| Route diberi prefix instruktur. Controller juga memvalidasi role dan
| memastikan setiap Instruktur hanya mengelola datanya sendiri.
*/
Route::middleware('auth')
    ->prefix('instruktur')
    ->name('instruktur.')
    ->group(function () {


Route::get('/evaluasi/{evaluasi}/pengerjaan/{pengerjaan}/penilaian', [EvaluasiController::class, 'showPenilaian'])
    ->name('evaluasi.penilaian.show');

Route::post('/evaluasi/{evaluasi}/pengerjaan/{pengerjaan}/penilaian', [EvaluasiController::class, 'simpanPenilaian'])
    ->name('evaluasi.penilaian.simpan');


Route::get('/referensi-chatbot', [InstrukturReferensiChatbotController::class, 'index'])
    ->name('referensi-chatbot.index');

Route::get('/referensi-chatbot/create', [InstrukturReferensiChatbotController::class, 'create'])
    ->name('referensi-chatbot.create');

Route::post('/referensi-chatbot', [InstrukturReferensiChatbotController::class, 'store'])
    ->name('referensi-chatbot.store');

Route::get('/referensi-chatbot/{referensiChatbot}/edit', [InstrukturReferensiChatbotController::class, 'edit'])
    ->name('referensi-chatbot.edit');

Route::put('/referensi-chatbot/{referensiChatbot}', [InstrukturReferensiChatbotController::class, 'update'])
    ->name('referensi-chatbot.update');

Route::patch('/referensi-chatbot/{referensiChatbot}/status', [InstrukturReferensiChatbotController::class, 'toggleStatus'])
    ->name('referensi-chatbot.status');

Route::delete('/referensi-chatbot/{referensiChatbot}', [InstrukturReferensiChatbotController::class, 'destroy'])
    ->name('referensi-chatbot.destroy');


Route::get('/sertifikat', [InstrukturSertifikatController::class, 'index'])
    ->name('sertifikat.index');
Route::post('/sertifikat', [InstrukturSertifikatController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('sertifikat.store');


        Route::get('/bahasa-pemrograman', [BahasaPemrogramanController::class, 'index'])
            ->name('bahasa.index');

        Route::get('/bahasa-pemrograman/create', [BahasaPemrogramanController::class, 'create'])
            ->name('bahasa.create');

        Route::post('/bahasa-pemrograman', [BahasaPemrogramanController::class, 'store'])
            ->name('bahasa.store');

        Route::get('/bahasa-pemrograman/{bahasa}/edit', [BahasaPemrogramanController::class, 'edit'])
            ->name('bahasa.edit');

        Route::put('/bahasa-pemrograman/{bahasa}', [BahasaPemrogramanController::class, 'update'])
            ->name('bahasa.update');

        Route::patch('/bahasa-pemrograman/{bahasa}/status', [BahasaPemrogramanController::class, 'toggleStatus'])
            ->name('bahasa.status');

        Route::delete('/bahasa-pemrograman/{bahasa}', [BahasaPemrogramanController::class, 'destroy'])
            ->name('bahasa.destroy');

        // KELOLA MODUL PEMBELAJARAN (FR-007)
        Route::get('/modul', [ModulController::class, 'index'])
            ->name('modul.index');

        Route::get('/modul/create', [ModulController::class, 'create'])
            ->name('modul.create');

        Route::post('/modul', [ModulController::class, 'store'])
            ->name('modul.store');

        Route::get('/modul/{modul}/edit', [ModulController::class, 'edit'])
            ->name('modul.edit');

        Route::put('/modul/{modul}', [ModulController::class, 'update'])
            ->name('modul.update');

        Route::patch('/modul/{modul}/status', [ModulController::class, 'toggleStatus'])
            ->name('modul.status');

        Route::delete('/modul/{modul}', [ModulController::class, 'destroy'])
            ->name('modul.destroy');

        // KELOLA MATERI PEMBELAJARAN (FR-008)
        Route::get('/materi', [MateriController::class, 'index'])
            ->name('materi.index');

        Route::get('/materi/create', [MateriController::class, 'create'])
            ->name('materi.create');

        Route::post('/materi', [MateriController::class, 'store'])
            ->name('materi.store');

        Route::get('/materi/{materi}/edit', [MateriController::class, 'edit'])
            ->name('materi.edit');

        Route::put('/materi/{materi}', [MateriController::class, 'update'])
            ->name('materi.update');

        Route::patch('/materi/{materi}/status', [MateriController::class, 'toggleStatus'])
            ->name('materi.status');

        Route::delete('/materi/{materi}', [MateriController::class, 'destroy'])
            ->name('materi.destroy');

        // KELOLA MEDIA PEMBELAJARAN (FR-009)
        Route::get('/media-pembelajaran', [MediaPembelajaranController::class, 'index'])
            ->name('media.index');

        Route::get('/media-pembelajaran/create', [MediaPembelajaranController::class, 'create'])
            ->name('media.create');

        Route::post('/media-pembelajaran', [MediaPembelajaranController::class, 'store'])
            ->name('media.store');

        Route::get('/media-pembelajaran/{mediaPembelajaran}/edit', [MediaPembelajaranController::class, 'edit'])
            ->name('media.edit');

        Route::put('/media-pembelajaran/{mediaPembelajaran}', [MediaPembelajaranController::class, 'update'])
            ->name('media.update');

        Route::delete('/media-pembelajaran/{mediaPembelajaran}', [MediaPembelajaranController::class, 'destroy'])
            ->name('media.destroy');

        // KELOLA LATIHAN CODE LAB (FR-011)
        Route::get('/code-lab', [CodeLabController::class, 'index'])
            ->name('code-lab.index');

        Route::get('/code-lab/create', [CodeLabController::class, 'create'])
            ->name('code-lab.create');

        Route::post('/code-lab', [CodeLabController::class, 'store'])
            ->name('code-lab.store');

        Route::get('/code-lab/{contohKode}/edit', [CodeLabController::class, 'edit'])
            ->name('code-lab.edit');

        Route::put('/code-lab/{contohKode}', [CodeLabController::class, 'update'])
            ->name('code-lab.update');

        Route::delete('/code-lab/{contohKode}', [CodeLabController::class, 'destroy'])
            ->name('code-lab.destroy');

        // KELOLA EVALUASI PEMBELAJARAN (FR-013)
        Route::get('/evaluasi', [EvaluasiController::class, 'index'])
            ->name('evaluasi.index');

        Route::get('/evaluasi/create', [EvaluasiController::class, 'create'])
            ->name('evaluasi.create');

        Route::post('/evaluasi', [EvaluasiController::class, 'store'])
            ->name('evaluasi.store');

        Route::get('/evaluasi/{evaluasi}', [EvaluasiController::class, 'show'])
            ->name('evaluasi.show');

        Route::get('/evaluasi/{evaluasi}/edit', [EvaluasiController::class, 'edit'])
            ->name('evaluasi.edit');

        Route::put('/evaluasi/{evaluasi}', [EvaluasiController::class, 'update'])
            ->name('evaluasi.update');

        Route::delete('/evaluasi/{evaluasi}', [EvaluasiController::class, 'destroy'])
            ->name('evaluasi.destroy');
    });


Route::middleware('auth')
    ->prefix('pelajar')
    ->name('pelajar.')
    ->group(function () {

        Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
        Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

Route::post(
    '/materi/{materi}/selesai',
    [PembelajaranController::class, 'selesaikanMateri']
)->middleware('throttle:30,1')
    ->name('materi.selesai');

        Route::get('/evaluasi', [PengerjaanEvaluasiController::class, 'index'])
            ->name('evaluasi.index');

        Route::post('/evaluasi/{evaluasi}/mulai', [PengerjaanEvaluasiController::class, 'start'])
            ->name('evaluasi.mulai');

        Route::get('/pengerjaan/{pengerjaan}', [PengerjaanEvaluasiController::class, 'show'])
            ->name('evaluasi.kerjakan');

        Route::post('/pengerjaan/{pengerjaan}/kumpulkan', [PengerjaanEvaluasiController::class, 'submit'])
            ->name('evaluasi.kumpulkan');
Route::get('/sertifikat/{sertifikat}/preview', [PelajarSertifikatController::class, 'preview'])
    ->name('sertifikat.preview');

Route::get('/sertifikat/{sertifikat}/download', [PelajarSertifikatController::class, 'download'])
    ->name('sertifikat.download');

            Route::get('/pengerjaan/{pengerjaan}/hasil', [HasilEvaluasiController::class, 'show'])
    ->name('evaluasi.hasil');

Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/message', [ChatbotController::class, 'send'])->middleware('throttle:10,1')->name('chatbot.send');
Route::post('/chatbot/clear', [ChatbotController::class, 'clear'])->name('chatbot.clear');

Route::get('/sertifikat', [PelajarSertifikatController::class, 'index'])
    ->name('sertifikat.index');
Route::get('/sertifikat/{sertifikat}/download', [PelajarSertifikatController::class, 'download'])
    ->name('sertifikat.download');


    });

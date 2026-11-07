@auth
    @php
        $navbarUser = auth()->user();
        $navbarRoute = request()->route()?->getName() ?? '';

        $navbarRole = match ($navbarUser->peran) {
            'admin' => 'Administrator',
            'instruktur' => 'Instruktur',
            'pelajar' => 'Pelajar',
            default => ucfirst((string) $navbarUser->peran),
        };

        // Fallback harus mengikuti role, bukan memakai judul Dashboard Pelajar untuk semua akun.
        $navbarDefaults = match ($navbarUser->peran) {
            'admin' => ['label' => 'ADMINISTRATOR', 'heading' => 'Panel Administrasi'],
            'instruktur' => ['label' => 'AREA INSTRUKTUR', 'heading' => 'Ruang Kerja Instruktur'],
            'pelajar' => ['label' => 'AREA PELAJAR', 'heading' => 'Selamat belajar kembali!'],
            default => ['label' => 'CODETUTOR', 'heading' => 'Selamat datang di CodeTutor'],
        };

        // Judul khusus berdasarkan nama route. Ini membuat halaman Referensi Chatbot
        // tetap memiliki judul yang benar walaupun view-nya belum mendefinisikan section.
        $navbarRouteTitles = [
            'dashboard' => match ($navbarUser->peran) {
                'admin' => ['label' => 'ADMINISTRATOR', 'heading' => 'Dashboard Administrator'],
                'instruktur' => ['label' => 'AREA INSTRUKTUR', 'heading' => 'Dashboard Instruktur'],
                'pelajar' => ['label' => 'AREA PELAJAR', 'heading' => 'Dashboard Pelajar'],
                default => $navbarDefaults,
            },

            'admin.referensi-chatbot.index' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Referensi Chatbot'],
            'admin.referensi-chatbot.create' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Tambah Referensi Chatbot'],
            'admin.referensi-chatbot.edit' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Edit Referensi Chatbot'],
            'admin.referensi-chatbot.store' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Referensi Chatbot'],
            'admin.referensi-chatbot.update' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Edit Referensi Chatbot'],
            'admin.referensi-chatbot.status' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Status Referensi Chatbot'],
            'admin.referensi-chatbot.destroy' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Referensi Chatbot'],

            'admin.pengawasan-konten.index' => ['label' => 'MANAJEMEN PEMBELAJARAN', 'heading' => 'Pengawasan Konten'],
            'admin.progres-pelajar.index' => ['label' => 'MONITORING AKADEMIK', 'heading' => 'Progres Belajar Pelajar'],
            'admin.aktivitas.index' => ['label' => 'SISTEM', 'heading' => 'Log Aktivitas'],
            'admin.akun.index' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Kelola Akun'],
            'admin.akun.instruktur.create' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Tambah Akun Instruktur'],
            'admin.akun.instruktur.store' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Tambah Akun Instruktur'],
            'admin.akun.instruktur.edit' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Edit Akun Instruktur'],
            'admin.akun.instruktur.update' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Edit Akun Instruktur'],
            'admin.akun.instruktur.destroy' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Kelola Akun Instruktur'],
            'admin.akun.pelajar.destroy' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Kelola Akun Pelajar'],
            'admin.akun.pelajar.status' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Status Akun Pelajar'],
            'admin.akun.show' => ['label' => 'MANAJEMEN PENGGUNA', 'heading' => 'Detail Akun'],

            'instruktur.referensi-chatbot.index' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Referensi Chatbot'],
            'instruktur.referensi-chatbot.create' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Tambah Referensi Chatbot'],
            'instruktur.referensi-chatbot.edit' => ['label' => 'PENGELOLAAN AI', 'heading' => 'Edit Referensi Chatbot'],
            'instruktur.bahasa.index' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Bahasa Pemrograman'],
            'instruktur.bahasa.create' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Tambah Bahasa Pemrograman'],
            'instruktur.bahasa.edit' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Edit Bahasa Pemrograman'],
            'instruktur.modul.index' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Kelola Modul'],
            'instruktur.modul.create' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Tambah Modul'],
            'instruktur.modul.edit' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Edit Modul'],
            'instruktur.materi.index' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Kelola Materi'],
            'instruktur.materi.create' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Tambah Materi'],
            'instruktur.materi.edit' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Edit Materi'],
            'instruktur.media.index' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Media Pembelajaran'],
            'instruktur.media.create' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Tambah Media Pembelajaran'],
            'instruktur.media.edit' => ['label' => 'KONTEN PEMBELAJARAN', 'heading' => 'Edit Media Pembelajaran'],
            'instruktur.code-lab.index' => ['label' => 'PRAKTIK PEMROGRAMAN', 'heading' => 'Code Lab'],
            'instruktur.code-lab.create' => ['label' => 'PRAKTIK PEMROGRAMAN', 'heading' => 'Tambah Contoh Kode'],
            'instruktur.code-lab.edit' => ['label' => 'PRAKTIK PEMROGRAMAN', 'heading' => 'Edit Contoh Kode'],
            'instruktur.evaluasi.index' => ['label' => 'EVALUASI', 'heading' => 'Kelola Evaluasi'],
            'instruktur.evaluasi.create' => ['label' => 'EVALUASI', 'heading' => 'Buat Evaluasi'],
            'instruktur.evaluasi.show' => ['label' => 'EVALUASI', 'heading' => 'Detail Evaluasi'],
            'instruktur.evaluasi.edit' => ['label' => 'EVALUASI', 'heading' => 'Edit Evaluasi'],
            'instruktur.sertifikat.index' => ['label' => 'PENCAPAIAN', 'heading' => 'Sertifikat'],

            'materi' => ['label' => 'PEMBELAJARAN', 'heading' => 'Pembelajaran Coding'],
            'progress' => ['label' => 'PEMBELAJARAN', 'heading' => 'Progres Belajar'],
            'code-editor' => ['label' => 'PRAKTIK PEMROGRAMAN', 'heading' => 'Code Editor'],
            'latihan' => ['label' => 'PRAKTIK PEMROGRAMAN', 'heading' => 'Latihan Coding'],
            'pelajar.chatbot.index' => ['label' => 'ASISTEN PEMBELAJARAN', 'heading' => 'Chatbot CodeTutor'],
            'pelajar.evaluasi.index' => ['label' => 'EVALUASI', 'heading' => 'Evaluasi Pembelajaran'],
            'pelajar.sertifikat.index' => ['label' => 'PENCAPAIAN', 'heading' => 'Sertifikat Saya'],
        ];

        $navbarRouteMeta = $navbarRouteTitles[$navbarRoute] ?? null;

        // Fallback aman untuk route admin lain yang belum dimasukkan ke peta di atas.
        if (!$navbarRouteMeta && str_starts_with($navbarRoute, 'admin.')) {
            $routeLabel = preg_replace('/^admin\./', '', $navbarRoute);
            $routeLabel = preg_replace('/\.(index|create|edit|store|update|destroy|status|show)$/', '', $routeLabel);
            $navbarRouteMeta = [
                'label' => 'ADMINISTRATOR',
                'heading' => \Illuminate\Support\Str::headline(str_replace('.', ' ', $routeLabel)),
            ];
        }

        $navbarRouteMeta = $navbarRouteMeta ?: $navbarDefaults;

        // Section dari halaman tetap lebih diutamakan bila memang ditentukan.
        $sectionPageLabel = trim($__env->yieldContent('page_label'));
        $sectionPageHeading = trim($__env->yieldContent('page_heading'));

        $navbarPageLabel = $sectionPageLabel !== '' ? $sectionPageLabel : $navbarRouteMeta['label'];
        $navbarPageHeading = $sectionPageHeading !== '' ? $sectionPageHeading : $navbarRouteMeta['heading'];

        $navbarInitial = strtoupper(mb_substr((string) ($navbarUser->nama ?? 'U'), 0, 1));
    @endphp
@endauth

<header class="sticky top-0 z-30 border-b border-maroon-900/8 bg-white/90 backdrop-blur-xl">
    <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        {{-- KIRI: MENU DAN JUDUL HALAMAN --}}
        <div class="flex min-w-0 items-center gap-3">
            <button
                id="openSidebar"
                type="button"
                class="grid h-10 w-10 shrink-0 place-items-center rounded-xl border border-maroon-900/10 bg-white text-maroon-800 transition hover:border-gold-500/50 hover:bg-warm-50 focus:outline-none focus:ring-2 focus:ring-gold-400/50 lg:hidden"
                aria-label="Buka menu"
                aria-controls="sidebar"
                aria-expanded="false"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="min-w-0">
                <p class="truncate text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700">
                    @auth {{ $navbarPageLabel }} @else CODETUTOR @endauth
                </p>
                <h1 class="mt-0.5 truncate font-display text-lg font-extrabold text-maroon-950 sm:text-xl">
                    @auth {{ $navbarPageHeading }} @else CodeTutor @endauth
                </h1>
            </div>
        </div>

        {{-- KANAN: IDENTITAS AKUN --}}
        <div class="flex shrink-0 items-center gap-2">
            @auth
                <div class="relative" id="profileDropdown">
                    <button
                        type="button"
                        id="profileDropdownButton"
                        aria-haspopup="true"
                        aria-expanded="false"
                        aria-controls="profileDropdownMenu"
                        class="flex items-center gap-2 rounded-xl border border-maroon-900/10 bg-white px-2 py-2 transition hover:border-gold-500/40 hover:bg-warm-50 focus:outline-none focus:ring-2 focus:ring-gold-400/50"
                    >
                        @if ($navbarUser->foto)
                            <img
                                src="{{ asset('storage/' . $navbarUser->foto) }}"
                                alt="Foto {{ $navbarUser->nama }}"
                                class="h-8 w-8 rounded-full object-cover"
                            >
                        @else
                            <span class="grid h-8 w-8 place-items-center rounded-full bg-maroon-800 text-[10px] font-extrabold text-gold-400">
                                {{ $navbarInitial }}
                            </span>
                        @endif

                        <span class="hidden pr-1 text-left sm:block">
                            <span class="block max-w-[150px] truncate text-xs font-bold text-maroon-950">
                                {{ $navbarUser->nama }}
                            </span>
                            <span class="block text-[10px] text-slate-400">{{ $navbarRole }}</span>
                        </span>

                        <svg
                            id="profileDropdownChevron"
                            class="h-4 w-4 text-slate-400 transition-transform duration-200"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    <div
                        id="profileDropdownMenu"
                        class="absolute right-0 top-full z-50 mt-2 hidden w-56 overflow-hidden rounded-2xl border border-maroon-900/10 bg-white p-2 shadow-xl shadow-maroon-950/10"
                        role="menu"
                        aria-labelledby="profileDropdownButton"
                    >
                        <div class="border-b border-maroon-900/10 px-3 py-3">
                            <p class="truncate text-sm font-bold text-maroon-950">{{ $navbarUser->nama }}</p>
                            <p class="mt-0.5 text-xs text-slate-500">{{ $navbarRole }}</p>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button
                                type="submit"
                                role="menuitem"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-200"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                    <polyline points="16 17 21 12 16 7"/>
                                    <line x1="21" y1="12" x2="9" y2="12"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.getElementById('profileDropdown');
    const button = document.getElementById('profileDropdownButton');
    const menu = document.getElementById('profileDropdownMenu');
    const chevron = document.getElementById('profileDropdownChevron');

    if (!dropdown || !button || !menu) return;

    function tutupDropdown() {
        menu.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
        chevron?.classList.remove('rotate-180');
    }

    function toggleDropdown() {
        const sedangTerbuka = !menu.classList.contains('hidden');
        if (sedangTerbuka) {
            tutupDropdown();
        } else {
            menu.classList.remove('hidden');
            button.setAttribute('aria-expanded', 'true');
            chevron?.classList.add('rotate-180');
        }
    }

    button.addEventListener('click', function (event) {
        event.stopPropagation();
        toggleDropdown();
    });

    document.addEventListener('click', function (event) {
        if (!dropdown.contains(event.target)) tutupDropdown();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') tutupDropdown();
    });
});
</script>
@endpush

{{-- =========================================================
     SIDEBAR
========================================================== --}}
<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-[260px] flex-col border-r border-white/10 bg-maroon-950 text-white transition-transform duration-300"
>

    {{-- =====================================================
         BRAND
    ====================================================== --}}
    <div class="flex h-20 shrink-0 items-center border-b border-white/10 px-5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl border border-gold-400/25 bg-white/[.05] text-gold-400">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m8 8-4 4 4 4"/>
                    <path d="m16 8 4 4-4 4"/>
                    <path d="m14 4-4 16"/>
                </svg>
            </span>
            <span class="font-display text-lg font-extrabold tracking-tight">
                Code<span class="text-gold-400">Tutor</span>
            </span>
        </a>
    </div>

    {{-- =====================================================
         NAVIGATION
    ====================================================== --}}
    <div class="sidebar-scroll min-h-0 flex-1 overflow-y-auto overflow-x-hidden px-4 py-5">

        {{-- MENU UTAMA --}}
        <p class="mb-3 px-3 text-[10px] font-extrabold uppercase tracking-[.2em] text-white/30">
            Menu Utama
        </p>

        {{-- =================================================
             ADMIN
        ================================================== --}}
        @if(auth()->check() && auth()->user()->peran === 'admin')
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                    </span>
                    <span class="truncate">Dashboard</span>
                </a>

                <a href="{{ route('admin.akun.index') }}" class="nav-item {{ request()->routeIs('admin.akun.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                    <span class="truncate">Kelola Akun</span>
                </a>

                <a href="{{ route('admin.pengawasan-konten.index') }}" class="nav-item {{ request()->routeIs('admin.pengawasan-konten.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </span>
                    <span class="truncate">Pengawasan Konten</span>
                </a>

                <a href="{{ route('admin.aktivitas.index') }}" class="nav-item {{ request()->routeIs('admin.aktivitas.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 3v18h18" />
                            <path d="m7 16 4-4 3 3 5-6" />
                        </svg>
                    </span>
                    <span class="truncate">Aktivitas Sistem</span>
                </a>

                <a href="{{ route('admin.progres-pelajar.index') }}" class="nav-item {{ request()->routeIs('admin.progres-pelajar.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                    </span>
                    <span class="truncate">Progres Pelajar</span>
                </a>

                <a href="{{ route('admin.referensi-chatbot.index') }}" class="nav-item {{ request()->routeIs('admin.referensi-chatbot.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3v-7a4 4 0 0 1-1-3V7a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z" />
                            <path d="M8 10h8M8 14h5" />
                        </svg>
                    </span>
                    <span class="truncate">Referensi Chatbot</span>
                </a>
            </nav>

        {{-- =================================================
             INSTRUKTUR
        ================================================== --}}
        @elseif(auth()->check() && auth()->user()->peran === 'instruktur')
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                    </span>
                    <span class="truncate">Dashboard</span>
                </a>

                <a href="{{ route('instruktur.bahasa.index') }}" class="nav-item {{ request()->routeIs('instruktur.bahasa.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M8 9l3 3-3 3" />
                            <path d="M13 15h3" />
                            <rect x="3" y="4" width="18" height="16" rx="2" />
                        </svg>
                    </span>
                    <span class="truncate">Bahasa Pemrograman</span>
                </a>

                <a href="{{ route('instruktur.modul.index') }}" class="nav-item {{ request()->routeIs('instruktur.modul.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
                        </svg>
                    </span>
                    <span class="truncate">Modul</span>
                </a>

                <a href="{{ route('instruktur.materi.index') }}" class="nav-item {{ request()->routeIs('instruktur.materi.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        {{-- Ikon khusus Instruktur: mengelola dan menyunting materi --}}
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                            <path d="m14.5 8.5 2 2" />
                            <path d="m10.5 15.5 1.1-3.3 4.8-4.8a1.4 1.4 0 0 1 2 2l-4.8 4.8-3.1 1.3Z" />
                        </svg>
                    </span>
                    <span class="truncate">Kelola Materi</span>
                </a>

                <a href="{{ route('instruktur.media.index') }}" class="nav-item {{ request()->routeIs('instruktur.media.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <polygon points="10 9 16 12 10 15" />
                        </svg>
                    </span>
                    <span class="truncate">Media Pembelajaran</span>
                </a>

                <a href="{{ route('instruktur.evaluasi.index') }}" class="nav-item {{ request()->routeIs('instruktur.evaluasi.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="8" y1="13" x2="16" y2="13" />
                            <line x1="8" y1="17" x2="16" y2="17" />
                        </svg>
                    </span>
                    <span class="truncate">Evaluasi</span>
                </a>

                <a href="{{ route('instruktur.code-lab.index') }}" class="nav-item {{ request()->routeIs('instruktur.code-lab.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="16 18 22 12 16 6"/>
                            <polyline points="8 6 2 12 8 18"/>
                        </svg>
                    </span>
                    <span class="truncate">Code Lab</span>
                </a>
            </nav>

            {{-- INSTRUKTUR MONITORING --}}
            <p class="mb-3 mt-8 px-3 text-[10px] font-extrabold uppercase tracking-[.2em] text-white/30">
                Monitoring
            </p>
            <nav class="space-y-1">
                <a href="{{ route('progress') }}" class="nav-item {{ request()->routeIs('progress') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </span>
                    <span class="truncate">Progres Pelajar</span>
                </a>

                <a href="{{ route('instruktur.referensi-chatbot.index') }}" class="nav-item {{ request()->routeIs('instruktur.referensi-chatbot.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5z" />
                        </svg>
                    </span>
                    <span class="truncate">Referensi Chatbot</span>
                </a>

                <a href="{{ route('instruktur.sertifikat.index') }}" class="nav-item {{ request()->routeIs('instruktur.sertifikat.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M8.5 12.5 7 22l5-3 5 3-1.5-9.5" />
                        </svg>
                    </span>
                    <span class="truncate">Sertifikat</span>
                </a>
            </nav>

        {{-- =================================================
             PELAJAR
        ================================================== --}}
        @elseif(auth()->check() && auth()->user()->peran === 'pelajar')
            <nav class="space-y-1">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                    </span>
                    <span class="truncate">Dashboard</span>
                </a>

                <a href="{{ route('materi') }}" class="nav-item {{ request()->routeIs('materi') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
                        </svg>
                    </span>
                    <span class="truncate">Materi</span>
                </a>

                <a href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => 'pretest']) }}" class="nav-item {{ request()->routeIs('pelajar.evaluasi.index') && request('jenis_evaluasi', 'pretest') === 'pretest' ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                    </span>
                    <span class="truncate">Pre-Test</span>
                </a>

                <a href="{{ route('code-editor') }}" class="nav-item {{ request()->routeIs('code-editor') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="16 18 22 12 16 6"/>
                            <polyline points="8 6 2 12 8 18"/>
                        </svg>
                    </span>
                    <span class="truncate">Code Editor</span>
                </a>

                <a href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => 'posttest']) }}" class="nav-item {{ request()->routeIs('pelajar.evaluasi.index') && request('jenis_evaluasi') === 'posttest' ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                        </svg>
                    </span>
                    <span class="truncate">Post test</span>
                </a>
            </nav>

            {{-- PELAJAR PROGRESS --}}
            <p class="mb-3 mt-8 px-3 text-[10px] font-extrabold uppercase tracking-[.2em] text-white/30">
                Perkembangan
            </p>
            <nav class="space-y-1">
                <a href="{{ route('progress') }}" class="nav-item {{ request()->routeIs('progress') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                    </span>
                    <span class="truncate">Progress Belajar</span>
                </a>

                <a href="{{ route('pelajar.chatbot.index') }}" class="nav-item {{ request()->routeIs('pelajar.chatbot.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3v-7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z" />
                            <circle cx="9" cy="10" r="1"/>
                            <circle cx="13" cy="10" r="1"/>
                            <circle cx="17" cy="10" r="1"/>
                        </svg>
                    </span>
                    <span class="truncate">Chatbot AI</span>
                </a>

                <a href="{{ route('pelajar.sertifikat.index') }}" class="nav-item {{ request()->routeIs('pelajar.sertifikat.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M8.5 12.5 7 22l5-3 5 3-1.5-9.5" />
                        </svg>
                    </span>
                    <span class="truncate">Sertifikat Saya</span>
                </a>


                <a href="{{ route('pelajar.profil.index') }}" class="nav-item {{ request()->routeIs('pelajar.profil.*') ? 'active' : '' }}">
                    <span class="nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M5 21a7 7 0 0 1 14 0" />
                        </svg>
                    </span>
                    <span class="truncate">Profil Saya</span>
                </a>
            </nav>
        @endif
    </div>

    {{-- =====================================================
         USER PROFILE
    ====================================================== --}}
    @auth
        @php
            $user = auth()->user();
            $roleLabel = match ($user->peran) {
                'admin' => 'Administrator',
                'instruktur' => 'Instruktur',
                'pelajar' => 'Pelajar',
                default => ucfirst($user->peran),
            };
            $initial = strtoupper(substr($user->nama ?? 'U', 0, 1));
        @endphp

        <div class="shrink-0 border-t border-white/10 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-white/[.04] px-3 py-3">
                {{-- FOTO --}}
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->nama }}" class="h-9 w-9 shrink-0 rounded-full object-cover">
                @else
                    <div class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-gold-400 font-display text-xs font-extrabold text-maroon-950">
                        {{ $initial }}
                    </div>
                @endif

                {{-- INFO USER --}}
                <div class="min-w-0 flex-1">
                    <p class="truncate text-xs font-bold text-white">{{ $user->nama }}</p>
                    <p class="truncate text-[10px] text-white/35">{{ $roleLabel }}</p>
                </div>

                {{-- ARROW --}}
                <svg class="h-4 w-4 text-white/30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </div>
        </div>
    @endauth
</aside>
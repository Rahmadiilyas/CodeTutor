@extends('layouts.master')
//perbaikan bug
@section('title', 'Dashboard — CodeTutor')

@section(
    'description',
    'Dashboard CodeTutor untuk melihat progres pembelajaran, evaluasi, dan aktivitas coding.'
)

@section('page_label', 'Dashboard')

@section(
    'page_heading',
    'Selamat belajar kembali!'
)

@section('content')

{{-- Daftar bahasa diambil dari database melalui route dashboard. --}}


<div class="mx-auto max-w-7xl space-y-6 pb-10">


    {{-- =========================================================
         WELCOME HERO
    ========================================================== --}}

    <section
        class="relative overflow-hidden rounded-[30px] bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 p-6 text-white shadow-card sm:p-8 lg:p-10"
    >

        {{-- Decorative --}}
        <div
            class="absolute -right-24 -top-24 h-72 w-72 rounded-full border-[35px] border-gold-400/10"
        ></div>

        <div
            class="absolute -bottom-32 right-20 h-64 w-64 rounded-full bg-gold-400/10 blur-3xl"
        ></div>

        <div
            class="absolute left-1/2 top-0 h-full w-px bg-white/[.02]"
        ></div>


        <div
            class="relative grid items-center gap-10 lg:grid-cols-[1.1fr_.9fr]"
        >


            {{-- LEFT --}}
            <div>

                <span
                    class="inline-flex items-center gap-2 rounded-full border border-gold-400/20 bg-white/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.15em] text-gold-300"
                >

                    <span
                        class="h-1.5 w-1.5 rounded-full bg-gold-400 shadow-[0_0_10px_rgba(250,204,21,.8)]"
                    ></span>

                    Terus berkembang

                </span>


                <h2
                    class="mt-5 max-w-2xl font-display text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl lg:text-[42px]"
                >

                    Hai, {{ auth()->user()->nama }} 👋

                    <br>

                    Mau belajar apa hari ini?

                </h2>


                <p
                    class="mt-4 max-w-xl text-sm leading-7 text-white/60"
                >

                    Lanjutkan materi terakhir, berlatih melalui soal,
                    atau eksplorasi bahasa pemrograman baru untuk
                    meningkatkan kemampuan coding kamu.

                </p>


                <div class="mt-7 flex flex-wrap gap-3">

                    <a
                        href="{{ route('materi') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-gold-400 px-5 py-3 text-sm font-extrabold text-maroon-950 shadow-gold transition hover:-translate-y-0.5 hover:bg-gold-300"
                    >

                        Lanjut Belajar

                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M5 12h14"/>
                            <path d="m13 6 6 6-6 6"/>
                        </svg>

                    </a>


                    <a
                        href="#bahasa"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 py-3 text-sm font-bold text-white transition hover:bg-white/10"
                    >

                        Jelajahi Bahasa

                    </a>

                </div>

            </div>



            {{-- RIGHT PROGRESS --}}
            <div class="relative mx-auto w-full max-w-sm">

                <div
                    class="rounded-[26px] border border-white/10 bg-white/[.06] p-6 backdrop-blur-xl"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p
                                class="text-[9px] font-extrabold uppercase tracking-[.17em] text-white/40"
                            >
                                Progress keseluruhan
                            </p>

                            <p
                                class="mt-1 font-display text-4xl font-extrabold text-gold-400"
                            >
                                {{ number_format($overallProgress, 0, ',', '.') }}%
                            </p>

                        </div>


                        <div
                            class="grid h-14 w-14 place-items-center rounded-full border border-gold-400/20 bg-gold-400/10"
                        >

                            <svg
                                class="h-6 w-6 text-gold-400"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M12 3v18"/>
                                <path d="m18 9-6-6-6 6"/>
                            </svg>

                        </div>

                    </div>


                    <div
                        class="mt-6 h-2.5 overflow-hidden rounded-full bg-white/10"
                    >

                        <div
                            class="h-full rounded-full bg-gradient-to-r from-gold-600 to-gold-300"
                            style="width: {{ $overallProgress }}%"
                        ></div>

                    </div>


                    <div class="mt-6 grid grid-cols-3 gap-2">

                        <div
                            class="rounded-xl bg-white/[.045] p-3"
                        >

                            <p class="font-display text-lg font-extrabold">
                                {{ number_format($totalMateriSelesai, 0, ',', '.') }}
                            </p>

                            <p class="mt-0.5 text-[9px] text-white/35">
                                Materi selesai
                            </p>

                        </div>


                        <div
                            class="rounded-xl bg-white/[.045] p-3"
                        >

                            <p class="font-display text-lg font-extrabold">
                                {{ number_format($totalEvaluasiSelesai, 0, ',', '.') }}
                            </p>

                            <p class="mt-0.5 text-[9px] text-white/35">
                                Posttest selesai
                            </p>

                        </div>


                        <div
                            class="rounded-xl bg-white/[.045] p-3"
                        >

                            <p class="font-display text-lg font-extrabold">
                                {{ number_format($totalEksekusiKode, 0, ',', '.') }}
                            </p>

                            <p class="mt-0.5 text-[9px] text-white/35">
                                Eksekusi kode
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         QUICK STATS
    ========================================================== --}}

    <section
        class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4"
    >


        {{-- STAT --}}
        <div
            class="group rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft transition hover:-translate-y-1 hover:shadow-lg"
        >

            <div class="flex items-center gap-4">

                <div
                    class="grid h-12 w-12 place-items-center rounded-xl bg-maroon-900 text-gold-400 transition group-hover:scale-105"
                >

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                    </svg>

                </div>


                <div>

                    <p
                        class="font-display text-2xl font-extrabold text-maroon-950"
                    >
                        {{ number_format($totalMateriSelesai, 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400">
                        Materi Selesai
                    </p>

                </div>

            </div>

        </div>



        {{-- STAT --}}
        <div
            class="group rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft transition hover:-translate-y-1 hover:shadow-lg"
        >

            <div class="flex items-center gap-4">

                <div
                    class="grid h-12 w-12 place-items-center rounded-xl bg-maroon-900 text-gold-400 transition group-hover:scale-105"
                >

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M8 6h13M8 12h13M8 18h13"/>
                        <path d="M3 6h.01M3 12h.01M3 18h.01"/>
                    </svg>

                </div>


                <div>

                    <p
                        class="font-display text-2xl font-extrabold text-maroon-950"
                    >
                        {{ number_format($totalEvaluasiSelesai, 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400">
                        Posttest Selesai
                    </p>

                </div>

            </div>

        </div>



        {{-- STAT --}}
        <div
            class="group rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft transition hover:-translate-y-1 hover:shadow-lg"
        >

            <div class="flex items-center gap-4">

                <div
                    class="grid h-12 w-12 place-items-center rounded-xl bg-maroon-900 text-gold-400 transition group-hover:scale-105"
                >

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="m8 12 2.4 2.4L16 9"/>
                    </svg>

                </div>


                <div>

                    <p
                        class="font-display text-2xl font-extrabold text-maroon-950"
                    >
                        {{ $rataNilai !== null ? number_format((float) $rataNilai, 0, ',', '.') . '/100' : '—' }}
                    </p>

                    <p class="text-xs text-slate-400">
                        Rata-rata Nilai Posttest
                    </p>

                </div>

            </div>

        </div>



        {{-- STAT --}}
        <div
            class="group rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft transition hover:-translate-y-1 hover:shadow-lg"
        >

            <div class="flex items-center gap-4">

                <div
                    class="grid h-12 w-12 place-items-center rounded-xl bg-maroon-900 text-gold-400 transition group-hover:scale-105"
                >

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M12 3v18"/>
                        <path d="M3 12h18"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>

                </div>


                <div>

                    <p
                        class="font-display text-2xl font-extrabold text-maroon-950"
                    >
                        {{ number_format($totalEksekusiKode, 0, ',', '.') }}
                    </p>

                    <p class="text-xs text-slate-400">
                        Eksekusi Kode
                    </p>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         CONTINUE LEARNING
    ========================================================== --}}

    <section
        class="grid gap-6 xl:grid-cols-[1.45fr_.75fr]"
    >


        {{-- LEFT --}}
        <div
            class="rounded-2xl border border-maroon-900/8 bg-white p-6 shadow-soft"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p
                        class="text-[10px] font-extrabold uppercase tracking-[.17em] text-maroon-700"
                    >
                        Lanjutkan Belajar
                    </p>

                    <h3
                        class="mt-1 font-display text-xl font-extrabold text-maroon-950"
                    >
                        Materi terakhir
                    </h3>

                </div>


                <a
                    href="{{ route('materi') }}"
                    class="text-xs font-bold text-maroon-700 transition hover:text-gold-700"
                >
                    Lihat semua
                </a>

            </div>



            {{-- PYTHON CURRENT COURSE --}}
            <div
                class="mt-6 overflow-hidden rounded-[24px] border border-maroon-900/8 bg-warm-50"
            >

                <div class="p-5">

                    <div
                        class="flex flex-col gap-5 sm:flex-row sm:items-center"
                    >


                        {{-- REAL PYTHON LOGO --}}
                        <div
                            class="grid h-20 w-20 shrink-0 place-items-center rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100"
                        >

                            @if (!empty($recentModuleLogo))
                                <img
                                    src="{{ $recentModuleLogo }}"
                                    alt="{{ $recentLanguageName ?? 'Bahasa pemrograman' }}"
                                    class="h-12 w-12 object-contain"
                                >
                            @else
                                <svg class="h-10 w-10 text-maroon-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="m8 8-4 4 4 4M16 8l4 4-4 4M14 4l-4 16"/>
                                </svg>
                            @endif

                        </div>



                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center gap-2">

                                <span
                                    class="rounded-full bg-blue-50 px-2.5 py-1 text-[9px] font-bold text-blue-700"
                                >
                                    {{ $recentLanguageName ?? 'Bahasa belum tersedia' }}
                                </span>

                                <span
                                    class="rounded-full bg-amber-50 px-2.5 py-1 text-[9px] font-bold text-amber-700"
                                >
                                    {{ $recentProgress ? 'Progres tercatat' : 'Belum mulai' }}
                                </span>

                            </div>


                            <h4
                                class="mt-2 font-display text-base font-extrabold text-maroon-950"
                            >
                                {{ $recentProgress?->modul?->nama_modul ?? 'Belum ada modul dipelajari' }}
                            </h4>


                            <p
                                class="mt-1 text-xs text-slate-400"
                            >
                                @if ($recentProgress)
                                    {{ $recentModuleMaterialsDone }} dari {{ $recentModuleMaterialsTotal }} materi selesai
                                @else
                                    Belum ada progres belajar yang tercatat
                                @endif
                            </p>


                            <div class="mt-4 flex items-center gap-3">

                                <div
                                    class="h-2 flex-1 overflow-hidden rounded-full bg-maroon-900/8"
                                >

                                    <div
                                        class="h-full rounded-full bg-maroon-700"
                                        style="width: {{ $recentProgressPercent }}%"
                                    ></div>

                                </div>


                                <span
                                    class="text-[10px] font-extrabold text-maroon-700"
                                >
                                    {{ number_format($recentProgressPercent, 0, ',', '.') }}%
                                </span>

                            </div>

                        </div>



                        <a
                            href="{{ route('materi', $recentProgress ? ['modul' => $recentProgress->id_modul, 'bahasa' => $recentProgress->modul?->id_bahasa] : []) }}"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-3 text-xs font-extrabold text-white shadow-soft transition hover:bg-maroon-700"
                        >

                            Lanjutkan

                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>

                        </a>

                    </div>

                </div>

            </div>



            {{-- REKOMENDASI DINAMIS --}}
            <div class="mt-8">
                <div class="flex items-center justify-between">
                    <h4 class="font-display text-base font-extrabold text-maroon-950">Rekomendasi untukmu</h4>
                    <a href="{{ route('materi') }}" class="text-[11px] font-bold text-maroon-700">Lihat semua</a>
                </div>

                <div class="mt-4 grid gap-3 md:grid-cols-2">
                    @forelse ($recommendedModules as $recommendation)
                        <a href="{{ route('materi', ['bahasa' => $recommendation->id_bahasa, 'modul' => $recommendation->id]) }}"
                           class="group rounded-2xl border border-maroon-900/8 p-4 transition hover:-translate-y-1 hover:border-gold-500/30 hover:shadow-soft">
                            <div class="flex items-center gap-3">
                                <div class="grid h-12 w-12 shrink-0 place-items-center rounded-xl {{ $recommendation->dashboard_bg }} p-2">
                                    @if ($recommendation->dashboard_logo)
                                        <img src="{{ $recommendation->dashboard_logo }}" alt="{{ $recommendation->bahasa->nama_bahasa ?? 'Bahasa' }}" class="h-8 w-8 object-contain transition group-hover:scale-110" loading="lazy">
                                    @else
                                        <svg class="h-7 w-7 text-maroon-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m8 8-4 4 4 4M16 8l4 4-4 4M14 4l-4 16"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-xs font-extrabold text-maroon-950">{{ $recommendation->nama_modul }}</p>
                                    <p class="mt-1 text-[10px] text-slate-400">{{ $recommendation->bahasa->nama_bahasa ?? 'Bahasa pemrograman' }} · {{ $recommendation->materi_count }} materi tersedia</p>
                                </div>
                                <svg class="h-4 w-4 text-slate-300 transition group-hover:translate-x-1 group-hover:text-maroon-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                            </div>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 p-4 text-xs text-slate-500 md:col-span-2">
                            Belum ada modul aktif yang dapat direkomendasikan.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>



        {{-- RIGHT --}}
        <div class="space-y-6">


            {{-- TARGET --}}
            <div
                class="rounded-2xl border border-maroon-900/8 bg-white p-6 shadow-soft"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p
                            class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700"
                        >
                            Progres Materi
                        </p>

                        <h3
                            class="mt-1 font-display text-lg font-extrabold text-maroon-950"
                        >
                            Penyelesaian pembelajaran
                        </h3>

                    </div>


                    <span
                        class="grid h-10 w-10 place-items-center rounded-xl bg-gold-400/15 text-gold-600"
                    >

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>

                    </span>

                </div>


                <div class="mt-5">

                    <div class="flex items-end justify-between">

                        <p
                            class="font-display text-2xl font-extrabold text-maroon-950"
                        >
                            {{ number_format($totalMateriSelesai, 0, ',', '.') }}

                            <span
                                class="text-sm font-bold text-slate-400"
                            >
                                / {{ number_format($totalMateriTersedia, 0, ',', '.') }} materi
                            </span>

                        </p>


                        <span
                            class="text-xs font-extrabold text-maroon-700"
                        >
                            {{ number_format($overallProgress, 0, ',', '.') }}%
                        </span>

                    </div>


                    <div
                        class="mt-3 h-2 overflow-hidden rounded-full bg-maroon-900/8"
                    >

                        <div
                            class="h-full rounded-full bg-gradient-to-r from-maroon-700 to-gold-500"
                            style="width: {{ $overallProgress }}%"
                        ></div>

                    </div>


                    <p
                        class="mt-3 text-[10px] text-slate-400"
                    >
                        @if ($totalMateriTersedia > $totalMateriSelesai)
                            Tersisa {{ number_format($totalMateriTersedia - $totalMateriSelesai, 0, ',', '.') }} materi yang belum selesai pada modul aktif.
                        @else
                            Semua materi pada modul aktif yang tersedia telah tercatat selesai.
                        @endif
                    </p>

                </div>

            </div>



            {{-- AKSI CEPAT --}}
            <div
                class="rounded-2xl border border-maroon-900/8 bg-white p-6 shadow-soft"
            >

                <p
                    class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700"
                >
                    Aksi Cepat
                </p>


                <h3
                    class="mt-1 font-display text-lg font-extrabold text-maroon-950"
                >
                    Mau melakukan apa?
                </h3>


                <div class="mt-5 grid grid-cols-2 gap-3">


                    {{-- EDITOR --}}
                    <a
                        href="{{ route('code-editor') }}"
                        class="group rounded-xl border border-maroon-900/8 p-4 transition hover:-translate-y-1 hover:border-gold-500/30 hover:shadow-soft"
                    >

                        <span
                            class="grid h-10 w-10 place-items-center rounded-xl bg-maroon-900 text-gold-400"
                        >

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="m8 9-4 3 4 3"/>
                                <path d="m16 9 4 3-4 3"/>
                                <path d="m14 5-4 14"/>
                            </svg>

                        </span>


                        <p
                            class="mt-3 text-[11px] font-extrabold text-maroon-950"
                        >
                            Buka Editor
                        </p>


                        <p
                            class="mt-1 text-[9px] leading-4 text-slate-400"
                        >
                            Coba source code
                        </p>

                    </a>



                    {{-- TEST --}}
                    <a
                        href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => 'posttest']) }}"
                        class="group rounded-xl border border-maroon-900/8 p-4 transition hover:-translate-y-1 hover:border-gold-500/30 hover:shadow-soft"
                    >

                        <span
                            class="grid h-10 w-10 place-items-center rounded-xl bg-maroon-900 text-gold-400"
                        >

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="m9 11 3 3L22 4"/>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>

                        </span>


                        <p
                            class="mt-3 text-[11px] font-extrabold text-maroon-950"
                        >
                            Ikuti Posttest
                        </p>


                        <p
                            class="mt-1 text-[9px] leading-4 text-slate-400"
                        >
                            Uji pemahaman setelah belajar
                        </p>

                    </a>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         BAHASA & TEKNOLOGI
    ========================================================== --}}

    <section
        id="bahasa"
        class="rounded-[26px] border border-maroon-900/8 bg-white p-6 shadow-soft sm:p-7"
    >


        <div
            class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"
        >

            <div>

                <p
                    class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700"
                >
                    Bahasa & Teknologi
                </p>


                <h3
                    class="mt-1 font-display text-xl font-extrabold text-maroon-950 sm:text-2xl"
                >
                    Pilih pembelajaranmu
                </h3>


                <p
                    class="mt-1 max-w-2xl text-xs leading-5 text-slate-400"
                >
                    Pilih bahasa pemrograman yang ingin kamu pelajari,
                    lanjutkan progress, atau mulai dari dasar.
                </p>

            </div>


            <a
                href="{{ route('materi') }}"
                class="inline-flex items-center gap-1 text-xs font-bold text-maroon-700 hover:text-gold-700"
            >
                Lihat semua

                <svg
                    class="h-3.5 w-3.5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M5 12h14"/>
                    <path d="m13 6 6 6-6 6"/>
                </svg>

            </a>

        </div>



        {{-- LANGUAGE GRID --}}
        <div
            class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5"
        >


            @foreach ($languages as $language)

                <a
                    href="{{ route('materi', ['bahasa' => $language['id']]) }}"
                    class="language-card group relative overflow-hidden rounded-[22px] border border-maroon-900/8 bg-white p-5 transition duration-300 hover:-translate-y-1.5 hover:border-gold-500/40 hover:shadow-[0_18px_45px_rgba(60,20,18,.10)]"
                >

                    {{-- TOP BRAND LINE --}}
                    <div
                        class="absolute left-0 right-0 top-0 h-1 opacity-70"
                        style="background: {{ $language['brand'] }}"
                    ></div>


                    <div class="flex items-start justify-between">


                        {{-- LOGO ASLI --}}
                        <div
                            class="grid h-16 w-16 place-items-center rounded-2xl {{ $language['bg'] }} p-3 transition duration-300 group-hover:scale-105"
                        >

                            @if (!empty($language['logo']))
                                <img
                                    src="{{ $language['logo'] }}"
                                    alt="{{ $language['name'] }} logo"
                                    class="h-11 w-11 object-contain"
                                    loading="lazy"
                                >
                            @else
                                <svg class="h-9 w-9 text-maroon-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m8 8-4 4 4 4M16 8l4 4-4 4M14 4l-4 16"/></svg>
                            @endif

                        </div>


                        {{-- ARROW --}}
                        <span
                            class="grid h-8 w-8 place-items-center rounded-lg bg-slate-50 text-slate-300 transition group-hover:bg-maroon-900 group-hover:text-gold-400"
                        >

                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>

                        </span>

                    </div>



                    {{-- LANGUAGE NAME --}}
                    <div class="mt-5">

                        <h4
                            class="text-sm font-extrabold text-maroon-950"
                        >
                            {{ $language['name'] }}
                        </h4>


                        <p
                            class="mt-1 text-[10px] text-slate-400"
                        >
                            {{ $language['desc'] }}
                        </p>

                    </div>



                    {{-- LEVEL --}}
                    <div class="mt-4 flex items-center justify-between">

                        <span
                            class="rounded-full bg-slate-50 px-2.5 py-1 text-[9px] font-bold text-slate-500"
                        >
                            {{ $language['level'] }}
                        </span>


                        <span
                            class="text-[9px] font-bold text-slate-400"
                        >
                            {{ $language['lessons'] }} materi
                        </span>

                    </div>



                    {{-- PROGRESS --}}
                    <div class="mt-4">

                        <div class="flex items-center justify-between">

                            <span
                                class="text-[9px] font-semibold text-slate-400"
                            >
                                Progress
                            </span>


                            <span
                                class="text-[9px] font-extrabold text-maroon-700"
                            >
                                {{ $language['progress'] }}%
                            </span>

                        </div>


                        <div
                            class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100"
                        >

                            <div
                                class="h-full rounded-full bg-maroon-700 transition-all duration-500 group-hover:bg-gold-500"
                                style="width: {{ $language['progress'] }}%"
                            ></div>

                        </div>

                    </div>

                </a>

            @endforeach

        </div>

    </section>



    {{-- =========================================================
         AKTIVITAS TERBARU
    ========================================================== --}}

    <section
        class="rounded-[26px] border border-maroon-900/8 bg-white p-6 shadow-soft sm:p-7"
    >

        <div class="flex items-center justify-between">

            <div>

                <p
                    class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700"
                >
                    Aktivitas Terbaru
                </p>


                <h3
                    class="mt-1 font-display text-xl font-extrabold text-maroon-950"
                >
                    Riwayat aktivitas
                </h3>

            </div>


            <a
                href="{{ route('progress') }}"
                class="text-xs font-bold text-maroon-700 hover:text-gold-700"
            >
                Lihat progres
            </a>

        </div>



        <div
            class="mt-6 divide-y divide-maroon-900/8"
        >


            @forelse ($recentActivities as $activity)
                <div class="flex items-start gap-4 py-4 first:pt-0">
                    <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-maroon-900/5 text-maroon-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="break-words text-xs font-bold text-maroon-950">{{ $activity->jenis_aktivitas ?: 'Aktivitas pengguna' }}</p>
                        <p class="mt-1 break-words text-[10px] leading-5 text-slate-500">{{ $activity->deskripsi ?: 'Tidak ada deskripsi aktivitas.' }}</p>
                        <p class="mt-1 text-[10px] text-slate-400">{{ $activity->waktu_aktivitas ? \Illuminate\Support\Carbon::parse($activity->waktu_aktivitas)->diffForHumans() : 'Waktu tidak tersedia' }}</p>
                    </div>
                    @if ($activity->entitas)
                        <span class="max-w-28 shrink-0 truncate rounded-full bg-maroon-900/5 px-2.5 py-1 text-[9px] font-bold text-maroon-700">{{ str_replace('_', ' ', $activity->entitas) }}</span>
                    @endif
                </div>
            @empty
                <div class="py-8 text-center">
                    <p class="text-sm font-bold text-maroon-950">Belum ada aktivitas tercatat</p>
                    <p class="mt-1 text-xs text-slate-500">Aktivitas belajar akan muncul setelah ada kegiatan yang berhasil dicatat sistem.</p>
                </div>
            @endforelse
        </div>

    </section>



    {{-- =========================================================
         MINI LANGUAGE SHOWCASE
    ========================================================== --}}

    <section
        class="overflow-hidden rounded-[26px] bg-maroon-950 p-6 text-white shadow-card sm:p-8"
    >

        <div
            class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between"
        >

            <div>

                <span
                    class="text-[9px] font-extrabold uppercase tracking-[.18em] text-gold-400"
                >
                    Belajar lebih banyak
                </span>


                <h3
                    class="mt-2 font-display text-2xl font-extrabold"
                >
                    Satu platform, banyak bahasa.
                </h3>


                <p
                    class="mt-2 max-w-xl text-xs leading-6 text-white/45"
                >
                    Pelajari konsep pemrograman dari dasar hingga tingkat
                    lanjutan melalui materi, latihan, dan code editor interaktif.
                </p>

            </div>



            {{-- LOGO ROW --}}
            <div class="flex flex-wrap items-center gap-3">

                @foreach (array_slice($languages, 0, 7) as $language)

                    <div
                        class="grid h-12 w-12 place-items-center rounded-xl border border-white/10 bg-white/5 p-2 transition hover:-translate-y-1 hover:bg-white/10"
                        title="{{ $language['name'] }}"
                    >

                        @if (!empty($language['logo']))
                            <img
                                src="{{ $language['logo'] }}"
                                alt="{{ $language['name'] }}"
                                class="h-7 w-7 object-contain"
                                loading="lazy"
                            >
                        @else
                            <svg class="h-7 w-7 text-gold-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m8 8-4 4 4 4M16 8l4 4-4 4M14 4l-4 16"/></svg>
                        @endif

                    </div>

                @endforeach

            </div>

        </div>

    </section>


</div>

@endsection
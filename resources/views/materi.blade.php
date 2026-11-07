@extends('layouts.master')



@section('title', 'Pembelajaran Coding — CodeTutor')



@section('description', 'Materi pembelajaran bahasa pemrograman CodeTutor.')



@section('page_label', 'Materi')



@section('page_heading', 'Pembelajaran Coding')



@section('content')



@php

    $moduleForView = $selectedModul ?? null;

    $materialForView = $selectedMateri ?? null;



    $moduleProgress = (float) ($moduleForView['progres'] ?? 0);

    $moduleMaterialTotal = (int) ($moduleForView['total_materi'] ?? 0);

    $moduleMaterialDone = (int) ($moduleForView['materi_selesai'] ?? 0);

    $materiSelesai = (bool) ($materialForView['selesai'] ?? false);

    $activeExample = collect($materialForView['contoh_kode'] ?? [])->first();



    // Rapikan spasi dan baris kosong dari isi materi agar awal teks tidak terdorong ke tengah.

    $isiMateri = trim((string) ($materialForView['isi'] ?? ''));

    $isiMateri = preg_replace('/^[ \\\t]+/m', '', $isiMateri) ?? $isiMateri;

    $isiMateri = preg_replace("/\n{3,}/", "\n\n", $isiMateri) ?? $isiMateri;

@endphp





<div class="mx-auto max-w-7xl space-y-5">



@if (session('success'))

    <div

        role="status"

        class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800"

    >

        {{ session('success') }}

    </div>

@endif

    {{-- =========================================================

         HEADER

    ========================================================== --}}



    <section

        class="rounded-3xl border border-maroon-900/8 bg-white p-6 shadow-soft sm:p-8"

    >



        <div class="flex flex-col gap-6">





            {{-- TOP HEADER --}}



            <div

                class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between"

            >





                {{-- LEFT --}}



                <div class="min-w-0 flex-1">



                    <div>



                        <div class="flex flex-wrap items-center gap-2">



                            <span

                                class="rounded-full bg-maroon-900/5 px-3 py-1 text-[9px] font-extrabold uppercase tracking-[.15em] text-maroon-700"

                            >

                                Bahasa Pemrograman

                            </span>





                            <span

                                id="languageLevel"

                                class="rounded-full bg-gold-400/10 px-3 py-1 text-[9px] font-extrabold text-gold-700"

                            >

                                Bahasa aktif

                            </span>



                        </div>





                        <h1

                            id="languageTitle"

                            class="mt-3 font-display text-3xl font-extrabold text-maroon-950 sm:text-4xl">{{ $selectedBahasa['nama'] ?? 'Pembelajaran Coding' }}</h1>





                        <p

                            id="languageDescription"

                            class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">{{ $selectedBahasa['deskripsi'] ?? 'Pilih bahasa pemrograman dan modul yang ingin kamu pelajari.' }}</p>



                    </div>



                </div>







                {{-- PROGRESS --}}



                <div

                    class="w-full rounded-2xl bg-warm-100 p-5 sm:max-w-xs"

                >



                    <div class="flex items-center justify-between">



                        <div>



                            <p

                                class="text-[9px] font-extrabold uppercase tracking-[.14em] text-slate-400"

                            >

                                Progress Belajar

                            </p>





                            <p

                                id="progressValue"

                                class="mt-1 font-display text-2xl font-extrabold text-maroon-950">{{ number_format($moduleProgress, 0) }}%</p>



                        </div>





                        <div class="text-right">



                            <p

                                id="progressCount"

                                class="text-[10px] font-bold text-slate-400">{{ $moduleMaterialDone }} / {{ $moduleMaterialTotal }}</p>





                            <p

                                class="mt-1 text-[9px] text-slate-400"

                            >

                                Materi selesai

                            </p>



                        </div>



                    </div>





                    <div

                        class="mt-4 h-2 overflow-hidden rounded-full bg-maroon-900/10"

                    >



                        <div

                            id="progressBar"

                            class="h-full rounded-full bg-gradient-to-r from-maroon-800 to-gold-500 transition-all duration-500"

                            style="width: {{ $moduleProgress }}%"

                        ></div>



                    </div>



                </div>



            </div>







            {{-- =====================================================

                 DROPDOWN BAHASA

            ====================================================== --}}



            <div

                class="border-t border-maroon-900/8 pt-5"

            >



                <div

                    class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"

                >



                    <div>



                        <p

                            class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700"

                        >

                            Pilih Bahasa

                        </p>



                        <p

                            class="mt-1 text-[10px] text-slate-400"

                        >

                            Pilih bahasa pemrograman yang ingin kamu pelajari.

                        </p>



                    </div>







                    {{-- DROPDOWN --}}



                    <div class="relative w-full sm:w-80">



                        <select

                            id="languageSelect"

                            class="w-full appearance-none rounded-2xl border-2 border-maroon-200 bg-white py-3.5 pl-11 pr-11 text-sm font-bold text-maroon-950 shadow-sm outline-none transition duration-200 hover:border-maroon-400 focus:border-maroon-700 focus:ring-4 focus:ring-maroon-100 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-400"

                            {{ empty($catalog) ? 'disabled' : '' }}

                        >

                            @forelse ($catalog as $language)

                                <option value="{{ $language['id'] }}" @selected((string) ($selectedBahasa['id'] ?? '') === (string) $language['id'])>

                                    {{ $language['nama'] }}

                                </option>

                            @empty

                                <option value="">Belum ada bahasa aktif</option>

                            @endforelse

                        </select>





                    
            <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-maroon-700" aria-hidden="true">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v3M16 3v3M4 9h16"/><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M8 13h3M8 17h6"/></svg>
            </span>
            <span class="pointer-events-none absolute inset-y-0 right-3.5 flex items-center text-maroon-700" aria-hidden="true">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 10 5 5 5-5"/></svg>
            </span>
</div>



                </div>



            </div>



            {{-- PILIH MODUL SETELAH BAHASA DIPILIH --}}

            <div class="border-t border-maroon-900/8 pt-5">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700">Pilih Modul</p>

                        <p class="mt-1 text-[10px] text-slate-400">Pilih modul untuk melihat daftar materi dan media pembelajarannya.</p>

                    </div>



                    <div class="relative w-full sm:w-80">

                        <select

                            id="moduleSelect"

                            class="w-full appearance-none rounded-2xl border-2 border-maroon-200 bg-white py-3.5 pl-11 pr-11 text-sm font-bold text-maroon-950 shadow-sm outline-none transition duration-200 hover:border-maroon-400 focus:border-maroon-700 focus:ring-4 focus:ring-maroon-100 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-400"

                            {{ empty($selectedBahasa['modul'] ?? []) ? 'disabled' : '' }}

                        >

                            @forelse (($selectedBahasa['modul'] ?? []) as $module)

                                <option value="{{ $module['id'] }}" @selected((string) ($moduleForView['id'] ?? '') === (string) $module['id'])>

                                    {{ $module['nama'] }}

                                </option>

                            @empty

                                <option value="">Belum ada modul aktif</option>

                            @endforelse

                        </select>





                    
            <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-maroon-700" aria-hidden="true">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v18H6.5A2.5 2.5 0 0 1 4 18.5z"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20"/></svg>
            </span>
            <span class="pointer-events-none absolute inset-y-0 right-3.5 flex items-center text-maroon-700" aria-hidden="true">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 10 5 5 5-5"/></svg>
            </span>
</div>

                </div>



                @if ($moduleForView)

                    <div class="mt-3 flex flex-wrap items-center gap-2 text-[10px] text-slate-500">

                        <span class="rounded-full bg-warm-100 px-3 py-1.5">{{ $moduleMaterialTotal }} materi tersedia</span>

                        <span class="rounded-full bg-emerald-50 px-3 py-1.5 font-bold text-emerald-700">{{ $moduleMaterialDone }} materi selesai</span>

                    </div>

                @endif

            </div>



        </div>



    </section>







    {{-- =========================================================

         CONTENT

    ========================================================== --}}



    <div

        class="grid gap-5 lg:grid-cols-[310px_minmax(0,1fr)]"

    >





        {{-- =====================================================

             LEFT : DAFTAR MATERI

        ====================================================== --}}



        <aside>



            <div

                class="sticky top-24 rounded-3xl border border-maroon-900/8 bg-white shadow-soft"

            >



                <div

                    class="border-b border-maroon-900/8 p-5"

                >



                    <p

                        id="learningPathLabel"

                        class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700"

                    >

                        Learning Path

                    </p>





                    <h2

                        id="materialTitle"

                        class="mt-1 font-display text-lg font-extrabold text-maroon-950">{{ $moduleForView['nama'] ?? 'Materi tersedia' }}</h2>





                    <p

                        id="moduleDescription"

                        class="mt-1 text-[10px] leading-5 text-slate-400"

                    >

                        {{ $moduleForView['deskripsi'] ?? 'Ikuti materi secara berurutan untuk mendapatkan pemahaman yang lebih baik.' }}

                    </p>



                </div>







                <div

                    id="topicContainer"

                    class="max-h-[650px] overflow-y-auto p-3"

                >





                    @forelse (($moduleForView['materi'] ?? []) as $material)

                    <a

                        href="{{ route('materi', ['bahasa' => $selectedBahasa['id'], 'modul' => $moduleForView['id'], 'materi' => $material['id']]) }}"

                        data-topic="{{ $material['judul'] }}"

                        data-description="{{ $material['deskripsi'] }}"

                        data-materi-id="{{ $material['id'] }}"

                        class="java-topic mt-2 flex w-full items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-left shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-maroon-300 hover:bg-maroon-50/70 hover:shadow-md focus:outline-none focus-visible:ring-4 focus-visible:ring-maroon-100 {{ (string) ($materialForView['id'] ?? '') === (string) $material['id'] ? 'active-topic border-maroon-900 bg-maroon-900 text-white shadow-md hover:bg-maroon-900' : 'text-maroon-950' }}"

                    >

                        <span class="topic-number grid h-9 w-9 shrink-0 place-items-center rounded-xl {{ (string) ($materialForView['id'] ?? '') === (string) $material['id'] ? 'bg-gold-400 text-maroon-950' : 'bg-warm-100 text-maroon-800' }} text-[10px] font-extrabold">

                            {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}

                        </span>

                        <span class="min-w-0 flex-1">

                            <span class="topic-title block text-xs font-extrabold {{ (string) ($materialForView['id'] ?? '') === (string) $material['id'] ? 'text-white' : 'text-maroon-950' }}">

                                {{ $material['judul'] }}

                            </span>

                            <span class="topic-subtitle mt-1 block text-[9px] {{ (string) ($materialForView['id'] ?? '') === (string) $material['id'] ? 'text-white/50' : 'text-slate-400' }}">

                                {{ \Illuminate\Support\Str::limit($material['deskripsi'] ?: 'Materi pembelajaran', 55) }}

                            </span>

                        </span>

                        <span class="topic-status ml-2 shrink-0 text-[9px] font-semibold {{ !empty($material['selesai']) ? (((string) ($materialForView['id'] ?? '') === (string) $material['id']) ? 'text-emerald-200' : 'text-emerald-700') : (((string) ($materialForView['id'] ?? '') === (string) $material['id']) ? 'text-white/60' : 'text-slate-400') }}">

                            {{ !empty($material['selesai']) ? 'Selesai' : 'Belum selesai' }}

                        </span>

                    </a>

                @empty

                    <div class="rounded-2xl bg-warm-50 p-4 text-xs leading-6 text-slate-500">

                        Belum ada materi aktif pada modul ini. Pilih modul lain atau minta Instruktur menambahkan materi.

                    </div>

                @endforelse





                </div>



            </div>



        </aside>







        {{-- =====================================================

             RIGHT CONTENT

        ====================================================== --}}



        <main class="min-w-0 space-y-5">





            {{-- =================================================

                 MATERI AKTIF

            ================================================== --}}



            <section

                id="materiDetail"
                class="scroll-mt-24 rounded-3xl border border-maroon-900/8 bg-white shadow-soft"

            >



                <div class="p-6 sm:p-8">



                    <div

                        class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between"

                    >



                        <div>



                            <span

                                class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700"

                            >

                                Materi Saat Ini

                            </span>





                            <h2

                                id="currentTopic"

                                class="mt-2 font-display text-2xl font-extrabold text-maroon-950">{{ $materialForView['judul'] ?? 'Pilih materi' }}</h2>





                            <p

                                id="currentDescription"

                                class="mt-2 max-w-3xl text-xs leading-6 text-slate-500">{{ $materialForView['deskripsi'] ?? 'Pilih materi di sebelah kiri untuk mulai belajar.' }}</p>



                            @if ($materialForView)

                                <span

                                    id="statusMateriAktif"

                                    class="mt-3 block text-xs font-semibold {{ $materiSelesai ? 'text-emerald-700' : 'text-amber-700' }}"

                                >

                                    {{ $materiSelesai ? 'Status: Sudah selesai' : 'Status: Belum selesai. Baca materi sampai bagian akhir.' }}

                                </span>

                            @endif



                        </div>





                    </div>







                    {{-- INFO --}}



                    <div

                        class="mt-5 grid gap-3 sm:grid-cols-3"

                    >



                        <div class="rounded-2xl bg-warm-100 p-4">



                            <p

                                class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400"

                            >

                                Materi

                            </p>





                            <p

                                class="mt-1 text-sm font-extrabold text-maroon-950"

                            >

                                {{ $materialForView ? 'Urutan ' . ($materialForView['urutan'] ?? 0) : '—' }}

                            </p>



                        </div>





                        <div class="rounded-2xl bg-warm-100 p-4">



                            <p

                                class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400"

                            >

                                Modul

                            </p>





                            <p

                                id="currentLevel"

                                class="mt-1 text-sm font-extrabold text-maroon-950">{{ $moduleForView['nama'] ?? '—' }}</p>



                        </div>





                        <div class="rounded-2xl bg-warm-100 p-4">



                            <p

                                class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400"

                            >

                                Aktivitas

                            </p>





                            <p

                                class="mt-1 text-sm font-extrabold text-maroon-950"

                            >

                                {{ count($materialForView['media'] ?? []) }} Media pendukung

                            </p>



                        </div>



                    </div>







                    {{-- ISI MATERI DARI DATABASE --}}

                    <article

                        id="isiMateriUtama"

                        class="mt-5 w-full min-w-0 max-w-none break-words text-left text-[15px] leading-8 text-slate-700 sm:text-base"

                        style="overflow-wrap: anywhere; word-break: normal; text-align: left;"

                    >

                        @if ($materialForView && $isiMateri !== '')

                            <div class="whitespace-normal text-left">

                                {!! nl2br(e($isiMateri)) !!}

                            </div>

                        @elseif ($materialForView)

                            <p class="m-0 text-slate-500">Instruktur belum menambahkan isi materi untuk topik ini.</p>

                        @else

                            <p class="m-0 text-slate-500">Pilih materi pada daftar di sebelah kiri untuk melihat isi pembelajaran.</p>

                        @endif

                    </article>



                    {{-- CONTOH KODE TERKAIT MATERI --}}

                    <div class="mt-5 overflow-hidden rounded-2xl bg-maroon-950">

                        <div class="border-b border-white/10 px-5 py-3">

                            <p class="text-[10px] font-semibold text-white/60">

                                {{ $activeExample['judul'] ?? 'Contoh Kode' }}

                            </p>

                        </div>

                        @if ($activeExample && !empty($activeExample['kode_program']))

                            <pre class="overflow-x-auto whitespace-pre-wrap p-5 font-mono text-xs leading-7 text-white/75"><code>{{ $activeExample['kode_program'] }}</code></pre>

                        @else

                            <div class="p-5 text-xs leading-6 text-white/55">

                                Belum ada contoh kode yang terhubung dengan materi ini. Contoh kode akan tampil setelah Instruktur menghubungkannya melalui menu Code Lab.

                            </div>

                        @endif

                    </div>



                    {{-- BUTTON DAN STATUS PENYELESAIAN --}}



                    <div

                        class="mt-6 flex flex-col gap-3 sm:flex-row sm:flex-wrap"

                    >@if ($materialForView && $moduleForView)

    <form

        id="formTandaiMateriSelesai"

        method="POST"

        action="{{ route('pelajar.materi.selesai', $materialForView['id']) }}"

        data-sudah-selesai="{{ $materiSelesai ? '1' : '0' }}"

        data-id-materi="{{ $materialForView['id'] }}"

    >

        @csrf



        <button

            id="tombolTandaiMateriSelesai"

            type="submit"

            {{ $materiSelesai ? 'disabled' : '' }}

            class="inline-flex w-full items-center justify-center gap-2 rounded-xl px-5 py-3 text-xs font-extrabold text-white shadow-sm transition-all duration-200 focus:outline-none focus:ring-4 disabled:cursor-not-allowed {{ $materiSelesai ? 'bg-emerald-700 focus:ring-emerald-100' : 'bg-maroon-900 hover:-translate-y-0.5 hover:bg-maroon-800 focus:ring-maroon-100' }} disabled:hover:translate-y-0"

        >

            {{ $materiSelesai ? 'Materi sudah selesai' : 'Tandai materi selesai' }}

        </button>

    </form>

    <p id="pesanProgresOtomatis" class="self-center text-[10px] leading-5 text-slate-500">

        {{ $materiSelesai ? 'Progres materi ini sudah tersimpan.' : 'Progres akan tersimpan otomatis saat kamu mencapai bagian akhir materi dan media.' }}

    </p>

@endif



                        <a

                            href="{{ route('latihan') }}"

                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-xs font-extrabold text-white transition hover:bg-maroon-700"

                        >

                            Kerjakan Latihan



                        </a>





                        <a

                            href="{{ route('code-editor') }}"

                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-maroon-900/10 px-5 py-3 text-xs font-extrabold text-maroon-800 transition hover:bg-warm-100"

                        >

                            Buka Code Editor



                        </a>



                    </div>



                </div>



            </section>







            {{-- =================================================

                 DOKUMEN PEMBELAJARAN

            ================================================== --}}



            <section

                class="rounded-3xl border border-maroon-900/8 bg-white shadow-soft"

            >



                <div

                    class="border-b border-maroon-900/8 p-6 sm:p-8"

                >



                    <div

                        class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"

                    >



                        <div>



                            <span

                                class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700"

                            >

                                Referensi Pembelajaran

                            </span>





                            <h2

                                class="mt-1 font-display text-xl font-extrabold text-maroon-950 sm:text-2xl"

                            >

                                Media {{ $materialForView['judul'] ?? 'Pembelajaran' }}

                            </h2>





                            <p

                                class="mt-1 max-w-2xl text-xs leading-5 text-slate-400"

                            >

                                Baca atau preview dokumen pembelajaran

                                langsung dari halaman ini.

                            </p>



                        </div>





                        <span

                            class="inline-flex w-fit items-center rounded-full bg-gold-400/10 px-3 py-1.5 text-[9px] font-extrabold text-gold-700"

                        >

                            {{ count($materialForView['media'] ?? []) }} Media

                        </span>



                    </div>



                </div>







                {{-- MEDIA PEMBELAJARAN DARI DATABASE --}}

                <div class="space-y-3 p-5 sm:p-7">

                    @forelse (($materialForView['media'] ?? []) as $media)
    @php
        $mediaJenis = strtolower((string) ($media['jenis'] ?? 'lainnya'));
        $mediaUrl = (string) ($media['url'] ?? '');
        $previewBisa = $mediaUrl !== '';
        $labelMedia = match ($mediaJenis) {
            'youtube' => 'VIDEO YOUTUBE',
            'pdf' => 'DOKUMEN PDF',
            'ppt' => 'PRESENTASI',
            'video' => 'VIDEO',
            'animasi' => 'ANIMASI / GAMBAR',
            'game' => 'GAME / ARSIP',
            default => strtoupper($mediaJenis),
        };
    @endphp

    <article class="group rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-maroon-300 hover:shadow-md sm:p-5">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-maroon-50 text-maroon-800 ring-1 ring-inset ring-maroon-100">
                @if ($mediaJenis === 'youtube' || $mediaJenis === 'video')
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31 31 0 0 0 0 12a31 31 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31 31 0 0 0 24 12a31 31 0 0 0-.5-5.8ZM9.6 15.6V8.4l6.3 3.6-6.3 3.6Z"/></svg>
                @elseif ($mediaJenis === 'pdf')
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg>
                @elseif ($mediaJenis === 'ppt')
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 16V8h3a2 2 0 0 1 0 4H8M15 8v8M15 8h3"/></svg>
                @else
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="M4 15l5-5 4 4 3-3 4 4"/><circle cx="9" cy="8" r="1.5"/></svg>
                @endif
            </div>

            <div class="min-w-0 flex-1">
                <div class="mb-1.5 flex flex-wrap items-center gap-2">
                    <span class="inline-flex rounded-md bg-maroon-50 px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-wider text-maroon-800 ring-1 ring-inset ring-maroon-100">
                        {{ $labelMedia }}
                    </span>
                    @if ($previewBisa)
                        <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Media tersedia
                        </span>
                    @endif
                </div>
                <h3 class="truncate text-sm font-extrabold text-maroon-950">{{ $media['judul'] ?? 'Media pembelajaran' }}</h3>
                <p class="mt-1 text-xs leading-5 text-slate-500">
                    Referensi untuk materi {{ $materialForView['judul'] ?? '' }}.
                </p>
            </div>

            <div class="flex shrink-0 flex-wrap gap-2">
                @if ($previewBisa)
                    <button
                        type="button"
                        class="preview-media inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-900 px-4 py-2.5 text-[11px] font-extrabold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-maroon-800 focus:outline-none focus:ring-4 focus:ring-maroon-100"
                        data-title="{{ $media['judul'] ?? 'Media pembelajaran' }}"
                        data-url="{{ $mediaUrl }}"
                        data-kind="{{ $mediaJenis }}"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                        Preview
                    </button>
                    <a href="{{ $mediaUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 rounded-xl border border-maroon-200 bg-white px-4 py-2.5 text-[11px] font-bold text-maroon-800 transition hover:border-maroon-400 hover:bg-maroon-50">
                        Buka
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3h7v7M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                    </a>
                @else
                    <span class="inline-flex items-center rounded-xl bg-slate-100 px-4 py-2.5 text-[11px] font-semibold text-slate-500">Media belum tersedia</span>
                @endif
            </div>
        </div>
    </article>
@empty
    <div class="rounded-2xl border border-dashed border-maroon-200 bg-maroon-50/40 px-5 py-9 text-center">
        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-maroon-700 shadow-sm ring-1 ring-maroon-100">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="M8 9h8M8 13h5"/></svg>
        </div>
        <h3 class="mt-3 font-display text-sm font-extrabold text-maroon-950">Belum ada media pembelajaran</h3>
        <p class="mx-auto mt-1 max-w-md text-xs leading-5 text-slate-500">Media PDF, presentasi, video, YouTube, dan tautan pendukung yang ditambahkan Instruktur akan muncul di sini.</p>
    </div>
@endforelse

                </div>



            </section>



            {{-- Penanda otomatis setelah Pelajar mencapai akhir materi dan bagian media pendukung. --}}

            @if ($materialForView && $moduleForView)

                <div id="penandaAkhirMateri" class="h-1 w-full" aria-hidden="true"></div>

            @endif





            {{-- =================================================

                 NEXT ACTION

            ================================================== --}}



            <section

                class="rounded-3xl bg-maroon-900 p-6 text-white sm:p-8"

            >



                <div

                    class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between"

                >



                    <div>



                        <p

                            class="text-[9px] font-extrabold uppercase tracking-[.16em] text-gold-400"

                        >

                            Setelah Materi

                        </p>





                        <h2

                            class="mt-2 font-display text-xl font-extrabold"

                        >

                            Uji pemahamanmu melalui latihan soal

                        </h2>





                        <p

                            class="mt-2 max-w-xl text-xs leading-6 text-white/45"

                        >

                            Setelah membaca materi, lanjutkan dengan

                            latihan soal untuk mengetahui sejauh mana

                            pemahamanmu terhadap {{ $selectedBahasa['nama'] ?? 'bahasa pemrograman' }}.

                        </p>



                    </div>





                    <a

    href="{{ route('latihan') }}"

    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-gold-400 px-5 py-3 text-xs font-extrabold text-maroon-950 transition hover:bg-gold-300"

\>

    Latihan Soal



</a>



                </div>



            </section>





        </main>



    </div>



</div>







{{-- =============================================================
     PREVIEW MEDIA PEMBELAJARAN
============================================================== --}}
<div id="mediaPreviewModal" class="fixed inset-0 z-[200] hidden bg-maroon-950/75 p-2 backdrop-blur-sm sm:p-5" role="dialog" aria-modal="true" aria-labelledby="mediaPreviewTitle">
    <div class="mx-auto flex h-full max-w-6xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl sm:rounded-3xl">
        <div class="flex shrink-0 items-center justify-between gap-3 border-b border-slate-200 px-4 py-3 sm:px-6">
            <div class="min-w-0">
                <p id="mediaPreviewLabel" class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700">Preview Media</p>
                <h2 id="mediaPreviewTitle" class="mt-1 truncate font-display text-base font-extrabold text-maroon-950 sm:text-lg">Media Pembelajaran</h2>
            </div>
            <div class="flex shrink-0 items-center gap-2">
                <a id="mediaPreviewOpen" href="#" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-xl border border-maroon-200 px-3 py-2 text-[10px] font-bold text-maroon-800 transition hover:bg-maroon-50 sm:px-4">
                    Buka Tab Baru
                </a>
                <button type="button" id="closeMediaPreview" class="rounded-xl bg-maroon-900 px-3.5 py-2 text-[10px] font-extrabold text-white transition hover:bg-maroon-800 sm:px-4">
                    Tutup
                </button>
            </div>
        </div>

        <div class="min-h-0 flex-1 bg-slate-100 p-2 sm:p-4">
            <div id="mediaPreviewStage" class="relative flex h-full min-h-[260px] items-center justify-center overflow-hidden rounded-xl bg-slate-200 sm:rounded-2xl">
                <iframe id="mediaPreviewFrame" class="hidden h-full w-full border-0 bg-white" src="about:blank" title="Preview media" allow="autoplay; encrypted-media; fullscreen; picture-in-picture" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>

                <img id="mediaPreviewImage" class="hidden max-h-full max-w-full object-contain" src="" alt="Preview media pembelajaran">

                <video id="mediaPreviewVideo" class="hidden h-full max-h-full w-full bg-black object-contain" controls playsinline preload="metadata">
                    Browser kamu tidak mendukung pemutaran video.
                </video>

                <audio id="mediaPreviewAudio" class="hidden w-full max-w-xl px-6" controls preload="metadata">
                    Browser kamu tidak mendukung pemutaran audio.
                </audio>

                <div id="mediaPreviewNotice" class="hidden max-w-xl px-6 py-10 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-maroon-800 shadow-sm">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg>
                    </div>
                    <h3 id="mediaPreviewNoticeTitle" class="mt-4 font-display text-base font-extrabold text-maroon-950">Pratinjau tidak tersedia</h3>
                    <p id="mediaPreviewNoticeText" class="mt-2 text-sm leading-6 text-slate-600">Gunakan tombol Buka Tab Baru untuk mengakses media.</p>
                    <a id="mediaPreviewNoticeLink" href="#" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center justify-center rounded-xl bg-maroon-900 px-5 py-2.5 text-xs font-extrabold text-white transition hover:bg-maroon-800">Buka Media</a>
                </div>
            </div>
            <p id="mediaPreviewHint" class="mt-2 text-center text-[10px] leading-5 text-slate-500">
                Beberapa situs eksternal membatasi penayangan di dalam iframe. Gunakan tombol Buka Tab Baru apabila pratinjau tidak muncul.
            </p>
        </div>
    </div>
</div>

@push('scripts')



<script>



document.addEventListener('DOMContentLoaded', function () {





    /*

    |--------------------------------------------------------------------------

    | PILIH BAHASA DAN MATERI DARI DATA DATABASE

    |--------------------------------------------------------------------------

    */



    const languageSelect = document.getElementById('languageSelect');



    if (languageSelect) {

        languageSelect.addEventListener('change', function () {

            if (!this.value) return;

            const url = new URL(window.location.href);

            url.searchParams.set('bahasa', this.value);

            // Modul dan materi dipilih ulang oleh controller untuk bahasa baru.

            url.searchParams.delete('modul');

            url.searchParams.delete('materi');

            window.location.href = url.toString();

        });

    }



    const moduleSelect = document.getElementById('moduleSelect');



    if (moduleSelect) {

        moduleSelect.addEventListener('change', function () {

            if (!this.value) return;



            const url = new URL(window.location.href);

            url.searchParams.set('modul', this.value);

            url.searchParams.delete('materi');

            window.location.href = url.toString();

        });

    }



    /*

    |--------------------------------------------------------------------------

    | TANDAI MATERI SELESAI OTOMATIS KETIKA PELAJAR MENCAPAI AKHIR BACAAN

    |--------------------------------------------------------------------------

    */

    const formSelesai = document.getElementById('formTandaiMateriSelesai');

    const penandaAkhirMateri = document.getElementById('penandaAkhirMateri');

    const pesanProgresOtomatis = document.getElementById('pesanProgresOtomatis');

    const tombolTandaiSelesai = document.getElementById('tombolTandaiMateriSelesai');

    const statusMateriAktif = document.getElementById('statusMateriAktif');



    if (formSelesai && penandaAkhirMateri) {

        let materiSudahSelesai = formSelesai.dataset.sudahSelesai === '1';

        let permintaanSedangDikirim = false;

        let sudahMelakukanScroll = false;

        let waktuTunda = null;



        async function simpanProgresMateri() {

            if (materiSudahSelesai || permintaanSedangDikirim) return;



            permintaanSedangDikirim = true;

            if (pesanProgresOtomatis) {

                pesanProgresOtomatis.textContent = 'Menyimpan progres belajarmu...';

                pesanProgresOtomatis.classList.remove('text-red-600');

            }



            const tokenCsrf = formSelesai.querySelector('input[name="_token"]')?.value;



            try {

                const respons = await fetch(formSelesai.action, {

                    method: 'POST',

                    headers: {

                        'X-CSRF-TOKEN': tokenCsrf,

                        'Accept': 'application/json',

                        'X-Requested-With': 'XMLHttpRequest'

                    },

                    body: new URLSearchParams({ _token: tokenCsrf })

                });



                const hasil = await respons.json();

                if (!respons.ok) {

                    throw new Error(hasil.message || 'Progres belum berhasil disimpan.');

                }



                materiSudahSelesai = true;

                formSelesai.dataset.sudahSelesai = '1';



                if (tombolTandaiSelesai) {

                    tombolTandaiSelesai.disabled = true;

                    tombolTandaiSelesai.textContent = 'Materi sudah selesai';

                    tombolTandaiSelesai.classList.remove('bg-maroon-900', 'hover:bg-maroon-800');

                    tombolTandaiSelesai.classList.add('bg-emerald-700');

                }



                if (statusMateriAktif) {

                    statusMateriAktif.textContent = 'Status: Sudah selesai';

                    statusMateriAktif.className = 'mt-3 block text-xs font-semibold text-emerald-700';

                }



                if (pesanProgresOtomatis) {

                    pesanProgresOtomatis.textContent = 'Berhasil! Progres materi sudah tersimpan otomatis.';

                    pesanProgresOtomatis.classList.remove('text-red-600');

                }



                const itemMateriAktif = document.querySelector('.java-topic[data-materi-id="' + formSelesai.dataset.idMateri + '"]');

                if (itemMateriAktif) {

                    const statusDaftarMateri = itemMateriAktif.querySelector('.topic-status');

                    if (statusDaftarMateri) {

                        statusDaftarMateri.textContent = 'Selesai';

                        statusDaftarMateri.classList.remove('text-slate-400', 'text-white/60', 'text-emerald-700', 'text-emerald-600');

                        statusDaftarMateri.classList.add('text-emerald-200');

                    }

                }



                const nilaiProgres = Number(hasil.presentase_progres || 0);

                const teksProgres = document.getElementById('progressValue');

                const jumlahProgres = document.getElementById('progressCount');

                const barProgres = document.getElementById('progressBar');



                if (teksProgres) teksProgres.textContent = Math.round(nilaiProgres) + '%';

                if (jumlahProgres) jumlahProgres.textContent = hasil.materi_selesai + ' / ' + hasil.total_materi;

                if (barProgres) barProgres.style.width = nilaiProgres + '%';

            } catch (kesalahan) {

                if (pesanProgresOtomatis) {

                    pesanProgresOtomatis.textContent = kesalahan.message || 'Koneksi bermasalah. Coba tekan tombol tandai selesai.';

                    pesanProgresOtomatis.classList.add('text-red-600');

                }

                permintaanSedangDikirim = false;

            }

        }



        function periksaAkhirMateri() {

            if (materiSudahSelesai || permintaanSedangDikirim || !sudahMelakukanScroll) return;



            const posisiAkhir = penandaAkhirMateri.getBoundingClientRect();

            if (posisiAkhir.top <= window.innerHeight + 40) {

                window.clearTimeout(waktuTunda);

                waktuTunda = window.setTimeout(simpanProgresMateri, 700);

            }

        }



        window.addEventListener('scroll', function () {

            if (window.scrollY > 0) sudahMelakukanScroll = true;

            periksaAkhirMateri();

        }, { passive: true });



        window.addEventListener('resize', periksaAkhirMateri);



        formSelesai.addEventListener('submit', function (event) {

            event.preventDefault();

            window.clearTimeout(waktuTunda);

            simpanProgresMateri();

        });

    }



        /* --------------------------------------------------------------------------
       PREVIEW SEMUA MEDIA PEMBELAJARAN
    -------------------------------------------------------------------------- */

    const mediaModal = document.getElementById('mediaPreviewModal');
    const mediaTitle = document.getElementById('mediaPreviewTitle');
    const mediaLabel = document.getElementById('mediaPreviewLabel');
    const mediaOpen = document.getElementById('mediaPreviewOpen');
    const mediaFrame = document.getElementById('mediaPreviewFrame');
    const mediaImage = document.getElementById('mediaPreviewImage');
    const mediaVideo = document.getElementById('mediaPreviewVideo');
    const mediaAudio = document.getElementById('mediaPreviewAudio');
    const mediaNotice = document.getElementById('mediaPreviewNotice');
    const mediaNoticeTitle = document.getElementById('mediaPreviewNoticeTitle');
    const mediaNoticeText = document.getElementById('mediaPreviewNoticeText');
    const mediaNoticeLink = document.getElementById('mediaPreviewNoticeLink');
    const closeMediaPreview = document.getElementById('closeMediaPreview');

    function sembunyikanSemuaPreview() {
        [mediaFrame, mediaImage, mediaVideo, mediaAudio, mediaNotice].forEach(function (element) {
            element.classList.add('hidden');
        });

        mediaFrame.src = 'about:blank';
        mediaImage.src = '';
        mediaVideo.pause();
        mediaVideo.removeAttribute('src');
        mediaVideo.load();
        mediaAudio.pause();
        mediaAudio.removeAttribute('src');
        mediaAudio.load();
    }

    function tampilkanPemberitahuan(judul, pesan, url) {
        mediaNoticeTitle.textContent = judul;
        mediaNoticeText.textContent = pesan;
        mediaNoticeLink.href = url || '#';
        mediaNotice.classList.remove('hidden');
        mediaLabel.textContent = 'INFORMASI MEDIA';
    }

    function ambilEkstensi(url) {
        try {
            const pathname = new URL(url, window.location.origin).pathname;
            const match = pathname.toLowerCase().match(/\.([a-z0-9]+)$/);
            return match ? match[1] : '';
        } catch (error) {
            return '';
        }
    }

    function youtubeEmbed(url) {
        try {
            const parsed = new URL(url);
            const host = parsed.hostname.replace(/^www\./, '').toLowerCase();
            let id = '';

            if (host === 'youtu.be') {
                id = parsed.pathname.split('/').filter(Boolean)[0] || '';
            } else if (['youtube.com', 'm.youtube.com', 'youtube-nocookie.com'].includes(host)) {
                id = parsed.searchParams.get('v') || '';
                if (!id) {
                    const parts = parsed.pathname.split('/').filter(Boolean);
                    if (['embed', 'shorts', 'live'].includes(parts[0])) id = parts[1] || '';
                }
            }

            return /^[A-Za-z0-9_-]{11}$/.test(id)
                ? 'https://www.youtube-nocookie.com/embed/' + id + '?autoplay=1&rel=0'
                : null;
        } catch (error) {
            return null;
        }
    }

    function officeViewerUrl(url) {
        return 'https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(url);
    }

    function googleViewerUrl(url) {
        try {
            const parsed = new URL(url);
            const host = parsed.hostname.toLowerCase();

            if (host === 'drive.google.com' || host === 'docs.google.com') {
                if (parsed.pathname.includes('/file/d/')) {
                    parsed.pathname = parsed.pathname.replace(/\/view\/?$/, '/preview');
                    if (!parsed.pathname.endsWith('/preview')) parsed.pathname = parsed.pathname.replace(/\/?$/, '/preview');
                    return parsed.toString();
                }

                if (/\/(document|spreadsheets|presentation)\/d\//.test(parsed.pathname)) {
                    return parsed.origin + parsed.pathname.replace(/\/(edit|view)\/?$/, '') +
                        (parsed.pathname.includes('/presentation/') ? '/embed' : '/preview');
                }
            }

            return null;
        } catch (error) {
            return null;
        }
    }

    function urlLokal(url) {
        try {
            const parsed = new URL(url, window.location.origin);
            return parsed.origin === window.location.origin ||
                ['localhost', '127.0.0.1', '::1'].includes(parsed.hostname);
        } catch (error) {
            return true;
        }
    }

    function bukaPreviewMedia(button) {
        const url = button.dataset.url;
        const kind = (button.dataset.kind || 'lainnya').toLowerCase();
        const title = button.dataset.title || 'Media Pembelajaran';
        const ext = ambilEkstensi(url);

        if (!url || !mediaModal) return;

        sembunyikanSemuaPreview();
        mediaTitle.textContent = title;
        mediaOpen.href = url;
        mediaLabel.textContent = 'PREVIEW ' + kind.toUpperCase();
        mediaModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        const youtubeUrl = youtubeEmbed(url);
        const cloudUrl = googleViewerUrl(url);

        // YouTube selalu diputar menggunakan embed, baik jenis tersimpan youtube maupun video.
        if (youtubeUrl) {
            mediaFrame.src = youtubeUrl;
            mediaFrame.classList.remove('hidden');
            mediaLabel.textContent = 'VIDEO YOUTUBE';
            return;
        }

        // Google Drive, Google Docs, Slides, dan Sheets diprioritaskan
        // agar tautan berbagi diarahkan ke endpoint preview yang benar.
        if (cloudUrl) {
            mediaFrame.src = cloudUrl;
            mediaFrame.classList.remove('hidden');
            mediaLabel.textContent = 'GOOGLE WORKSPACE';
            return;
        }

        // PDF.
        if (kind === 'pdf' || ext === 'pdf') {
            mediaFrame.src = url;
            mediaFrame.classList.remove('hidden');
            mediaLabel.textContent = 'DOKUMEN PDF';
            return;
        }

        // PowerPoint: Office Viewer hanya dapat membaca file yang dapat diakses publik.
        if (kind === 'ppt' || ['ppt', 'pptx'].includes(ext)) {
            if (urlLokal(url)) {
                tampilkanPemberitahuan(
                    'Preview PowerPoint memerlukan URL publik',
                    'File PowerPoint ini masih berada di alamat lokal aplikasi. Office Viewer tidak dapat mengambil file dari localhost. Buka atau unduh file, atau unggah versi PDF agar dapat dipreview langsung.',
                    url
                );
            } else {
                mediaFrame.src = officeViewerUrl(url);
                mediaFrame.classList.remove('hidden');
                mediaLabel.textContent = 'PRESENTASI POWERPOINT';
            }
            return;
        }

        // Video.
        if (kind === 'video' || ['mp4', 'm4v', 'webm', 'mov', 'ogv', 'ogg'].includes(ext)) {
            if (['mp4', 'm4v', 'webm', 'mov', 'ogv', 'ogg'].includes(ext)) {
                mediaVideo.src = url;
                mediaVideo.classList.remove('hidden');
                mediaLabel.textContent = 'VIDEO PEMBELAJARAN';
            } else {
                mediaFrame.src = url;
                mediaFrame.classList.remove('hidden');
                mediaLabel.textContent = 'VIDEO / TAUTAN EKSTERNAL';
            }
            return;
        }

        // Gambar dan animasi.
        if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'].includes(ext)) {
            mediaImage.src = url;
            mediaImage.classList.remove('hidden');
            mediaLabel.textContent = 'GAMBAR / ANIMASI';
            return;
        }

        // Audio.
        if (['mp3', 'wav', 'm4a', 'aac', 'flac'].includes(ext)) {
            mediaAudio.src = url;
            mediaAudio.classList.remove('hidden');
            mediaLabel.textContent = 'AUDIO PEMBELAJARAN';
            return;
        }

        // Arsip ZIP tidak dapat dimainkan di browser.
        if (kind === 'game' || ext === 'zip') {
            tampilkanPemberitahuan(
                'File paket / game',
                'File ZIP tidak dapat dijalankan langsung di dalam preview browser. Buka atau unduh file untuk melihat isi paketnya.',
                url
            );
            return;
        }

        // Tautan non-YouTube lainnya: coba tampilkan di iframe.
        // Situs yang melarang iframe tetap dapat dibuka melalui tombol Buka Tab Baru.
        mediaFrame.src = url;
        mediaFrame.classList.remove('hidden');
        mediaLabel.textContent = 'TAUTAN EKSTERNAL';
    }

    document.querySelectorAll('.preview-media').forEach(function (button) {
        button.addEventListener('click', function () {
            bukaPreviewMedia(this);
        });
    });

    function tutupPreviewMedia() {
        sembunyikanSemuaPreview();
        mediaModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    if (closeMediaPreview) {
        closeMediaPreview.addEventListener('click', tutupPreviewMedia);
    }

    if (mediaModal) {
        mediaModal.addEventListener('click', function (event) {
            if (event.target === mediaModal) tutupPreviewMedia();
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && mediaModal && !mediaModal.classList.contains('hidden')) {
            tutupPreviewMedia();
        }
    });

    /* --------------------------------------------------------------------------
       ARAHKAN PELAJAR KE KONTEN MATERI SETELAH MEMILIH TOPIK
    -------------------------------------------------------------------------- */
    const queryHalaman = new URLSearchParams(window.location.search);
    const detailMateri = document.getElementById('materiDetail');

    if (queryHalaman.has('materi') && detailMateri) {
        window.setTimeout(function () {
            detailMateri.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 250);
    }

});



</script>



@endpush



@endsection
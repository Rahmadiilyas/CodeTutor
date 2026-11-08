@extends('layouts.master')
//perbaikan bug
@section('title', 'Latihan Soal — CodeTutor')

@section('description', 'Latihan soal pemrograman CodeTutor.')

@section('page_label', 'Latihan')

@section('page_heading', 'Latihan Soal')


@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <section class="overflow-hidden rounded-3xl border border-maroon-900/8 bg-white shadow-soft">

        <div class="p-6 sm:p-8">

            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                {{-- LEFT --}}

                <div class="flex items-start gap-4">

                    <div
                        id="languageIcon"
                        class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-maroon-900 p-3"
                    >
                        <img
                            id="languageLogo"
                            src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/java/java-original.svg"
                            alt="Logo Java"
                            class="h-11 w-11 object-contain"
                        >
                    </div>

                    <div>

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="rounded-full bg-maroon-900/5 px-3 py-1 text-[9px] font-extrabold uppercase tracking-[.15em] text-maroon-700">
                                Evaluasi Pembelajaran
                            </span>

                            <span class="rounded-full bg-gold-400/10 px-3 py-1 text-[9px] font-extrabold text-gold-700">
                                Practice
                            </span>

                        </div>

                        <h1
                            id="languageTitle"
                            class="mt-3 font-display text-3xl font-extrabold text-maroon-950 sm:text-4xl"
                        >
                            Latihan Soal Java
                        </h1>

                        <p
                            id="languageDescription"
                            class="mt-2 max-w-2xl text-sm leading-6 text-slate-500"
                        >
                            Uji pemahamanmu melalui berbagai soal Java dari tingkat dasar hingga menengah.
                        </p>

                    </div>

                </div>


                {{-- SCORE --}}

                <div class="w-full rounded-2xl bg-warm-100 p-5 sm:max-w-xs">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-[9px] font-extrabold uppercase tracking-[.14em] text-slate-400">
                                Nilai Terakhir
                            </p>

                            <p
                                id="lastScore"
                                class="mt-1 font-display text-2xl font-extrabold text-maroon-950"
                            >
                                -
                            </p>

                        </div>

                        <div class="grid h-11 w-11 place-items-center rounded-xl bg-gold-400 text-maroon-950">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M12 3l2.7 5.5 6.3.9-4.5 4.4 1.1 6.2L12 17l-5.6 3 1.1-6.2L12 3z"/>
                            </svg>

                        </div>

                    </div>

                    <p class="mt-3 text-[10px] leading-5 text-slate-400">
                        Nilai akan diperbarui setelah kamu menyelesaikan latihan.
                    </p>

                </div>

            </div>


            {{-- SELECTOR --}}

            <div class="mt-7 border-t border-maroon-900/8 pt-6">

                <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

                    {{-- LANGUAGE --}}

                    <div class="w-full lg:max-w-xs">

                        <label
                            for="languageSelect"
                            class="mb-2 block text-[9px] font-extrabold uppercase tracking-[.15em] text-maroon-700"
                        >
                            Bahasa Pemrograman
                        </label>

                        <div class="relative">

                            <select
                                id="languageSelect"
                                class="w-full appearance-none rounded-2xl border border-maroon-900/10 bg-white px-4 py-3 pr-11 text-xs font-extrabold text-maroon-950 outline-none transition focus:border-gold-400 focus:ring-4 focus:ring-gold-400/10"
                            >

                                <option value="java">Java</option>

                                <option value="python">Python</option>

                                <option value="javascript">JavaScript</option>

                                <option value="php">PHP</option>

                                <option value="cpp">C++</option>

                                <option value="dart">Dart</option>

                            </select>

                            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-maroon-800">

                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>

                            </div>

                        </div>

                    </div>


                    {{-- CATEGORY --}}

                    <div class="w-full lg:max-w-xs">

                        <label
                            for="categorySelect"
                            class="mb-2 block text-[9px] font-extrabold uppercase tracking-[.15em] text-maroon-700"
                        >
                            Kategori Latihan
                        </label>

                        <div class="relative">

                            <select
                                id="categorySelect"
                                class="w-full appearance-none rounded-2xl border border-maroon-900/10 bg-white px-4 py-3 pr-11 text-xs font-extrabold text-maroon-950 outline-none transition focus:border-gold-400 focus:ring-4 focus:ring-gold-400/10"
                            >

                                <option value="dasar">
                                    Dasar Pemrograman
                                </option>

                                <option value="menengah">
                                    Tingkat Menengah
                                </option>

                                <option value="oop">
                                    Object Oriented Programming
                                </option>

                            </select>

                            <div class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-maroon-800">

                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>

                            </div>

                        </div>

                    </div>


                    {{-- INFO --}}

                    <div class="flex flex-wrap gap-2">

                        <span class="inline-flex items-center gap-2 rounded-xl bg-maroon-900/5 px-3 py-3 text-[10px] font-bold text-maroon-800">

                            <span class="h-2 w-2 rounded-full bg-gold-400"></span>

                            10 Soal

                        </span>

                        <span class="inline-flex items-center gap-2 rounded-xl bg-maroon-900/5 px-3 py-3 text-[10px] font-bold text-maroon-800">

                            <span class="h-2 w-2 rounded-full bg-maroon-700"></span>

                            15 Menit

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <div class="grid gap-6 lg:grid-cols-[250px_minmax(0,1fr)]">


        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}

        <aside>

            <div class="sticky top-24 rounded-3xl border border-maroon-900/8 bg-white shadow-soft">


                {{-- TIMER --}}

                <div
                    id="timerCard"
                    class="hidden border-b border-maroon-900/8 p-5"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-[9px] font-extrabold uppercase tracking-[.15em] text-slate-400">
                                Waktu Tersisa
                            </p>

                            <p
                                id="timerText"
                                class="mt-1 font-mono text-2xl font-black tracking-wider text-maroon-900"
                            >
                                15:00
                            </p>

                        </div>

                        <div
                            id="timerIcon"
                            class="grid h-11 w-11 place-items-center rounded-xl bg-maroon-900/5 text-maroon-800"
                        >

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                            </svg>

                        </div>

                    </div>

                    <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-maroon-900/10">

                        <div
                            id="timerProgress"
                            class="h-full w-full rounded-full bg-gold-400 transition-all duration-1000"
                        ></div>

                    </div>

                </div>



                {{-- NAVIGATION --}}

                <div class="border-b border-maroon-900/8 p-5">

                    <p class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700">
                        Daftar Soal
                    </p>

                    <h2 class="mt-1 font-display text-lg font-extrabold text-maroon-950">
                        Navigasi
                    </h2>

                    <p class="mt-1 text-[10px] leading-5 text-slate-400">
                        Pilih nomor soal untuk berpindah.
                    </p>

                </div>


                {{-- PROGRESS --}}

                <div class="p-5">

                    <div class="mb-2 flex items-center justify-between">

                        <span class="text-[9px] font-bold text-slate-400">
                            Progress
                        </span>

                        <span
                            id="progressText"
                            class="text-[9px] font-extrabold text-maroon-800"
                        >
                            0 / 10
                        </span>

                    </div>

                    <div class="h-2 overflow-hidden rounded-full bg-maroon-900/10">

                        <div
                            id="progressBar"
                            class="h-full w-0 rounded-full bg-gradient-to-r from-maroon-800 to-gold-500 transition-all duration-300"
                        ></div>

                    </div>

                </div>


                {{-- NUMBER --}}

                <div
                    id="questionNumbers"
                    class="grid grid-cols-5 gap-2 border-t border-maroon-900/8 p-5"
                >

                    @for ($i = 1; $i <= 10; $i++)

                        <button
                            type="button"
                            data-number="{{ $i }}"
                            class="question-number grid aspect-square place-items-center rounded-xl border border-maroon-900/10 text-[10px] font-extrabold text-maroon-800 transition hover:border-gold-400 hover:bg-gold-400/10"
                        >
                            {{ $i }}
                        </button>

                    @endfor

                </div>


                {{-- LEGEND --}}

                <div class="border-t border-maroon-900/8 p-5">

                    <div class="space-y-2">

                        <div class="flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded bg-maroon-900"></span>

                            <span class="text-[9px] text-slate-400">
                                Soal aktif
                            </span>

                        </div>

                        <div class="flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded bg-gold-400"></span>

                            <span class="text-[9px] text-slate-400">
                                Sudah dijawab
                            </span>

                        </div>

                        <div class="flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded border border-maroon-900/10 bg-white"></span>

                            <span class="text-[9px] text-slate-400">
                                Belum dijawab
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </aside>



        {{-- =====================================================
             CONTENT
        ====================================================== --}}

        <main class="min-w-0">


            {{-- =================================================
                 START SCREEN
            ================================================== --}}

            <section
                id="startScreen"
                class="overflow-hidden rounded-3xl border border-maroon-900/8 bg-white shadow-soft"
            >

                <div class="relative overflow-hidden bg-maroon-900 p-8 text-white sm:p-12">

                    {{-- DECORATION --}}

                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full border-[40px] border-gold-400/10"></div>

                    <div class="absolute -bottom-32 -left-20 h-72 w-72 rounded-full border-[45px] border-white/5"></div>


                    <div class="relative max-w-2xl">

                        <span class="inline-flex items-center gap-2 rounded-full bg-gold-400/15 px-4 py-2 text-[9px] font-extrabold uppercase tracking-[.15em] text-gold-300">

                            <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>

                            Siap untuk tantangan?

                        </span>


                        <h2
                            id="startTitle"
                            class="mt-5 font-display text-3xl font-extrabold leading-tight sm:text-5xl"
                        >
                            Latihan Soal Java
                        </h2>


                        <p class="mt-4 max-w-xl text-sm leading-7 text-white/60">

                            Uji kemampuanmu dengan menjawab 10 soal
                            pemrograman. Waktu pengerjaan akan dimulai
                            setelah kamu menekan tombol mulai.

                        </p>


                        {{-- STATISTICS --}}

                        <div class="mt-8 grid grid-cols-3 gap-3 sm:max-w-lg">

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">

                                <p class="text-2xl font-black text-gold-400">
                                    10
                                </p>

                                <p class="mt-1 text-[9px] font-bold text-white/40">
                                    SOAL
                                </p>

                            </div>


                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">

                                <p class="text-2xl font-black text-gold-400">
                                    15
                                </p>

                                <p class="mt-1 text-[9px] font-bold text-white/40">
                                    MENIT
                                </p>

                            </div>


                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">

                                <p class="text-2xl font-black text-gold-400">
                                    100
                                </p>

                                <p class="mt-1 text-[9px] font-bold text-white/40">
                                    NILAI MAKS
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- RULES --}}

                <div class="p-6 sm:p-8">

                    <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">

                        <div>

                            <p class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700">
                                Sebelum memulai
                            </p>

                            <h3 class="mt-2 font-display text-xl font-extrabold text-maroon-950">
                                Pastikan kamu sudah siap
                            </h3>


                            <div class="mt-5 grid gap-3 sm:grid-cols-2">


                                <div class="flex items-start gap-3 rounded-2xl bg-warm-100 p-4">

                                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-gold-400 text-maroon-950">

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M12 7v5l3 2"/>
                                        </svg>

                                    </span>

                                    <div>

                                        <p class="text-xs font-extrabold text-maroon-950">
                                            Waktu terbatas
                                        </p>

                                        <p class="mt-1 text-[10px] leading-5 text-slate-400">
                                            Kamu memiliki waktu 15 menit untuk menyelesaikan seluruh soal.
                                        </p>

                                    </div>

                                </div>


                                <div class="flex items-start gap-3 rounded-2xl bg-warm-100 p-4">

                                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-maroon-900 text-gold-400">

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M5 12l4 4L19 6"/>
                                        </svg>

                                    </span>

                                    <div>

                                        <p class="text-xs font-extrabold text-maroon-950">
                                            Pilih jawaban
                                        </p>

                                        <p class="mt-1 text-[10px] leading-5 text-slate-400">
                                            Kamu dapat berpindah soal kapan saja selama waktu tersedia.
                                        </p>

                                    </div>

                                </div>


                                <div class="flex items-start gap-3 rounded-2xl bg-warm-100 p-4">

                                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-maroon-900 text-gold-400">

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M12 3v18"/>
                                            <path d="M3 12h18"/>
                                        </svg>

                                    </span>

                                    <div>

                                        <p class="text-xs font-extrabold text-maroon-950">
                                            Nilai otomatis
                                        </p>

                                        <p class="mt-1 text-[10px] leading-5 text-slate-400">
                                            Nilai dihitung setelah latihan selesai.
                                        </p>

                                    </div>

                                </div>


                                <div class="flex items-start gap-3 rounded-2xl bg-warm-100 p-4">

                                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-gold-400 text-maroon-950">

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M12 2v20"/>
                                            <path d="m17 5-5-3-5 3"/>
                                            <path d="m17 19-5 3-5-3"/>
                                        </svg>

                                    </span>

                                    <div>

                                        <p class="text-xs font-extrabold text-maroon-950">
                                            Fokus
                                        </p>

                                        <p class="mt-1 text-[10px] leading-5 text-slate-400">
                                            Setelah dimulai, gunakan waktu sebaik mungkin.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- START BUTTON --}}

                        <div class="lg:min-w-[200px]">

                            <button
                                type="button"
                                id="startButton"
                                class="group inline-flex w-full items-center justify-center gap-3 rounded-2xl bg-maroon-900 px-6 py-4 text-xs font-extrabold text-white shadow-lg shadow-maroon-900/15 transition hover:-translate-y-1 hover:bg-maroon-800"
                            >

                                <span class="grid h-8 w-8 place-items-center rounded-xl bg-gold-400 text-maroon-950">

                                    <svg
                                        class="ml-0.5 h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>

                                </span>

                                Mulai Latihan

                                <svg
                                    class="h-4 w-4 transition group-hover:translate-x-1"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M5 12h14"/>
                                    <path d="m13 6 6 6-6 6"/>
                                </svg>

                            </button>

                            <p class="mt-3 text-center text-[9px] text-slate-400">
                                Timer dimulai setelah tombol ditekan
                            </p>

                        </div>

                    </div>

                </div>

            </section>



            {{-- =================================================
                 QUIZ
            ================================================== --}}

            <section
                id="quizSection"
                class="hidden overflow-hidden rounded-3xl border border-maroon-900/8 bg-white shadow-soft"
            >

                {{-- QUESTION HEADER --}}

                <div class="border-b border-maroon-900/8 p-6 sm:p-8">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <span class="text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700">
                                Pertanyaan
                            </span>

                            <div class="mt-2 flex items-center gap-3">

                                <span
                                    id="questionCounter"
                                    class="grid h-9 w-9 place-items-center rounded-xl bg-maroon-900 text-[10px] font-extrabold text-gold-400"
                                >
                                    01
                                </span>

                                <h2
                                    id="questionTitle"
                                    class="font-display text-xl font-extrabold text-maroon-950 sm:text-2xl"
                                >
                                    Dasar Java
                                </h2>

                            </div>

                        </div>


                        <span
                            id="difficultyBadge"
                            class="inline-flex w-fit rounded-full bg-gold-400/10 px-3 py-1.5 text-[9px] font-extrabold text-gold-700"
                        >
                            Beginner
                        </span>

                    </div>

                </div>


                {{-- QUESTION BODY --}}

                <div class="p-6 sm:p-8">

                    <div class="rounded-2xl bg-warm-100 p-5 sm:p-6">

                        <p
                            id="questionText"
                            class="text-sm font-bold leading-7 text-maroon-950 sm:text-base"
                        >
                        </p>

                    </div>


                    {{-- ANSWER --}}

                    <div
                        id="answerContainer"
                        class="mt-6 space-y-3"
                    >
                    </div>


                    {{-- NAVIGATION --}}

                    <div class="mt-8 flex flex-col-reverse gap-3 border-t border-maroon-900/8 pt-6 sm:flex-row sm:items-center sm:justify-between">

                        <button
                            type="button"
                            id="previousButton"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-maroon-900/10 px-5 py-3 text-xs font-extrabold text-maroon-800 transition hover:border-gold-400 hover:bg-gold-400/10 disabled:cursor-not-allowed disabled:opacity-40"
                            disabled
                        >

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="M19 12H5"/>
                                <path d="m12 19-7-7 7-7"/>
                            </svg>

                            Sebelumnya

                        </button>


                        <div class="flex gap-2">

                            <button
                                type="button"
                                id="finishButton"
                                class="hidden rounded-xl border border-maroon-900/10 px-5 py-3 text-xs font-extrabold text-maroon-800 transition hover:border-gold-400 hover:bg-gold-400/10"
                            >
                                Selesaikan
                            </button>


                            <button
                                type="button"
                                id="nextButton"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-6 py-3 text-xs font-extrabold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-maroon-700"
                            >

                                Soal Berikutnya

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

                            </button>

                        </div>

                    </div>

                </div>

            </section>



            {{-- TIPS --}}

            <section class="mt-6 rounded-3xl bg-maroon-900 p-6 text-white sm:p-8">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-[9px] font-extrabold uppercase tracking-[.16em] text-gold-400">
                            Tips Belajar
                        </p>

                        <h2 class="mt-2 font-display text-xl font-extrabold">
                            Pahami konsep, bukan hanya jawaban
                        </h2>

                        <p class="mt-2 max-w-2xl text-xs leading-6 text-white/55">
                            Gunakan latihan sebagai cara untuk mengetahui
                            bagian materi yang masih perlu kamu pelajari.
                        </p>

                    </div>

                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-gold-400 text-maroon-950">

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M9 18h6"/>
                            <path d="M10 22h4"/>
                            <path d="M8.5 14.5a6 6 0 1 1 7 0c-.8.6-1.5 1.4-1.5 2.5h-5c0-1.1-.7-1.9-1.5-2.5z"/>
                        </svg>

                    </div>

                </div>

            </section>

        </main>

    </div>

</div>



{{-- =============================================================
     CONFIRM MODAL
============================================================== --}}

<div
    id="confirmModal"
    class="fixed inset-0 z-[300] hidden bg-maroon-950/70 p-4 backdrop-blur-sm"
>

    <div class="flex min-h-full items-center justify-center">

        <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl sm:p-8">

            <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-gold-400 text-maroon-950">

                <svg
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 8v4"/>
                    <path d="M12 16h.01"/>
                </svg>

            </div>

            <div class="mt-5 text-center">

                <h2 class="font-display text-2xl font-extrabold text-maroon-950">
                    Selesaikan latihan?
                </h2>

                <p
                    id="confirmMessage"
                    class="mt-2 text-xs leading-6 text-slate-400"
                >
                    Pastikan semua jawaban sudah diperiksa.
                </p>

            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">

                <button
                    type="button"
                    id="cancelFinish"
                    class="rounded-xl border border-maroon-900/10 px-4 py-3 text-xs font-extrabold text-maroon-800 transition hover:bg-warm-100"
                >
                    Kembali
                </button>

                <button
                    type="button"
                    id="confirmFinish"
                    class="rounded-xl bg-maroon-900 px-4 py-3 text-xs font-extrabold text-white transition hover:bg-maroon-800"
                >
                    Ya, Selesaikan
                </button>

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
     TIME UP
============================================================== --}}

<div
    id="timeUpModal"
    class="fixed inset-0 z-[400] hidden bg-maroon-950/80 p-4 backdrop-blur-sm"
>

    <div class="flex min-h-full items-center justify-center">

        <div class="w-full max-w-md rounded-3xl bg-white p-7 text-center shadow-2xl sm:p-9">

            <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-maroon-900 text-gold-400">

                <svg
                    class="h-7 w-7"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>

            </div>

            <h2 class="mt-5 font-display text-2xl font-extrabold text-maroon-950">
                Waktu Habis
            </h2>

            <p class="mt-2 text-xs leading-6 text-slate-400">
                Waktu pengerjaan telah berakhir.
                Jawaban yang sudah kamu pilih akan dinilai otomatis.
            </p>

            <button
                type="button"
                id="timeUpButton"
                class="mt-6 w-full rounded-xl bg-maroon-900 px-5 py-3 text-xs font-extrabold text-white transition hover:bg-maroon-800"
            >
                Lihat Hasil
            </button>

        </div>

    </div>

</div>



{{-- =============================================================
     RESULT
============================================================== --}}

<div
    id="resultModal"
    class="fixed inset-0 z-[500] hidden bg-maroon-950/80 p-4 backdrop-blur-sm"
>

    <div class="flex min-h-full items-center justify-center">

        <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl sm:p-8">

            <div class="text-center">

                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-gold-400 text-maroon-950">

                    <svg
                        class="h-7 w-7"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M12 3l2.7 5.5 6.3.9-4.5 4.4 1.1 6.2L12 17l-5.6 3 1.1-6.2L12 3z"/>
                    </svg>

                </div>

                <p class="mt-5 text-[9px] font-extrabold uppercase tracking-[.16em] text-maroon-700">
                    Latihan Selesai
                </p>

                <h2 class="mt-2 font-display text-3xl font-extrabold text-maroon-950">
                    Hasil Latihan
                </h2>

                <p class="mt-2 text-xs leading-6 text-slate-400">
                    Berikut hasil latihan yang telah kamu kerjakan.
                </p>


                <div class="mt-6 grid grid-cols-3 gap-3">

                    <div class="rounded-2xl bg-warm-100 p-4">

                        <p class="text-[9px] font-extrabold uppercase text-slate-400">
                            Nilai
                        </p>

                        <p
                            id="resultScore"
                            class="mt-1 font-display text-3xl font-black text-maroon-900"
                        >
                            0
                        </p>

                    </div>


                    <div class="rounded-2xl bg-warm-100 p-4">

                        <p class="text-[9px] font-extrabold uppercase text-slate-400">
                            Benar
                        </p>

                        <p
                            id="resultCorrect"
                            class="mt-1 font-display text-3xl font-black text-maroon-900"
                        >
                            0
                        </p>

                    </div>


                    <div class="rounded-2xl bg-warm-100 p-4">

                        <p class="text-[9px] font-extrabold uppercase text-slate-400">
                            Total
                        </p>

                        <p
                            id="resultTotal"
                            class="mt-1 font-display text-3xl font-black text-maroon-900"
                        >
                            10
                        </p>

                    </div>

                </div>


                <button
                    type="button"
                    id="restartButton"
                    class="mt-6 w-full rounded-xl bg-maroon-900 px-5 py-3 text-xs font-extrabold text-white transition hover:bg-maroon-800"
                >
                    Ulangi Latihan
                </button>

            </div>

        </div>

    </div>

</div>



{{-- =============================================================
     JAVASCRIPT
     SENGAJA LANGSUNG DI SINI, TIDAK MENGGUNAKAN @PUSH
============================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DATA SOAL
    |--------------------------------------------------------------------------
    */

    const questionData = {

        java: [

            {
                title: 'Dasar Java',
                question: 'Manakah struktur method utama yang benar untuk menjalankan program Java?',
                options: {
                    A: 'public void main()',
                    B: 'public static void main(String[] args)',
                    C: 'static main(String args)',
                    D: 'main.public.static()'
                },
                answer: 'B',
                difficulty: 'Beginner'
            },

            {
                title: 'Variabel Java',
                question: 'Manakah deklarasi variabel integer yang benar pada Java?',
                options: {
                    A: 'integer umur = 20;',
                    B: 'int umur = 20;',
                    C: 'number umur = 20;',
                    D: 'IntegerType umur = 20;'
                },
                answer: 'B',
                difficulty: 'Beginner'
            },

            {
                title: 'Tipe Data Java',
                question: 'Tipe data apa yang digunakan untuk menyimpan nilai true atau false?',
                options: {
                    A: 'boolean',
                    B: 'bool',
                    C: 'logical',
                    D: 'bit'
                },
                answer: 'A',
                difficulty: 'Beginner'
            },

            {
                title: 'Operator Java',
                question: 'Apa hasil dari operasi 10 % 3 pada Java?',
                options: {
                    A: '1',
                    B: '2',
                    C: '3',
                    D: '0'
                },
                answer: 'A',
                difficulty: 'Beginner'
            },

            {
                title: 'Percabangan Java',
                question: 'Keyword apa yang digunakan untuk membuat percabangan pada Java?',
                options: {
                    A: 'check',
                    B: 'condition',
                    C: 'if',
                    D: 'when'
                },
                answer: 'C',
                difficulty: 'Beginner'
            },

            {
                title: 'Perulangan Java',
                question: 'Manakah perulangan yang cocok digunakan ketika jumlah iterasi sudah diketahui?',
                options: {
                    A: 'for',
                    B: 'switch',
                    C: 'if',
                    D: 'try'
                },
                answer: 'A',
                difficulty: 'Beginner'
            },

            {
                title: 'Method Java',
                question: 'Apa fungsi return pada sebuah method Java?',
                options: {
                    A: 'Menghentikan komputer',
                    B: 'Mengembalikan nilai dari method',
                    C: 'Membuat class',
                    D: 'Membuat perulangan'
                },
                answer: 'B',
                difficulty: 'Beginner'
            },

            {
                title: 'Class Java',
                question: 'Keyword apa yang digunakan untuk membuat sebuah class pada Java?',
                options: {
                    A: 'object',
                    B: 'class',
                    C: 'struct',
                    D: 'newclass'
                },
                answer: 'B',
                difficulty: 'Beginner'
            },

            {
                title: 'Object Java',
                question: 'Keyword apa yang biasanya digunakan untuk membuat object baru dari sebuah class?',
                options: {
                    A: 'create',
                    B: 'object',
                    C: 'new',
                    D: 'instance'
                },
                answer: 'C',
                difficulty: 'Beginner'
            },

            {
                title: 'OOP Java',
                question: 'Konsep OOP yang memungkinkan sebuah class mewarisi sifat dari class lain disebut...',
                options: {
                    A: 'Inheritance',
                    B: 'Iteration',
                    C: 'Compilation',
                    D: 'Casting'
                },
                answer: 'A',
                difficulty: 'Intermediate'
            }

        ],


        python: [

            {
                title: 'Dasar Python',
                question: 'Manakah perintah yang benar untuk menampilkan teks pada Python?',
                options: {
                    A: 'echo("Hello")',
                    B: 'print("Hello")',
                    C: 'printf("Hello")',
                    D: 'display("Hello")'
                },
                answer: 'B',
                difficulty: 'Beginner'
            },

            {
                title: 'Variabel Python',
                question: 'Manakah deklarasi variabel yang benar pada Python?',
                options: {
                    A: 'int umur = 20',
                    B: 'var umur = 20',
                    C: 'umur = 20',
                    D: 'integer umur = 20'
                },
                answer: 'C',
                difficulty: 'Beginner'
            },

            {
                title: 'Tipe Data Python',
                question: 'Tipe data untuk menyimpan nilai True atau False pada Python adalah...',
                options: {
                    A: 'boolean',
                    B: 'bool',
                    C: 'logical',
                    D: 'bit'
                },
                answer: 'B',
                difficulty: 'Beginner'
            },

            {
                title: 'Operator Python',
                question: 'Apa hasil dari 10 % 3 pada Python?',
                options: {
                    A: '0',
                    B: '1',
                    C: '2',
                    D: '3'
                },
                answer: 'B',
                difficulty: 'Beginner'
            },

            {
                title: 'Percabangan Python',
                question: 'Keyword yang digunakan untuk membuat kondisi pada Python adalah...',
                options: {
                    A: 'if',
                    B: 'when',
                    C: 'condition',
                    D: 'check'
                },
                answer: 'A',
                difficulty: 'Beginner'
            },

            {
                title: 'Perulangan Python',
                question: 'Keyword yang digunakan untuk membuat perulangan pada Python adalah...',
                options: {
                    A: 'loop',
                    B: 'repeat',
                    C: 'for',
                    D: 'iterate'
                },
                answer: 'C',
                difficulty: 'Beginner'
            },

            {
                title: 'List Python',
                question: 'Manakah contoh list yang benar pada Python?',
                options: {
                    A: '{1, 2, 3}',
                    B: '(1, 2, 3)',
                    C: '[1, 2, 3]',
                    D: '<1, 2, 3>'
                },
                answer: 'C',
                difficulty: 'Beginner'
            },

            {
                title: 'Function Python',
                question: 'Keyword yang digunakan untuk mendefinisikan function pada Python adalah...',
                options: {
                    A: 'function',
                    B: 'def',
                    C: 'func',
                    D: 'method'
                },
                answer: 'B',
                difficulty: 'Beginner'
            },

            {
                title: 'Dictionary Python',
                question: 'Struktur data Python yang menyimpan data dalam pasangan key dan value disebut...',
                options: {
                    A: 'List',
                    B: 'Tuple',
                    C: 'Dictionary',
                    D: 'Array'
                },
                answer: 'C',
                difficulty: 'Intermediate'
            },

            {
                title: 'OOP Python',
                question: 'Keyword yang digunakan untuk mendefinisikan class pada Python adalah...',
                options: {
                    A: 'object',
                    B: 'class',
                    C: 'struct',
                    D: 'define'
                },
                answer: 'B',
                difficulty: 'Intermediate'
            }

        ]

    };


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const languageSelect =
        document.getElementById('languageSelect');

    const categorySelect =
        document.getElementById('categorySelect');

    const languageIcon =
        document.getElementById('languageIcon');

    const languageLogo =
        document.getElementById('languageLogo');

    const languageTitle =
        document.getElementById('languageTitle');

    const languageDescription =
        document.getElementById('languageDescription');

    const startTitle =
        document.getElementById('startTitle');

    const startScreen =
        document.getElementById('startScreen');

    const quizSection =
        document.getElementById('quizSection');

    const startButton =
        document.getElementById('startButton');

    const timerCard =
        document.getElementById('timerCard');

    const timerText =
        document.getElementById('timerText');

    const timerProgress =
        document.getElementById('timerProgress');

    const timerIcon =
        document.getElementById('timerIcon');

    const questionTitle =
        document.getElementById('questionTitle');

    const questionText =
        document.getElementById('questionText');

    const questionCounter =
        document.getElementById('questionCounter');

    const difficultyBadge =
        document.getElementById('difficultyBadge');

    const answerContainer =
        document.getElementById('answerContainer');

    const progressText =
        document.getElementById('progressText');

    const progressBar =
        document.getElementById('progressBar');

    const previousButton =
        document.getElementById('previousButton');

    const nextButton =
        document.getElementById('nextButton');

    const finishButton =
        document.getElementById('finishButton');

    const lastScore =
        document.getElementById('lastScore');

    const confirmModal =
        document.getElementById('confirmModal');

    const confirmMessage =
        document.getElementById('confirmMessage');

    const cancelFinish =
        document.getElementById('cancelFinish');

    const confirmFinish =
        document.getElementById('confirmFinish');

    const timeUpModal =
        document.getElementById('timeUpModal');

    const timeUpButton =
        document.getElementById('timeUpButton');

    const resultModal =
        document.getElementById('resultModal');

    const resultScore =
        document.getElementById('resultScore');

    const resultCorrect =
        document.getElementById('resultCorrect');

    const resultTotal =
        document.getElementById('resultTotal');

    const restartButton =
        document.getElementById('restartButton');


    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let currentLanguage = 'java';

    let currentQuestion = 0;

    let answers = {};

    let quizStarted = false;

    let quizFinished = false;

    let timerInterval = null;

    const TOTAL_TIME = 15 * 60;

    let remainingTime = TOTAL_TIME;


    /*
    |--------------------------------------------------------------------------
    | GET QUESTIONS
    |--------------------------------------------------------------------------
    */

    function getQuestions() {

        return questionData[currentLanguage] || [];

    }


    /*
    |--------------------------------------------------------------------------
    | START BUTTON
    |--------------------------------------------------------------------------
    */

    startButton.addEventListener('click', function () {

        console.log('Tombol Mulai Latihan diklik');

        startQuiz();

    });


    /*
    |--------------------------------------------------------------------------
    | START QUIZ
    |--------------------------------------------------------------------------
    */

    function startQuiz() {

        const questions = getQuestions();


        if (!questions.length) {

            alert('Soal untuk bahasa ini belum tersedia.');

            return;

        }


        quizStarted = true;

        quizFinished = false;

        currentQuestion = 0;

        answers = {};

        remainingTime = TOTAL_TIME;


        /*
        | Sembunyikan halaman awal
        */

        startScreen.classList.add('hidden');


        /*
        | Tampilkan halaman soal
        */

        quizSection.classList.remove('hidden');


        /*
        | Tampilkan timer
        */

        timerCard.classList.remove('hidden');


        /*
        | Render soal pertama
        */

        renderQuestion();


        /*
        | Mulai timer
        */

        startTimer();


        /*
        | Update progress
        */

        updateProgress();


        /*
        | Scroll ke bagian soal
        */

        setTimeout(function () {

            quizSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        }, 100);

    }


    /*
    |--------------------------------------------------------------------------
    | TIMER
    |--------------------------------------------------------------------------
    */

    function startTimer() {

        stopTimer();

        updateTimer();


        timerInterval = setInterval(function () {

            if (!quizStarted || quizFinished) {

                return;

            }


            remainingTime--;

            updateTimer();


            if (remainingTime <= 0) {

                remainingTime = 0;

                stopTimer();

                handleTimeUp();

            }

        }, 1000);

    }


    function stopTimer() {

        if (timerInterval !== null) {

            clearInterval(timerInterval);

            timerInterval = null;

        }

    }


    function updateTimer() {

        const minutes =
            Math.floor(remainingTime / 60);

        const seconds =
            remainingTime % 60;


        timerText.textContent =
            String(minutes).padStart(2, '0')
            + ':'
            + String(seconds).padStart(2, '0');


        const percentage =
            (remainingTime / TOTAL_TIME) * 100;


        timerProgress.style.width =
            percentage + '%';


        /*
        | Reset warna
        */

        timerText.classList.remove(
            'text-maroon-900',
            'text-orange-600',
            'text-red-600',
            'animate-pulse'
        );


        timerProgress.classList.remove(
            'bg-gold-400',
            'bg-orange-500',
            'bg-red-500'
        );


        timerIcon.classList.remove(
            'bg-maroon-900/5',
            'bg-orange-100',
            'bg-red-100',
            'text-maroon-800',
            'text-orange-600',
            'text-red-600'
        );


        /*
        | 1 menit terakhir
        */

        if (remainingTime <= 60) {

            timerText.classList.add(
                'text-red-600',
                'animate-pulse'
            );

            timerProgress.classList.add(
                'bg-red-500'
            );

            timerIcon.classList.add(
                'bg-red-100',
                'text-red-600'
            );

        }

        /*
        | 3 menit terakhir
        */

        else if (remainingTime <= 180) {

            timerText.classList.add(
                'text-orange-600'
            );

            timerProgress.classList.add(
                'bg-orange-500'
            );

            timerIcon.classList.add(
                'bg-orange-100',
                'text-orange-600'
            );

        }

        /*
        | Normal
        */

        else {

            timerText.classList.add(
                'text-maroon-900'
            );

            timerProgress.classList.add(
                'bg-gold-400'
            );

            timerIcon.classList.add(
                'bg-maroon-900/5',
                'text-maroon-800'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | TIME UP
    |--------------------------------------------------------------------------
    */

    function handleTimeUp() {

        quizFinished = true;

        timeUpModal.classList.remove('hidden');

        document.body.classList.add('overflow-hidden');

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER QUESTION
    |--------------------------------------------------------------------------
    */

    function renderQuestion() {

        const questions = getQuestions();


        if (!questions.length) {

            return;

        }


        const question =
            questions[currentQuestion];


        questionTitle.textContent =
            question.title;


        questionText.textContent =
            question.question;


        questionCounter.textContent =
            String(currentQuestion + 1).padStart(2, '0');


        difficultyBadge.textContent =
            question.difficulty;


        renderAnswers(question);

        updateProgress();

        updateNavigation();

    }


    /*
    |--------------------------------------------------------------------------
    | RENDER ANSWERS
    |--------------------------------------------------------------------------
    */

    function renderAnswers(question) {

        answerContainer.innerHTML = '';


        Object.entries(question.options).forEach(
            function ([letter, text]) {


                const selected =
                    answers[currentQuestion] === letter;


                const button =
                    document.createElement('button');


                button.type = 'button';


                button.className =
                    'group flex w-full items-center gap-4 rounded-2xl border p-4 text-left transition ' +
                    (
                        selected
                            ? 'border-maroon-900 bg-maroon-900 text-white shadow-lg shadow-maroon-900/10'
                            : 'border-maroon-900/10 bg-white hover:border-gold-400 hover:bg-gold-400/5'
                    );


                button.innerHTML = `

                    <span
                        class="grid h-10 w-10 shrink-0 place-items-center rounded-xl text-xs font-extrabold transition ${
                            selected
                                ? 'bg-gold-400 text-maroon-950'
                                : 'bg-maroon-900/5 text-maroon-800'
                        }"
                    >
                        ${letter}
                    </span>


                    <span
                        class="flex-1 text-xs font-bold leading-6 sm:text-sm ${
                            selected
                                ? 'text-white'
                                : 'text-slate-600'
                        }"
                    >
                        ${text}
                    </span>


                    ${
                        selected
                        ?
                        `
                        <span class="text-gold-400">

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.5"
                            >
                                <path d="m5 12 4 4L19 6"/>
                            </svg>

                        </span>
                        `
                        :
                        ''
                    }

                `;


                button.addEventListener(
                    'click',
                    function () {

                        if (!quizStarted) {

                            return;

                        }


                        if (quizFinished) {

                            return;

                        }


                        /*
                        | Simpan jawaban
                        */

                        answers[currentQuestion] =
                            letter;


                        /*
                        | Render ulang agar pilihan berubah
                        | menjadi maroon + teks putih
                        */

                        renderQuestion();

                    }
                );


                answerContainer.appendChild(button);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | PROGRESS
    |--------------------------------------------------------------------------
    */

    function updateProgress() {

        const questions = getQuestions();

        const total = questions.length;

        const answered =
            Object.keys(answers).length;


        progressText.textContent =
            answered + ' / ' + total;


        const percentage =
            total > 0
                ? (answered / total) * 100
                : 0;


        progressBar.style.width =
            percentage + '%';


        document
            .querySelectorAll('.question-number')
            .forEach(function (button) {


                const number =
                    Number(button.dataset.number);


                button.classList.remove(
                    'bg-maroon-900',
                    'bg-gold-400',
                    'text-white',
                    'text-maroon-950',
                    'border-gold-400'
                );


                /*
                | Soal aktif
                */

                if (
                    quizStarted &&
                    number - 1 === currentQuestion
                ) {

                    button.classList.add(
                        'bg-maroon-900',
                        'text-white'
                    );

                }


                /*
                | Sudah dijawab
                */

                else if (
                    answers[number - 1]
                ) {

                    button.classList.add(
                        'bg-gold-400',
                        'text-maroon-950',
                        'border-gold-400'
                    );

                }

            });

    }


    /*
    |--------------------------------------------------------------------------
    | NAVIGATION
    |--------------------------------------------------------------------------
    */

    function updateNavigation() {

        const questions =
            getQuestions();


        previousButton.disabled =
            currentQuestion === 0;


        if (
            currentQuestion ===
            questions.length - 1
        ) {

            nextButton.innerHTML = `

                Selesai

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

            `;


            finishButton.classList.remove(
                'hidden'
            );

        }

        else {

            nextButton.innerHTML = `

                Soal Berikutnya

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

            `;


            finishButton.classList.add(
                'hidden'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | NEXT
    |--------------------------------------------------------------------------
    */

    nextButton.addEventListener(
        'click',
        function () {


            if (!quizStarted) {

                return;

            }


            const questions =
                getQuestions();


            if (
                currentQuestion <
                questions.length - 1
            ) {

                currentQuestion++;

                renderQuestion();

                scrollToQuestion();

            }

            else {

                openConfirm();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | PREVIOUS
    |--------------------------------------------------------------------------
    */

    previousButton.addEventListener(
        'click',
        function () {


            if (!quizStarted) {

                return;

            }


            if (currentQuestion > 0) {

                currentQuestion--;

                renderQuestion();

                scrollToQuestion();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | QUESTION NUMBER
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.question-number')
        .forEach(function (button) {


            button.addEventListener(
                'click',
                function () {


                    if (!quizStarted) {

                        return;

                    }


                    if (quizFinished) {

                        return;

                    }


                    const number =
                        Number(
                            this.dataset.number
                        );


                    currentQuestion =
                        number - 1;


                    renderQuestion();

                    scrollToQuestion();

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | OPEN CONFIRM
    |--------------------------------------------------------------------------
    */

    function openConfirm() {

        const total =
            getQuestions().length;


        const answered =
            Object.keys(answers).length;


        const unanswered =
            total - answered;


        if (unanswered > 0) {

            confirmMessage.textContent =
                'Masih ada ' +
                unanswered +
                ' soal yang belum dijawab. Apakah kamu yakin ingin menyelesaikan latihan?';

        }

        else {

            confirmMessage.textContent =
                'Semua soal sudah dijawab. Apakah kamu yakin ingin menyelesaikan latihan?';

        }


        confirmModal.classList.remove(
            'hidden'
        );


        document.body.classList.add(
            'overflow-hidden'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FINISH BUTTON
    |--------------------------------------------------------------------------
    */

    finishButton.addEventListener(
        'click',
        function () {

            if (!quizStarted) {

                return;

            }


            openConfirm();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CANCEL
    |--------------------------------------------------------------------------
    */

    cancelFinish.addEventListener(
        'click',
        function () {

            confirmModal.classList.add(
                'hidden'
            );

            document.body.classList.remove(
                'overflow-hidden'
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CONFIRM FINISH
    |--------------------------------------------------------------------------
    */

    confirmFinish.addEventListener(
        'click',
        function () {

            confirmModal.classList.add(
                'hidden'
            );

            document.body.classList.remove(
                'overflow-hidden'
            );

            finishQuiz();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FINISH QUIZ
    |--------------------------------------------------------------------------
    */

    function finishQuiz() {

        stopTimer();


        quizFinished = true;


        const questions =
            getQuestions();


        let correct = 0;


        questions.forEach(
            function (question, index) {

                if (
                    answers[index] ===
                    question.answer
                ) {

                    correct++;

                }

            }
        );


        const score =
            Math.round(
                (correct / questions.length) * 100
            );


        lastScore.textContent =
            score;


        resultScore.textContent =
            score;


        resultCorrect.textContent =
            correct;


        resultTotal.textContent =
            questions.length;


        resultModal.classList.remove(
            'hidden'
        );


        document.body.classList.add(
            'overflow-hidden'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TIME UP -> RESULT
    |--------------------------------------------------------------------------
    */

    timeUpButton.addEventListener(
        'click',
        function () {

            timeUpModal.classList.add(
                'hidden'
            );

            document.body.classList.remove(
                'overflow-hidden'
            );

            finishQuiz();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RESTART
    |--------------------------------------------------------------------------
    */

    restartButton.addEventListener(
        'click',
        function () {


            resultModal.classList.add(
                'hidden'
            );


            document.body.classList.remove(
                'overflow-hidden'
            );


            quizStarted = false;

            quizFinished = false;

            currentQuestion = 0;

            answers = {};

            remainingTime = TOTAL_TIME;


            stopTimer();


            updateTimer();


            startScreen.classList.remove(
                'hidden'
            );


            quizSection.classList.add(
                'hidden'
            );


            timerCard.classList.add(
                'hidden'
            );


            updateProgress();


            window.scrollTo({

                top: 0,

                behavior: 'smooth'

            });

        }
    );


    /*
    |--------------------------------------------------------------------------
    | LANGUAGE CHANGE
    |--------------------------------------------------------------------------
    */

    languageSelect.addEventListener(
        'change',
        function () {


            const languageMeta = {
                java: {
                    name: 'Java',
                    logo: 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/java/java-original.svg',
                    description: 'Uji pemahamanmu melalui berbagai soal Java dari tingkat dasar hingga menengah.',
                    available: true
                },
                python: {
                    name: 'Python',
                    logo: 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/python/python-original.svg',
                    description: 'Uji pemahamanmu melalui berbagai soal Python dari konsep dasar hingga Object-Oriented Programming.',
                    available: true
                },
                javascript: {
                    name: 'JavaScript',
                    logo: 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg',
                    description: 'Latihan untuk JavaScript akan segera tersedia.',
                    available: false
                },
                php: {
                    name: 'PHP',
                    logo: 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg',
                    description: 'Latihan untuk PHP akan segera tersedia.',
                    available: false
                },
                cpp: {
                    name: 'C++',
                    logo: 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/cplusplus/cplusplus-original.svg',
                    description: 'Latihan untuk C++ akan segera tersedia.',
                    available: false
                },
                dart: {
                    name: 'Dart',
                    logo: 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/dart/dart-original.svg',
                    description: 'Latihan untuk Dart akan segera tersedia.',
                    available: false
                }
            };

            const selectedLanguage =
                languageMeta[currentLanguage];

            languageLogo.src =
                selectedLanguage.logo;

            languageLogo.alt =
                'Logo ' + selectedLanguage.name;

            languageTitle.textContent =
                selectedLanguage.available
                    ? 'Latihan Soal ' + selectedLanguage.name
                    : 'Bahasa Belum Tersedia';

            startTitle.textContent =
                selectedLanguage.available
                    ? 'Latihan Soal ' + selectedLanguage.name
                    : 'Bahasa Belum Tersedia';

            languageDescription.textContent =
                selectedLanguage.description;


            startScreen.classList.remove(
                'hidden'
            );

            quizSection.classList.add(
                'hidden'
            );

            timerCard.classList.add(
                'hidden'
            );


            updateTimer();

            updateProgress();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CATEGORY CHANGE
    |--------------------------------------------------------------------------
    */

    categorySelect.addEventListener(
        'change',
        function () {


            if (quizStarted) {

                const confirmChange =
                    confirm(
                        'Mengganti kategori akan mengulang latihan. Lanjutkan?'
                    );


                if (!confirmChange) {

                    return;

                }

            }


            stopTimer();


            quizStarted = false;

            quizFinished = false;

            currentQuestion = 0;

            answers = {};

            remainingTime =
                TOTAL_TIME;


            startScreen.classList.remove(
                'hidden'
            );

            quizSection.classList.add(
                'hidden'
            );

            timerCard.classList.add(
                'hidden'
            );


            updateTimer();

            updateProgress();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SCROLL
    |--------------------------------------------------------------------------
    */

    function scrollToQuestion() {

        quizSection.scrollIntoView({

            behavior: 'smooth',

            block: 'start'

        });

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    updateTimer();

    updateProgress();

});

</script>

@endsection
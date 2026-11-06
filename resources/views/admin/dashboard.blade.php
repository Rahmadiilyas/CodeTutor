@extends('layouts.master')

@section('title', 'Dashboard Admin — CodeTutor')
@section('description', 'Dashboard Admin untuk memantau akun pengguna dan aktivitas sistem.')
@section('page_label', 'Administrator')
@section('page_heading', 'Dashboard Admin')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 pb-10">

    {{-- WELCOME --}}
    <section class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 p-6 text-white shadow-card sm:p-8">
        <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border-[32px] border-gold-400/10"></div>
        <div class="pointer-events-none absolute -bottom-20 right-24 h-48 w-48 rounded-full bg-gold-400/10 blur-3xl"></div>

        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-400/20 bg-white/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.15em] text-gold-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                    Ringkasan Sistem
                </span>
                <h2 class="mt-4 font-display text-2xl font-extrabold tracking-tight sm:text-3xl">
                    Selamat datang, {{ auth()->user()->nama }}!
                </h2>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-white/65">
                    Pantau akun pengguna dan aktivitas penting CodeTutor melalui dashboard administrator.
                </p>
            </div>

            <a href="{{ route('admin.akun.index') }}"
               class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-gold-400 px-5 py-3 text-sm font-extrabold text-maroon-950 transition hover:bg-gold-300">
                Kelola Akun
            </a>
        </div>
    </section>

    {{-- STATISTIK AKUN --}}
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @php
            $stats = [
                ['label' => 'Total Instruktur', 'value' => $totalInstruktur, 'note' => 'Seluruh akun instruktur', 'color' => 'text-maroon-950'],
                ['label' => 'Instruktur Aktif', 'value' => $instrukturAktif, 'note' => 'Status akun aktif', 'color' => 'text-emerald-600'],
                ['label' => 'Total Pelajar', 'value' => $totalPelajar, 'note' => 'Seluruh akun pelajar', 'color' => 'text-maroon-950'],
                ['label' => 'Pelajar Aktif', 'value' => $pelajarAktif, 'note' => 'Status akun aktif', 'color' => 'text-emerald-600'],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft">
                <p class="text-xs font-semibold text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 font-display text-3xl font-extrabold {{ $stat['color'] }}">
                    {{ number_format($stat['value']) }}
                </p>
                <p class="mt-1 text-xs text-slate-400">{{ $stat['note'] }}</p>
            </div>
        @endforeach
    </section>

    {{-- AKTIVITAS DAN AKSI CEPAT --}}
    <section class="grid gap-6 xl:grid-cols-[1.4fr_.8fr]">
        <div class="overflow-hidden rounded-2xl border border-maroon-900/8 bg-white shadow-soft">
            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700">Pengawasan</p>
                    <h3 class="mt-1 font-display text-xl font-extrabold text-maroon-950">Aktivitas Sistem Terbaru</h3>
                    <p class="mt-1 text-xs text-slate-400">Aktivitas yang sudah tercatat dalam sistem.</p>
                </div>
                <span class="inline-flex w-fit items-center rounded-full bg-warm-50 px-3 py-1.5 text-xs font-bold text-maroon-800">
                    {{ $aktivitasHariIni }} aktivitas hari ini
                </span>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($aktivitasTerbaru as $aktivitas)
                    <div class="flex gap-3 p-5">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-maroon-900/5 text-maroon-800">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 8v4l3 2"/>
                            </svg>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-maroon-950">{{ $aktivitas->jenis_aktivitas }}</p>
                            <p class="mt-1 break-words text-sm leading-5 text-slate-500">{{ $aktivitas->deskripsi }}</p>
                            <p class="mt-2 text-xs text-slate-400">
                                Pengguna #{{ $aktivitas->id_user }}
                                <span class="mx-1">•</span>
                                {{ $aktivitas->waktu_aktivitas ? \Illuminate\Support\Carbon::parse($aktivitas->waktu_aktivitas)->format('d M Y, H:i') : '-' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-sm font-bold text-maroon-950">Belum ada aktivitas tercatat</p>
                        <p class="mt-1 text-xs text-slate-500">Aktivitas akan tampil setelah ada tindakan yang dicatat sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-maroon-900/8 bg-white p-6 shadow-soft">
                <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700">Aksi Cepat</p>
                <h3 class="mt-1 font-display text-lg font-extrabold text-maroon-950">Administrasi Pengguna</h3>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Lihat data Instruktur dan Pelajar serta kelola akun sesuai kewenangan Admin.
                </p>
                <a href="{{ route('admin.akun.index') }}"
                   class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-maroon-900 px-4 py-3 text-sm font-extrabold text-white transition hover:bg-maroon-700">
                    Buka Kelola Akun
                </a>
            </div>

            <div class="rounded-2xl border border-gold-500/20 bg-gradient-to-br from-warm-50 to-white p-6">
                <h3 class="font-display text-base font-extrabold text-maroon-950">Pemantauan Sistem</h3>
                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Pengawasan konten pembelajaran dan progres pelajar dapat dilengkapi setelah modul pembelajaran menyimpan data yang diperlukan.
                </p>
            </div>
        </div>
    </section>
</div>
@endsection

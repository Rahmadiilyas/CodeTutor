@extends('layouts.master')

@section('title', 'Sertifikat Saya - CodeTutor')
@section('description', 'Lihat dan unduh sertifikat pembelajaran yang telah diterbitkan.')
@section('page_label', 'Pelajar')
@section('page_heading', 'Sertifikat Saya')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <section class="relative overflow-hidden rounded-3xl bg-maroon-950 px-6 py-7 text-white shadow-card sm:px-8 sm:py-9">
        <div class="pointer-events-none absolute -right-8 -top-12 h-48 w-48 rounded-full border-[22px] border-gold-400/10"></div>
        <div class="pointer-events-none absolute -bottom-16 right-36 h-40 w-40 rounded-full bg-gold-400/10 blur-2xl"></div>
        <div class="relative z-10 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-300/25 bg-white/5 px-3 py-1 text-[10px] font-extrabold uppercase tracking-[.16em] text-gold-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span> Pencapaian Belajar
                </span>
                <h1 class="mt-3 font-display text-2xl font-extrabold tracking-tight sm:text-3xl">Sertifikat Saya</h1>
                <p class="mt-2 text-sm leading-6 text-white/65">Kumpulan bukti penyelesaian modul yang telah diterbitkan oleh instruktur. Sertifikat dapat dilihat langsung atau diunduh sebagai PDF.</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 px-5 py-4 sm:min-w-36 sm:text-center">
                <p class="text-[10px] font-bold uppercase tracking-wider text-white/50">Total Sertifikat</p>
                <p class="mt-1 font-display text-3xl font-extrabold text-gold-300">{{ $sertifikat->count() }}</p>
                <p class="text-[10px] text-white/45">Telah diterbitkan</p>
            </div>
        </div>
    </section>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif

    @if ($sertifikat->isEmpty())
        <section class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm">
            <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-warm-100 text-maroon-800">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M7 3h10a2 2 0 0 1 2 2v16l-7-4-7 4V5a2 2 0 0 1 2-2z"/><path d="m9 10 2 2 4-4"/></svg>
            </div>
            <h2 class="mt-4 font-display text-lg font-extrabold text-maroon-950">Belum Ada Sertifikat</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Sertifikat akan muncul setelah progres modul mencapai 100%, seluruh Posttest memenuhi nilai minimum, dan instruktur menerbitkannya.</p>
        </section>
    @else
        <div class="grid gap-5 xl:grid-cols-2">
            @foreach ($sertifikat as $item)
                <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-gold-500/50 hover:shadow-card">
                    <div class="relative overflow-hidden bg-maroon-950 px-5 py-5 text-white">
                        <div class="absolute -right-5 -top-8 h-28 w-28 rounded-full border-[12px] border-gold-400/10"></div>
                        <div class="relative flex items-start justify-between gap-4">
                            <div>
                                <p class="text-[9px] font-extrabold uppercase tracking-[.2em] text-gold-300">CodeTutor Achievement</p>
                                <h2 class="mt-2 font-display text-lg font-extrabold leading-snug">{{ $item->judul_sertifikat }}</h2>
                                <p class="mt-2 text-xs text-white/55">{{ $item->modul->bahasa->nama_bahasa ?? 'Bahasa Pemrograman' }}</p>
                            </div>
                            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl border border-gold-300/30 bg-gold-400/10 text-gold-300">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="5"/><path d="m8.5 12-1 9 4.5-2.5 4.5 2.5-1-9"/><path d="m10 8 1.3 1.3L14 6.5"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4 p-5">
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div class="rounded-xl bg-warm-50 p-3">
                                <p class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400">Modul</p>
                                <p class="mt-1 text-sm font-bold text-maroon-950">{{ $item->modul->nama_modul ?? 'Modul Pembelajaran' }}</p>
                            </div>
                            <div class="rounded-xl bg-warm-50 p-3">
                                <p class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400">Instruktur</p>
                                <p class="mt-1 text-sm font-bold text-maroon-950">{{ $item->instruktur->nama ?? 'Instruktur CodeTutor' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 pt-3">
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Nomor Sertifikat</p>
                                <p class="mt-1 text-xs font-extrabold tracking-wide text-maroon-800">{{ $item->nomor_sertifikat }}</p>
                                <p class="mt-1 text-[10px] text-slate-400">Diterbitkan {{ \Illuminate\Support\Carbon::parse($item->tanggal_terbit)->translatedFormat('d F Y') }}</p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-[10px] font-bold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Resmi diterbitkan
                            </span>
                        </div>
                        <div class="flex flex-col gap-2 border-t border-slate-100 pt-4 sm:flex-row">
                            <a href="{{ route('pelajar.sertifikat.preview', $item) }}" target="_blank" rel="noopener noreferrer"
                               class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-maroon-800/15 bg-white px-4 py-3 text-xs font-extrabold text-maroon-800 transition hover:bg-warm-50">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                Lihat Sertifikat
                            </a>
                            <a href="{{ route('pelajar.sertifikat.download', $item) }}"
                               class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-3 text-xs font-extrabold text-white transition hover:bg-maroon-700">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5M12 15V3"/></svg>
                                Unduh PDF
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection

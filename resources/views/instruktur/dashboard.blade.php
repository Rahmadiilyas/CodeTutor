@extends('layouts.master')

@section('title', 'Dashboard Instruktur — CodeTutor')
@section('description', 'Ringkasan bahasa, modul, materi, evaluasi, dan progres Pelajar yang dikelola Instruktur.')
@section('page_label', 'Instruktur')
@section('page_heading', 'Dashboard Instruktur')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 pb-10">
    <section class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 p-6 text-white shadow-card sm:p-8">
        <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border-[32px] border-gold-400/10"></div>
        <div class="pointer-events-none absolute -bottom-20 right-24 h-48 w-48 rounded-full bg-gold-400/10 blur-3xl"></div>
        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-400/20 bg-white/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.15em] text-gold-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                    Ringkasan pembelajaran
                </span>
                <h2 class="mt-4 font-display text-2xl font-extrabold tracking-tight sm:text-3xl">Selamat datang, {{ auth()->user()->nama }}!</h2>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-white/65">Kelola bahasa pemrograman, modul, materi, Code Lab, serta pantau progres dan evaluasi Pelajar dari satu tempat.</p>
            </div>
            <a href="{{ route('instruktur.modul.index') }}" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-gold-400 px-5 py-3 text-sm font-extrabold text-maroon-950 transition hover:bg-gold-300">Kelola Modul</a>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @php
            $stats = [
                ['label' => 'Bahasa Aktif', 'value' => $bahasaInstruktur->count(), 'note' => 'Bahasa yang dikelola'],
                ['label' => 'Modul Aktif', 'value' => $totalModulInstruktur, 'note' => 'Modul milik Anda'],
                ['label' => 'Materi Aktif', 'value' => $totalMateriInstruktur, 'note' => 'Materi pada modul aktif'],
                ['label' => 'Posttest', 'value' => $totalEvaluasiInstruktur, 'note' => 'Posttest yang dibuat'],
                ['label' => 'Pelajar Terpantau', 'value' => $totalPelajarTerpantau, 'note' => 'Pelajar dengan catatan progres'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft">
                <p class="text-xs font-semibold text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 font-display text-3xl font-extrabold text-maroon-950">{{ number_format((int) $stat['value'], 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-400">{{ $stat['note'] }}</p>
            </div>
        @endforeach
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.2fr_.8fr]">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700">Konten pembelajaran</p>
                    <h3 class="mt-1 font-display text-xl font-extrabold text-maroon-950">Modul yang dikelola</h3>
                    <p class="mt-1 text-xs text-slate-500">Daftar modul aktif milik akun Instruktur ini.</p>
                </div>
                <a href="{{ route('instruktur.modul.index') }}" class="inline-flex w-fit items-center rounded-xl bg-maroon-800 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-maroon-700">Lihat Modul</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($modulInstruktur as $modul)
                    <div class="flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-extrabold text-maroon-950">{{ $modul->nama_modul }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $modul->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia' }} · {{ number_format((int) $modul->materi_count, 0, ',', '.') }} materi aktif</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $modul->deskripsi ?: 'Belum ada deskripsi modul.' }}</p>
                        </div>
                        <a href="{{ route('instruktur.modul.edit', $modul) }}" class="inline-flex w-fit shrink-0 items-center rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-maroon-800 transition hover:bg-warm-50">Kelola</a>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-sm font-bold text-maroon-950">Belum ada modul aktif</p>
                        <p class="mt-1 text-xs text-slate-500">Buat modul untuk mulai menyusun materi dan evaluasi pembelajaran.</p>
                        <a href="{{ route('instruktur.modul.create') }}" class="mt-4 inline-flex rounded-xl bg-maroon-800 px-4 py-2.5 text-xs font-bold text-white hover:bg-maroon-700">Buat Modul</a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft sm:p-6">
            <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700">Akses cepat</p>
            <h3 class="mt-1 font-display text-lg font-extrabold text-maroon-950">Kelola pembelajaran</h3>
            <div class="mt-5 grid grid-cols-2 gap-3">
                <a href="{{ route('instruktur.bahasa.index') }}" class="rounded-xl border border-slate-200 p-4 transition hover:border-gold-500/40 hover:bg-warm-50">
                    <p class="text-sm font-extrabold text-maroon-950">Bahasa</p><p class="mt-1 text-[10px] text-slate-500">Atur bahasa pemrograman</p>
                </a>
                <a href="{{ route('instruktur.materi.index') }}" class="rounded-xl border border-slate-200 p-4 transition hover:border-gold-500/40 hover:bg-warm-50">
                    <p class="text-sm font-extrabold text-maroon-950">Materi</p><p class="mt-1 text-[10px] text-slate-500">Kelola konten belajar</p>
                </a>
                <a href="{{ route('instruktur.code-lab.index') }}" class="rounded-xl border border-slate-200 p-4 transition hover:border-gold-500/40 hover:bg-warm-50">
                    <p class="text-sm font-extrabold text-maroon-950">Code Lab</p><p class="mt-1 text-[10px] text-slate-500">Contoh dan latihan kode</p>
                </a>
                <a href="{{ route('instruktur.evaluasi.index', ['jenis_evaluasi' => 'posttest']) }}" class="rounded-xl border border-slate-200 p-4 transition hover:border-gold-500/40 hover:bg-warm-50">
                    <p class="text-sm font-extrabold text-maroon-950">Posttest</p><p class="mt-1 text-[10px] text-slate-500">{{ number_format((int) $menungguPenilaian, 0, ',', '.') }} menunggu penilaian</p>
                </a>
                <a href="{{ route('instruktur.referensi-chatbot.index') }}" class="rounded-xl border border-slate-200 p-4 transition hover:border-gold-500/40 hover:bg-warm-50 col-span-2">
                    <p class="text-sm font-extrabold text-maroon-950">Referensi Chatbot AI</p><p class="mt-1 text-[10px] text-slate-500">Kelola referensi yang mendukung jawaban chatbot.</p>
                </a>
            </div>
            <div class="mt-5 rounded-xl bg-warm-50 p-4">
                <div class="flex items-center justify-between text-xs"><span class="font-semibold text-slate-600">Rata-rata progres modul Anda</span><span class="font-extrabold text-maroon-900">{{ number_format($rataProgresInstruktur, 1, ',', '.') }}%</span></div>
                <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-200"><div class="h-full rounded-full bg-gradient-to-r from-maroon-700 to-gold-500" style="width: {{ $rataProgresInstruktur }}%"></div></div>
            </div>
        </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
        <div class="border-b border-slate-100 p-5">
            <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700">Pemantauan</p>
            <h3 class="mt-1 font-display text-xl font-extrabold text-maroon-950">Progres Pelajar terbaru</h3>
            <p class="mt-1 text-xs text-slate-500">Menampilkan catatan progres untuk modul yang dikelola akun Instruktur ini.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-warm-50"><tr class="text-left text-[10px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Pelajar</th><th class="px-5 py-3">Modul</th><th class="px-5 py-3">Materi selesai</th><th class="px-5 py-3">Progres</th><th class="px-5 py-3">Status</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($progresPelajarTerbaru as $progres)
                        @php $percent = min(100, max(0, (float) $progres->presentase_progres)); @endphp
                        <tr class="align-top">
                            <td class="px-5 py-4"><p class="text-sm font-bold text-maroon-950">{{ $progres->pelajar->nama ?? 'Pelajar tidak tersedia' }}</p><p class="mt-1 text-xs text-slate-400">{{ $progres->pelajar->email ?? '' }}</p></td>
                            <td class="px-5 py-4 text-sm text-slate-600">{{ $progres->modul->nama_modul ?? 'Modul tidak tersedia' }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ number_format((int) $progres->materi_selesai, 0, ',', '.') }} / {{ number_format((int) $progres->total_materi, 0, ',', '.') }}</td>
                            <td class="min-w-36 px-5 py-4"><p class="text-xs font-extrabold text-maroon-900">{{ number_format($percent, 0, ',', '.') }}%</p><div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-maroon-800" style="width: {{ $percent }}%"></div></div></td>
                            <td class="px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-bold {{ $percent >= 100 || $progres->status === 'selesai' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ $percent >= 100 || $progres->status === 'selesai' ? 'Selesai' : (filled($progres->status) ? ucfirst(str_replace('_', ' ', $progres->status)) : 'Berlangsung') }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada progres Pelajar pada modul yang Anda kelola.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 p-4 text-right"><a href="{{ route('progress') }}" class="text-xs font-bold text-maroon-800 hover:text-gold-700">Buka pemantauan progres →</a></div>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white shadow-soft">
        <div class="border-b border-slate-100 p-5"><h3 class="font-display text-lg font-extrabold text-maroon-950">Aktivitas terbaru Anda</h3><p class="mt-1 text-xs text-slate-500">Catatan aktivitas yang terkait dengan akun Instruktur ini.</p></div>
        <div class="divide-y divide-slate-100">
            @forelse ($aktivitasInstruktur as $aktivitas)
                <div class="flex flex-col gap-1 p-4 sm:flex-row sm:items-start sm:justify-between">
                    <div><p class="text-sm font-bold text-maroon-950">{{ $aktivitas->jenis_aktivitas ?: 'Aktivitas' }}</p><p class="mt-1 text-xs leading-5 text-slate-500">{{ $aktivitas->deskripsi ?: 'Tidak ada deskripsi.' }}</p></div>
                    <span class="shrink-0 text-[10px] text-slate-400">{{ $aktivitas->waktu_aktivitas ? \Illuminate\Support\Carbon::parse($aktivitas->waktu_aktivitas)->diffForHumans() : 'Waktu tidak tersedia' }}</span>
                </div>
            @empty
                <p class="p-5 text-sm text-slate-500">Belum ada aktivitas yang tercatat untuk akun ini.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection

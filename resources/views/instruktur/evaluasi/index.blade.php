@extends('layouts.master')

@section('title', 'Kelola Evaluasi')
@section('description', 'Kelola evaluasi, soal, pilihan jawaban, dan nilai minimal pembelajaran.')
@section('page_label', 'Area Instruktur')
@section('page_heading', 'Kelola Evaluasi')

@section('content')
@php
    $labelJenis = ['pretest' => 'Pretest', 'posttest' => 'Posttest'];
    $jenisFilterAktif = request('jenis_evaluasi');
@endphp
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
   
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Kelola Evaluasi</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Buat pretest dan posttest beserta soal, pilihan jawaban, bobot, durasi, serta nilai minimal kelulusan.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('instruktur.evaluasi.create', ['jenis_evaluasi' => 'pretest']) }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-900 shadow-sm transition hover:bg-amber-100 focus:outline-none focus:ring-4 focus:ring-amber-100">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"><path d="M9 18h6M10 22h4M8.5 14.5a6 6 0 1 1 7 0c-.8.6-1.2 1.3-1.3 2.5h-4.4c-.1-1.2-.5-1.9-1.3-2.5Z"/></svg>
                Buat Pretest
            </a>
            <a href="{{ route('instruktur.evaluasi.create', ['jenis_evaluasi' => 'posttest']) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Buat Posttest
            </a>
        </div>
    </div>

    @if (session('success'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">{{ session('error') }}</div>@endif
    @if ($errors->any())<div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"><p class="font-semibold">Ada data yang perlu diperbaiki.</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><p class="text-sm font-medium text-slate-500">Total evaluasi</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($totalEvaluasi, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-400">Evaluasi milik akunmu</p></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><p class="text-sm font-medium text-slate-500">Total soal</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($totalSoal, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-400">Semua jenis soal</p></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><p class="text-sm font-medium text-slate-500">Pengerjaan Posttest tercatat</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($totalPengerjaan, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-400">Hasil Posttest yang diteruskan ke Instruktur</p></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><p class="text-sm font-medium text-slate-500">Posttest sudah dikerjakan</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($evaluasiDenganPengerjaan, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-400">Pengeditan soal akan dikunci demi menjaga riwayat</p></div>
    </div>

    @if ($modul->isEmpty())
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 sm:p-6">
            <div class="flex items-start gap-3"><div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-white text-amber-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M8 7h8M8 11h8"/></svg></div><div><h2 class="font-display font-bold text-amber-950">Belum ada modul pembelajaran</h2><p class="mt-1 text-sm leading-6 text-amber-800">Buat modul terlebih dahulu. Evaluasi harus terhubung dengan modul milikmu.</p><a href="{{ route('instruktur.modul.index') }}" class="mt-3 inline-flex items-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Buka Kelola Modul</a></div></div>
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-soft sm:p-5">
        <div class="mb-4">
            <h2 class="font-display text-base font-bold text-maroon-950">Cari evaluasi</h2>
            <p class="mt-1 text-xs text-slate-500">Pilih tab Pretest atau Posttest, lalu cari berdasarkan judul dan modul.</p>
        </div>
        <div class="mb-4 flex flex-wrap gap-2" role="group" aria-label="Filter jenis evaluasi">
            <a href="{{ route('instruktur.evaluasi.index', array_filter(['q' => request('q'), 'id_modul' => request('id_modul')])) }}" class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ !$jenisFilterAktif ? 'border-maroon-800 bg-maroon-800 text-white' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">Semua</a>
            <a href="{{ route('instruktur.evaluasi.index', array_filter(['jenis_evaluasi' => 'pretest', 'q' => request('q'), 'id_modul' => request('id_modul')])) }}" class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ $jenisFilterAktif === 'pretest' ? 'border-amber-300 bg-amber-100 text-amber-900' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">Pretest</a>
            <a href="{{ route('instruktur.evaluasi.index', array_filter(['jenis_evaluasi' => 'posttest', 'q' => request('q'), 'id_modul' => request('id_modul')])) }}" class="rounded-xl border px-4 py-2 text-sm font-semibold transition {{ $jenisFilterAktif === 'posttest' ? 'border-maroon-200 bg-maroon-50 text-maroon-900' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">Posttest</a>
        </div>
        <form method="GET" action="{{ route('instruktur.evaluasi.index') }}" class="grid gap-3 md:grid-cols-2">
            @if ($jenisFilterAktif)
                <input type="hidden" name="jenis_evaluasi" value="{{ $jenisFilterAktif }}">
            @endif
            <div>
                <label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Kata kunci</label>
                <input id="q" name="q" value="{{ request('q') }}" type="text" placeholder="Judul evaluasi atau modul..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
            </div>
            <div>
                <label for="id_modul" class="mb-1.5 block text-xs font-semibold text-slate-600">Modul</label>
                <select id="id_modul" name="id_modul" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    <option value="">Semua modul</option>
                    @foreach ($modul as $itemModul)
                        <option value="{{ $itemModul->id }}" @selected((string) request('id_modul') === (string) $itemModul->id)>{{ $itemModul->nama_modul }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-wrap items-center gap-2 md:col-span-2">
                <button type="submit" class="rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Terapkan Filter</button>
                <a href="{{ route('instruktur.evaluasi.index', $jenisFilterAktif ? ['jenis_evaluasi' => $jenisFilterAktif] : []) }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Reset</a>
                <span class="text-xs text-slate-400 md:ml-auto">{{ $evaluasi->total() }} evaluasi ditemukan</span>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="font-display text-base font-bold text-maroon-950">Daftar evaluasi</h2><p class="mt-1 text-xs text-slate-500">Evaluasi hanya dapat dikelola oleh Instruktur pemiliknya.</p></div><span class="w-fit rounded-full bg-warm-100 px-3 py-1 text-xs font-semibold text-maroon-800">{{ $evaluasi->total() }} data</span></div>
        <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-100"><thead class="bg-warm-50"><tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="whitespace-nowrap px-5 py-3">Evaluasi</th><th class="whitespace-nowrap px-5 py-3">Modul</th><th class="whitespace-nowrap px-5 py-3">Jenis</th><th class="whitespace-nowrap px-5 py-3">Durasi</th><th class="whitespace-nowrap px-5 py-3">Soal</th><th class="whitespace-nowrap px-5 py-3">Nilai minimal</th><th class="whitespace-nowrap px-5 py-3">Pengerjaan</th><th class="whitespace-nowrap px-5 py-3 text-right">Aksi</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($evaluasi as $item)
                <tr class="align-top transition hover:bg-warm-50/70"><td class="min-w-[220px] px-5 py-4"><p class="font-semibold text-slate-800">{{ $item->judul_evaluasi }}</p><p class="mt-1 line-clamp-2 max-w-sm text-xs leading-5 text-slate-400">{{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}</p></td><td class="whitespace-nowrap px-5 py-4"><p class="text-sm font-medium text-slate-700">{{ $item->modul->nama_modul ?? 'Modul tidak tersedia' }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->modul->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia' }}</p></td><td class="whitespace-nowrap px-5 py-4"><span class="inline-flex rounded-lg border border-maroon-100 bg-maroon-50 px-2.5 py-1 text-xs font-semibold text-maroon-800">{{ $labelJenis[$item->jenis_evaluasi] ?? ucfirst($item->jenis_evaluasi) }}</span></td><td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-700">{{ $item->durasi_menit }} menit</td><td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-700">{{ $item->soal_count }}</td><td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-700">{{ $item->nilai_minimal }}</td><td class="whitespace-nowrap px-5 py-4">
                    @if ($item->jenis_evaluasi === 'posttest')
                        <span class="text-sm font-semibold text-slate-700">{{ $item->pengerjaan_count }}</span>
                        @if ($item->pengerjaan_count > 0)<p class="mt-1 text-[11px] text-amber-700">Hasil masuk ke Instruktur</p>@else<p class="mt-1 text-[11px] text-slate-400">Belum ada hasil</p>@endif
                    @else
                        <span class="text-sm font-semibold text-slate-500">—</span>
                        <p class="mt-1 text-[11px] text-amber-700">Latihan mandiri Pelajar</p>
                    @endif
                </td><td class="whitespace-nowrap px-5 py-4"><div class="flex justify-end gap-2"><a href="{{ route('instruktur.evaluasi.show', $item) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-white">Detail</a>@if ($item->pengerjaan_count === 0)<a href="{{ route('instruktur.evaluasi.edit', $item) }}" class="rounded-lg bg-maroon-50 px-3 py-2 text-xs font-semibold text-maroon-800 hover:bg-maroon-100">Edit</a><form method="POST" action="{{ route('instruktur.evaluasi.destroy', $item) }}" onsubmit="return confirm('Hapus evaluasi ini beserta soal dan pilihan jawabannya? Tindakan ini tidak dapat dibatalkan.');">@csrf @method('DELETE')<button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Hapus</button></form>@else<span class="rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-400" title="Evaluasi sudah memiliki riwayat pengerjaan">Terkunci</span>@endif</div></td></tr>
            @empty
                <tr><td colspan="8" class="px-6 py-14 text-center"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8M8 17h5"/></svg></div><h3 class="mt-4 font-display text-base font-bold text-slate-800">Belum ada evaluasi</h3><p class="mx-auto mt-1 max-w-md text-sm text-slate-500">Buat evaluasi pertama setelah modul tersedia. Tambahkan soal dan pilihan jawaban sesuai jenis soalnya.</p>@if (!$modul->isEmpty())<div class="mt-4 flex flex-wrap justify-center gap-2"><a href="{{ route('instruktur.evaluasi.create', ['jenis_evaluasi' => 'pretest']) }}" class="inline-flex rounded-xl border border-amber-200 bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-900 hover:bg-amber-100">Buat Pretest</a><a href="{{ route('instruktur.evaluasi.create', ['jenis_evaluasi' => 'posttest']) }}" class="inline-flex rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Buat Posttest</a></div>@endif</td></tr>
            @endforelse
            </tbody></table></div>
        @if ($evaluasi->hasPages())<div class="border-t border-slate-100 px-5 py-4">{{ $evaluasi->links() }}</div>@endif
    </div>
</div>
@endsection

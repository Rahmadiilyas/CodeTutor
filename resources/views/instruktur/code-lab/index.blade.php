@extends('layouts.master')

@section('title', 'Kelola Latihan Code Lab')
@section('description', 'Kelola contoh kode pemrograman milik Instruktur.')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>

            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Kelola Latihan Code Lab</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Susun contoh kode, jelaskan tujuan latihan, dan hubungkan kode dengan bahasa pemrograman serta materi yang sesuai.</p>
        </div>
        <a href="{{ route('instruktur.code-lab.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg> Tambah Contoh Kode
        </a>
    </div>

    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"><svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg><p>{{ session('success') }}</p></div>
    @endif
    @if (session('error'))
        <div class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800"><svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4m0 4h.01"/></svg><p>{{ session('error') }}</p></div>
    @endif
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"><p class="font-semibold">Ada data yang perlu diperbaiki.</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Total Contoh Kode</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalKode, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Seluruh kode milik akunmu</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></span></div></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Terhubung ke Materi</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-emerald-700">{{ number_format($kodeTerhubungMateri, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Kode dengan materi terkait</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg></span></div></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Tanpa Materi</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-700">{{ number_format($kodeTanpaMateri, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Contoh kode berdiri sendiri</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-100 text-slate-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M8 12h8"/></svg></span></div></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Bahasa Digunakan</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($jumlahBahasaDigunakan, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Bahasa dengan contoh kode</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-gold-100 text-maroon-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m8 9 3 3-3 3M13 15h3"/><rect x="3" y="4" width="18" height="16" rx="2"/></svg></span></div></div>
    </div>

    @if ($bahasa->isEmpty())
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-950"><div class="flex items-start gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v4m0 4h.01"/><path d="M10.3 3.8 2.4 17.5A2 2 0 0 0 4.1 20h15.8a2 2 0 0 0 1.7-2.5L13.7 3.8a2 2 0 0 0-3.4 0z"/></svg><div><h2 class="font-display font-bold">Belum ada bahasa pemrograman</h2><p class="mt-1 text-sm leading-6 text-amber-900/80">Tambahkan bahasa pemrograman terlebih dahulu sebelum membuat contoh kode.</p><a href="{{ route('instruktur.bahasa.create') }}" class="mt-3 inline-flex items-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700">Tambah Bahasa Pemrograman</a></div></div></div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="border-b border-slate-100 px-5 py-4"><h2 class="font-display text-base font-bold text-maroon-950">Daftar Contoh Kode</h2><p class="mt-1 text-xs text-slate-500">Hanya menampilkan contoh kode yang dibuat oleh akun Instruktur ini.</p></div>
        <form method="GET" action="{{ route('instruktur.code-lab.index') }}" class="grid gap-3 border-b border-slate-100 bg-warm-50/70 p-4 md:grid-cols-[minmax(0,1fr)_240px_auto_auto]">
            <div><label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Kata kunci</label><div class="relative"><svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg><input id="q" name="q" value="{{ request('q') }}" placeholder="Judul, deskripsi, kode, materi..." class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"></div></div>
            <div><label for="id_bahasa" class="mb-1.5 block text-xs font-semibold text-slate-600">Bahasa pemrograman</label><select id="id_bahasa" name="id_bahasa" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="">Semua bahasa</option>@foreach ($bahasa as $itemBahasa)<option value="{{ $itemBahasa->id }}" @selected((string) request('id_bahasa') === (string) $itemBahasa->id)>{{ $itemBahasa->nama_bahasa }}</option>@endforeach</select></div>
            <div class="flex items-end"><button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700">Filter</button></div>
            <div class="flex items-end"><a href="{{ route('instruktur.code-lab.index') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a></div>
        </form>
        <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-warm-50"><tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Contoh Kode</th><th class="whitespace-nowrap px-5 py-3">Bahasa</th><th class="whitespace-nowrap px-5 py-3">Materi</th><th class="whitespace-nowrap px-5 py-3">Diperbarui</th><th class="whitespace-nowrap px-5 py-3 text-right">Aksi</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($kode as $item)
                <tr class="align-top transition hover:bg-warm-50/70">
                    <td class="max-w-2xl px-5 py-4"><div class="flex items-start gap-3"><span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></span><div class="min-w-0"><p class="font-display text-sm font-bold text-slate-800">{{ $item->judul }}</p><p class="mt-1 whitespace-normal break-words text-sm leading-5 text-slate-500">{{ $item->deskripsi ?: 'Belum ada deskripsi.' }}</p><pre class="mt-3 max-h-28 overflow-hidden whitespace-pre-wrap break-words rounded-xl bg-slate-950 p-3 font-mono text-xs leading-5 text-emerald-100">{{ \Illuminate\Support\Str::limit((string) $item->kode_program, 400) }}</pre></div></div></td>
                    <td class="whitespace-nowrap px-5 py-4"><span class="inline-flex rounded-lg border border-maroon-100 bg-maroon-50 px-2.5 py-1 text-xs font-semibold text-maroon-800">{{ $item->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia' }}</span></td>
                    <td class="max-w-xs px-5 py-4"><p class="text-sm font-semibold text-slate-700">{{ $item->materi->judul_materi ?? 'Tidak dikaitkan' }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->materi->modul->nama_modul ?? 'Contoh kode umum' }}</p></td>
                    <td class="whitespace-nowrap px-5 py-4"><p class="text-sm text-slate-600">{{ optional($item->updated_at)->format('d M Y') ?? '—' }}</p><p class="mt-1 text-xs text-slate-400">{{ optional($item->updated_at)->format('H:i') ?? '' }}</p></td>
                    <td class="px-5 py-4"><div class="flex flex-wrap items-center justify-end gap-2"><a href="{{ route('instruktur.code-lab.edit', $item) }}" class="inline-flex items-center rounded-lg border border-slate-200 px-2.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800">Edit</a><form method="POST" action="{{ route('instruktur.code-lab.destroy', $item) }}" onsubmit="return confirm('Hapus contoh kode {{ addslashes($item->judul) }}?')">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-lg border border-rose-200 px-2.5 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button></form></div></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-14 text-center"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div><h3 class="mt-4 font-display text-base font-bold text-slate-800">Belum ada contoh kode</h3><p class="mx-auto mt-1 max-w-md text-sm text-slate-500">Tambahkan contoh kode agar dapat dikaitkan dengan bahasa pemrograman dan materi pembelajaran.</p>@if ($bahasa->isNotEmpty())<a href="{{ route('instruktur.code-lab.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Tambah Contoh Kode Pertama</a>@endif</td></tr>
            @endforelse
            </tbody>
        </table></div>
        @if ($kode->hasPages())<div class="border-t border-slate-100 px-5 py-4">{{ $kode->links() }}</div>@endif
    </div>
    <p class="text-xs leading-5 text-slate-400">Code Lab pada halaman ini mengelola contoh kode yang tersimpan. Eksekusi kode secara langsung bukan bagian dari halaman CRUD ini dan memerlukan fitur/lingkungan eksekusi tersendiri.</p>
</div>
@endsection

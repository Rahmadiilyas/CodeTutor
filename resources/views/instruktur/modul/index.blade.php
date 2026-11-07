@extends('layouts.master')

@section('title', 'Kelola Modul Pembelajaran')
@section('description', 'Kelola modul pembelajaran dan bahasa pemrograman yang digunakan.')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
          
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Modul Pembelajaran</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Susun modul berdasarkan bahasa pemrograman, atur urutan pembelajaran, dan pantau konten yang terkait.</p>
        </div>
        <a href="{{ route('instruktur.modul.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Modul
        </a>
    </div>

    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"><svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg><p>{{ session('success') }}</p></div>
    @endif
    @if (session('error'))
        <div class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800"><svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4m0 4h.01M10.3 3.9 1.8 18.2A2 2 0 0 0 3.5 21h17a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0z"/></svg><p>{{ session('error') }}</p></div>
    @endif
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"><p class="font-semibold">Periksa kembali filter yang dipilih.</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Total Modul</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalModul, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Modul milik akunmu</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg></span></div></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Modul Aktif</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-emerald-700">{{ number_format($modulAktif, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Dapat digunakan dalam pembelajaran</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m5 12 4 4L19 6"/><circle cx="12" cy="12" r="10"/></svg></span></div></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Modul Nonaktif</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-amber-700">{{ number_format($modulNonaktif, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Data tetap tersimpan</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-50 text-amber-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M8 12h8"/></svg></span></div></div>
    </div>

    @if ($bahasa->isEmpty())
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 sm:p-8">
            <div class="mx-auto max-w-xl text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-amber-700 shadow-sm"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m8 9-4 3 4 3m8-6 4 3-4 3m-2-9-4 12"/></svg></div>
                <h2 class="mt-4 font-display text-lg font-bold text-amber-950">Belum ada bahasa pemrograman</h2>
                <p class="mt-2 text-sm leading-6 text-amber-900/80">Tambahkan bahasa pemrograman aktif terlebih dahulu. Modul harus terhubung dengan salah satu bahasa milikmu.</p>
                <a href="{{ route('instruktur.bahasa.create') }}" class="mt-4 inline-flex items-center justify-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700">Tambah Bahasa Pemrograman</a>
            </div>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="border-b border-slate-100 px-5 py-4"><h2 class="font-display text-base font-bold text-maroon-950">Daftar Modul</h2><p class="mt-1 text-xs text-slate-500">Setiap Instruktur hanya dapat mengelola modul yang dimilikinya.</p></div>
        <form method="GET" action="{{ route('instruktur.modul.index') }}" class="grid gap-3 border-b border-slate-100 bg-warm-50/70 p-4 md:grid-cols-[minmax(0,1fr)_190px_170px_auto_auto]">
            <div><label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Cari modul</label><div class="relative"><svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg><input id="q" name="q" value="{{ request('q') }}" placeholder="Nama, deskripsi, bahasa..." class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"></div></div>
            <div><label for="bahasa" class="mb-1.5 block text-xs font-semibold text-slate-600">Bahasa</label><select id="bahasa" name="bahasa" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="">Semua bahasa</option>@foreach ($bahasa as $itemBahasa)<option value="{{ $itemBahasa->id }}" @selected((string) request('bahasa') === (string) $itemBahasa->id)>{{ $itemBahasa->nama_bahasa }}{{ $itemBahasa->status ? '' : ' (Nonaktif)' }}</option>@endforeach</select></div>
            <div><label for="status" class="mb-1.5 block text-xs font-semibold text-slate-600">Status modul</label><select id="status" name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="">Semua status</option><option value="1" @selected(request('status') === '1')>Aktif</option><option value="0" @selected(request('status') === '0')>Nonaktif</option></select></div>
            <div class="flex items-end"><button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700">Filter</button></div>
            <div class="flex items-end"><a href="{{ route('instruktur.modul.index') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a></div>
        </form>

        <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-warm-50"><tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Modul</th><th class="whitespace-nowrap px-5 py-3">Bahasa</th><th class="whitespace-nowrap px-5 py-3">Konten terkait</th><th class="whitespace-nowrap px-5 py-3">Urutan</th><th class="whitespace-nowrap px-5 py-3">Status</th><th class="whitespace-nowrap px-5 py-3 text-right">Aksi</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($modul as $item)
                <tr class="align-top transition hover:bg-warm-50/70">
                    <td class="max-w-md px-5 py-4"><div class="flex items-start gap-3"><span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg></span><div><p class="font-display text-sm font-bold text-slate-800">{{ $item->nama_modul }}</p><p class="mt-1 whitespace-normal break-words text-sm leading-5 text-slate-500">{{ $item->deskripsi ?: 'Belum ada deskripsi.' }}</p><p class="mt-1 text-xs text-slate-400">Dibuat {{ optional($item->created_at)->format('d M Y') ?? '—' }}</p></div></div></td>
                    <td class="whitespace-nowrap px-5 py-4"><p class="text-sm font-semibold text-slate-700">{{ $item->bahasa->nama_bahasa ?? 'Bahasa dihapus' }}</p>@if ($item->bahasa && ! $item->bahasa->status)<p class="mt-1 text-xs text-amber-600">Bahasa nonaktif</p>@endif</td>
                    <td class="whitespace-nowrap px-5 py-4"><p class="text-sm font-semibold text-slate-700">{{ $item->materi_count }} materi</p><p class="mt-1 text-xs text-slate-400">{{ $item->evaluasi_count }} evaluasi</p><p class="mt-1 text-xs text-slate-400">{{ $item->progres_belajar_count }} catatan progres</p></td>
                    <td class="whitespace-nowrap px-5 py-4"><span class="inline-flex min-w-8 justify-center rounded-lg bg-warm-100 px-2.5 py-1 text-sm font-semibold text-slate-700">{{ $item->urutan }}</span></td>
                    <td class="whitespace-nowrap px-5 py-4">@if ($item->status)<span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Aktif</span>@else<span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>Nonaktif</span>@endif</td>
                    <td class="px-5 py-4"><div class="flex flex-wrap items-center justify-end gap-2">
                        <a href="{{ route('instruktur.modul.edit', $item) }}" class="inline-flex items-center rounded-lg border border-slate-200 px-2.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800">Edit</a>
                        <form method="POST" action="{{ route('instruktur.modul.status', $item) }}" onsubmit="return confirm('Yakin ingin {{ $item->status ? 'menonaktifkan' : 'mengaktifkan' }} modul {{ addslashes($item->nama_modul) }}?')">@csrf @method('PATCH')<button type="submit" class="inline-flex items-center rounded-lg border border-amber-200 px-2.5 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-50">{{ $item->status ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                        <form method="POST" action="{{ route('instruktur.modul.destroy', $item) }}" onsubmit="return confirm('PERINGATAN: Hapus modul {{ addslashes($item->nama_modul) }}? Semua materi, media pembelajaran, contoh kode, evaluasi, soal, jawaban dan pengerjaan pelajar, progres belajar, serta sertifikat pada modul ini akan ikut terhapus permanen. Tindakan ini tidak dapat dibatalkan. Lanjutkan?')">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-lg border border-rose-200 px-2.5 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-14 text-center"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg></div><h3 class="mt-4 font-display text-base font-bold text-slate-800">Belum ada modul pembelajaran</h3><p class="mx-auto mt-1 max-w-md text-sm text-slate-500">Tambahkan modul pertama untuk mulai menyusun jalur pembelajaran.</p>@if ($bahasa->isNotEmpty())<a href="{{ route('instruktur.modul.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Tambah Modul Pertama</a>@endif</td></tr>
            @endforelse
            </tbody>
        </table></div>
        @if ($modul->hasPages())<div class="border-t border-slate-100 px-5 py-4">{{ $modul->links() }}</div>@endif
    </div>
</div>
@endsection

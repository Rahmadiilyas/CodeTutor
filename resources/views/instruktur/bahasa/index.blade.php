@extends('layouts.master')

@section('title', 'Kelola Bahasa Pemrograman')
@section('description', 'Kelola bahasa pemrograman untuk materi dan modul pembelajaran.')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
          
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Bahasa Pemrograman</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Kelola bahasa pemrograman yang akan digunakan sebagai dasar modul dan contoh kode pembelajaran.</p>
        </div>
        <a href="{{ route('instruktur.bahasa.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Bahasa
        </a>
    </div>

    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4m0 4h.01M10.3 3.9 1.8 18.2A2 2 0 0 0 3.5 21h17a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0z"/></svg>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-3">
                <div><p class="text-sm font-medium text-slate-500">Total Bahasa</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalBahasa, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Bahasa milik akunmu</p></div>
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="m8 9 3 3-3 3m5 0h3"/></svg></span>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-3">
                <div><p class="text-sm font-medium text-slate-500">Bahasa Aktif</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-emerald-700">{{ number_format($bahasaAktif, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Dapat dipilih untuk konten baru</p></div>
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m5 12 4 4L19 6"/><circle cx="12" cy="12" r="10"/></svg></span>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-3">
                <div><p class="text-sm font-medium text-slate-500">Bahasa Nonaktif</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-amber-700">{{ number_format($bahasaNonaktif, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Data tetap tersimpan</p></div>
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-50 text-amber-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M8 12h8"/></svg></span>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="font-display text-base font-bold text-maroon-950">Daftar Bahasa Pemrograman</h2>
            <p class="mt-1 text-xs text-slate-500">Setiap Instruktur hanya dapat melihat dan mengelola bahasanya sendiri.</p>
        </div>
        <form method="GET" action="{{ route('instruktur.bahasa.index') }}" class="grid gap-3 border-b border-slate-100 bg-warm-50/70 p-4 md:grid-cols-[minmax(0,1fr)_200px_auto_auto]">
            <div>
                <label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Cari bahasa</label>
                <div class="relative"><svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg><input id="q" name="q" value="{{ request('q') }}" placeholder="Nama atau deskripsi..." class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"></div>
            </div>
            <div><label for="status" class="mb-1.5 block text-xs font-semibold text-slate-600">Status</label><select id="status" name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="">Semua status</option><option value="1" @selected(request('status') === '1')>Aktif</option><option value="0" @selected(request('status') === '0')>Nonaktif</option></select></div>
            <div class="flex items-end"><button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg>Filter</button></div>
            <div class="flex items-end"><a href="{{ route('instruktur.bahasa.index') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a></div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-warm-50"><tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Bahasa</th><th class="px-5 py-3">Konten terkait</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Dibuat</th><th class="px-5 py-3 text-right">Aksi</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                @forelse ($bahasa as $item)
                    <tr class="align-top transition hover:bg-warm-50/70">
                        <td class="max-w-md px-5 py-4"><div class="flex items-start gap-3"><span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m8 9-4 3 4 3m8-6 4 3-4 3m-2-9-4 12"/></svg></span><div><p class="font-display text-sm font-bold text-slate-800">{{ $item->nama_bahasa }}</p><p class="mt-1 whitespace-normal break-words text-sm leading-5 text-slate-500">{{ $item->deskripsi ?: 'Belum ada deskripsi.' }}</p></div></div></td>
                        <td class="whitespace-nowrap px-5 py-4"><p class="text-sm font-semibold text-slate-700">{{ $item->modul_count }} modul</p><p class="mt-1 text-xs text-slate-400">{{ $item->contoh_kode_count }} contoh kode</p></td>
                        <td class="whitespace-nowrap px-5 py-4">@if ($item->status)<span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Aktif</span>@else<span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>Nonaktif</span>@endif</td>
                        <td class="whitespace-nowrap px-5 py-4"><p class="text-sm text-slate-600">{{ optional($item->created_at)->format('d M Y') ?? '—' }}</p></td>
                        <td class="px-5 py-4"><div class="flex flex-wrap items-center justify-end gap-2">
                            <a href="{{ route('instruktur.bahasa.edit', $item) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-2.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/></svg>Edit</a>
                            <form method="POST" action="{{ route('instruktur.bahasa.status', $item) }}" onsubmit="return confirm('Yakin ingin {{ $item->status ? 'menonaktifkan' : 'mengaktifkan' }} bahasa {{ addslashes($item->nama_bahasa) }}?')">@csrf @method('PATCH')<button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-amber-200 px-2.5 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-50">{{ $item->status ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                            <form method="POST" action="{{ route('instruktur.bahasa.destroy', $item) }}" onsubmit="return confirm('PERINGATAN: Hapus bahasa {{ addslashes($item->nama_bahasa) }}? Semua modul, materi, media pembelajaran, contoh kode, evaluasi, soal, jawaban dan pengerjaan pelajar, progres belajar, sertifikat, serta riwayat eksekusi kode untuk bahasa ini akan ikut terhapus permanen. Tindakan ini tidak dapat dibatalkan. Lanjutkan?')">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 px-2.5 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button></form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-14 text-center"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="m8 9-4 3 4 3m8-6 4 3-4 3m-2-9-4 12"/></svg></div><h3 class="mt-4 font-display text-base font-bold text-slate-800">Belum ada bahasa pemrograman</h3><p class="mx-auto mt-1 max-w-md text-sm text-slate-500">Tambahkan bahasa pemrograman pertamamu untuk digunakan saat membuat modul dan contoh kode.</p><a href="{{ route('instruktur.bahasa.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Tambah Bahasa Pertama</a></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($bahasa->hasPages())<div class="border-t border-slate-100 px-5 py-4">{{ $bahasa->links() }}</div>@endif
    </div>
</div>
@endsection

@extends('layouts.master')

@section('title', 'Referensi Chatbot')
@section('description', 'Kelola referensi jawaban chatbot CodeTutor.')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <span class="mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700">
                <span class="h-2 w-2 rounded-full bg-gold-500"></span> Administrasi AI
            </span>
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Referensi Chatbot</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Kelola pertanyaan dan jawaban acuan agar referensi chatbot tersimpan rapi dan dapat ditinjau Admin.</p>
        </div>
        <a href="{{ route('admin.referensi-chatbot.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Referensi
        </a>
    </div>

    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <p class="font-semibold">Periksa kembali data yang dimasukkan.</p>
            <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Total referensi</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($totalReferensi, 0, ',', '.') }}</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg></span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Referensi aktif</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($referensiAktif, 0, ',', '.') }}</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m5 12 4 4L19 6"/><circle cx="12" cy="12" r="9"/></svg></span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Referensi nonaktif</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($referensiNonaktif, 0, ',', '.') }}</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-amber-50 text-amber-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M8 12h8"/></svg></span></div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Terhubung ke materi</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($referensiTerhubungMateri, 0, ',', '.') }}</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-gold-100 text-maroon-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v18H6.5A2.5 2.5 0 0 1 4 18.5z"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20"/></svg></span></div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-soft sm:p-5">
        <div class="mb-4"><h2 class="font-display text-base font-bold text-maroon-950">Cari dan filter referensi</h2><p class="mt-1 text-xs text-slate-500">Cari dari pertanyaan, jawaban, materi terkait, atau nama pengelola.</p></div>
        <form method="GET" action="{{ route('admin.referensi-chatbot.index') }}" class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
            <div class="xl:col-span-2"><label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Kata kunci</label><input id="q" name="q" value="{{ request('q') }}" type="search" placeholder="Cari pertanyaan atau jawaban..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"></div>
            <div><label for="status" class="mb-1.5 block text-xs font-semibold text-slate-600">Status</label><select id="status" name="status" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="">Semua status</option><option value="1" @selected(request('status') === '1')>Aktif</option><option value="0" @selected(request('status') === '0')>Nonaktif</option></select></div>
            <div><label for="materi" class="mb-1.5 block text-xs font-semibold text-slate-600">Materi terkait</label><select id="materi" name="materi" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="">Semua materi</option>@foreach ($materiList as $materi)<option value="{{ $materi->id }}" @selected((string) request('materi') === (string) $materi->id)>{{ $materi->judul_materi }}</option>@endforeach</select></div>
            <div class="flex flex-wrap items-center gap-2 md:col-span-2 xl:col-span-4"><button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg>Terapkan Filter</button><a href="{{ route('admin.referensi-chatbot.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a><span class="text-xs text-slate-400 md:ml-auto">{{ $referensi->total() }} referensi ditemukan</span></div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="font-display text-base font-bold text-maroon-950">Daftar referensi chatbot</h2><p class="mt-1 text-xs text-slate-500">Kelola referensi jawaban yang tersimpan pada database.</p></div><span class="w-fit rounded-full bg-warm-100 px-3 py-1 text-xs font-semibold text-maroon-800">{{ $referensi->firstItem() ?? 0 }}–{{ $referensi->lastItem() ?? 0 }} dari {{ $referensi->total() }}</span></div>
        <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-100"><thead class="bg-warm-50"><tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Pertanyaan</th><th class="min-w-[250px] px-5 py-3">Jawaban referensi</th><th class="px-5 py-3">Materi</th><th class="px-5 py-3">Pengelola</th><th class="px-5 py-3">Status</th><th class="px-5 py-3 text-right">Aksi</th></tr></thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($referensi as $item)
                <tr class="align-top transition hover:bg-warm-50/70">
                    <td class="max-w-[300px] px-5 py-4"><p class="whitespace-normal break-words text-sm font-semibold leading-6 text-slate-800">{{ $item->pertanyaan }}</p><p class="mt-1 text-xs text-slate-400">Dibuat {{ $item->created_at?->format('d M Y, H:i') ?? '—' }}</p></td>
                    <td class="max-w-[380px] px-5 py-4"><p class="whitespace-normal break-words text-sm leading-6 text-slate-600">{{ \Illuminate\Support\Str::limit($item->jawaban_referensi, 220) }}</p></td>
                    <td class="px-5 py-4">@if ($item->materi)<span class="inline-flex max-w-[220px] rounded-lg bg-warm-100 px-2.5 py-1 text-xs font-semibold text-maroon-800">{{ $item->materi->judul_materi }}</span>@else<span class="text-xs text-slate-400">Umum / tanpa materi</span>@endif</td>
                    <td class="px-5 py-4">@if ($item->pengguna)<p class="whitespace-nowrap text-sm font-semibold text-slate-700">{{ $item->pengguna->nama }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->pengguna->email }}</p>@else<span class="text-xs text-slate-400">Pengelola tidak tersedia</span>@endif</td>
                    <td class="px-5 py-4">@if ($item->status)<span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Aktif</span>@else<span class="inline-flex rounded-full border border-slate-200 bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">Nonaktif</span>@endif</td>
                    <td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="{{ route('admin.referensi-chatbot.edit', $item) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/></svg>Edit</a>
                        <form action="{{ route('admin.referensi-chatbot.status', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin {{ $item->status ? 'menonaktifkan' : 'mengaktifkan' }} referensi ini?')">@csrf @method('PATCH')<button type="submit" class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50">{{ $item->status ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                        <form action="{{ route('admin.referensi-chatbot.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus referensi chatbot ini secara permanen?')">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-600 transition hover:bg-rose-50">Hapus</button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-14 text-center"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="4" width="18" height="14" rx="2"/><path d="M8 22h8M12 18v4"/></svg></div><h3 class="mt-4 font-display text-base font-bold text-slate-800">Belum ada referensi chatbot</h3><p class="mx-auto mt-1 max-w-md text-sm text-slate-500">Tambahkan pertanyaan dan jawaban referensi pertama, atau ubah filter pencarian jika data belum terlihat.</p><a href="{{ route('admin.referensi-chatbot.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700">Tambah Referensi Pertama</a></td></tr>
            @endforelse
        </tbody></table></div>
        @if ($referensi->hasPages())<div class="border-t border-slate-100 px-5 py-4">{{ $referensi->links() }}</div>@endif
    </div>
    <p class="text-xs leading-5 text-slate-400">
    Referensi aktif dapat digunakan oleh chatbot ketika relevan dengan
    pertanyaan Pelajar. Sistem memilih maksimal tiga referensi berdasarkan
    kecocokan kata kunci.
</p>
</div>
@endsection

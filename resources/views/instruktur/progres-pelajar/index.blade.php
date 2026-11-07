@extends('layouts.master')

@section('title', 'Progres Pelajar')
@section('description', 'Pantau progres Pelajar pada modul yang dikelola Instruktur.')
@section('page_label', 'Area Instruktur')
@section('page_heading', 'Progres Pelajar')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 pb-10">
    <section class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 p-6 text-white shadow-card sm:p-8">
        <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border-[32px] border-gold-400/10"></div>
        <div class="relative flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div><span class="inline-flex rounded-full border border-gold-400/20 bg-white/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.15em] text-gold-300">Pemantauan Pembelajaran</span><h1 class="mt-4 font-display text-2xl font-extrabold sm:text-3xl">Progres Pelajar</h1><p class="mt-2 max-w-2xl text-sm leading-6 text-white/65">Lihat modul dan materi yang telah diselesaikan serta rata-rata nilai Posttest Pelajar pada modul yang Anda kelola.</p></div>
            <a href="{{ route('instruktur.modul.index') }}" class="inline-flex rounded-xl bg-gold-400 px-4 py-3 text-xs font-extrabold text-maroon-950 hover:bg-gold-300">Lihat Modul Saya</a>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([['Modul Dikelola', $totalModul], ['Pelajar Terpantau', $totalPelajar], ['Rata-rata Progres', number_format(min(100, max(0, $rataProgres)), 1, ',', '.') . '%'], ['Modul Selesai', $modulSelesai]] as $stat)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft"><p class="text-xs font-semibold text-slate-500">{{ $stat[0] }}</p><p class="mt-2 font-display text-3xl font-extrabold text-maroon-950">{{ $stat[1] }}</p></div>
        @endforeach
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-soft sm:p-5">
        <form method="GET" action="{{ route('progress') }}" class="flex flex-col gap-3 sm:flex-row">
            <div class="flex-1"><label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Cari Pelajar</label><input id="q" name="q" value="{{ request('q') }}" type="search" placeholder="Nama atau email Pelajar..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm focus:border-maroon-400 focus:outline-none focus:ring-4 focus:ring-maroon-100"></div>
            <div class="flex items-end gap-2"><button class="rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Cari</button><a href="{{ route('progress') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Reset</a></div>
        </form>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="font-display text-lg font-extrabold text-maroon-950">Daftar Pelajar Terpantau</h2><p class="mt-1 text-xs text-slate-500">Data dibatasi pada modul yang dikelola oleh akun Instruktur ini.</p></div><span class="w-fit rounded-full bg-warm-100 px-3 py-1 text-xs font-semibold text-maroon-800">{{ $pelajar->total() }} Pelajar</span></div>
        <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-100"><thead class="bg-warm-50"><tr class="text-left text-[10px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Pelajar</th><th class="px-5 py-3">Modul</th><th class="px-5 py-3">Materi selesai</th><th class="min-w-44 px-5 py-3">Rata-rata progres</th><th class="px-5 py-3">Rata-rata nilai Posttest</th><th class="px-5 py-3">Aksi</th></tr></thead><tbody class="divide-y divide-slate-100">
            @forelse ($pelajar as $akun)
                @php($ringkasan = $akun->ringkasan_progres)
                <tr class="hover:bg-warm-50/60"><td class="px-5 py-4"><p class="text-sm font-bold text-slate-800">{{ $akun->nama }}</p><p class="mt-1 text-xs text-slate-400">{{ $akun->email }}</p></td><td class="px-5 py-4"><div class="min-w-[180px] max-w-xs">@if ($akun->rincian_progres_modul->isNotEmpty())<p class="text-xs font-semibold leading-5 text-slate-700">{{ $akun->rincian_progres_modul->pluck('modul.nama_modul')->filter()->take(3)->implode(', ') }}</p><p class="mt-1 text-[10px] text-slate-400">{{ $ringkasan['jumlah_modul_selesai'] }} dari {{ $ringkasan['jumlah_modul'] }} modul selesai</p>@else<p class="text-xs text-slate-400">Belum ada modul</p>@endif</div></td><td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700">{{ $ringkasan['materi_selesai'] }} / {{ $ringkasan['total_materi'] }}</td><td class="min-w-44 px-5 py-4"><div class="flex justify-between text-xs"><strong class="text-maroon-800">{{ number_format($ringkasan['rata_progres'], 1, ',', '.') }}%</strong><span class="text-slate-400">rata-rata</span></div><div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-gradient-to-r from-maroon-700 to-gold-500" style="width: {{ min(100, max(0, $ringkasan['rata_progres'])) }}%"></div></div></td><td class="whitespace-nowrap px-5 py-4">@if ($ringkasan['rata_nilai_posttest'] !== null)<strong class="text-sm text-maroon-900">{{ number_format($ringkasan['rata_nilai_posttest'], 1, ',', '.') }}/100</strong><span class="mt-1 block text-[10px] text-slate-400">{{ $ringkasan['jumlah_posttest'] }} Posttest</span>@else<span class="text-xs text-slate-400">Belum ada nilai</span>@endif</td><td class="px-5 py-4"><a href="{{ route('progress.pelajar.show', $akun) }}" class="inline-flex whitespace-nowrap rounded-lg bg-maroon-800 px-3 py-2 text-xs font-bold text-white hover:bg-maroon-700">Lihat Detail →</a></td></tr>
            @empty
                <tr><td colspan="6" class="px-5 py-12 text-center"><p class="font-bold text-slate-700">Belum ada Pelajar terpantau</p><p class="mt-1 text-sm text-slate-500">Data tampil setelah Pelajar mulai menyelesaikan materi di modul yang Anda kelola.</p></td></tr>
            @endforelse
        </tbody></table></div>
        @if ($pelajar->hasPages())<div class="border-t border-slate-100 p-5">{{ $pelajar->links() }}</div>@endif
    </section>
</div>
@endsection

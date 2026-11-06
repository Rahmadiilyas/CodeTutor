@extends('layouts.master')

@section('title', 'Progres Pelajar')
@section('description', 'Pantau progres modul, materi, dan hasil Posttest seluruh Pelajar CodeTutor.')
@section('page_label', 'Administrasi Pembelajaran')
@section('page_heading', 'Progres Pelajar')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 pb-10">
    <section class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 p-6 text-white shadow-card sm:p-8">
        <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border-[32px] border-gold-400/10"></div>
        <div class="relative">
            <span class="inline-flex rounded-full border border-gold-400/20 bg-white/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.15em] text-gold-300">Monitoring Pembelajaran</span>
            <h1 class="mt-4 font-display text-2xl font-extrabold sm:text-3xl">Progres Seluruh Pelajar</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-white/65">Pantau modul dan materi yang telah diselesaikan, rata-rata progres belajar, serta pencapaian Posttest setiap Pelajar.</p>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([['Total Pelajar', $totalPelajar, 'Akun Pelajar'], ['Pelajar Aktif', $pelajarAktif, 'Akun berstatus aktif'], ['Pelajar dengan Progres', $pelajarMemilikiProgres, 'Memiliki catatan modul'], ['Posttest Dikumpulkan', $totalEvaluasiSelesai, 'Seluruh pengerjaan Posttest']] as $stat)
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
                <p class="text-xs font-semibold text-slate-500">{{ $stat[0] }}</p>
                <p class="mt-2 font-display text-3xl font-extrabold text-maroon-950">{{ number_format((int) $stat[1], 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-400">{{ $stat[2] }}</p>
            </div>
        @endforeach
    </section>

    <section class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-soft sm:p-5">
        <form method="GET" action="{{ route('admin.progres-pelajar.index') }}" class="grid gap-3 md:grid-cols-[minmax(0,1fr)_210px_auto_auto]">
            <div>
                <label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Cari nama atau email Pelajar</label>
                <input id="q" name="q" value="{{ request('q') }}" type="search" placeholder="Masukkan nama atau email..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
            </div>
            <div>
                <label for="status_akun" class="mb-1.5 block text-xs font-semibold text-slate-600">Status akun</label>
                <select id="status_akun" name="status_akun" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    <option value="">Semua status</option>
                    <option value="aktif" @selected(request('status_akun') === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(request('status_akun') === 'nonaktif')>Nonaktif</option>
                </select>
            </div>
            <div class="flex items-end"><button class="w-full rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700 md:w-auto">Terapkan</button></div>
            <div class="flex items-end"><a href="{{ route('admin.progres-pelajar.index') }}" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50 md:w-auto">Reset</a></div>
        </form>
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div><h2 class="font-display text-lg font-extrabold text-maroon-950">Daftar Progres Pelajar</h2><p class="mt-1 text-xs text-slate-500">Pilih Detail untuk melihat rincian modul, materi, dan hasil Posttest satu Pelajar.</p></div>
            <span class="w-fit rounded-full bg-warm-100 px-3 py-1 text-xs font-semibold text-maroon-800">{{ $pelajar->total() }} Pelajar ditemukan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-warm-50"><tr class="text-left text-[10px] font-bold uppercase tracking-wider text-slate-500">
                    <th class="whitespace-nowrap px-5 py-3">Pelajar</th><th class="whitespace-nowrap px-5 py-3">Modul</th><th class="whitespace-nowrap px-5 py-3">Materi selesai</th><th class="min-w-44 px-5 py-3">Rata-rata progres</th><th class="whitespace-nowrap px-5 py-3">Rata-rata nilai Posttest</th><th class="px-5 py-3">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pelajar as $akun)
                        @php($ringkasan = $akun->ringkasan_progres)
                        <tr class="align-middle hover:bg-warm-50/60">
                            <td class="px-5 py-4"><div class="flex min-w-[220px] items-center gap-3">
                                @if ($akun->foto)<img src="{{ asset('storage/' . $akun->foto) }}" alt="Foto {{ $akun->nama }}" class="h-10 w-10 rounded-full object-cover">@else<span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-maroon-50 font-bold text-maroon-800">{{ strtoupper(substr($akun->nama ?? 'P', 0, 1)) }}</span>@endif
                                <div class="min-w-0"><p class="truncate text-sm font-bold text-slate-800">{{ $akun->nama }}</p><p class="truncate text-xs text-slate-400">{{ $akun->email }}</p><span class="mt-1 inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $akun->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $akun->status ? 'Aktif' : 'Nonaktif' }}</span></div>
                            </div></td>
                            <td class="px-5 py-4"><div class="min-w-[180px] max-w-xs">@if ($akun->rincian_progres_modul->isNotEmpty())<p class="text-xs font-semibold leading-5 text-slate-700">{{ $akun->rincian_progres_modul->pluck('modul.nama_modul')->filter()->take(3)->implode(', ') }}</p><p class="mt-1 text-[10px] text-slate-400">{{ $ringkasan['jumlah_modul_selesai'] }} dari {{ $ringkasan['jumlah_modul'] }} modul selesai</p>@else<p class="text-xs text-slate-400">Belum ada modul</p>@endif</div></td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-700">{{ $ringkasan['materi_selesai'] }} / {{ $ringkasan['total_materi'] }}</td>
                            <td class="min-w-44 px-5 py-4"><div class="flex items-center justify-between text-xs"><strong class="text-maroon-800">{{ number_format($ringkasan['rata_progres'], 1, ',', '.') }}%</strong><span class="text-slate-400">rata-rata</span></div><div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-gradient-to-r from-maroon-700 to-gold-500" style="width: {{ min(100, max(0, $ringkasan['rata_progres'])) }}%"></div></div></td>
                            <td class="whitespace-nowrap px-5 py-4">@if ($ringkasan['rata_nilai_posttest'] !== null)<strong class="text-sm text-maroon-900">{{ number_format($ringkasan['rata_nilai_posttest'], 1, ',', '.') }}/100</strong><span class="mt-1 block text-[10px] text-slate-400">{{ $ringkasan['jumlah_posttest'] }} Posttest dikumpulkan</span>@else<span class="text-xs text-slate-400">Belum ada nilai</span>@endif</td>
                            <td class="px-5 py-4"><a href="{{ route('admin.progres-pelajar.show', $akun) }}" class="inline-flex whitespace-nowrap items-center gap-1 rounded-lg bg-maroon-800 px-3 py-2 text-xs font-bold text-white hover:bg-maroon-700">Lihat Detail <span aria-hidden="true">→</span></a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center"><p class="font-bold text-slate-700">Pelajar tidak ditemukan</p><p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci atau filter pencarian.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pelajar->hasPages())<div class="border-t border-slate-100 p-5">{{ $pelajar->links() }}</div>@endif
    </section>
</div>
@endsection

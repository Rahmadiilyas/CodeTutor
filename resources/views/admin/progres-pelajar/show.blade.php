@extends('layouts.master')

@section('title', 'Detail Progres Pelajar')
@section('description', 'Rincian modul, materi selesai, dan hasil Posttest Pelajar.')
@section('page_label', 'Administrator')
@section('page_heading', 'Detail Progres Pelajar')

@section('content')
@php($modules = $pelajar->rincian_progres_modul)
<div class="mx-auto max-w-6xl space-y-6 pb-10">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"><div><a href="{{ route('admin.progres-pelajar.index') }}" class="text-xs font-bold text-maroon-700 hover:text-gold-700">Kembali ke daftar Pelajar</a><h1 class="mt-3 font-display text-2xl font-extrabold text-maroon-950">{{ $pelajar->nama }}</h1><p class="mt-1 text-sm text-slate-500">{{ $pelajar->email }} · Detail progres pembelajaran</p></div><span class="w-fit rounded-full px-3 py-1.5 text-xs font-bold {{ $pelajar->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $pelajar->status ? 'Akun Aktif' : 'Akun Nonaktif' }}</span></div>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([['Modul dipantau', $ringkasan['jumlah_modul']], ['Materi selesai', $ringkasan['materi_selesai'] . ' / ' . $ringkasan['total_materi']], ['Rata-rata progres', number_format($ringkasan['rata_progres'], 1, ',', '.') . '%'], ['Rata-rata nilai Posttest', $ringkasan['rata_nilai_posttest'] !== null ? number_format($ringkasan['rata_nilai_posttest'], 1, ',', '.') . '/100' : '—']] as $stat)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft"><p class="text-xs font-semibold text-slate-500">{{ $stat[0] }}</p><p class="mt-2 font-display text-2xl font-extrabold text-maroon-950">{{ $stat[1] }}</p></div>
        @endforeach
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft sm:p-6">
        <div class="mb-5"><h2 class="font-display text-lg font-extrabold text-maroon-950">Progres Modul dan Materi</h2><p class="mt-1 text-xs text-slate-500">Materi berstatus selesai berdasarkan aktivitas penyelesaian yang tercatat di sistem.</p></div>
        @forelse ($modules->groupBy('nama_bahasa') as $namaBahasa => $daftarModul)
            <div class="mb-5 last:mb-0"><div class="mb-3 flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-gold-500"></span><h3 class="font-bold text-maroon-900">{{ $namaBahasa }}</h3></div>
                <div class="space-y-3">
                    @foreach ($daftarModul as $baris)
                        <article class="rounded-xl border border-slate-200 p-4">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"><div><h4 class="font-bold text-slate-800">{{ $baris['modul']->nama_modul }}</h4><p class="mt-1 text-xs text-slate-500">{{ $baris['materi_selesai'] }} dari {{ $baris['jumlah_materi'] }} materi selesai</p></div><span class="text-sm font-extrabold text-maroon-800">{{ number_format($baris['persentase'], 1, ',', '.') }}%</span></div>
                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-gradient-to-r from-maroon-700 to-gold-500" style="width: {{ $baris['persentase'] }}%"></div></div>
                            @if ($baris['materi']->isNotEmpty())<div class="mt-4 grid gap-2 sm:grid-cols-2">@foreach ($baris['materi'] as $materi)<div class="flex items-start gap-2 rounded-lg bg-warm-50 px-3 py-2 text-xs"><span class="mt-0.5 {{ $materi->sudah_selesai ? 'text-emerald-600' : 'text-slate-300' }}">{{ $materi->sudah_selesai ? '✓' : '○' }}</span><span class="{{ $materi->sudah_selesai ? 'font-semibold text-slate-700' : 'text-slate-500' }}">{{ $materi->judul_materi }}</span><span class="ml-auto shrink-0 text-[10px] {{ $materi->sudah_selesai ? 'text-emerald-700' : 'text-slate-400' }}">{{ $materi->sudah_selesai ? 'Selesai' : 'Belum' }}</span></div>@endforeach</div>@else<p class="mt-3 text-xs text-slate-400">Belum ada materi aktif pada modul ini.</p>@endif
                        </article>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-slate-200 px-5 py-10 text-center"><p class="font-bold text-slate-700">Belum ada progres modul</p><p class="mt-1 text-sm text-slate-500">Progres akan tampil setelah Pelajar menyelesaikan materi.</p></div>
        @endforelse
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
        <div class="border-b border-slate-100 p-5"><h2 class="font-display text-lg font-extrabold text-maroon-950">Hasil Posttest</h2><p class="mt-1 text-xs text-slate-500">Hanya hasil Posttest yang ditampilkan pada pemantauan Admin.</p></div>
        <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-100"><thead class="bg-warm-50"><tr class="text-left text-[10px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Evaluasi</th><th class="px-5 py-3">Modul</th><th class="px-5 py-3">Nilai</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Tanggal dikumpulkan</th></tr></thead><tbody class="divide-y divide-slate-100">
            @forelse ($pelajar->rincian_posttest as $hasil)
                @php($menunggu = $hasil->status === 'menunggu_penilaian' || ($hasil->waktu_selesai && $hasil->nilai === null))
                <tr><td class="px-5 py-4 text-sm font-semibold text-slate-800">{{ $hasil->evaluasi->judul_evaluasi ?? 'Posttest' }}</td><td class="px-5 py-4 text-sm text-slate-600">{{ $hasil->evaluasi->modul->nama_modul ?? '—' }}</td><td class="px-5 py-4 text-sm font-bold text-maroon-900">{{ $hasil->nilai !== null ? number_format((float) $hasil->nilai, 1, ',', '.') . '/100' : '—' }}</td><td class="px-5 py-4 text-xs {{ $menunggu ? 'font-semibold text-sky-700' : 'text-emerald-700' }}">{{ $menunggu ? 'Menunggu penilaian' : 'Dikumpulkan' }}</td><td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500">{{ $hasil->waktu_selesai ? \Illuminate\Support\Carbon::parse($hasil->waktu_selesai)->format('d M Y, H:i') : '—' }}</td></tr>
            @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">Belum ada hasil Posttest.</td></tr>
            @endforelse
        </tbody></table></div>
    </section>
</div>
@endsection

@extends('layouts.master')

@section('title', 'Progres Belajar')
@section('description', 'Pantau progres modul, materi, dan hasil Pretest serta Posttest.')
@section('page_label', 'Area Pelajar')
@section('page_heading', 'Progres Belajar')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 pb-10">
    <section class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 p-6 text-white shadow-card sm:p-8">
        <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border-[32px] border-gold-400/10"></div>
        <div class="relative"><span class="inline-flex rounded-full border border-gold-400/20 bg-white/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.15em] text-gold-300">Perjalanan Belajarmu</span><h1 class="mt-4 font-display text-2xl font-extrabold sm:text-3xl">Progres Belajar</h1><p class="mt-2 max-w-2xl text-sm leading-6 text-white/65">Lihat perkembangan setiap bahasa pemrograman, modul dan materi yang sudah dipelajari, serta hasil Pretest dan Posttest secara terpisah.</p></div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([['Modul dipelajari', $ringkasan['jumlah_modul']], ['Materi selesai', $ringkasan['materi_selesai'] . ' / ' . $ringkasan['total_materi']], ['Rata-rata progres modul', number_format($ringkasan['rata_progres'], 1, ',', '.') . '%'], ['Rata-rata nilai Posttest', $ringkasan['rata_nilai_posttest'] !== null ? number_format($ringkasan['rata_nilai_posttest'], 1, ',', '.') . '/100' : '—']] as $stat)
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><p class="text-xs font-semibold text-slate-500">{{ $stat[0] }}</p><p class="mt-2 font-display text-2xl font-extrabold text-maroon-950">{{ $stat[1] }}</p></div>
        @endforeach
    </section>

    <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-6">
        <div class="mb-5"><h2 class="font-display text-lg font-extrabold text-maroon-950">Progres Bahasa Pemrograman</h2><p class="mt-1 text-xs text-slate-500">Modul dikelompokkan berdasarkan bahasa pemrograman dan dihitung dari materi yang telah ditandai selesai.</p></div>
        @forelse ($modul->groupBy('nama_bahasa') as $namaBahasa => $daftarModul)
            <div class="mb-6 last:mb-0"><div class="mb-3 flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-gold-500"></span><h3 class="font-bold text-maroon-900">{{ $namaBahasa }}</h3><span class="text-[10px] text-slate-400">{{ $daftarModul->count() }} modul</span></div>
                <div class="grid gap-4 xl:grid-cols-2">
                    @foreach ($daftarModul as $baris)
                        <article class="rounded-2xl border border-slate-200 p-4 sm:p-5">
                            <div class="flex items-start justify-between gap-3"><div><h4 class="font-display text-base font-extrabold text-maroon-950">{{ $baris['modul']->nama_modul }}</h4><p class="mt-1 text-xs text-slate-500">{{ $baris['materi_selesai'] }} dari {{ $baris['jumlah_materi'] }} materi selesai</p></div><span class="rounded-full bg-warm-100 px-2.5 py-1 text-xs font-bold text-maroon-800">{{ number_format($baris['persentase'], 0, ',', '.') }}%</span></div>
                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-gradient-to-r from-maroon-700 to-gold-500" style="width: {{ $baris['persentase'] }}%"></div></div>
                            <div class="mt-4 space-y-2">
                                @forelse ($baris['materi'] as $materi)
                                    <div class="flex items-start gap-2 text-xs"><span class="mt-0.5 {{ $materi->sudah_selesai ? 'text-emerald-600' : 'text-slate-300' }}">{{ $materi->sudah_selesai ? '✓' : '○' }}</span><span class="flex-1 {{ $materi->sudah_selesai ? 'font-medium text-slate-700' : 'text-slate-500' }}">{{ $materi->judul_materi }}</span><span class="text-[10px] {{ $materi->sudah_selesai ? 'text-emerald-700' : 'text-slate-400' }}">{{ $materi->sudah_selesai ? 'Selesai' : 'Belum dipelajari' }}</span></div>
                                @empty
                                    <p class="text-xs text-slate-400">Belum ada materi aktif di modul ini.</p>
                                @endforelse
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-slate-200 px-5 py-12 text-center"><p class="font-bold text-slate-700">Belum ada progres modul</p><p class="mt-1 text-sm text-slate-500">Mulai pelajari materi agar perkembangan belajarmu tercatat di sini.</p><a href="{{ route('materi') }}" class="mt-4 inline-flex rounded-xl bg-maroon-800 px-4 py-2.5 text-xs font-bold text-white hover:bg-maroon-700">Mulai Belajar</a></div>
        @endforelse
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="border-b border-slate-100 p-5 sm:p-6"><h2 class="font-display text-lg font-extrabold text-maroon-950">Hasil Evaluasi</h2><p class="mt-1 text-xs text-slate-500">Pretest dan Posttest ditampilkan pada tab berbeda agar hasil latihan awal dan evaluasi akhir tidak tercampur.</p>
            <div class="mt-5 grid grid-cols-2 gap-2 rounded-xl bg-warm-50 p-1.5">
                <button type="button" data-progress-tab="pretest" aria-selected="true" class="progress-tab rounded-lg bg-white px-3 py-3 text-sm font-extrabold text-maroon-900 shadow-sm">Pretest <span class="ml-1 text-xs text-slate-400">({{ $pretest->count() }})</span></button>
                <button type="button" data-progress-tab="posttest" aria-selected="false" class="progress-tab rounded-lg px-3 py-3 text-sm font-extrabold text-slate-500 transition hover:text-maroon-800">Posttest <span class="ml-1 text-xs text-slate-400">({{ $posttest->count() }})</span></button>
            </div>
        </div>
        <div id="progress-panel-pretest" class="progress-panel p-5 sm:p-6">
            <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 p-4"><p class="text-sm font-bold text-amber-900">Pretest · Latihan sebelum pembelajaran</p><p class="mt-1 text-xs leading-5 text-amber-800">Gunakan hasil Pretest untuk melihat pemahaman awal sebelum mempelajari materi. Nilai Pretest tidak digabung dengan nilai Posttest.</p><a href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => 'pretest']) }}" class="mt-3 inline-flex text-xs font-extrabold text-amber-900 underline underline-offset-2">Lihat daftar Pretest</a></div>
            @include('progres.partials.evaluasi-list', ['daftarEvaluasi' => $pretest, 'jenis' => 'Pretest'])
        </div>
        <div id="progress-panel-posttest" class="progress-panel hidden p-5 sm:p-6">
            <div class="mb-4 rounded-xl border border-maroon-100 bg-maroon-50 p-4"><p class="text-sm font-bold text-maroon-900">Posttest · Evaluasi setelah pembelajaran</p><p class="mt-1 text-xs leading-5 text-maroon-700">Hasil Posttest digunakan untuk melihat pencapaian setelah mempelajari materi dan menjadi hasil evaluasi yang dipantau Instruktur.</p><a href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => 'posttest']) }}" class="mt-3 inline-flex text-xs font-extrabold text-maroon-900 underline underline-offset-2">Lihat daftar Posttest</a></div>
            @include('progres.partials.evaluasi-list', ['daftarEvaluasi' => $posttest, 'jenis' => 'Posttest'])
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('[data-progress-tab]');
    const panels = {
        pretest: document.getElementById('progress-panel-pretest'),
        posttest: document.getElementById('progress-panel-posttest')
    };
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const selected = tab.dataset.progressTab;
            tabs.forEach(function (item) {
                const active = item === tab;
                item.setAttribute('aria-selected', active ? 'true' : 'false');
                item.classList.toggle('bg-white', active);
                item.classList.toggle('shadow-sm', active);
                item.classList.toggle('text-maroon-900', active);
                item.classList.toggle('text-slate-500', !active);
            });
            Object.keys(panels).forEach(function (key) {
                panels[key].classList.toggle('hidden', key !== selected);
            });
        });
    });
});
</script>
@endpush

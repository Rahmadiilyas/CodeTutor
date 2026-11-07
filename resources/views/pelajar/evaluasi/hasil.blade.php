@extends('layouts.master')

@section('title', 'Hasil Evaluasi')
@section('description', 'Lihat nilai dan rincian hasil evaluasi pembelajaran CodeTutor.')

@section('content')
@php
    $daftarRincianSoal = $rincianSoal ?? [];
    $jumlahRincianSoal = is_countable($daftarRincianSoal) ? count($daftarRincianSoal) : 0;
    $flashType = session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : null));
    $flashMessage = session('success') ?? session('error') ?? session('info');
    $isPretest = $evaluasi->jenis_evaluasi === 'pretest';
    $labelJenis = [
        'pretest' => 'Pretest',
        'kuis' => 'Kuis',
        'posttest' => 'Posttest',
    ];
@endphp

<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700">
                <span class="h-2 w-2 rounded-full bg-gold-500"></span> Evaluasi pembelajaran
            </div>
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">{{ $isPretest ? 'Hasil Latihan Pretest' : 'Hasil Posttest' }}</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">{{ $isPretest ? 'Lihat hasil latihan awalmu dan gunakan sebagai panduan untuk menentukan materi yang perlu dipelajari kembali.' : 'Periksa nilai dan rincian jawaban Posttest yang telah kamu kumpulkan. Hasil ini juga diteruskan ke area Instruktur.' }}</p>
        </div>
        <a href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => $evaluasi->jenis_evaluasi]) }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Kembali ke Evaluasi
        </a>
    </div>


    <section class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-soft">
        <div class="{{ $isPretest ? 'bg-gradient-to-br from-amber-700 via-amber-800 to-orange-900' : 'bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-800' }} p-6 text-white sm:p-8">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-lg border border-white/15 bg-white/10 px-2.5 py-1 text-xs font-semibold"><?php echo e($labelJenis[$evaluasi->jenis_evaluasi] ?? ucfirst($evaluasi->jenis_evaluasi)); ?></span>
                        <span class="rounded-lg border border-white/15 bg-white/10 px-2.5 py-1 text-xs font-semibold"><?php echo e($evaluasi->modul->nama_modul ?? 'Modul'); ?></span>
                    </div>
                    <h2 class="mt-4 font-display text-2xl font-extrabold leading-tight sm:text-3xl"><?php echo e($evaluasi->judul_evaluasi); ?></h2>
                    <p class="mt-2 max-w-2xl whitespace-pre-line text-sm leading-6 text-white/65"><?php echo e($evaluasi->deskripsi ?: 'Tidak ada deskripsi tambahan.'); ?></p>
                </div>
                <div class="shrink-0 rounded-2xl border border-white/10 bg-white/[.06] px-5 py-4 sm:min-w-40">
                    <p class="text-xs font-semibold uppercase tracking-wider text-white/55">{{ $isPretest ? 'Nilai latihan' : 'Nilai Posttest' }}</p>
                    <?php if ($menungguPenilaian): ?>
                        <p class="mt-2 font-display text-2xl font-extrabold">—</p>
                        <p class="mt-1 text-xs text-white/60">Menunggu penilaian</p>
                    <?php else: ?>
                        <p class="mt-2 font-display text-4xl font-extrabold"><?php echo e(number_format($nilai, 0, ',', '.')); ?><span class="text-lg text-white/55">/100</span></p>
                        <p class="mt-1 text-xs text-white/60">Nilai minimal <?php echo e($nilaiMinimal); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid gap-4 p-5 sm:grid-cols-3 sm:p-6">
            <div class="rounded-2xl border border-slate-200 bg-warm-50 p-4">
                <p class="text-xs font-semibold text-slate-500">Status hasil</p>
                <?php if ($menungguPenilaian): ?>
                    <p class="mt-2 inline-flex items-center gap-2 text-sm font-bold text-sky-800"><span class="h-2 w-2 rounded-full bg-sky-500"></span> Menunggu penilaian</p>
                    <p class="mt-1 text-xs leading-5 text-slate-500">Essay atau coding perlu diperiksa Instruktur.</p>
                <?php elseif ($lulus): ?>
                    <p class="mt-2 inline-flex items-center gap-2 text-sm font-bold text-emerald-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16.5 9"/></svg> Lulus</p>
                    <p class="mt-1 text-xs leading-5 text-slate-500">{{ $isPretest ? 'Hasil latihan awalmu mencapai batas nilai yang ditetapkan.' : 'Nilai Posttest mencapai batas minimal.' }}</p>
                <?php else: ?>
                    <p class="mt-2 inline-flex items-center gap-2 text-sm font-bold text-rose-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m15 9-6 6m0-6 6 6"/></svg> Belum lulus</p>
                    <p class="mt-1 text-xs leading-5 text-slate-500">{{ $isPretest ? 'Gunakan hasil latihan ini untuk mempelajari materi yang belum dikuasai.' : 'Nilai Posttest belum mencapai batas minimal.' }}</p>
                <?php endif; ?>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-warm-50 p-4">
                <p class="text-xs font-semibold text-slate-500">Waktu mulai</p>
                <p class="mt-2 text-sm font-bold text-maroon-950"><?php echo e($pengerjaan->waktu_mulai ? \Carbon\Carbon::parse($pengerjaan->waktu_mulai)->format('d M Y, H:i') : '—'); ?></p>
                <p class="mt-1 text-xs text-slate-500">Waktu pengerjaan dimulai</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-warm-50 p-4">
                <p class="text-xs font-semibold text-slate-500">Waktu dikumpulkan</p>
                <p class="mt-2 text-sm font-bold text-maroon-950"><?php echo e($pengerjaan->waktu_selesai ? \Carbon\Carbon::parse($pengerjaan->waktu_selesai)->format('d M Y, H:i') : '—'); ?></p>
                <p class="mt-1 text-xs text-slate-500">Nilai minimal: <?php echo e($nilaiMinimal); ?></p>
            </div>
        </div>
    </section>

    <?php if ($menungguPenilaian): ?>
        <div class="flex gap-3 rounded-2xl border border-sky-200 bg-sky-50 p-4 text-sm leading-6 text-sky-900">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
            <div><p class="font-bold">Nilai akhir belum tersedia</p><p class="mt-1 text-sky-800">Evaluasi berisi soal essay/coding atau masih menunggu penilaian. Status lulus atau belum lulus baru ditentukan setelah nilai akhir disimpan.</p></div>
        </div>
    <?php endif; ?>

    <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <h2 class="font-display text-lg font-extrabold text-maroon-950">{{ $isPretest ? 'Pembahasan hasil latihan' : 'Rincian jawaban Posttest' }}</h2>
            <p class="mt-1 text-xs text-slate-500">{{ $isPretest ? 'Semua soal Pretest berupa pilihan ganda dan dikoreksi otomatis. Hasil ini hanya untuk membantu kamu belajar.' : 'Jawaban pilihan ganda dikoreksi otomatis, sedangkan essay dan coding menampilkan hasil penilaian Instruktur.' }}</p>
        </div>

        <div class="divide-y divide-slate-100">
            <?php if ($jumlahRincianSoal > 0): ?>
                <?php foreach ($daftarRincianSoal as $index => $item): ?>
                    <?php
                        $soal = $item['soal'] ?? null;
                        $jawaban = $item['jawaban'] ?? null;
                        if (!$soal) {
                            continue;
                        }
                        $isPilihanGanda = $soal->jenis_soal === 'pilihan_ganda';
                        $jawabanBenar = $jawaban && $jawaban->benar !== null && (bool) $jawaban->benar;
                        $menungguPenilaianSoal = (bool) ($item['menunggu_penilaian'] ?? false);
                        $poinDiperoleh = $item['poin_diperoleh'] ?? 0;
                        $pilihanBenar = $item['pilihan_benar'] ?? null;
                        $pilihanJawaban = $jawaban->pilihan ?? null;
                    ?>
                    <article class="p-5 sm:p-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="rounded-lg bg-warm-100 px-2.5 py-1 text-xs font-bold text-maroon-800">Soal <?php echo e($index + 1); ?></span>
                                    <span class="rounded-lg border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-500"><?php echo e(['pilihan_ganda' => 'Pilihan ganda', 'essay' => 'Essay', 'coding' => 'Coding'][$soal->jenis_soal] ?? ucfirst($soal->jenis_soal)); ?></span>
                                </div>
                                <p class="mt-3 whitespace-pre-line text-sm font-semibold leading-6 text-slate-800"><?php echo e($soal->pertanyaan); ?></p>
                            </div>
                            <?php if ($menungguPenilaianSoal): ?>
                                <span class="w-fit shrink-0 rounded-lg border border-sky-200 bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-800">Menunggu penilaian</span>
                            <?php elseif (in_array($soal->jenis_soal, ['essay', 'coding'], true)): ?>
                                <span class="w-fit shrink-0 rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Dinilai · +<?php echo e($poinDiperoleh); ?> poin</span>
                            <?php elseif ($jawabanBenar): ?>
                                <span class="w-fit shrink-0 rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Benar · +<?php echo e($poinDiperoleh); ?> poin</span>
                            <?php else: ?>
                                <span class="w-fit shrink-0 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">Salah · +<?php echo e($poinDiperoleh); ?> poin</span>
                            <?php endif; ?>
                        </div>

                        <?php if ($isPilihanGanda): ?>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-3.5">
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Jawaban kamu</p>
                                    <p class="mt-1.5 whitespace-pre-line text-sm text-slate-700"><?php echo e($pilihanJawaban->teks_pilihan ?? 'Tidak dijawab'); ?></p>
                                </div>
                                <div class="rounded-xl border border-emerald-200 bg-emerald-50/70 p-3.5">
                                    <p class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Kunci jawaban</p>
                                    <p class="mt-1.5 whitespace-pre-line text-sm text-emerald-900"><?php echo e($pilihanBenar->teks_pilihan ?? 'Kunci jawaban belum ditentukan.'); ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-3.5">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Jawaban kamu</p>
                                <?php if ($jawaban && $jawaban->jawaban_teks): ?>
                                    <pre class="mt-2 whitespace-pre-wrap break-words rounded-lg bg-slate-950 p-3 font-mono text-xs leading-5 text-slate-100"><?php echo e($jawaban->jawaban_teks); ?></pre>
                                <?php else: ?>
                                    <p class="mt-1.5 text-sm italic text-slate-500">Tidak ada jawaban yang dikirim.</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="px-6 py-12 text-center text-sm text-slate-500">Rincian soal tidak tersedia.</div>
            <?php endif; ?>
        </div>
    </section>

    <div class="flex flex-wrap justify-end gap-3">
        <a href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => $evaluasi->jenis_evaluasi]) }}" class="inline-flex items-center justify-center rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white transition hover:bg-maroon-700">Kembali ke Daftar Evaluasi</a>
    </div>
</div>

{{-- Popup notifikasi hasil evaluasi --}}
<style>
    @keyframes evaluasi-popup-enter {
        from { opacity: 0; transform: translateY(12px) scale(.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .evaluasi-popup-panel { animation: evaluasi-popup-enter .22s ease-out both; }
    @media (prefers-reduced-motion: reduce) { .evaluasi-popup-panel { animation: none; } }
</style>
<div id="popupHasilEvaluasi" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-[3px]" aria-hidden="true">
    <div class="evaluasi-popup-panel w-full max-w-[420px] overflow-hidden rounded-[28px] border border-white/70 bg-white shadow-[0_24px_80px_-20px_rgba(15,23,42,.45)]" role="dialog" aria-modal="true" aria-labelledby="popupHasilJudul" aria-describedby="popupHasilPesan">
        <div class="px-7 pb-6 pt-8 text-center sm:px-9">
            <div id="popupHasilIconWrap" class="mx-auto flex h-[76px] w-[76px] items-center justify-center rounded-[25px] border border-emerald-200 bg-emerald-50 text-emerald-700 shadow-sm">
                <svg id="popupHasilIcon" class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16.5 9"/></svg>
            </div>
            <h2 id="popupHasilJudul" class="mt-5 font-display text-xl font-extrabold tracking-tight text-slate-900 sm:text-[22px]">Informasi</h2>
            <p id="popupHasilPesan" class="mx-auto mt-2.5 max-w-[330px] whitespace-pre-line text-sm leading-6 text-slate-600"></p>
        </div>
        <div class="px-7 pb-7 sm:px-9">
            <button type="button" id="popupHasilOK" class="min-h-11 w-full rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-100">Mengerti</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const messageText = @json($flashMessage);
    if (!messageText) return;

    const modal = document.getElementById('popupHasilEvaluasi');
    const title = document.getElementById('popupHasilJudul');
    const message = document.getElementById('popupHasilPesan');
    const iconWrap = document.getElementById('popupHasilIconWrap');
    const icon = document.getElementById('popupHasilIcon');
    const button = document.getElementById('popupHasilOK');
    const type = @json($flashType);
    const styles = {
        success: {
            title: 'Berhasil',
            wrap: 'border-emerald-200 bg-emerald-50 text-emerald-700',
            button: 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-100',
            icon: '<circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16.5 9"/>'
        },
        error: {
            title: 'Terjadi Kesalahan',
            wrap: 'border-rose-200 bg-rose-50 text-rose-700',
            button: 'bg-rose-600 hover:bg-rose-700 focus:ring-rose-100',
            icon: '<circle cx="12" cy="12" r="9"/><path d="m15 9-6 6m0-6 6 6"/>'
        },
        info: {
            title: 'Informasi',
            wrap: 'border-sky-200 bg-sky-50 text-sky-700',
            button: 'bg-sky-600 hover:bg-sky-700 focus:ring-sky-100',
            icon: '<circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/>'
        }
    };
    const style = styles[type] || styles.info;

    title.textContent = style.title;
    message.textContent = messageText;
    iconWrap.className = 'mx-auto flex h-[76px] w-[76px] items-center justify-center rounded-[25px] border shadow-sm ' + style.wrap;
    icon.innerHTML = style.icon;
    button.className = 'min-h-11 w-full rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition focus:outline-none focus:ring-4 ' + style.button;

    function closePopup() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }
    button.addEventListener('click', closePopup);
    modal.addEventListener('click', function (event) {
        if (event.target === modal) closePopup();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) closePopup();
    });
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('overflow-hidden');
    button.focus();
});
</script>
@endpush

@endsection

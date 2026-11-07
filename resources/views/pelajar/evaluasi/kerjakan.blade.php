@extends('layouts.master')

@section('title', 'Kerjakan ' . ucfirst($pengerjaan->evaluasi?->jenis_evaluasi ?? 'Evaluasi'))
@section('description', 'Kerjakan dan kumpulkan jawaban evaluasi pembelajaran.')
@section('page_label', 'Area Pelajar')
@section('page_heading', 'Kerjakan Evaluasi')

@section('content')
@php
    $evaluasi = $pengerjaan->evaluasi;
    $labelJenis = ['pretest' => 'Pretest', 'posttest' => 'Posttest'];
    $isPretest = ($evaluasi->jenis_evaluasi ?? 'pretest') === 'pretest';
    $flashType = session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : null));
    $flashMessage = session('success') ?? session('error') ?? session('info');
@endphp

<div class="mx-auto max-w-4xl space-y-6">
    <a href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => $evaluasi->jenis_evaluasi]) }}" id="linkKembali" class="inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 transition hover:text-maroon-950">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
        Kembali ke daftar evaluasi
    </a>

    <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-7">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-lg border {{ $isPretest ? 'border-amber-200 bg-amber-50 text-amber-800' : 'border-maroon-100 bg-maroon-50 text-maroon-800' }} px-2.5 py-1 text-xs font-semibold">{{ $labelJenis[$evaluasi->jenis_evaluasi] ?? ucfirst($evaluasi->jenis_evaluasi) }}</span>
                    <span class="rounded-lg bg-warm-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $evaluasi->soal->count() }} soal</span>
                </div>
                <h1 class="mt-3 font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">{{ $evaluasi->judul_evaluasi }}</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">{{ $evaluasi->deskripsi ?: ($isPretest ? 'Ini adalah latihan awal untuk mengenali pemahamanmu. Pilih jawaban yang menurutmu paling tepat.' : 'Ini adalah evaluasi akhir setelah mempelajari materi. Periksa kembali jawaban sebelum dikumpulkan.') }}</p>
                <div class="mt-5 grid gap-3 rounded-xl {{ $isPretest ? 'bg-amber-50/70' : 'bg-warm-50' }} p-4 text-sm sm:grid-cols-2">
                    <div><span class="text-slate-500">Modul</span><p class="mt-1 font-semibold text-slate-800">{{ $evaluasi->modul->nama_modul ?? 'Modul' }}</p></div>
                    <div><span class="text-slate-500">Durasi pengerjaan</span><p class="mt-1 font-semibold text-slate-800">{{ $durasiMenit }} menit</p></div>
                </div>
            </div>

            <div class="w-full shrink-0 rounded-2xl border {{ $isPretest ? 'border-amber-200 bg-amber-50' : 'border-maroon-100 bg-maroon-50' }} p-4 sm:w-56" role="status" aria-live="polite">
                <p class="text-xs font-bold uppercase tracking-wider {{ $isPretest ? 'text-amber-800' : 'text-maroon-700' }}">Sisa waktu</p>
                <p id="timerCountdown" class="mt-2 font-mono text-3xl font-extrabold tabular-nums {{ $isPretest ? 'text-amber-950' : 'text-maroon-950' }}" data-remaining="{{ max(0, (int) $sisaDetik) }}">--:--:--</p>
                <p id="timerHint" class="mt-1 text-xs leading-5 {{ $isPretest ? 'text-amber-800' : 'text-maroon-700' }}">{{ $isPretest ? 'Waktu latihan mulai saat kamu menekan Mulai Latihan.' : 'Waktu Posttest mulai saat kamu menekan Mulai Posttest.' }}</p>
            </div>
        </div>
    </section>

    <div class="rounded-xl border {{ $isPretest ? 'border-amber-200 bg-amber-50/70 text-amber-900' : 'border-maroon-100 bg-maroon-50/70 text-maroon-900' }} px-4 py-3 text-sm leading-6">
        <span class="font-bold">{{ $isPretest ? 'Mode latihan:' : 'Mode evaluasi akhir:' }}</span>
        {{ $isPretest ? 'Semua pertanyaan berbentuk pilihan ganda. Gunakan latihan ini untuk mengetahui materi yang perlu kamu pelajari lagi. Hasilnya tidak masuk ke daftar penilaian Instruktur.' : 'Jawab seluruh pertanyaan dengan teliti. Hasil Posttest akan dikirim ke area Instruktur setelah kamu mengumpulkannya.' }}
    </div>

    <form method="POST" action="{{ route('pelajar.evaluasi.kumpulkan', $pengerjaan) }}" id="formEvaluasi" class="space-y-5" data-draft-key="codetutor-evaluasi-{{ $pengerjaan->id }}">
        @csrf
        <input type="hidden" name="pengiriman_final" id="pengirimanFinal" value="0">

        @foreach ($evaluasi->soal as $index => $soal)
            <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-6">
                <div class="flex items-start gap-3">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-maroon-50 font-display text-sm font-extrabold text-maroon-800">{{ $index + 1 }}</span>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ str_replace('_', ' ', $soal->jenis_soal) }}</span>
                            <span class="rounded-md bg-warm-100 px-2 py-0.5 text-xs font-semibold text-slate-600">Bobot {{ $soal->bobot }}</span>
                        </div>
                        <h2 class="mt-2 whitespace-pre-line text-base font-bold leading-7 text-slate-800">{{ $soal->pertanyaan }}</h2>

                        @if ($soal->jenis_soal === 'pilihan_ganda')
                            <div class="mt-4 space-y-3">
                                @forelse ($soal->pilihan as $indexPilihan => $pilihan)
                                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-3.5 transition hover:border-maroon-200 hover:bg-warm-50 has-[:checked]:border-maroon-400 has-[:checked]:bg-maroon-50/60">
                                        <input type="radio" name="jawaban[{{ $soal->id }}][pilihan]" value="{{ $pilihan->id }}" @checked(old("jawaban.{$soal->id}.pilihan") == $pilihan->id) class="mt-1 h-4 w-4 border-slate-300 text-maroon-700 focus:ring-maroon-500">
                                        <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-slate-100 text-xs font-bold text-slate-600">{{ chr(65 + ($indexPilihan % 26)) }}</span>
                                        <span class="whitespace-pre-line text-sm leading-6 text-slate-700">{{ $pilihan->teks_pilihan }}</span>
                                    </label>
                                @empty
                                    <p class="rounded-xl border border-amber-200 bg-amber-50 p-3 text-sm text-amber-800">Soal ini belum memiliki pilihan jawaban. Hubungi Instruktur.</p>
                                @endforelse
                            </div>
                        @elseif ($soal->jenis_soal === 'coding')
                            <label for="jawaban_{{ $soal->id }}" class="mt-4 block text-xs font-semibold text-slate-600">Tulis kode atau jawaban coding</label>
                            <textarea id="jawaban_{{ $soal->id }}" name="jawaban[{{ $soal->id }}][teks]" rows="8" maxlength="50000" spellcheck="false" placeholder="Tulis jawaban atau kode kamu di sini..." class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-950 px-4 py-3 font-mono text-sm leading-6 text-emerald-100 outline-none transition placeholder:text-slate-500 focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old("jawaban.{$soal->id}.teks") }}</textarea>
                        @else
                            <label for="jawaban_{{ $soal->id }}" class="mt-4 block text-xs font-semibold text-slate-600">Jawaban essay</label>
                            <textarea id="jawaban_{{ $soal->id }}" name="jawaban[{{ $soal->id }}][teks]" rows="5" maxlength="50000" placeholder="Tuliskan jawabanmu dengan jelas..." class="mt-2 w-full rounded-xl border border-slate-200 bg-warm-50 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old("jawaban.{$soal->id}.teks") }}</textarea>
                        @endif
                    </div>
                </div>
            </section>
        @endforeach

        <div class="sticky bottom-3 rounded-2xl border border-slate-200 bg-white/95 p-4 shadow-lg backdrop-blur sm:flex sm:items-center sm:justify-between sm:gap-4">
            <p class="text-xs leading-5 text-slate-500">{{ $isPretest ? 'Jawaban latihan akan dikoreksi otomatis dan nilainya dapat kamu lihat sendiri.' : 'Jawaban Posttest akan disimpan dan hasilnya ditampilkan pada area Instruktur.' }} Ketika waktu habis, sistem akan mengumpulkan otomatis.</p>
            <button id="submitEvaluasi" type="submit" class="mt-3 inline-flex w-full shrink-0 items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 sm:mt-0 sm:w-auto">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
                {{ $isPretest ? 'Kumpulkan Latihan' : 'Kumpulkan Posttest' }}
            </button>
        </div>
    </form>
</div>

{{-- Popup tunggal untuk konfirmasi, peringatan, dan notifikasi --}}
<style>
    @keyframes evaluasi-popup-enter {
        from { opacity: 0; transform: translateY(12px) scale(.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .evaluasi-popup-panel { animation: evaluasi-popup-enter .22s ease-out both; }
    @media (prefers-reduced-motion: reduce) { .evaluasi-popup-panel { animation: none; } }
</style>
<div id="popupEvaluasi" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-[3px]" aria-hidden="true">
    <div class="evaluasi-popup-panel w-full max-w-[420px] overflow-hidden rounded-[28px] border border-white/70 bg-white shadow-[0_24px_80px_-20px_rgba(15,23,42,.45)]" role="dialog" aria-modal="true" aria-labelledby="popupJudul" aria-describedby="popupPesan">
        <div class="px-7 pb-6 pt-8 text-center sm:px-9">
            <div id="popupIconWrap" class="mx-auto flex h-[76px] w-[76px] items-center justify-center rounded-[25px] border border-amber-200 bg-amber-50 text-amber-700 shadow-sm">
                <svg id="popupIcon" class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4m0 4h.01"/></svg>
            </div>
            <h2 id="popupJudul" class="mt-5 font-display text-xl font-extrabold tracking-tight text-slate-900 sm:text-[22px]">Konfirmasi</h2>
            <p id="popupPesan" class="mx-auto mt-2.5 max-w-[330px] whitespace-pre-line text-sm leading-6 text-slate-600">Apakah kamu yakin?</p>
        </div>
        <div id="popupActions" class="flex flex-col-reverse gap-2.5 px-7 pb-7 sm:grid sm:grid-cols-2 sm:px-9">
            <button type="button" id="popupBatal" class="min-h-11 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Batal</button>
            <button type="button" id="popupKonfirmasi" class="min-h-11 rounded-xl bg-maroon-800 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">Ya, lanjutkan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formEvaluasi');
    const timer = document.getElementById('timerCountdown');
    const hint = document.getElementById('timerHint');
    const submitButton = document.getElementById('submitEvaluasi');
    const finalInput = document.getElementById('pengirimanFinal');
    const backLink = document.getElementById('linkKembali');

    const popup = document.getElementById('popupEvaluasi');
    const popupTitle = document.getElementById('popupJudul');
    const popupMessage = document.getElementById('popupPesan');
    const popupIconWrap = document.getElementById('popupIconWrap');
    const popupIcon = document.getElementById('popupIcon');
    const popupCancel = document.getElementById('popupBatal');
    const popupConfirm = document.getElementById('popupKonfirmasi');
    const popupActions = document.getElementById('popupActions');

    if (!form || !timer || !finalInput || !popup) return;

    const draftKey = form.dataset.draftKey;
    let remaining = Math.max(0, Number(timer.dataset.remaining || 0));
    let deadline = Date.now() + remaining * 1000;
    let isSubmitting = false;
    let expiryTriggered = false;
    let popupAction = null;
    let timerInterval = null;

    const popupStyles = {
        success: {
            wrap: 'border-emerald-200 bg-emerald-50 text-emerald-700',
            button: 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-100',
            icon: '<circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16.5 9"/>'
        },
        error: {
            wrap: 'border-rose-200 bg-rose-50 text-rose-700',
            button: 'bg-rose-600 hover:bg-rose-700 focus:ring-rose-100',
            icon: '<circle cx="12" cy="12" r="9"/><path d="m15 9-6 6m0-6 6 6"/>'
        },
        warning: {
            wrap: 'border-amber-200 bg-amber-50 text-amber-700',
            button: 'bg-maroon-800 hover:bg-maroon-700 focus:ring-maroon-100',
            icon: '<path d="m10.3 3.9-8 13.6A1.7 1.7 0 0 0 3.8 20h16.4a1.7 1.7 0 0 0 1.5-2.5l-8-13.6a2 2 0 0 0-3.4 0Z"/><path d="M12 9v4m0 3h.01"/>'
        },
        info: {
            wrap: 'border-sky-200 bg-sky-50 text-sky-700',
            button: 'bg-sky-600 hover:bg-sky-700 focus:ring-sky-100',
            icon: '<circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/>'
        }
    };

    function openPopup({title, message, type = 'warning', confirmText = 'Mengerti', cancelText = null, onConfirm = null, onCancel = null}) {
        const popupType = popupStyles[type] ? type : 'info';
        const style = popupStyles[popupType];
        popupTitle.textContent = title;
        popupMessage.textContent = message;
        popupAction = {onConfirm, onCancel};
        popupIconWrap.className = 'mx-auto flex h-[76px] w-[76px] items-center justify-center rounded-[25px] border shadow-sm ' + style.wrap;
        popupIcon.innerHTML = style.icon;
        popupConfirm.className = 'min-h-11 rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition focus:outline-none focus:ring-4 ' + style.button;
        popupCancel.textContent = cancelText || 'Batal';
        popupCancel.classList.toggle('hidden', !cancelText);
        popupConfirm.textContent = confirmText;
        popupActions.classList.toggle('sm:grid-cols-1', !cancelText);
        popupActions.classList.toggle('sm:max-w-[190px]', !cancelText);
        popupActions.classList.toggle('sm:mx-auto', !cancelText);
        popupActions.classList.toggle('sm:grid-cols-2', !!cancelText);
        popup.classList.remove('hidden');
        popup.classList.add('flex');
        popup.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        popupConfirm.focus();
    }

    function closePopup() {
        popup.classList.add('hidden');
        popup.classList.remove('flex');
        popup.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
        popupAction = null;
    }

    popupConfirm.addEventListener('click', function () {
        const action = popupAction && popupAction.onConfirm;
        closePopup();
        if (typeof action === 'function') action();
    });
    popupCancel.addEventListener('click', function () {
        const action = popupAction && popupAction.onCancel;
        closePopup();
        if (typeof action === 'function') action();
    });
    popup.addEventListener('click', function (event) {
        if (event.target === popup && popupCancel && !popupCancel.classList.contains('hidden')) popupCancel.click();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !popup.classList.contains('hidden') && !popupCancel.classList.contains('hidden')) popupCancel.click();
    });

    function saveDraft() {
        try {
            const data = {};
            form.querySelectorAll('input[type="radio"]:checked, textarea').forEach(function (field) {
                data[field.name] = field.value;
            });
            localStorage.setItem(draftKey, JSON.stringify(data));
        } catch (error) {}
    }

    function restoreDraft() {
        try {
            const saved = JSON.parse(localStorage.getItem(draftKey) || '{}');
            Object.keys(saved).forEach(function (name) {
                Array.from(form.elements).filter(field => field.name === name).forEach(function (field) {
                    if (field.type === 'radio') field.checked = field.value === String(saved[name]);
                    else field.value = saved[name];
                });
            });
        } catch (error) {}
    }

    function clearDraft() {
        try { localStorage.removeItem(draftKey); } catch (error) {}
    }

    function formatTime(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;
        return [h, m, s].map(value => String(value).padStart(2, '0')).join(':');
    }

    function sendForm(isTimeout) {
        if (isSubmitting) return;
        isSubmitting = true;
        finalInput.value = '1';
        if (isTimeout && hint) hint.textContent = 'Waktu habis. Sistem sedang mengumpulkan jawaban...';
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Mengumpulkan...';
            submitButton.classList.add('cursor-not-allowed', 'opacity-60');
        }
        clearDraft();
        HTMLFormElement.prototype.submit.call(form);
    }

    function timeExpired() {
        if (isSubmitting || expiryTriggered) return;
        expiryTriggered = true;
        remaining = 0;
        timer.textContent = '00:00:00';
        timer.classList.add('text-rose-700');
        if (timerInterval) window.clearInterval(timerInterval);
        openPopup({
            title: 'Waktu Pengerjaan Habis',
            message: @json($isPretest ? 'Waktu latihan Pretest telah berakhir. Jawaban yang terisi akan langsung dikumpulkan dan dikoreksi otomatis.' : 'Waktu Posttest telah berakhir. Jawaban yang terisi akan langsung dikumpulkan untuk diproses.'),
            type: 'warning',
            confirmText: 'Kumpulkan Sekarang',
            onConfirm: function () { sendForm(true); }
        });
        // Otomatis kirim meskipun Pelajar tidak menekan tombol popup.
        window.setTimeout(function () { sendForm(true); }, 1800);
    }

    restoreDraft();
    form.addEventListener('input', saveDraft);
    form.addEventListener('change', saveDraft);

    form.addEventListener('submit', function (event) {
        if (isSubmitting) return;
        event.preventDefault();
        if (remaining <= 0) {
            timeExpired();
            return;
        }
        openPopup({
            title: '{{ $isPretest ? 'Kumpulkan Latihan' : 'Kumpulkan Posttest' }}?',
            message: 'Pastikan semua jawaban sudah benar. Setelah dikumpulkan, kamu tidak dapat mengubah jawaban lagi.',
            type: 'warning',
            confirmText: 'Ya, Kumpulkan',
            cancelText: 'Periksa Lagi',
            onConfirm: function () { sendForm(false); }
        });
    });

    if (backLink) {
        backLink.addEventListener('click', function (event) {
            if (isSubmitting) return;
            event.preventDefault();
            openPopup({
                title: @json($isPretest ? 'Keluar dari Latihan?' : 'Keluar dari Posttest?'),
                message: 'Waktu tetap berjalan meskipun kamu meninggalkan halaman ini. Draft jawaban di perangkat ini akan disimpan, dan kamu bisa melanjutkan selama waktu belum habis.',
                type: 'warning',
                confirmText: 'Ya, Keluar',
                cancelText: 'Lanjut Mengerjakan',
                onConfirm: function () { isSubmitting = true; window.location.href = backLink.href; }
            });
        });
    }

    // Browser hanya mengizinkan dialog bawaan untuk refresh/tutup tab.
    window.addEventListener('beforeunload', function (event) {
        if (!isSubmitting && remaining > 0) {
            event.preventDefault();
            event.returnValue = '';
        }
    });

    function tick() {
        remaining = Math.max(0, Math.ceil((deadline - Date.now()) / 1000));
        timer.textContent = formatTime(remaining);
        if (remaining <= 300) {
            timer.classList.add('text-rose-700');
            if (hint) hint.textContent = 'Waktu hampir habis. Segera periksa dan kumpulkan jawaban.';
        }
        if (remaining <= 0) timeExpired();
    }

    tick();
    if (remaining > 0) timerInterval = window.setInterval(tick, 250);

    @if ($errors->any())
        openPopup({
            title: 'Periksa Jawaban',
            message: @json(implode("\n", $errors->all())),
            type: 'error',
            confirmText: 'Mengerti'
        });
    @elseif ($flashMessage)
        openPopup({
            title: @json($flashType === 'success' ? 'Berhasil' : ($flashType === 'error' ? 'Terjadi Kesalahan' : 'Informasi')),
            message: @json($flashMessage),
            type: @json($flashType),
            confirmText: 'Mengerti'
        });
    @endif
});
</script>
@endpush
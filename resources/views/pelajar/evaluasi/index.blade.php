@extends('layouts.master')

@section('title', $jenisMenu === 'pretest' ? 'Pretest — Latihan Awal' : 'Posttest — Evaluasi Akhir')
@section('description', $jenisMenu === 'pretest' ? 'Latihan awal untuk mengukur pemahaman sebelum pembelajaran.' : 'Evaluasi akhir untuk mengukur pemahaman setelah pembelajaran.')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    @php $isPretest = $jenisMenu === 'pretest'; @endphp
   

    <section class="overflow-hidden rounded-2xl border {{ $isPretest ? 'border-amber-200 bg-gradient-to-r from-amber-50 via-white to-orange-50' : 'border-maroon-100 bg-gradient-to-r from-maroon-50 via-white to-warm-50' }} p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl {{ $isPretest ? 'bg-amber-100 text-amber-700' : 'bg-maroon-100 text-maroon-800' }}">
                @if ($isPretest)
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 18h6M10 22h4M8.5 14.5a6 6 0 1 1 7 0c-.8.6-1.2 1.3-1.3 2.5h-4.4c-.1-1.2-.5-1.9-1.3-2.5Z"/><path d="M12 2v2"/></svg>
                @else
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 5h12M8 12h12M8 19h12"/><path d="m3 5 1.5 1.5L6.5 4M3 12l1.5 1.5 2-2M3 19l1.5 1.5 2-2"/></svg>
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <h2 class="font-display text-lg font-extrabold {{ $isPretest ? 'text-amber-950' : 'text-maroon-950' }}">{{ $isPretest ? 'Kenali kemampuan awalmu' : 'Saatnya menguji hasil belajarmu' }}</h2>
                <p class="mt-1 max-w-3xl text-sm leading-6 {{ $isPretest ? 'text-amber-900/80' : 'text-slate-600' }}">{{ $isPretest ? 'Pretest berfungsi sebagai latihan awal. Jawaban dan nilai latihan dapat kamu lihat sendiri untuk mengetahui bagian materi yang perlu dipelajari.' : 'Posttest dikerjakan setelah kamu mempelajari materi. Hasil Posttest akan masuk ke riwayat evaluasi Instruktur untuk dipantau dan dinilai.' }}</p>
            </div>
            <span class="w-fit rounded-full {{ $isPretest ? 'bg-amber-100 text-amber-800' : 'bg-maroon-100 text-maroon-800' }} px-3 py-1.5 text-xs font-bold">{{ $isPretest ? 'Latihan mandiri' : 'Penilaian akhir' }}</span>
        </div>
    </section>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><p class="text-sm font-medium text-slate-500">{{ $isPretest ? 'Latihan tersedia' : 'Posttest tersedia' }}</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($totalTersedia, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-400">{{ $isPretest ? 'Latihan dari modul aktif' : 'Posttest dari modul aktif' }}</p></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><p class="text-sm font-medium text-slate-500">{{ $isPretest ? 'Latihan selesai' : 'Posttest dikumpulkan' }}</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ number_format($totalSelesai, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-400">{{ $isPretest ? 'Hasil bisa dilihat olehmu' : 'Termasuk yang menunggu penilaian' }}</p></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><p class="text-sm font-medium text-slate-500">{{ $isPretest ? 'Jenis soal' : 'Menunggu penilaian' }}</p><p class="mt-3 font-display text-3xl font-extrabold text-maroon-950">{{ $isPretest ? 'PG' : number_format($totalMenungguPenilaian, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-400">{{ $isPretest ? 'Semua soal berupa pilihan ganda' : 'Essay atau coding diperiksa Instruktur' }}</p></div>
    </div>

    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-soft sm:p-5">
        <div class="mb-4"><h2 class="font-display text-base font-bold text-maroon-950">Cari evaluasi</h2><p class="mt-1 text-xs text-slate-500">Cari berdasarkan judul, deskripsi, atau modul.</p></div>
        <form method="GET" action="{{ route('pelajar.evaluasi.index') }}" class="grid gap-3 md:grid-cols-2">
            <input type="hidden" name="jenis_evaluasi" value="{{ $jenisMenu }}">
            <div class="md:col-span-1"><label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Kata kunci</label><input id="q" name="q" value="{{ request('q') }}" type="text" placeholder="Cari judul evaluasi atau modul..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"></div>
            <div class="flex flex-wrap items-center gap-2 md:col-span-1"><button type="submit" class="rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700">Terapkan Filter</button><a href="{{ route('pelajar.evaluasi.index', ['jenis_evaluasi' => $jenisMenu]) }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a><span class="text-xs text-slate-400 md:ml-auto">{{ $evaluasi->total() }} evaluasi ditemukan</span></div>
        </form>
    </div>

    <div class="space-y-4">
        @forelse ($evaluasi as $item)
            @php
                $attempt = $pengerjaanPelajar->get($item->id);
                $typeLabels = ['pretest' => 'Pretest', 'posttest' => 'Posttest'];
                $sudahMemulai = $attempt && $attempt->status === 'belum_selesai' && !$attempt->waktu_selesai;
            @endphp
            <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft transition hover:border-maroon-200 sm:p-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-lg border {{ $isPretest ? 'border-amber-200 bg-amber-50 text-amber-800' : 'border-maroon-100 bg-maroon-50 text-maroon-800' }} px-2.5 py-1 text-xs font-semibold">{{ $isPretest ? 'Latihan awal' : 'Posttest' }}</span>
                            @if ($attempt)
                                @if ($sudahMemulai)
                                    <span class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-800">Sedang dikerjakan</span>
                                @elseif ($attempt->status === 'menunggu_penilaian')
                                    <span class="rounded-lg border border-sky-200 bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-800">Menunggu penilaian</span>
                                @else
                                    <span class="rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800">Selesai</span>
                                @endif
                            @else
                                <span class="rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-600">Belum dikerjakan</span>
                            @endif
                        </div>
                        <h2 class="mt-3 font-display text-lg font-extrabold text-maroon-950">{{ $item->judul_evaluasi }}</h2>
                        <p class="mt-1 max-w-3xl whitespace-pre-line text-sm leading-6 text-slate-500">{{ $item->deskripsi ?: 'Tidak ada deskripsi tambahan.' }}</p>
                        <div class="mt-4 flex flex-wrap gap-x-5 gap-y-2 text-xs text-slate-500">
                            <span class="inline-flex items-center gap-1.5">{{ $item->modul->nama_modul ?? 'Modul tidak tersedia' }}</span>
                            <span class="inline-flex items-center gap-1.5">{{ $item->soal_count }} soal</span>
                            <span class="inline-flex items-center gap-1.5">Nilai minimal {{ $item->nilai_minimal }}</span>
                            <span class="inline-flex items-center gap-1.5"><strong class="font-semibold text-slate-600">Durasi:</strong> {{ $item->durasi_menit }} menit</span>
                            @if ($attempt && !is_null($attempt->nilai))
                                <span class="inline-flex items-center gap-1.5 font-semibold text-maroon-800">{{ $isPretest ? 'Nilai latihan' : 'Nilai Posttest' }}: {{ $attempt->nilai }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="shrink-0">
                        @if ($item->soal_count < 1)
                            <span class="inline-flex cursor-not-allowed rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-400" title="Evaluasi belum memiliki soal">Belum tersedia</span>
                        @elseif ($sudahMemulai)
                            <form method="POST" action="{{ route('pelajar.evaluasi.mulai', $item) }}">@csrf<button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700">{{ $isPretest ? 'Lanjutkan Latihan' : 'Lanjutkan Posttest' }}</button></form>
                        @elseif (!$attempt)
                            <form method="POST" action="{{ route('pelajar.evaluasi.mulai', $item) }}" data-confirm-start>@csrf<button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700">{{ $isPretest ? 'Mulai Latihan' : 'Mulai Posttest' }}</button></form>
                        @else
                            <a href="{{ route('pelajar.evaluasi.hasil', $attempt) }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-maroon-200 bg-white px-4 py-3 text-sm font-semibold text-maroon-800 transition hover:bg-maroon-50">Lihat Hasil</a>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-slate-200/80 bg-white px-6 py-14 text-center shadow-soft">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg></div>
                <h3 class="mt-4 font-display text-base font-bold text-slate-800">{{ $isPretest ? 'Belum ada latihan Pretest' : 'Belum ada Posttest tersedia' }}</h3>
                <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-slate-500">{{ $isPretest ? 'Latihan awal akan tampil setelah Instruktur menambahkan Pretest pada modul yang aktif.' : 'Posttest akan tampil setelah Instruktur menambahkan evaluasi akhir pada modul yang aktif.' }}</p>
            </div>
        @endforelse
    </div>

    @if ($evaluasi->hasPages())
        <div class="rounded-2xl border border-slate-200/80 bg-white px-5 py-4 shadow-soft">{{ $evaluasi->links() }}</div>
    @endif
    <p class="text-xs leading-5 text-slate-400">{{ $isPretest ? "Latihan Pretest hanya berupa pilihan ganda dan nilai tersimpan untuk dilihat oleh Pelajar." : "Hasil Posttest diteruskan ke area Instruktur. Waktu pengerjaan dihitung sejak tombol Mulai Posttest ditekan." }} Setelah durasi habis, sistem mengumpulkan jawaban secara otomatis.</p>
</div>

<style>
    @keyframes evaluasi-popup-enter {
        from { opacity: 0; transform: translateY(12px) scale(.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .evaluasi-popup-panel { animation: evaluasi-popup-enter .22s ease-out both; }
    @media (prefers-reduced-motion: reduce) { .evaluasi-popup-panel { animation: none; } }
</style>

<div id="popupDaftarEvaluasi" class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-[3px]" aria-hidden="true">
    <div class="evaluasi-popup-panel w-full max-w-[420px] overflow-hidden rounded-[28px] border border-white/70 bg-white shadow-[0_24px_80px_-20px_rgba(15,23,42,.45)]" role="dialog" aria-modal="true" aria-labelledby="popupDaftarJudul" aria-describedby="popupDaftarPesan">
        <div class="px-7 pb-6 pt-8 text-center sm:px-9">
            <div id="popupDaftarIconWrap" class="mx-auto flex h-[76px] w-[76px] items-center justify-center rounded-[25px] border border-amber-200 bg-amber-50 text-amber-700 shadow-sm">
                <svg id="popupDaftarIcon" class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v4m0 4h.01"/></svg>
            </div>
            <h2 id="popupDaftarJudul" class="mt-5 font-display text-xl font-extrabold tracking-tight text-slate-900 sm:text-[22px]">Konfirmasi</h2>
            <p id="popupDaftarPesan" class="mx-auto mt-2.5 max-w-[330px] whitespace-pre-line text-sm leading-6 text-slate-600"></p>
        </div>
        <div id="popupDaftarActions" class="flex flex-col-reverse gap-2.5 px-7 pb-7 sm:grid sm:grid-cols-2 sm:px-9">
            <button type="button" id="popupDaftarBatal" class="min-h-11 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Batal</button>
            <button type="button" id="popupDaftarOK" class="min-h-11 rounded-xl bg-maroon-800 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">Mengerti</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('popupDaftarEvaluasi');
    const title = document.getElementById('popupDaftarJudul');
    const message = document.getElementById('popupDaftarPesan');
    const iconWrap = document.getElementById('popupDaftarIconWrap');
    const icon = document.getElementById('popupDaftarIcon');
    const actions = document.getElementById('popupDaftarActions');
    const cancel = document.getElementById('popupDaftarBatal');
    const ok = document.getElementById('popupDaftarOK');
    let confirmAction = null;

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

    function showPopup(judul, pesan, options = {}) {
        const type = popupStyles[options.type] ? options.type : 'info';
        const style = popupStyles[type];
        title.textContent = judul;
        message.textContent = pesan;
        iconWrap.className = 'mx-auto flex h-[76px] w-[76px] items-center justify-center rounded-[25px] border shadow-sm ' + style.wrap;
        icon.innerHTML = style.icon;
        ok.className = 'min-h-11 rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition focus:outline-none focus:ring-4 ' + style.button;
        cancel.classList.toggle('hidden', !options.cancelText);
        cancel.textContent = options.cancelText || 'Batal';
        ok.textContent = options.okText || 'Mengerti';
        actions.classList.toggle('sm:grid-cols-1', !options.cancelText);
        actions.classList.toggle('sm:max-w-[190px]', !options.cancelText);
        actions.classList.toggle('sm:mx-auto', !options.cancelText);
        actions.classList.toggle('sm:grid-cols-2', !!options.cancelText);
        confirmAction = options.onConfirm || null;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');
        ok.focus();
    }

    function hidePopup() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
        confirmAction = null;
    }

    ok.addEventListener('click', function () {
        const action = confirmAction;
        hidePopup();
        if (typeof action === 'function') action();
    });
    cancel.addEventListener('click', hidePopup);
    modal.addEventListener('click', function (event) {
        if (event.target === modal && !cancel.classList.contains('hidden')) cancel.click();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden') && !cancel.classList.contains('hidden')) cancel.click();
    });

    document.querySelectorAll('form[data-confirm-start]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (form.dataset.confirmed === '1') return;
            event.preventDefault();
            showPopup(@json($jenisMenu === 'pretest' ? 'Mulai Latihan Pretest?' : 'Mulai Posttest?'), @json($jenisMenu === 'pretest' ? 'Gunakan latihan ini untuk mengukur pemahaman awalmu. Durasi mulai berjalan setelah kamu menekan tombol mulai.' : 'Pastikan kamu sudah mempelajari materi. Durasi Posttest mulai berjalan setelah kamu menekan tombol mulai.'), {
                type: 'warning', cancelText: 'Belum Siap', okText: 'Mulai Sekarang',
                onConfirm: function () { form.dataset.confirmed = '1'; form.submit(); }
            });
        });
    });

    @if ($errors->any())
        showPopup('Periksa Kembali', @json(implode("\n", $errors->all())), {type: 'error', okText: 'Mengerti'});
    @elseif (session('success'))
        showPopup('Berhasil', @json(session('success')), {type: 'success', okText: 'Mengerti'});
    @elseif (session('error'))
        showPopup('Terjadi Kesalahan', @json(session('error')), {type: 'error', okText: 'Mengerti'});
    @elseif (session('info'))
        showPopup('Informasi', @json(session('info')), {type: 'info', okText: 'Mengerti'});
    @endif
});
</script>
@endpush
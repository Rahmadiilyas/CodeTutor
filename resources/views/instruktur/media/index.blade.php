@extends('layouts.master')

@section('title', 'Media Pembelajaran')
@section('description', 'Kelola dan pratinjau media pembelajaran yang terhubung dengan materi milik Instruktur.')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Media Pembelajaran</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Kelola file, video, foto, presentasi, dan tautan YouTube. Gunakan tombol Preview untuk melihat media tanpa meninggalkan halaman.</p>
        </div>
        <a href="{{ route('instruktur.media.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Media
        </a>
    </div>

    @if (session('success'))
        <div role="status" class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div role="alert" class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div role="alert" class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <p class="font-semibold">Ada data yang perlu diperbaiki.</p>
            <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <p class="text-sm font-medium text-slate-500">Total Media</p>
            <p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalMedia, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-500">Media dalam materi milikmu</p>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <p class="text-sm font-medium text-slate-500">Media dengan File</p>
            <p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalFile, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-500">File yang tersimpan di sistem</p>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <p class="text-sm font-medium text-slate-500">Media dengan Tautan</p>
            <p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalTautan, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-500">URL eksternal atau YouTube</p>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-soft sm:p-5">
        <div class="mb-4">
            <h2 class="font-display text-base font-bold text-maroon-950">Cari dan filter media</h2>
            <p class="mt-1 text-xs text-slate-500">Cari judul media atau materi, lalu filter jenis dan materi pembelajaran.</p>
        </div>
        <form method="GET" action="{{ route('instruktur.media.index') }}" class="grid gap-3 md:grid-cols-2 xl:grid-cols-4">
            <div class="xl:col-span-2">
                <label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Kata kunci</label>
                <input id="q" name="q" value="{{ request('q') }}" type="text" placeholder="Judul media, materi, tautan..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
            </div>
            <div>
                <label for="jenis_media" class="mb-1.5 block text-xs font-semibold text-slate-600">Jenis media</label>
                <select id="jenis_media" name="jenis_media" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    <option value="">Semua jenis</option>
                    @foreach ($jenisMedia as $jenis)<option value="{{ $jenis }}" @selected(request('jenis_media') === $jenis)>{{ strtoupper($jenis) }}</option>@endforeach
                </select>
            </div>
            <div>
                <label for="materi" class="mb-1.5 block text-xs font-semibold text-slate-600">Materi</label>
                <select id="materi" name="materi" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    <option value="">Semua materi</option>
                    @foreach ($materiFilter as $itemMateri)<option value="{{ $itemMateri->id }}" @selected((string) request('materi') === (string) $itemMateri->id)>{{ $itemMateri->judul_materi }}</option>@endforeach
                </select>
            </div>
            <div class="flex flex-wrap items-center gap-2 md:col-span-2 xl:col-span-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700">Terapkan Filter</button>
                <a href="{{ route('instruktur.media.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
                <span class="text-xs text-slate-400 md:ml-auto">{{ $media->total() }} media ditemukan</span>
            </div>
        </form>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-base font-bold text-maroon-950">Daftar media pembelajaran</h2>
                <p class="mt-1 text-xs text-slate-500">Media yang terhubung dengan materi di dalam modul milikmu.</p>
            </div>
            <span class="w-fit rounded-full bg-warm-100 px-3 py-1 text-xs font-semibold text-maroon-800">{{ $media->firstItem() ?? 0 }}–{{ $media->lastItem() ?? 0 }} dari {{ $media->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-warm-50">
                    <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="whitespace-nowrap px-5 py-3">Media</th>
                        <th class="whitespace-nowrap px-5 py-3">Jenis</th>
                        <th class="min-w-[220px] px-5 py-3">Materi dan Modul</th>
                        <th class="whitespace-nowrap px-5 py-3">Sumber</th>
                        <th class="whitespace-nowrap px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse ($media as $item)
                    <tr class="align-top transition hover:bg-warm-50/70">
                        <td class="px-5 py-4">
                            <p class="max-w-xs whitespace-normal break-words text-sm font-semibold text-slate-800">{{ $item->judul_media }}</p>
                            <p class="mt-1 text-xs text-slate-400">Dibuat {{ $item->created_at?->format('d M Y') ?? '—' }}</p>
                        </td>
                        <td class="px-5 py-4"><span class="inline-flex rounded-lg border border-maroon-100 bg-maroon-50 px-2.5 py-1 text-xs font-semibold uppercase text-maroon-800">{{ $item->jenis_media }}</span></td>
                        <td class="px-5 py-4">
                            <p class="max-w-xs whitespace-normal text-sm font-medium text-slate-700">{{ $item->materi->judul_materi ?? 'Materi tidak tersedia' }}</p>
                            <p class="mt-1 text-xs text-slate-400">{{ $item->materi->modul->nama_modul ?? 'Modul tidak tersedia' }} · {{ $item->materi->modul->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex flex-col items-start gap-1.5">
                                @if ($item->lokasi_file)
                                    <span class="max-w-[200px] truncate text-xs text-slate-500">{{ $item->nama_file_preview ?: 'File tersimpan' }}</span>
                                @endif
                                @if ($item->tautan && $item->jenis_media !== 'youtube')
                                    <a
                                        href="{{ $item->tautan }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center text-xs font-semibold text-sky-700 hover:text-sky-900"
                                    >Buka tautan</a>
                                @elseif ($item->jenis_media === 'youtube' && $item->tautan)
                                    <span class="text-xs text-slate-500">Video YouTube</span>
                                @endif
                                @if (!$item->lokasi_file && !$item->tautan)
                                    <span class="text-xs text-slate-400">Sumber kosong</span>
                                @endif
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                @if ($item->jenis_media === 'youtube' && $item->youtube_embed_url)
                                    <button
                                        type="button"
                                        class="tombol-preview-media inline-flex items-center rounded-lg bg-maroon-800 px-3 py-2 text-xs font-semibold text-white transition hover:bg-maroon-700"
                                        data-judul="{{ $item->judul_media }}"
                                        data-jenis="youtube"
                                        data-url=""
                                        data-youtube="{{ $item->youtube_embed_url }}"
                                        data-tautan="{{ $item->tautan }}"
                                    >Preview</button>
                                @elseif ($item->lokasi_file && $item->url_preview)
                                    <button
                                        type="button"
                                        class="tombol-preview-media inline-flex items-center rounded-lg bg-maroon-800 px-3 py-2 text-xs font-semibold text-white transition hover:bg-maroon-700"
                                        data-judul="{{ $item->judul_media }}"
                                        data-jenis="{{ $item->jenis_media }}"
                                        data-url="{{ $item->url_preview }}"
                                        data-youtube=""
                                        data-tautan=""
                                    >Preview</button>
                                @endif
                                <a href="{{ route('instruktur.media.edit', $item) }}" class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800">Edit</a>
                                <form action="{{ route('instruktur.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus media ini? File yang diunggah juga akan dihapus dari penyimpanan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-lg border border-rose-200 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-14 text-center">
                            <h3 class="font-display text-base font-bold text-slate-800">Belum ada media pembelajaran</h3>
                            <p class="mx-auto mt-1 max-w-sm text-sm text-slate-500">Tambahkan file atau tautan media ke salah satu materi milikmu. Materi dan modul aktif harus tersedia terlebih dahulu.</p>
                            <a href="{{ route('instruktur.media.create') }}" class="mt-4 inline-flex items-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Tambah Media Pertama</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($media->hasPages())<div class="border-t border-slate-100 px-5 py-4">{{ $media->links() }}</div>@endif
    </div>

    <p class="text-xs leading-5 text-slate-400">File yang diunggah dibatasi maksimal 20 MB. Pastikan symbolic link Laravel sudah dibuat dengan <code class="rounded bg-white px-1.5 py-0.5 text-slate-600">php artisan storage:link</code>.</p>
</div>

{{-- Popup Preview Media --}}
<div id="popupPreviewMedia" class="fixed inset-0 z-[300] hidden items-center justify-center bg-slate-950/80 p-2 backdrop-blur-sm sm:p-5" aria-hidden="true">
    <section class="flex max-h-[95vh] w-full max-w-6xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl" role="dialog" aria-modal="true" aria-labelledby="judulPopupPreview">
        <header class="flex shrink-0 items-center justify-between gap-4 border-b border-slate-200 px-4 py-3 sm:px-6">
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-[.14em] text-maroon-700">Pratinjau Media</p>
                <h2 id="judulPopupPreview" class="mt-1 truncate text-base font-bold text-slate-900 sm:text-lg">Media Pembelajaran</h2>
            </div>
            <button id="tutupPopupPreview" type="button" class="shrink-0 rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Tutup</button>
        </header>
        <div id="pesanPreviewMedia" class="hidden border-b border-amber-200 bg-amber-50 px-4 py-3 text-xs leading-5 text-amber-900 sm:px-6"></div>
        <div id="isiPopupPreview" class="min-h-[280px] flex-1 overflow-auto bg-slate-100 p-2 sm:min-h-[480px] sm:p-4">
            <div class="flex min-h-[280px] items-center justify-center text-sm text-slate-500">Pilih media untuk melihat pratinjau.</div>
        </div>
        <footer class="flex shrink-0 flex-col gap-2 border-t border-slate-200 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <p class="text-xs text-slate-500">Pratinjau ditampilkan di halaman ini apabila format dan sumber mendukung.</p>
            <a id="bukaMediaAsli" href="#" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-lg bg-maroon-800 px-4 py-2.5 text-xs font-semibold text-white hover:bg-maroon-700">Buka sumber asli</a>
        </footer>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('popupPreviewMedia');
    const judulPopup = document.getElementById('judulPopupPreview');
    const isiPopup = document.getElementById('isiPopupPreview');
    const pesanPopup = document.getElementById('pesanPreviewMedia');
    const tombolTutup = document.getElementById('tutupPopupPreview');
    const tautanAsli = document.getElementById('bukaMediaAsli');

    if (!popup || !isiPopup) return;

    const ekstensiDariUrl = function (url) {
        try {
            const alamat = new URL(url, window.location.origin);
            const bagian = alamat.pathname.split('.');
            return bagian.length > 1 ? bagian.pop().toLowerCase() : '';
        } catch (error) {
            return '';
        }
    };

    const buatElemen = function (tag, kelas) {
        const elemen = document.createElement(tag);
        if (kelas) elemen.className = kelas;
        return elemen;
    };

    const tampilkanPesan = function (teks) {
        const pesan = buatElemen('div', 'mx-auto flex min-h-[260px] max-w-2xl items-center justify-center rounded-xl bg-white p-6 text-center text-sm leading-6 text-slate-600');
        pesan.textContent = teks;
        isiPopup.appendChild(pesan);
    };

    const tutupPopup = function () {
        popup.classList.add('hidden');
        popup.classList.remove('flex');
        popup.setAttribute('aria-hidden', 'true');
        isiPopup.replaceChildren();
        pesanPopup.classList.add('hidden');
        pesanPopup.textContent = '';
        tautanAsli.href = '#';
        document.body.classList.remove('overflow-hidden');
    };

    const bukaPopup = function (data) {
        const judul = data.judul || 'Media Pembelajaran';
        const jenis = (data.jenis || 'lainnya').toLowerCase();
        const url = data.url || '';
        const youtube = data.youtube || '';
        const tautanAsli = data.tautan || url || youtube;
        const ekstensi = ekstensiDariUrl(url);
        const jenisGambar = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'].includes(ekstensi);
        const jenisVideo = ['mp4', 'mov', 'webm', 'ogg', 'm4v'].includes(ekstensi);
        const jenisPdf = ekstensi === 'pdf' || jenis === 'pdf';
        const jenisPpt = ['ppt', 'pptx'].includes(ekstensi) || jenis === 'ppt';

        judulPopup.textContent = judul;
        isiPopup.replaceChildren();
        pesanPopup.classList.add('hidden');
        pesanPopup.textContent = '';
        tautanAsli.href = tautanAsli || '#';

        popup.classList.remove('hidden');
        popup.classList.add('flex');
        popup.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        if (jenis === 'youtube') {
            if (!youtube) {
                tampilkanPesan('Tautan YouTube belum dapat dikenali. Periksa kembali tautan yang disimpan, lalu gunakan tombol Buka sumber asli.');
                return;
            }
            const video = buatElemen('iframe', 'h-full min-h-[280px] w-full rounded-lg bg-black sm:min-h-[65vh]');
            video.src = youtube;
            video.title = judul;
            video.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
            video.referrerPolicy = 'strict-origin-when-cross-origin';
            video.allowFullscreen = true;
            isiPopup.appendChild(video);
            tautanAsli.href = data.tautan || youtube;
            return;
        }

        if (!url) {
            tampilkanPesan('Sumber media belum tersedia. Tambahkan file atau tautan pada menu Edit Media.');
            return;
        }

        const alamatPenuh = new URL(url, window.location.origin).href;

        if (jenisPdf) {
            const bingkai = buatElemen('iframe', 'h-[70vh] min-h-[360px] w-full rounded-lg bg-white');
            bingkai.src = alamatPenuh;
            bingkai.title = 'Pratinjau PDF ' + judul;
            bingkai.loading = 'lazy';
            isiPopup.appendChild(bingkai);
            return;
        }

        if (jenisPpt) {
            const hostname = new URL(alamatPenuh).hostname.toLowerCase();
            const alamatLokal = hostname === 'localhost'
                || hostname === '127.0.0.1'
                || hostname === '::1'
                || hostname.endsWith('.local')
                || hostname.startsWith('192.168.')
                || hostname.startsWith('10.');

            if (alamatLokal) {
                pesanPopup.textContent = 'Google Docs Viewer hanya dapat mengambil file yang dapat diakses dari internet. Karena aplikasi sedang memakai alamat lokal, file PPT belum bisa dimuat di Google Docs. Jalankan aplikasi melalui domain publik atau gunakan tautan file yang dapat diakses publik.';
                pesanPopup.classList.remove('hidden');
            } else {
                pesanPopup.textContent = 'Presentasi ditampilkan melalui Google Docs Viewer. File harus memiliki URL publik dan dapat diakses tanpa login.';
                pesanPopup.classList.remove('hidden');
            }

            const bingkai = buatElemen('iframe', 'h-[70vh] min-h-[360px] w-full rounded-lg bg-white');
            bingkai.src = 'https://docs.google.com/gview?embedded=1&url=' + encodeURIComponent(alamatPenuh);
            bingkai.title = 'Pratinjau PowerPoint ' + judul;
            bingkai.loading = 'lazy';
            bingkai.referrerPolicy = 'no-referrer';
            isiPopup.appendChild(bingkai);
            return;
        }

        if (jenis === 'video' || jenisVideo || (jenis === 'animasi' && jenisVideo)) {
            const video = buatElemen('video', 'mx-auto max-h-[72vh] w-full rounded-lg bg-black');
            video.controls = true;
            video.playsInline = true;
            video.preload = 'metadata';
            video.src = alamatPenuh;
            isiPopup.appendChild(video);
            return;
        }

        if (jenis === 'animasi' || jenisGambar) {
            const gambar = buatElemen('img', 'mx-auto max-h-[72vh] max-w-full rounded-lg bg-white object-contain');
            gambar.src = alamatPenuh;
            gambar.alt = judul;
            gambar.loading = 'lazy';
            gambar.addEventListener('error', function () {
                isiPopup.replaceChildren();
                tampilkanPesan('Gambar tidak dapat dimuat. Periksa apakah file masih tersedia pada penyimpanan.');
            }, { once: true });
            isiPopup.appendChild(gambar);
            return;
        }

        tampilkanPesan('Pratinjau langsung belum tersedia untuk jenis media ini. Gunakan tombol Buka sumber asli untuk mengunduh atau membuka file.');
    };

    document.querySelectorAll('.tombol-preview-media').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            bukaPopup({
                judul: this.dataset.judul,
                jenis: this.dataset.jenis,
                url: this.dataset.url,
                youtube: this.dataset.youtube,
                tautan: this.dataset.tautan
            });
        });
    });

    tombolTutup.addEventListener('click', tutupPopup);

    popup.addEventListener('click', function (event) {
        if (event.target === popup) tutupPopup();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !popup.classList.contains('hidden')) {
            tutupPopup();
        }
    });
});
</script>
@endpush

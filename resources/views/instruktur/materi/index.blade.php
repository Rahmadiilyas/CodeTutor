@extends('layouts.master')

@section('title', 'Kelola Materi Pembelajaran')
@section('description', 'Kelola materi pembelajaran yang terhubung dengan modul milik Instruktur.')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
    
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Materi Pembelajaran</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Susun isi pembelajaran, atur urutan materi, dan hubungkan setiap materi dengan modul yang kamu kelola.</p>
        </div>
        <a href="{{ route('instruktur.materi.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg> Tambah Materi
        </a>
    </div>

    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"><svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg><p>{{ session('success') }}</p></div>
    @endif
    @if (session('error'))
        <div class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800"><svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4m0 4h.01"/></svg><p>{{ session('error') }}</p></div>
    @endif
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"><p class="font-semibold">Ada data yang perlu diperbaiki.</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Total Materi</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalMateri, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Materi milik akunmu</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg></span></div></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Materi Aktif</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-emerald-700">{{ number_format($materiAktif, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Tersedia untuk dipakai</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-emerald-50 text-emerald-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m5 12 4 4L19 6"/></svg></span></div></div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft"><div class="flex items-start justify-between gap-3"><div><p class="text-sm font-medium text-slate-500">Materi Nonaktif</p><p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-slate-700">{{ number_format($materiNonaktif, 0, ',', '.') }}</p><p class="mt-1 text-xs text-slate-500">Disimpan tetapi dinonaktifkan</p></div><span class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-100 text-slate-600"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M8 12h8"/></svg></span></div></div>
    </div>

    @if ($modulFilter->isEmpty())
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-950">
            <div class="flex items-start gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 9v4m0 4h.01"/><path d="M10.3 3.8 2.4 17.5A2 2 0 0 0 4.1 20h15.8a2 2 0 0 0 1.7-2.5L13.7 3.8a2 2 0 0 0-3.4 0z"/></svg><div><h2 class="font-display font-bold">Belum ada modul pembelajaran</h2><p class="mt-1 text-sm leading-6 text-amber-900/80">Buat modul terlebih dahulu sebelum menambahkan materi. Modul harus dimiliki akun Instruktur ini.</p><a href="{{ route('instruktur.modul.create') }}" class="mt-3 inline-flex items-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700">Buat Modul</a></div></div>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="border-b border-slate-100 px-5 py-4"><h2 class="font-display text-base font-bold text-maroon-950">Daftar Materi</h2><p class="mt-1 text-xs text-slate-500">Materi hanya ditampilkan jika terhubung dengan modul milikmu.</p></div>
        <form method="GET" action="{{ route('instruktur.materi.index') }}" class="grid gap-3 border-b border-slate-100 bg-warm-50/70 p-4 md:grid-cols-[minmax(0,1fr)_240px_160px_auto_auto]">
            <div><label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Kata kunci</label><div class="relative"><svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg><input id="q" name="q" value="{{ request('q') }}" placeholder="Judul, deskripsi, isi, modul..." class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"></div></div>
            <div><label for="modul" class="mb-1.5 block text-xs font-semibold text-slate-600">Modul</label><select id="modul" name="modul" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="">Semua modul</option>@foreach ($modulFilter as $itemModul)<option value="{{ $itemModul->id }}" @selected((string) request('modul') === (string) $itemModul->id)>{{ $itemModul->nama_modul }}</option>@endforeach</select></div>
            <div><label for="status" class="mb-1.5 block text-xs font-semibold text-slate-600">Status</label><select id="status" name="status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="">Semua status</option><option value="1" @selected(request('status') === '1')>Aktif</option><option value="0" @selected(request('status') === '0')>Nonaktif</option></select></div>
            <div class="flex items-end"><button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700">Filter</button></div>
            <div class="flex items-end"><a href="{{ route('instruktur.materi.index') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a></div>
        </form>
        <div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-warm-50"><tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Materi</th><th class="whitespace-nowrap px-5 py-3">Modul</th><th class="whitespace-nowrap px-5 py-3">Konten terkait</th><th class="whitespace-nowrap px-5 py-3">Urutan</th><th class="whitespace-nowrap px-5 py-3">Status</th><th class="whitespace-nowrap px-5 py-3 text-right">Aksi</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($materi as $item)
                <tr class="align-top transition hover:bg-warm-50/70">
                    <td class="max-w-lg px-5 py-4"><div class="flex items-start gap-3"><span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg></span><div><p class="font-display text-sm font-bold text-slate-800">{{ $item->judul_materi }}</p><p class="mt-1 whitespace-normal break-words text-sm leading-5 text-slate-500">{{ $item->deskripsi ?: 'Belum ada deskripsi.' }}</p><p class="mt-1 text-xs text-slate-400">Dibuat {{ optional($item->created_at)->format('d M Y') ?? '—' }} · {{ \Illuminate\Support\Str::limit(trim(strip_tags((string) $item->isi_materi)), 90) ?: 'Isi materi belum ditambahkan.' }}</p></div></div></td>
                    <td class="whitespace-nowrap px-5 py-4"><p class="text-sm font-semibold text-slate-700">{{ $item->modul->nama_modul ?? 'Modul tidak tersedia' }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->modul->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia' }}</p></td>
                    <td class="whitespace-nowrap px-5 py-4"><p class="text-sm font-semibold text-slate-700">{{ $item->media_count }} media</p><p class="mt-1 text-xs text-slate-400">{{ $item->contoh_kode_count }} contoh kode</p></td>
                    <td class="whitespace-nowrap px-5 py-4"><span class="inline-flex min-w-8 justify-center rounded-lg bg-warm-100 px-2.5 py-1 text-sm font-semibold text-slate-700">{{ $item->urutan }}</span></td>
                    <td class="whitespace-nowrap px-5 py-4">@if ($item->status)<span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Aktif</span>@else<span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>Nonaktif</span>@endif</td>
                    <td class="px-5 py-4"><div class="flex flex-wrap items-center justify-end gap-2">
                        <button
                            type="button"
                            data-buka-preview="{{ $item->id }}"
                            class="inline-flex items-center rounded-lg border border-maroon-200 bg-maroon-50 px-2.5 py-2 text-xs font-semibold text-maroon-800 transition hover:bg-maroon-100 focus:outline-none focus:ring-4 focus:ring-maroon-100"
                        >Lihat</button>
                        <a href="{{ route('instruktur.materi.edit', $item) }}" class="inline-flex items-center rounded-lg border border-slate-200 px-2.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800">Edit</a>
                        <form method="POST" action="{{ route('instruktur.materi.status', $item) }}" onsubmit="return confirm('Yakin ingin {{ $item->status ? 'menonaktifkan' : 'mengaktifkan' }} materi ini?')">@csrf @method('PATCH')<button type="submit" class="inline-flex items-center rounded-lg border border-amber-200 px-2.5 py-2 text-xs font-semibold text-amber-700 transition hover:bg-amber-50">{{ $item->status ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                        <form method="POST" action="{{ route('instruktur.materi.destroy', $item) }}" onsubmit="return confirm('Hapus materi {{ addslashes($item->judul_materi) }} beserta {{ (int) $item->media_count }} media dan {{ (int) $item->contoh_kode_count }} contoh kode yang terhubung? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center rounded-lg border border-rose-200 px-2.5 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-50">Hapus</button>
                        </form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-14 text-center"><div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg></div><h3 class="mt-4 font-display text-base font-bold text-slate-800">Belum ada materi pembelajaran</h3><p class="mx-auto mt-1 max-w-md text-sm text-slate-500">Tambahkan materi pada salah satu modul milikmu untuk mulai menyusun isi pembelajaran.</p>@if ($modulFilter->where('status', true)->isNotEmpty())<a href="{{ route('instruktur.materi.create') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Tambah Materi Pertama</a>@endif</td></tr>
            @endforelse
            </tbody>
        </table></div>

        {{-- Data detail untuk popup. Isi materi ditampilkan sebagai teks aman dan tetap mempertahankan baris baru. --}}
        @foreach ($materi as $item)
            <template id="materi-preview-{{ $item->id }}">
                <div class="space-y-7">
                    <section class="border-b border-slate-100 pb-5">
                        <div class="flex flex-wrap items-center gap-2 text-xs">
                            <span class="rounded-full bg-warm-100 px-3 py-1.5 font-semibold text-slate-700">
                                {{ $item->modul->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia' }}
                            </span>
                            <span class="rounded-full bg-maroon-50 px-3 py-1.5 font-semibold text-maroon-800">
                                {{ $item->modul->nama_modul ?? 'Modul tidak tersedia' }}
                            </span>
                            @if ($item->status)
                                <span class="rounded-full bg-emerald-50 px-3 py-1.5 font-semibold text-emerald-700">Aktif</span>
                            @else
                                <span class="rounded-full bg-slate-100 px-3 py-1.5 font-semibold text-slate-600">Nonaktif</span>
                            @endif
                        </div>

                        <h3 class="mt-4 font-display text-xl font-extrabold leading-tight text-maroon-950 sm:text-2xl">
                            {{ $item->judul_materi }}
                        </h3>

                        <p class="mt-2 text-sm leading-7 text-slate-600">
                            {{ $item->deskripsi ?: 'Belum ada deskripsi materi.' }}
                        </p>

                        <div class="mt-4 flex flex-wrap gap-x-5 gap-y-2 text-xs text-slate-500">
                            <span>Urutan: {{ $item->urutan }}</span>
                            <span>Dibuat: {{ optional($item->created_at)->format('d M Y') ?? '—' }}</span>
                            <span>{{ $item->media->count() }} media</span>
                            <span>{{ $item->contohKode->count() }} contoh kode</span>
                        </div>
                    </section>

                    <section>
                        <h4 class="font-display text-base font-bold text-maroon-950">Isi Materi</h4>
                        @if (trim((string) $item->isi_materi) !== '')
                            <div class="mt-3 whitespace-pre-wrap break-words rounded-2xl border border-slate-200 bg-white p-4 text-sm leading-8 text-slate-700 sm:p-6">{{ trim((string) $item->isi_materi) }}</div>
                        @else
                            <p class="mt-3 rounded-xl bg-warm-50 p-4 text-sm leading-6 text-slate-500">Instruktur belum menambahkan isi materi.</p>
                        @endif
                    </section>

                    <section>
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="font-display text-base font-bold text-maroon-950">Media Pembelajaran</h4>
                            <span class="text-xs text-slate-500">{{ $item->media->count() }} media</span>
                        </div>

                        @forelse ($item->media as $media)
                            <div class="mt-3 flex flex-col gap-3 rounded-xl border border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0">
                                    <p class="break-words text-sm font-semibold text-slate-800">{{ $media->judul_media }}</p>
                                    <p class="mt-1 text-xs uppercase text-slate-500">{{ $media->jenis_media }}</p>
                                </div>
                                @if ($media->url_tampilan)
                                    <a href="{{ $media->url_tampilan }}" target="_blank" rel="noopener noreferrer" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-maroon-800 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-maroon-700">
                                        Buka Media
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400">File atau tautan belum tersedia</span>
                                @endif
                            </div>
                        @empty
                            <p class="mt-3 rounded-xl bg-warm-50 p-4 text-sm leading-6 text-slate-500">Belum ada media pembelajaran untuk materi ini.</p>
                        @endforelse
                    </section>

                    <section>
                        <div class="flex items-center justify-between gap-3">
                            <h4 class="font-display text-base font-bold text-maroon-950">Contoh Kode</h4>
                            <span class="text-xs text-slate-500">{{ $item->contohKode->count() }} contoh</span>
                        </div>

                        @forelse ($item->contohKode as $contoh)
                            <div class="mt-3 overflow-hidden rounded-xl border border-slate-200">
                                <div class="border-b border-white/10 bg-maroon-900 px-4 py-3">
                                    <p class="text-sm font-semibold text-white">{{ $contoh->judul ?: 'Contoh Kode' }}</p>
                                    @if ($contoh->deskripsi)
                                        <p class="mt-1 text-xs leading-5 text-white/70">{{ $contoh->deskripsi }}</p>
                                    @endif
                                </div>
                                <pre class="max-h-96 overflow-auto whitespace-pre-wrap break-words bg-slate-950 p-4 text-xs leading-6 text-slate-100"><code>{{ $contoh->kode_program }}</code></pre>
                            </div>
                        @empty
                            <p class="mt-3 rounded-xl bg-warm-50 p-4 text-sm leading-6 text-slate-500">Belum ada contoh kode yang terhubung dengan materi ini.</p>
                        @endforelse
                    </section>
                </div>
            </template>
        @endforeach

        @if ($materi->hasPages())<div class="border-t border-slate-100 px-5 py-4">{{ $materi->links() }}</div>@endif
    </div>
    <p class="text-xs leading-5 text-slate-400">Saat materi dihapus, seluruh media pembelajaran, file media yang tersimpan, dan contoh kode yang terhubung juga akan ikut dihapus. Pastikan data tersebut memang sudah tidak diperlukan.</p>
</div>

{{-- Popup detail materi untuk Instruktur --}}
<div
    id="modalPreviewMateri"
    class="fixed inset-0 z-[150] hidden overflow-y-auto bg-slate-950/60 p-3 backdrop-blur-sm sm:p-6"
    aria-hidden="true"
>
    <div class="flex min-h-full items-center justify-center">
        <section
            role="dialog"
            aria-modal="true"
            aria-labelledby="judulModalMateri"
            class="flex max-h-[92vh] w-full max-w-4xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <header class="flex shrink-0 items-center justify-between gap-4 border-b border-slate-200 px-4 py-4 sm:px-6">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-maroon-700">Pratinjau Materi</p>
                    <h2 id="judulModalMateri" class="mt-1 font-display text-lg font-extrabold text-maroon-950 sm:text-xl">Detail Materi</h2>
                </div>
                <button
                    type="button"
                    id="tutupModalMateri"
                    class="inline-flex shrink-0 items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-maroon-100"
                >Tutup</button>
            </header>

            <div id="kontenPreviewMateri" class="min-h-0 flex-1 overflow-y-auto p-4 sm:p-6">
                <p class="text-sm text-slate-500">Pilih materi untuk melihat detailnya.</p>
            </div>

            <footer class="shrink-0 border-t border-slate-200 bg-warm-50 px-4 py-3 text-right sm:px-6">
                <button
                    type="button"
                    id="tutupModalMateriBawah"
                    class="inline-flex items-center justify-center rounded-lg bg-maroon-800 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100"
                >Tutup</button>
            </footer>
        </section>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalMateri = document.getElementById('modalPreviewMateri');
    const kontenPreview = document.getElementById('kontenPreviewMateri');
    const tombolTutupAtas = document.getElementById('tutupModalMateri');
    const tombolTutupBawah = document.getElementById('tutupModalMateriBawah');

    if (!modalMateri || !kontenPreview) return;

    let tombolTerakhir = null;

    function bukaPreviewMateri(idMateri, tombolPemicu) {
        const templateMateri = document.getElementById('materi-preview-' + idMateri);
        if (!templateMateri) return;

        tombolTerakhir = tombolPemicu;
        kontenPreview.replaceChildren(templateMateri.content.cloneNode(true));
        modalMateri.classList.remove('hidden');
        modalMateri.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden');

        tombolTutupAtas?.focus();
    }

    function tutupPreviewMateri() {
        modalMateri.classList.add('hidden');
        modalMateri.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
        kontenPreview.replaceChildren();

        if (tombolTerakhir) {
            tombolTerakhir.focus();
            tombolTerakhir = null;
        }
    }

    document.querySelectorAll('[data-buka-preview]').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            bukaPreviewMateri(this.dataset.bukaPreview, this);
        });
    });

    tombolTutupAtas?.addEventListener('click', tutupPreviewMateri);
    tombolTutupBawah?.addEventListener('click', tutupPreviewMateri);

    modalMateri.addEventListener('click', function (event) {
        if (event.target === modalMateri) {
            tutupPreviewMateri();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modalMateri.classList.contains('hidden')) {
            tutupPreviewMateri();
        }
    });
});
</script>
@endpush
@endsection

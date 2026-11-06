@extends('layouts.master')

@section('title', 'Pengawasan Konten')
@section('description', 'Pemantauan konten pembelajaran CodeTutor.')

@section('content')
@php
    $tabs = [
        'bahasa' => ['label' => 'Bahasa Pemrograman', 'count' => $totalBahasa, 'icon' => 'terminal'],
        'modul' => ['label' => 'Modul', 'count' => $totalModul, 'icon' => 'book'],
        'materi' => ['label' => 'Materi', 'count' => $totalMateri, 'icon' => 'file'],
        'media' => ['label' => 'Media Pembelajaran', 'count' => $totalMedia, 'icon' => 'media'],
        'kode' => ['label' => 'Code Lab', 'count' => $totalContohKode, 'icon' => 'code'],
        'evaluasi' => ['label' => 'Evaluasi', 'count' => $totalEvaluasi, 'icon' => 'check'],
    ];
    $jumlahSeluruhKonten = $totalBahasa + $totalModul + $totalMateri + $totalMedia + $totalContohKode + $totalEvaluasi;
@endphp

<div class="mx-auto max-w-7xl space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700">
                <span class="h-2 w-2 rounded-full bg-gold-500"></span>
                Administrasi konten
            </div>
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Pengawasan Konten</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                Pantau bahasa pemrograman, modul, materi, media, contoh kode, dan evaluasi yang tersimpan di sistem.
            </p>
        </div>
        <div class="inline-flex items-center gap-2 self-start rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-500 sm:self-auto">
            <svg class="h-4 w-4 text-maroon-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
            Mode pemantauan · hanya baca
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Bahasa Pemrograman</p>
                    <p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalBahasa, 0, ',', '.') }}</p>
                </div>
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-maroon-50 text-maroon-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m8 8-4 4 4 4M16 8l4 4-4 4M14 4l-4 16"/></svg></span>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Modul dan Materi</p>
                    <p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalModul + $totalMateri, 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-slate-400">{{ $totalModul }} modul · {{ $totalMateri }} materi</p>
                </div>
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gold-100 text-maroon-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg></span>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Media, Code Lab, Evaluasi</p>
                    <p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">{{ number_format($totalMedia + $totalContohKode + $totalEvaluasi, 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-slate-400">{{ $totalMedia }} media · {{ $totalContohKode }} contoh kode · {{ $totalEvaluasi }} evaluasi</p>
                </div>
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-100 text-slate-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h5"/></svg></span>
            </div>
        </div>
    </div>

    {{-- Tabs kategori --}}
    <div class="rounded-2xl border border-slate-200/80 bg-white p-3 shadow-soft sm:p-4">
        <div class="mb-3 px-1">
            <h2 class="font-display text-base font-bold text-maroon-950">Kategori konten</h2>
            <p class="mt-1 text-xs text-slate-500">Pilih kategori untuk melihat data yang sudah tersimpan.</p>
        </div>
        <div class="flex gap-2 overflow-x-auto pb-1">
            @foreach ($tabs as $key => $tab)
                <a href="{{ route('admin.pengawasan-konten.index', array_filter(['jenis' => $key, 'q' => $kataKunci, 'status' => in_array($key, ['bahasa', 'modul', 'materi'], true) ? $status : null])) }}"
                    class="inline-flex shrink-0 items-center gap-2 rounded-xl border px-3.5 py-2.5 text-sm font-semibold transition {{ $jenis === $key ? 'border-maroon-800 bg-maroon-800 text-white shadow-sm' : 'border-slate-200 bg-white text-slate-600 hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800' }}">
                    <span>{{ $tab['label'] }}</span>
                    <span class="rounded-lg px-2 py-0.5 text-xs {{ $jenis === $key ? 'bg-white/15 text-white' : 'bg-slate-100 text-slate-500' }}">{{ $tab['count'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Pencarian dan filter --}}
    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-soft sm:p-5">
        <form method="GET" action="{{ route('admin.pengawasan-konten.index') }}" class="grid gap-3 md:grid-cols-2 xl:grid-cols-5">
            <input type="hidden" name="jenis" value="{{ $jenis }}">
            <div class="xl:col-span-3">
                <label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Cari konten</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg>
                    <input id="q" name="q" type="text" value="{{ $kataKunci }}" placeholder="Cari judul, deskripsi, instruktur..." class="w-full rounded-xl border border-slate-200 bg-warm-50 py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                </div>
            </div>
            <div class="{{ in_array($jenis, ['bahasa', 'modul', 'materi'], true) ? '' : 'hidden' }}">
                <label for="status" class="mb-1.5 block text-xs font-semibold text-slate-600">Status konten</label>
                <select id="status" name="status" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    <option value="">Semua status</option>
                    <option value="aktif" @selected($status === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected($status === 'nonaktif')>Nonaktif</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg>
                    Cari
                </button>
                <a href="{{ route('admin.pengawasan-konten.index', ['jenis' => $jenis]) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
            </div>
        </form>
        <div class="mt-3 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-400">
            <span>Menampilkan kategori: <strong class="text-slate-600">{{ $tabs[$jenis]['label'] }}</strong></span>
            <span>{{ $items->total() }} data ditemukan</span>
        </div>
    </div>

    {{-- Tabel data per kategori --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-base font-bold text-maroon-950">{{ $tabs[$jenis]['label'] }}</h2>
                <p class="mt-1 text-xs text-slate-500">Data ditampilkan untuk ditinjau. Perubahan konten dilakukan oleh pengelola yang berwenang.</p>
            </div>
            <span class="w-fit rounded-full bg-warm-100 px-3 py-1 text-xs font-semibold text-maroon-800">{{ $items->firstItem() ?? 0 }}–{{ $items->lastItem() ?? 0 }} dari {{ $items->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-warm-50">
                    @if ($jenis === 'bahasa')
                        <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Bahasa</th><th class="px-5 py-3">Instruktur</th><th class="px-5 py-3">Konten terkait</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Dibuat</th></tr>
                    @elseif ($jenis === 'modul')
                        <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Modul</th><th class="px-5 py-3">Bahasa</th><th class="px-5 py-3">Instruktur</th><th class="px-5 py-3">Konten terkait</th><th class="px-5 py-3">Status</th></tr>
                    @elseif ($jenis === 'materi')
                        <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Materi</th><th class="px-5 py-3">Modul / Bahasa</th><th class="px-5 py-3">Konten terkait</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Dibuat</th></tr>
                    @elseif ($jenis === 'media')
                        <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Media</th><th class="px-5 py-3">Jenis</th><th class="px-5 py-3">Materi / Modul</th><th class="px-5 py-3">Lokasi / Tautan</th><th class="px-5 py-3">Dibuat</th></tr>
                    @elseif ($jenis === 'kode')
                        <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Contoh kode</th><th class="px-5 py-3">Bahasa</th><th class="px-5 py-3">Instruktur</th><th class="px-5 py-3">Materi</th><th class="px-5 py-3">Kode program</th></tr>
                    @else
                        <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500"><th class="px-5 py-3">Evaluasi</th><th class="px-5 py-3">Modul</th><th class="px-5 py-3">Instruktur</th><th class="px-5 py-3">Isi evaluasi</th><th class="px-5 py-3">Nilai minimal</th></tr>
                    @endif
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($items as $item)
                        @if ($jenis === 'bahasa')
                            <tr class="align-top transition hover:bg-warm-50/70">
                                <td class="max-w-xs px-5 py-4"><p class="text-sm font-bold text-slate-800">{{ $item->nama_bahasa }}</p><p class="mt-1 whitespace-normal text-xs leading-5 text-slate-500">{{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}</p></td>
                                <td class="px-5 py-4">@if($item->instruktur)<p class="whitespace-nowrap text-sm font-semibold text-slate-700">{{ $item->instruktur->nama }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->instruktur->email }}</p>@else<span class="text-sm text-slate-400">Instruktur tidak tersedia</span>@endif</td>
                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-600"><p>{{ $item->modul_count }} modul</p><p class="mt-1">{{ $item->contoh_kode_count }} contoh kode</p></td>
                                <td class="px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $item->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $item->status ? 'Aktif' : 'Nonaktif' }}</span></td>
                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500">{{ $item->created_at?->format('d M Y') ?? '—' }}</td>
                            </tr>
                        @elseif ($jenis === 'modul')
                            <tr class="align-top transition hover:bg-warm-50/70">
                                <td class="max-w-sm px-5 py-4"><p class="text-sm font-bold text-slate-800">{{ $item->nama_modul }}</p><p class="mt-1 whitespace-normal text-xs leading-5 text-slate-500">{{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}</p><p class="mt-1 text-[11px] text-slate-400">Urutan: {{ $item->urutan }}</p></td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ $item->bahasa?->nama_bahasa ?? '—' }}</td>
                                <td class="px-5 py-4">@if($item->instruktur)<p class="whitespace-nowrap text-sm font-semibold text-slate-700">{{ $item->instruktur->nama }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->instruktur->email }}</p>@else<span class="text-sm text-slate-400">—</span>@endif</td>
                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-600"><p>{{ $item->materi_count }} materi</p><p class="mt-1">{{ $item->evaluasi_count }} evaluasi</p></td>
                                <td class="px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $item->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $item->status ? 'Aktif' : 'Nonaktif' }}</span></td>
                            </tr>
                        @elseif ($jenis === 'materi')
                            <tr class="align-top transition hover:bg-warm-50/70">
                                <td class="max-w-sm px-5 py-4"><p class="text-sm font-bold text-slate-800">{{ $item->judul_materi }}</p><p class="mt-1 whitespace-normal text-xs leading-5 text-slate-500">{{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}</p><details class="mt-2"><summary class="cursor-pointer text-xs font-semibold text-maroon-700">Lihat ringkasan isi</summary><p class="mt-2 max-w-lg whitespace-pre-line break-words text-xs leading-5 text-slate-600">{{ \Illuminate\Support\Str::limit(strip_tags($item->isi_materi ?? ''), 700) ?: 'Isi materi masih kosong.' }}</p></details></td>
                                <td class="px-5 py-4"><p class="text-sm font-semibold text-slate-700">{{ $item->modul?->nama_modul ?? 'Modul tidak tersedia' }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->modul?->bahasa?->nama_bahasa ?? 'Bahasa tidak tersedia' }}</p></td>
                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-600"><p>{{ $item->media_count }} media</p><p class="mt-1">{{ $item->contoh_kode_count }} contoh kode</p><p class="mt-1 text-slate-400">Urutan: {{ $item->urutan }}</p></td>
                                <td class="px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $item->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">{{ $item->status ? 'Aktif' : 'Nonaktif' }}</span><p class="mt-2 whitespace-nowrap text-xs text-slate-400">{{ $item->created_at?->format('d M Y') ?? '—' }}</p></td>
                                <td class="px-5 py-4 text-xs text-slate-400">ID: {{ $item->id }}</td>
                            </tr>
                        @elseif ($jenis === 'media')
                            @php
                                // Preview hanya untuk YouTube dan file yang diunggah ke storage.
                                // Tautan eksternal biasa cukup dibuka melalui tombol Buka Tautan.
                                $hasUploadedFile = filled($item->lokasi_file);
                                $urlPreview = $hasUploadedFile
                                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($item->lokasi_file)
                                    : null;
                                $externalUrl = $item->tautan && filter_var($item->tautan, FILTER_VALIDATE_URL)
                                    ? $item->tautan
                                    : null;

                                $youtubeEmbed = null;
                                if ($item->jenis_media === 'youtube' && $externalUrl) {
                                    $host = strtolower((string) parse_url($externalUrl, PHP_URL_HOST));
                                    $host = preg_replace('/^www\./', '', $host);
                                    $path = trim((string) parse_url($externalUrl, PHP_URL_PATH), '/');
                                    parse_str((string) parse_url($externalUrl, PHP_URL_QUERY), $params);
                                    $videoId = $host === 'youtu.be'
                                        ? (explode('/', $path)[0] ?? null)
                                        : ($params['v'] ?? (preg_match('~^(?:embed|shorts|live)/([^/?]+)~', $path, $m) ? $m[1] : null));

                                    if (in_array($host, ['youtube.com', 'm.youtube.com', 'youtu.be', 'youtube-nocookie.com'], true)
                                        && $videoId && preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId)) {
                                        $youtubeEmbed = 'https://www.youtube-nocookie.com/embed/' . $videoId;
                                    }
                                }

                                $pathForExtension = $hasUploadedFile
                                    ? $item->lokasi_file
                                    : (parse_url($externalUrl ?? '', PHP_URL_PATH) ?: '');
                                $extensionPreview = strtolower(pathinfo($pathForExtension, PATHINFO_EXTENSION));
                                $fileNamePreview = $hasUploadedFile
                                    ? basename($item->lokasi_file)
                                    : ($pathForExtension ? basename($pathForExtension) : '');

                                $previewableExtensions = [
                                    'pdf', 'ppt', 'pptx', 'pptm', 'odp',
                                    'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp',
                                    'mp4', 'webm', 'mov', 'ogg', 'm4v',
                                    'mp3', 'wav', 'm4a', 'aac', 'flac',
                                ];
                                $canPreviewUploadedFile = $hasUploadedFile
                                    && in_array($extensionPreview, $previewableExtensions, true);
                                $canPreview = filled($youtubeEmbed) || $canPreviewUploadedFile;
                            @endphp
                            <tr class="align-top transition hover:bg-warm-50/70">
                                <td class="max-w-xs px-5 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ $item->judul_media }}</p>
                                    <p class="mt-1 text-xs text-slate-400">ID: {{ $item->id }}</p>
                                    @if($fileNamePreview)
                                        <p class="mt-1 max-w-[220px] truncate text-[11px] text-slate-400" title="{{ $fileNamePreview }}">{{ $fileNamePreview }}</p>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="inline-flex rounded-lg bg-maroon-50 px-2.5 py-1 text-xs font-semibold uppercase text-maroon-800">{{ $item->jenis_media }}</span>
                                    @if($extensionPreview)
                                        <p class="mt-1 text-[10px] font-semibold uppercase text-slate-400">{{ $extensionPreview }}</p>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-slate-700">{{ $item->materi?->judul_materi ?? 'Materi tidak tersedia' }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $item->materi?->modul?->nama_modul ?? 'Modul tidak tersedia' }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $item->materi?->modul?->bahasa?->nama_bahasa ?? '' }}</p>
                                </td>
                                <td class="max-w-xs px-5 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        @if($canPreview)
                                            <button type="button" data-media-preview
                                                data-title="{{ $item->judul_media }}"
                                                data-kind="{{ $item->jenis_media }}"
                                                data-url="{{ $urlPreview }}"
                                                data-youtube="{{ $youtubeEmbed }}"
                                                data-extension="{{ $extensionPreview }}"
                                                class="inline-flex items-center gap-1.5 rounded-lg bg-maroon-800 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                                Preview
                                            </button>
                                        @endif
                                        @if($hasUploadedFile && $urlPreview)
                                            <a href="{{ $urlPreview }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800">Buka File</a>
                                        @elseif($externalUrl)
                                            <a href="{{ $externalUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:bg-maroon-50 hover:text-maroon-800">Buka Tautan</a>
                                        @else
                                            <span class="text-xs text-slate-400">Belum ada file atau tautan</span>
                                        @endif
                                    </div>
                                    @if($item->tautan)
                                        <p class="mt-2 max-w-[240px] break-all text-[10px] leading-4 text-slate-400">{{ $item->tautan }}</p>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500">{{ $item->created_at?->format('d M Y') ?? '—' }}</td>
                            </tr>
                        @elseif ($jenis === 'kode')
                            <tr class="align-top transition hover:bg-warm-50/70">
                                <td class="max-w-xs px-5 py-4"><p class="text-sm font-bold text-slate-800">{{ $item->judul }}</p><p class="mt-1 whitespace-normal text-xs leading-5 text-slate-500">{{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}</p><p class="mt-1 text-[11px] text-slate-400">Dibuat: {{ $item->created_at?->format('d M Y') ?? '—' }}</p></td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ $item->bahasa?->nama_bahasa ?? '—' }}</td>
                                <td class="px-5 py-4">@if($item->instruktur)<p class="whitespace-nowrap text-sm font-semibold text-slate-700">{{ $item->instruktur->nama }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->instruktur->email }}</p>@else<span class="text-sm text-slate-400">—</span>@endif</td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $item->materi?->judul_materi ?? 'Tidak terkait materi' }}</td>
                                <td class="px-5 py-4"><details><summary class="cursor-pointer whitespace-nowrap text-xs font-semibold text-maroon-700">Lihat kode</summary><pre class="mt-2 max-h-72 max-w-md overflow-auto rounded-xl bg-slate-950 p-3 text-xs leading-5 text-emerald-100"><code>{{ $item->kode_program ?: '// Kode program kosong.' }}</code></pre></details></td>
                            </tr>
                        @elseif ($jenis === 'evaluasi')
                            <tr class="align-top transition hover:bg-warm-50/70">
                                <td class="max-w-xs px-5 py-4"><p class="text-sm font-bold text-slate-800">{{ $item->judul_evaluasi }}</p><p class="mt-1 whitespace-normal text-xs leading-5 text-slate-500">{{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}</p><span class="mt-2 inline-flex rounded-lg bg-maroon-50 px-2 py-1 text-[11px] font-semibold uppercase text-maroon-800">{{ $item->jenis_evaluasi }}</span></td>
                                <td class="px-5 py-4"><p class="text-sm font-semibold text-slate-700">{{ $item->modul?->nama_modul ?? 'Modul tidak tersedia' }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->modul?->bahasa?->nama_bahasa ?? '—' }}</p></td>
                                <td class="px-5 py-4">@if($item->instruktur)<p class="whitespace-nowrap text-sm font-semibold text-slate-700">{{ $item->instruktur->nama }}</p><p class="mt-1 text-xs text-slate-400">{{ $item->instruktur->email }}</p>@else<span class="text-sm text-slate-400">—</span>@endif</td>
                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-600"><p>{{ $item->soal_count }} soal</p><p class="mt-1">{{ $item->pengerjaan_count }} pengerjaan</p></td>
                                <td class="whitespace-nowrap px-5 py-4"><span class="inline-flex rounded-lg bg-gold-100 px-2.5 py-1 text-xs font-bold text-maroon-900">{{ $item->nilai_minimal }} / 100</span><p class="mt-2 text-[11px] text-slate-400">Dibuat: {{ $item->created_at?->format('d M Y') ?? '—' }}</p></td>
                            </tr>
                        @endif
                    @empty
                        <tr><td colspan="5" class="px-6 py-14 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 4h16v16H4z"/><path d="M8 9h8M8 13h5"/></svg></div>
                            <h3 class="mt-4 font-display text-base font-bold text-slate-800">Belum ada data pada kategori ini</h3>
                            <p class="mx-auto mt-1 max-w-sm text-sm text-slate-500">Konten akan tampil setelah ada data yang tersimpan atau setelah filter pencarian diubah.</p>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($items->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">{{ $items->links() }}</div>
        @endif
    </div>

    <p class="text-xs leading-5 text-slate-400">Pengawasan Konten bersifat baca-saja. Data diambil dari tabel konten yang sudah ada; halaman ini tidak membuat tabel baru dan tidak mengubah konten.</p>
</div>

@if ($jenis === 'media')
    <div id="mediaPreviewModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/75 p-3 backdrop-blur-sm sm:p-6" aria-hidden="true">
        <div class="flex max-h-[94vh] w-full max-w-6xl flex-col overflow-hidden rounded-2xl border border-white/10 bg-white shadow-2xl">
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-4 py-3 sm:px-6">
                <div class="min-w-0"><p class="text-[10px] font-bold uppercase tracking-[0.18em] text-maroon-700">Preview media pembelajaran</p><h3 id="mediaPreviewTitle" class="mt-1 truncate text-sm font-bold text-slate-900 sm:text-base">Media</h3></div>
                <div class="flex shrink-0 items-center gap-2"><a id="mediaPreviewOpen" href="#" target="_blank" rel="noopener noreferrer" class="hidden rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 sm:inline-flex">Buka di tab baru</a><button type="button" id="mediaPreviewClose" class="grid h-9 w-9 place-items-center rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200" aria-label="Tutup preview"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m18 6-12 12M6 6l12 12"/></svg></button></div>
            </div>
            <div id="mediaPreviewContent" class="min-h-[260px] flex-1 overflow-auto bg-slate-100 p-2 sm:min-h-[520px] sm:p-4"></div>
            <div id="mediaPreviewNote" class="hidden border-t border-slate-100 bg-white px-4 py-3 text-xs leading-5 text-slate-500 sm:px-6"></div>
        </div>
    </div>
    <script>
        (() => {
            const modal = document.getElementById('mediaPreviewModal');
            const title = document.getElementById('mediaPreviewTitle');
            const content = document.getElementById('mediaPreviewContent');
            const note = document.getElementById('mediaPreviewNote');
            const openLink = document.getElementById('mediaPreviewOpen');
            const safeUrl = (value) => {
                try { const u = new URL(value, window.location.origin); return ['http:', 'https:'].includes(u.protocol) ? u.href : null; }
                catch (_) { return null; }
            };
            const message = (heading, description) => {
                const box = document.createElement('div'); box.className = 'grid min-h-[300px] place-content-center px-6 py-12 text-center';
                const h = document.createElement('p'); h.className = 'text-base font-bold text-slate-800'; h.textContent = heading;
                const p = document.createElement('p'); p.className = 'mx-auto mt-2 max-w-lg text-sm leading-6 text-slate-500'; p.textContent = description;
                box.append(h, p); content.append(box);
            };
            const frame = (src, label) => {
                const el = document.createElement('iframe'); el.src = src; el.title = label;
                el.className = 'h-[68vh] min-h-[420px] w-full rounded-xl border border-slate-200 bg-white sm:h-[72vh]';
                el.loading = 'lazy'; el.referrerPolicy = 'strict-origin-when-cross-origin'; el.setAttribute('allowfullscreen', ''); content.append(el);
            };
            const open = (button) => {
                const label = button.dataset.title || 'Media pembelajaran';
                const kind = (button.dataset.kind || '').toLowerCase();
                const ext = (button.dataset.extension || '').toLowerCase();
                const url = safeUrl(button.dataset.url || '');
                const youtube = safeUrl(button.dataset.youtube || '');
                title.textContent = label; content.replaceChildren(); note.textContent = ''; note.classList.add('hidden');
                openLink.classList.add('hidden'); openLink.removeAttribute('href');
                if (url) { openLink.href = url; openLink.classList.remove('hidden'); }

                if (kind === 'youtube') {
                    if (youtube) { frame(youtube + '?rel=0', label); note.textContent = 'Video YouTube diputar langsung di halaman ini.'; note.classList.remove('hidden'); }
                    else message('Tautan YouTube tidak valid', 'Periksa kembali tautan YouTube yang tersimpan.');
                } else if (!url) {
                    message('Preview tidak tersedia', 'File atau tautan media belum tersedia.');
                } else if (ext === 'pdf' || kind === 'pdf') {
                    frame(url + (url.includes('#') ? '' : '#toolbar=1&navpanes=0'), label);
                    note.textContent = 'PDF ditampilkan dengan penampil bawaan browser. Jika kosong, buka file di tab baru atau periksa storage:link.'; note.classList.remove('hidden');
                } else if (['ppt','pptx','pptm','odp'].includes(ext) || kind === 'ppt') {
                    frame('https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent(url), label);
                    note.textContent = 'PowerPoint memakai Microsoft Office Viewer dan membutuhkan URL yang bisa diakses publik. File di localhost/server privat tidak dapat diambil oleh viewer eksternal; gunakan versi PDF untuk preview lokal.'; note.classList.remove('hidden');
                } else if (['jpg','jpeg','png','gif','webp','svg','bmp'].includes(ext)) {
                    const img = document.createElement('img'); img.src = url; img.alt = label; img.className = 'mx-auto max-h-[72vh] max-w-full rounded-xl object-contain shadow-sm'; content.append(img);
                    img.onerror = () => { content.replaceChildren(); message('Gambar tidak dapat ditampilkan', 'Periksa file dan izin aksesnya.'); };
                } else if (['mp4','webm','mov','ogg','m4v'].includes(ext) || kind === 'video') {
                    const v = document.createElement('video'); v.src = url; v.controls = true; v.playsInline = true; v.preload = 'metadata'; v.className = 'mx-auto max-h-[72vh] w-full rounded-xl bg-black'; content.append(v);
                    note.textContent = 'Jika video tidak diputar, browser mungkin tidak mendukung codec file tersebut.'; note.classList.remove('hidden');
                } else if (['mp3','wav','m4a','aac','flac'].includes(ext)) {
                    const a = document.createElement('audio'); a.src = url; a.controls = true; a.className = 'mx-auto mt-16 w-full max-w-2xl'; content.append(a);
                } else if (kind === 'game' || ext === 'zip') {
                    message('Paket pembelajaran', 'File ZIP tidak dapat dipreview langsung. Gunakan tombol Buka di tab baru untuk mengakses atau mengunduhnya.');
                } else {
                    message('Preview belum tersedia untuk format ini', 'Gunakan tombol Buka di tab baru untuk membuka atau mengunduh file.');
                }
                modal.classList.remove('hidden'); modal.classList.add('flex'); modal.setAttribute('aria-hidden', 'false'); document.body.classList.add('overflow-hidden');
            };
            const close = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); modal.setAttribute('aria-hidden','true'); content.replaceChildren(); document.body.classList.remove('overflow-hidden'); };
            document.querySelectorAll('[data-media-preview]').forEach(btn => btn.addEventListener('click', () => open(btn)));
            document.getElementById('mediaPreviewClose')?.addEventListener('click', close);
            modal.addEventListener('click', e => { if (e.target === modal) close(); });
            document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) close(); });
        })();
    </script>
@endif

@endsection

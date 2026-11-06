@extends('layouts.master')

@section('title', 'Aktivitas Sistem')

@section('description', 'Riwayat aktivitas pengguna dan perubahan penting di CodeTutor.')

@section('page_label', 'Administrasi Sistem')

@section('page_heading', 'Aktivitas Sistem')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">

    {{-- Heading --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700">
                <span class="h-2 w-2 rounded-full bg-gold-500"></span>
                Pemantauan sistem
            </div>
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">
                Aktivitas Sistem
            </h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                Telusuri aktivitas penting yang tercatat di sistem, termasuk pengelolaan akun dan perubahan data.
            </p>
        </div>
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white text-maroon-700 shadow-sm ring-1 ring-slate-200">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M12 7v5l3 2"></path>
                </svg>
            </span>
            <span>Urutan terbaru terlebih dahulu</span>
        </div>
    </div>

    {{-- Flash message --}}
    @if (session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m5 12 4 4L19 6"></path>
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <p class="font-semibold">Filter tidak dapat diproses.</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Summary --}}
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total aktivitas tercatat</p>
                    <p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">
                        {{ number_format($totalAktivitas, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">Seluruh catatan aktivitas di sistem</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-maroon-50 text-maroon-700">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M8 6h13M8 12h13M8 18h13"></path>
                        <path d="M3 6h.01M3 12h.01M3 18h.01"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Aktivitas hari ini</p>
                    <p class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950">
                        {{ number_format($aktivitasHariIni, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gold-100 text-maroon-800">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="17" rx="2"></rect>
                        <path d="M16 2v4M8 2v4M3 10h18"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-soft sm:p-5">
        <div class="mb-4">
            <h2 class="font-display text-base font-bold text-maroon-950">Cari dan filter aktivitas</h2>
            <p class="mt-1 text-xs text-slate-500">Gunakan kata kunci, jenis aktivitas, atau rentang tanggal.</p>
        </div>

        <form method="GET" action="{{ route('admin.aktivitas.index') }}" class="grid gap-3 md:grid-cols-2 xl:grid-cols-6">
            <div class="xl:col-span-2">
                <label for="q" class="mb-1.5 block text-xs font-semibold text-slate-600">Kata kunci</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="10.8" cy="10.8" r="6.8"></circle>
                        <path d="m16 16 5 5"></path>
                    </svg>
                    <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Nama, email, deskripsi..."
                        class="w-full rounded-xl border border-slate-200 bg-warm-50 py-2.5 pl-9 pr-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                </div>
            </div>

            <div>
                <label for="jenis_aktivitas" class="mb-1.5 block text-xs font-semibold text-slate-600">Jenis aktivitas</label>
                <select id="jenis_aktivitas" name="jenis_aktivitas"
                    class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    <option value="">Semua aktivitas</option>
                    @foreach ($jenisAktivitas as $jenis)
                        <option value="{{ $jenis }}" @selected(request('jenis_aktivitas') === $jenis)>{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="peran_user" class="mb-1.5 block text-xs font-semibold text-slate-600">Peran pengguna</label>
                <select id="peran_user" name="peran_user"
                    class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    <option value="">Semua peran</option>
                    <option value="admin" @selected(request('peran_user') === 'admin')>Admin</option>
                    <option value="instruktur" @selected(request('peran_user') === 'instruktur')>Instruktur</option>
                    <option value="pelajar" @selected(request('peran_user') === 'pelajar')>Pelajar</option>
                </select>
            </div>

            <div>
                <label for="tanggal_mulai" class="mb-1.5 block text-xs font-semibold text-slate-600">Dari tanggal</label>
                <input id="tanggal_mulai" name="tanggal_mulai" type="date" value="{{ request('tanggal_mulai') }}"
                    class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
            </div>

            <div>
                <label for="tanggal_selesai" class="mb-1.5 block text-xs font-semibold text-slate-600">Sampai tanggal</label>
                <input id="tanggal_selesai" name="tanggal_selesai" type="date" value="{{ request('tanggal_selesai') }}"
                    class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3 py-2.5 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
            </div>

            <div class="flex flex-wrap items-center gap-2 md:col-span-2 xl:col-span-6">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="10.8" cy="10.8" r="6.8"></circle>
                        <path d="m16 16 5 5"></path>
                    </svg>
                    Terapkan Filter
                </button>
                <a href="{{ route('admin.aktivitas.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Reset
                </a>
                <span class="text-xs text-slate-400 md:ml-auto">
                    {{ $aktivitas->total() }} catatan ditemukan
                </span>
            </div>
        </form>
    </div>

    {{-- Activity table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="flex flex-col gap-1 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-base font-bold text-maroon-950">Riwayat aktivitas</h2>
                <p class="mt-1 text-xs text-slate-500">Detail aktivitas disesuaikan dengan data yang tersedia di log.</p>
            </div>
            <span class="w-fit rounded-full bg-warm-100 px-3 py-1 text-xs font-semibold text-maroon-800">
                {{ $aktivitas->firstItem() ?? 0 }}–{{ $aktivitas->lastItem() ?? 0 }} dari {{ $aktivitas->total() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-warm-50">
                    <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="whitespace-nowrap px-5 py-3">Waktu</th>
                        <th class="whitespace-nowrap px-5 py-3">Pengguna</th>
                        <th class="whitespace-nowrap px-5 py-3">Peran</th>
                        <th class="whitespace-nowrap px-5 py-3">Aktivitas</th>
                        <th class="min-w-[260px] px-5 py-3">Deskripsi</th>
                        <th class="whitespace-nowrap px-5 py-3">Entitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($aktivitas as $item)
                        <tr class="align-top transition hover:bg-warm-50/70">
                            <td class="whitespace-nowrap px-5 py-4">
                                <p class="text-sm font-semibold text-slate-700">
                                    {{ $item->waktu_aktivitas ? \Carbon\Carbon::parse($item->waktu_aktivitas)->format('d M Y') : '—' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $item->waktu_aktivitas ? \Carbon\Carbon::parse($item->waktu_aktivitas)->format('H:i:s') : 'Waktu tidak tersedia' }}
                                </p>
                            </td>
                            <td class="px-5 py-4">
                                @if ($item->user)
                                    <p class="whitespace-nowrap text-sm font-semibold text-slate-800">{{ $item->user->nama }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $item->user->email }}</p>
                                @else
                                    <p class="text-sm font-medium text-slate-500">Pengguna tidak tersedia</p>
                                    <p class="mt-1 text-xs text-slate-400">ID: {{ $item->id_user ?? '—' }}</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4">
                                @php
                                    $peranLabel = [
                                        'admin' => 'Admin',
                                        'instruktur' => 'Instruktur',
                                        'pelajar' => 'Pelajar',
                                    ];
                                @endphp
                                <span class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                    {{ $peranLabel[$item->user->peran ?? ''] ?? 'Tidak tersedia' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex max-w-[220px] items-center rounded-lg border border-maroon-100 bg-maroon-50 px-2.5 py-1 text-xs font-semibold text-maroon-800">
                                    {{ $item->jenis_aktivitas ?: 'Aktivitas lainnya' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="max-w-xl whitespace-normal break-words text-sm leading-6 text-slate-600">
                                    {{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}
                                </p>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4">
                                @if ($item->entitas)
                                    <p class="text-xs font-semibold text-slate-700">{{ $item->entitas }}</p>
                                    <p class="mt-1 text-xs text-slate-400">ID: {{ $item->id_entitas ?? '—' }}</p>
                                @else
                                    <span class="text-sm text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-warm-100 text-maroon-700">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <path d="M12 7v5l3 2"></path>
                                    </svg>
                                </div>
                                <h3 class="mt-4 font-display text-base font-bold text-slate-800">Belum ada aktivitas yang cocok</h3>
                                <p class="mx-auto mt-1 max-w-sm text-sm text-slate-500">Coba ubah kata kunci atau rentang tanggal. Aktivitas akan tampil setelah sistem mencatat suatu tindakan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($aktivitas->hasPages())
            <div class="border-t border-slate-100 px-5 py-4">
                {{ $aktivitas->links() }}
            </div>
        @endif
    </div>

    <p class="text-xs leading-5 text-slate-400">
        Catatan: halaman ini menampilkan catatan yang benar-benar tersimpan pada tabel <code class="rounded bg-white px-1.5 py-0.5 text-slate-600">log_aktivitas</code>.
        Jenis tindakan yang belum mencatat log tidak akan muncul di riwayat.
    </p>
</div>
@endsection

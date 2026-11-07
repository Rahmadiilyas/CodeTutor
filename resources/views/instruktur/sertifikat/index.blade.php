@extends('layouts.master')

@section('title', 'Penerbitan Sertifikat — CodeTutor')
@section('description', 'Tinjau pencapaian Pelajar dan terbitkan sertifikat penyelesaian modul.')
@section('page_label', 'Instruktur')
@section('page_heading', 'Penerbitan Sertifikat')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 pb-10">

    {{-- HERO CARD --}}
    <section class="relative isolate overflow-hidden rounded-[28px] bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 p-6 text-white shadow-card sm:p-8">
        <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border-[32px] border-gold-400/10"></div>
        <div class="pointer-events-none absolute -bottom-24 right-1/4 h-48 w-48 rounded-full border-[24px] border-white/5"></div>
        <div class="pointer-events-none absolute bottom-0 right-0 h-28 w-28 rotate-45 translate-x-12 translate-y-12 bg-gold-400/10"></div>

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-400/25 bg-white/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.16em] text-gold-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                    Apresiasi Pencapaian Pembelajaran
                </span>
                <h1 class="mt-4 font-display text-2xl font-extrabold tracking-tight text-white sm:text-3xl lg:text-4xl">
                    Penerbitan Sertifikat
                </h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-white/70">
                    Tinjau progres belajar dan hasil Post-test Pelajar. Terbitkan sertifikat sebagai bentuk apresiasi bagi Pelajar yang telah memenuhi seluruh kriteria penyelesaian modul.
                </p>

                @if ($selectedModul)
                    <div class="mt-5 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/10 px-3 py-2 text-xs font-semibold text-white">
                            <svg class="h-4 w-4 text-gold-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                            </svg>
                            {{ $selectedModul->nama_modul }}
                        </span>
                        <span class="rounded-xl border border-gold-400/20 bg-gold-400/10 px-3 py-2 text-xs font-semibold text-gold-200">
                            {{ $selectedModul->bahasa->nama_bahasa ?? 'Bahasa Pemrograman' }}
                        </span>
                    </div>
                @else
                    <p class="mt-5 inline-flex rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-xs text-white/65">
                        Pilih modul untuk melihat pencapaian Pelajar.
                    </p>
                @endif
            </div>

            <div class="grid w-full grid-cols-2 gap-3 sm:max-w-sm lg:w-[330px] lg:shrink-0">
                <div class="rounded-2xl border border-white/10 bg-white/[.08] p-4 backdrop-blur-sm sm:p-5">
                    <div class="flex items-center gap-2 text-gold-200">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="6" />
                            <path d="m8.5 13-1 9 4.5-2.5 4.5 2.5-1-9" />
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-white/60">Sertifikat Terbit</span>
                    </div>
                    <p class="mt-3 font-display text-3xl font-extrabold text-white sm:text-4xl">{{ number_format((int) $totalTerbit, 0, ',', '.') }}</p>
                    <p class="mt-1 text-[10px] text-white/45">Total diterbitkan oleh akun Anda</p>
                </div>

                <div class="rounded-2xl border border-gold-400/20 bg-gold-400/10 p-4 backdrop-blur-sm sm:p-5">
                    <div class="flex items-center gap-2 text-gold-200">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v18H6.5A2.5 2.5 0 0 1 4 18.5z" />
                            <path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20" />
                        </svg>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-white/60">Modul Dikelola</span>
                    </div>
                    <p class="mt-3 font-display text-3xl font-extrabold text-white sm:text-4xl">{{ number_format((int) $totalModul, 0, ',', '.') }}</p>
                    <p class="mt-1 text-[10px] text-white/45">Modul milik Anda</p>
                </div>
            </div>
        </div>
    </section>

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if (session('info'))
        <div class="rounded-2xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-800">{{ session('info') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">{{ session('error') }}</div>
    @endif

    {{-- FILTER MODUL --}}
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-soft sm:p-6">
        <div class="mb-4">
            <h2 class="font-display text-base font-extrabold text-maroon-950">Pilih Modul Pembelajaran</h2>
            <p class="mt-1 text-xs leading-5 text-slate-500">Pilih modul yang ingin ditinjau pencapaiannya sebelum menerbitkan sertifikat.</p>
        </div>
        <form method="GET" action="{{ route('instruktur.sertifikat.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div class="min-w-0 flex-1">
                <label for="modul" class="mb-1.5 block text-xs font-bold text-slate-600">Modul pembelajaran</label>
                <select id="modul" name="modul" required class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm font-semibold text-slate-700 outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    <option value="">Pilih modul</option>
                    @foreach ($modulList as $modul)
                        <option value="{{ $modul->id }}" @selected($selectedModul && (int) $selectedModul->id === (int) $modul->id)>
                            {{ $modul->nama_modul }} — {{ $modul->bahasa->nama_bahasa ?? 'Bahasa' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 4h18l-7 8v6l-4 2v-8L3 4Z" />
                </svg>
                Tampilkan Pencapaian
            </button>
        </form>
        @if ($modulList->isEmpty())
            <p class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-800">
                Kamu belum memiliki modul. Buat modul pembelajaran terlebih dahulu sebelum menerbitkan sertifikat.
            </p>
        @endif
    </section>

    {{-- DAFTAR PENCAPAIAN --}}
    @if ($selectedModul)
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-700">Pencapaian Modul</p>
                    <h2 class="mt-1 font-display text-xl font-extrabold text-maroon-950">{{ $selectedModul->nama_modul }}</h2>
                    <p class="mt-1 text-xs leading-5 text-slate-500">Kriteria: progres 100% dan seluruh Post-test selesai dengan nilai minimal yang ditentukan.</p>
                </div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-warm-100 px-3 py-1.5 text-xs font-bold text-maroon-800">
                    <span class="h-1.5 w-1.5 rounded-full bg-maroon-600"></span>
                    {{ $rows->count() }} Pelajar
                </span>
            </div>

            @if ($rows->isEmpty())
                <div class="px-6 py-12 text-center">
                    <div class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-warm-100 text-maroon-700">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <p class="mt-3 font-bold text-slate-700">Belum ada Pelajar aktif</p>
                    <p class="mt-1 text-sm text-slate-500">Belum ada akun Pelajar aktif untuk ditampilkan.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[850px] text-left">
                        <thead class="bg-warm-50 text-[10px] uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-5 py-4 font-bold">Pelajar</th>
                                <th class="px-5 py-4 font-bold">Progres</th>
                                <th class="px-5 py-4 font-bold">Post-test</th>
                                <th class="px-5 py-4 font-bold">Kelayakan</th>
                                <th class="px-5 py-4 text-right font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($rows as $row)
                                <tr class="align-top transition hover:bg-warm-50/60">
                                    <td class="px-5 py-4">
                                        <p class="text-sm font-bold text-maroon-950">{{ $row['pelajar']->nama }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $row['pelajar']->email }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        <p class="text-sm font-extrabold text-maroon-950">{{ number_format($row['progres'], 0) }}%</p>
                                        <div class="mt-2 h-1.5 w-28 overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-gradient-to-r from-maroon-700 to-gold-500" style="width: {{ min(100, max(0, $row['progres'])) }}%"></div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($row['jumlah_posttest'] === 0)
                                            <span class="text-xs text-slate-500">Belum tersedia</span>
                                        @else
                                            <span class="text-sm font-semibold text-maroon-950">{{ $row['posttest_lulus'] }} / {{ $row['jumlah_posttest'] }} lulus</span>
                                            <div class="mt-1.5 space-y-1">
                                                @foreach ($row['post_tests'] as $test)
                                                    <p class="text-[10px] {{ $test['passed'] ? 'font-semibold text-emerald-700' : 'text-slate-500' }}">
                                                        {{ $test['title'] }}: {{ $test['nilai'] === null ? str_replace('_', ' ', $test['status']) : $test['nilai'] . '/' . $test['nilai_minimal'] }}
                                                    </p>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ($row['sertifikat'])
                                            <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700">Sudah diterbitkan</span>
                                        @elseif ($row['layak'])
                                            <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700">Layak</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700">Belum layak</span>
                                        @endif
                                        <p class="mt-1 max-w-52 text-[10px] leading-5 text-slate-500">{{ $row['alasan'] }}</p>
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        @if ($row['sertifikat'])
                                            <span class="text-xs font-semibold text-slate-400">{{ $row['sertifikat']->nomor_sertifikat }}</span>
                                        @elseif ($row['layak'])
                                            <form method="POST" action="{{ route('instruktur.sertifikat.store') }}" onsubmit="return confirm('Terbitkan sertifikat untuk {{ addslashes($row['pelajar']->nama) }}?')">
                                                @csrf
                                                <input type="hidden" name="id_modul" value="{{ $selectedModul->id }}">
                                                <input type="hidden" name="id_pelajar" value="{{ $row['pelajar']->id }}">
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-maroon-800 px-3.5 py-2.5 text-xs font-bold text-white transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
                                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 3v12" />
                                                        <path d="m7 10 5 5 5-5" />
                                                        <path d="M5 21h14" />
                                                    </svg>
                                                    Terbitkan PDF
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400">Belum dapat diterbitkan</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    @else
        <section class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center shadow-soft">
            <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-warm-100 text-maroon-700">
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v18H6.5A2.5 2.5 0 0 1 4 18.5z" />
                    <path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20" />
                </svg>
            </div>
            <h2 class="mt-4 font-display text-base font-extrabold text-maroon-950">Pilih modul terlebih dahulu</h2>
            <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-slate-500">Daftar pencapaian Pelajar akan ditampilkan setelah kamu memilih modul pembelajaran di atas.</p>
        </section>
    @endif
</div>
@endsection

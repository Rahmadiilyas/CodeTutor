
@php
    $isPretest = strtolower($jenis) === 'pretest';
    $jenisLabel = $isPretest ? 'Pretest' : 'Posttest';

    $tema = $isPretest
        ? [
            'badge' => 'bg-amber-50 text-amber-700 ring-amber-200',
            'dot' => 'bg-amber-500',
            'icon' => 'bg-amber-50 text-amber-600',
            'border' => 'border-l-amber-400',
        ]
        : [
            'badge' => 'bg-maroon-50 text-maroon-800 ring-maroon-200',
            'dot' => 'bg-maroon-700',
            'icon' => 'bg-maroon-50 text-maroon-800',
            'border' => 'border-l-maroon-700',
        ];
@endphp

@if ($daftarEvaluasi->isNotEmpty())

    <div class="space-y-4">

        {{-- Header daftar evaluasi --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold tracking-tight text-slate-800">
                    Riwayat {{ $jenisLabel }}
                </h3>
                <p class="mt-1 text-xs text-slate-500">
                    Daftar hasil pengerjaan {{ strtolower($jenisLabel) }} kamu.
                </p>
            </div>

            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                <span class="h-1.5 w-1.5 rounded-full {{ $tema['dot'] }}"></span>
                {{ $daftarEvaluasi->count() }} Evaluasi
            </span>
        </div>

        {{-- Daftar evaluasi --}}
        <div class="grid gap-3">

            @foreach ($daftarEvaluasi as $hasil)

                @php
                    $menungguNilai = $hasil->status === 'menunggu_penilaian'
                        || ($hasil->waktu_selesai !== null && $hasil->nilai === null);

                    $belumDikumpulkan = $hasil->waktu_selesai === null;

                    $evaluasi = $hasil->evaluasi;

                    $namaModul = optional(optional($evaluasi)->modul)->nama_modul
                        ?? 'Modul tidak tersedia';

                    $judulEvaluasi = optional($evaluasi)->judul_evaluasi
                        ?? 'Evaluasi tidak tersedia';

                    $tanggalSelesai = $hasil->waktu_selesai
                        ? \Illuminate\Support\Carbon::parse($hasil->waktu_selesai)
                        : null;

                    if ($menungguNilai) {
                        $statusLabel = 'Menunggu Penilaian';
                        $statusClass = 'bg-sky-50 text-sky-700 ring-sky-200';
                        $statusDot = 'bg-sky-500';
                    } elseif ($belumDikumpulkan) {
                        $statusLabel = 'Belum Dikumpulkan';
                        $statusClass = 'bg-amber-50 text-amber-700 ring-amber-200';
                        $statusDot = 'bg-amber-500';
                    } elseif ($hasil->nilai !== null) {
                        $statusLabel = 'Selesai Dinilai';
                        $statusClass = 'bg-emerald-50 text-emerald-700 ring-emerald-200';
                        $statusDot = 'bg-emerald-500';
                    } else {
                        $statusLabel = 'Sudah Dikumpulkan';
                        $statusClass = 'bg-slate-100 text-slate-600 ring-slate-200';
                        $statusDot = 'bg-slate-400';
                    }
                @endphp

                <article
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md"
                >
                    {{-- Garis aksen --}}
                    <div class="absolute inset-y-0 left-0 w-1 {{ $tema['dot'] }}"></div>

                    <div class="flex flex-col gap-4 p-4 pl-5 sm:flex-row sm:items-center sm:justify-between sm:p-5 sm:pl-6">

                        {{-- Informasi evaluasi --}}
                        <div class="flex min-w-0 flex-1 items-start gap-3">

                            {{-- Ikon --}}
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $tema['icon'] }}">
                                @if ($isPretest)
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M9 11l3 3L22 4"/>
                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 3l2.5 5.5L20 11l-5.5 2.5L12 19l-2.5-5.5L4 11l5.5-2.5L12 3z"/>
                                        <path d="M19 14v4"/>
                                        <path d="M17 16h4"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">

                                {{-- Label dan status --}}
                                <div class="mb-2 flex flex-wrap items-center gap-2">
                                    <span class="rounded-md px-2 py-1 text-[10px] font-bold uppercase tracking-wider ring-1 ring-inset {{ $tema['badge'] }}">
                                        {{ $jenisLabel }}
                                    </span>

                                    <span class="inline-flex items-center gap-1.5 rounded-md px-2 py-1 text-[10px] font-semibold ring-1 ring-inset {{ $statusClass }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                {{-- Judul --}}
                                <h4 class="truncate text-sm font-bold text-slate-800 transition group-hover:text-maroon-800 sm:text-base">
                                    {{ $judulEvaluasi }}
                                </h4>

                                {{-- Nama modul --}}
                                <div class="mt-2 flex items-center gap-1.5 text-xs text-slate-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 shrink-0 text-slate-400"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                    </svg>

                                    <span class="truncate">{{ $namaModul }}</span>
                                </div>

                                {{-- Tanggal --}}
                                <div class="mt-1.5 flex items-center gap-1.5 text-xs text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5 shrink-0"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                        <path d="M16 2v4M8 2v4M3 10h18"/>
                                    </svg>

                                    @if ($tanggalSelesai)
                                        <span>
                                            Dikumpulkan {{ $tanggalSelesai->translatedFormat('d F Y, H:i') }}
                                        </span>
                                    @else
                                        <span>Belum ada tanggal pengumpulan</span>
                                    @endif
                                </div>

                            </div>
                        </div>

                        {{-- Panel nilai --}}
                        <div class="flex items-center justify-between gap-4 rounded-xl bg-slate-50 px-4 py-3 sm:min-w-[155px] sm:justify-center sm:text-center">

                            @if ($menungguNilai)

                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                        Hasil Evaluasi
                                    </p>
                                    <p class="mt-1 text-sm font-bold text-sky-700">
                                        Menunggu
                                    </p>
                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        Sedang diperiksa
                                    </p>
                                </div>

                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-sky-100 text-sky-600 sm:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                </div>

                            @elseif ($belumDikumpulkan)

                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                        Hasil Evaluasi
                                    </p>
                                    <p class="mt-1 text-sm font-bold text-amber-700">
                                        Belum Selesai
                                    </p>
                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        Belum dikumpulkan
                                    </p>
                                </div>

                            @elseif ($hasil->nilai !== null)

                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                        Nilai Akhir
                                    </p>

                                    <p class="mt-0.5 font-display text-3xl font-extrabold tracking-tight text-slate-900">
                                        {{ number_format((float) $hasil->nilai, 0, ',', '.') }}
                                        <span class="text-sm font-semibold text-slate-400">/100</span>
                                    </p>

                                    <p class="mt-0.5 text-[10px] font-semibold text-emerald-700">
                                        <span class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3 w-3"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="m5 12 4 4L19 6"/>
                                            </svg>
                                            Nilai tersedia
                                        </span>
                                    </p>
                                </div>

                            @else

                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                        Hasil Evaluasi
                                    </p>
                                    <p class="mt-1 text-sm font-bold text-slate-600">
                                        Terkumpul
                                    </p>
                                    <p class="mt-0.5 text-[10px] text-slate-400">
                                        Menunggu hasil nilai
                                    </p>
                                </div>

                            @endif

                        </div>

                    </div>
                </article>

            @endforeach

        </div>
    </div>

@else

    {{-- Empty state --}}
    <div class="overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-12 text-center">

        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl {{ $tema['icon'] }}">
            @if ($isPretest)
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M12 3l2.5 5.5L20 11l-5.5 2.5L12 19l-2.5-5.5L4 11l5.5-2.5L12 3z"/>
                </svg>
            @endif
        </div>

        <h3 class="mt-5 text-base font-bold text-slate-800">
            Belum Ada Hasil {{ $jenisLabel }}
        </h3>

        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500">
            Riwayat pengerjaan {{ strtolower($jenisLabel) }} kamu akan muncul di sini setelah evaluasi mulai dikerjakan dan dikumpulkan.
        </p>

        <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-3.5 w-3.5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 8v4l3 2"/>
            </svg>
            Riwayat belum tersedia
        </div>

    </div>

@endif
 
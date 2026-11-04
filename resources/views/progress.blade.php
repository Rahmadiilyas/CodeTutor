            @extends('layouts.master')

@section('title', 'Progres Belajar')

@section('content')
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[.2em] text-gold-600">Evaluasi</p>
                        <h2 class="mt-1 text-lg font-black text-slate-800">Riwayat Evaluasi Terakhir</h2>
                    </div>
                    <a href="{{ route('pelajar.evaluasi.index') }}" class="shrink-0 text-xs font-bold text-maroon-800 transition hover:text-gold-600">Lihat evaluasi</a>
                </div>

{{-- Tabel Evaluasi Pretest dan Posttest --}}
<div class="mt-6 overflow-hidden rounded-xl border border-slate-200">
    <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
        <h3 class="text-sm font-black text-slate-800">
            Daftar Evaluasi Pretest dan Posttest
        </h3>
        <p class="mt-1 text-xs text-slate-500">
            Pantau jenis evaluasi, nilai, dan status pengerjaanmu.
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[650px] text-left text-xs">
            <thead class="bg-white text-[10px] uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3 font-black">No.</th>
                    <th class="px-4 py-3 font-black">Nama Evaluasi</th>
                    
                    <th class="px-4 py-3 text-center font-black">Nilai</th>
                    <th class="px-4 py-3 font-black">Status</th>
                    <th class="px-4 py-3 font-black">Tanggal</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($riwayatEvaluasi as $hasil)
                    @php
    $evaluasi = $hasil->evaluasi;

    $jenisEvaluasi = strtolower(trim(
        (string) ($evaluasi->jenis_evaluasi ?? '')
    ));

    if ($jenisEvaluasi === 'pretest') {
        $jenisTampil = 'Pretest';
    } elseif ($jenisEvaluasi === 'posttest') {
        $jenisTampil = 'Posttest';
    } elseif ($jenisEvaluasi === 'kuis') {
        $jenisTampil = 'Kuis';
    } else {
        $jenisTampil = 'Jenis belum diatur';
    }

    $statusEvaluasi = strtolower(
        (string) ($hasil->status ?? '')
    );

    $menungguNilai = $statusEvaluasi === 'menunggu_penilaian'
        || (
            $hasil->waktu_selesai !== null
            && $hasil->nilai === null
        );
@endphp

                    <tr class="transition hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-500">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3 font-bold text-slate-700">
                            {{ $hasil->evaluasi->judul_evaluasi ?? 'Evaluasi tidak tersedia' }}
                        </td>

                        

                        <td class="px-4 py-3 text-center font-black text-maroon-800">
                            {{ $hasil->nilai !== null
                                ? number_format((float) $hasil->nilai, 0, ',', '.') . '/100'
                                : '-' }}
                        </td>

                        <td class="px-4 py-3">
                            @php
    $statusEvaluasi = strtolower(
        (string) ($hasil->status ?? '')
    );

    $menungguNilai = $statusEvaluasi === 'menunggu_penilaian'
        || (
            $hasil->waktu_selesai !== null
            && $hasil->nilai === null
        );
@endphp
                            @if ($menungguNilai)
                                <span class="font-bold text-sky-700">
                                    Menunggu penilaian
                                </span>
                            @elseif ($hasil->nilai !== null)
                                <span class="font-bold text-emerald-700">
                                    Selesai
                                </span>
                            @elseif ($hasil->waktu_selesai !== null)
                                <span class="font-bold text-amber-700">
                                    Sudah dikerjakan
                                </span>
                            @else
                                <span class="font-bold text-slate-500">
                                    Belum dikerjakan
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-slate-500">
                            {{ $hasil->waktu_selesai
                                ? \Carbon\Carbon::parse($hasil->waktu_selesai)->format('d/m/Y')
                                : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center">
                            <p class="font-bold text-slate-700">
                                Belum ada data evaluasi
                            </p>
                            <p class="mt-1 text-slate-500">
                                Evaluasi Pretest dan Posttest akan ditampilkan di sini.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

                <div class="mt-5 divide-y divide-slate-100">
                    @forelse ($riwayatEvaluasi as $hasil)
                        @php
                            $statusHasil = strtolower((string) ($hasil->status ?? ''));
                            $menungguPenilaian = $statusHasil === 'menunggu_penilaian'
                                || ($hasil->waktu_selesai !== null && $hasil->nilai === null);
                        @endphp
                        <div class="flex items-start gap-3 py-4">
                            <div class="grid h-10 w-10 shrink-0 place-items-center rounded-xl {{ $menungguPenilaian ? 'bg-sky-50 text-sky-700' : 'bg-gold-50 text-maroon-800' }}">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    @if ($menungguPenilaian)
                                        <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>
                                    @else
                                        <path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/>
                                    @endif
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-slate-700">{{ $hasil->evaluasi->judul_evaluasi ?? 'Evaluasi tidak tersedia' }}</p>
                                <p class="mt-1 text-[11px] text-slate-400">
                                    {{ $hasil->waktu_selesai ? \Carbon\Carbon::parse($hasil->waktu_selesai)->format('d M Y, H:i') : 'Waktu pengumpulan belum tersedia' }}
                                </p>
                            </div>
                            <div class="shrink-0 text-right">
                                @if ($menungguPenilaian)
                                    <p class="text-xs font-bold text-sky-800">Menunggu penilaian</p>
                                @elseif ($hasil->nilai !== null)
                                    <p class="text-sm font-black text-maroon-800">{{ number_format((float) $hasil->nilai, 0, ',', '.') }}/100</p>
                                    <p class="mt-1 text-[10px] text-emerald-700">Nilai tersedia</p>
                                @else
                                    <p class="text-xs text-slate-400">Nilai belum tersedia</p>
                                @endif
                                
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center">
                            <p class="font-bold text-slate-700">Belum ada riwayat evaluasi</p>
                            <p class="mt-1 text-sm text-slate-500">Hasil evaluasi akan muncul setelah kamu mengumpulkan pengerjaan.</p>
                            <a href="{{ route('pelajar.evaluasi.index') }}" class="mt-4 inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold text-maroon-800 hover:bg-warm-50">Lihat daftar evaluasi</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <aside class="rounded-2xl bg-gradient-to-br from-maroon-950 to-maroon-900 p-6 text-white shadow-sm">
                <div class="grid h-11 w-11 place-items-center rounded-xl bg-gold-400/10 text-gold-400">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9.663 17h4.674"/><path d="M12 3a7 7 0 0 0-4 12.748V18a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2v-2.252A7 7 0 0 0 12 3z"/><path d="M9 21h6"/>
                    </svg>
                </div>
                <p class="mt-6 text-[10px] font-black uppercase tracking-[.2em] text-gold-400">Langkah berikutnya</p>
                <h3 class="mt-2 text-xl font-black leading-tight">
                    @if ($totalModul === 0)
                        Mulai perjalanan belajarmu
                    @elseif ($modulSelesai < $totalModul)
                        Lanjutkan modul yang sedang dipelajari
                    @else
                        Pertahankan kemajuanmu
                    @endif
                </h3>
                <p class="mt-3 text-xs leading-6 text-white/65">
                    @if ($totalModul === 0)
                        Buka materi dan mulai belajar agar progresmu tercatat di CodeTutor.
                    @elseif ($modulSelesai < $totalModul)
                        Selesaikan materi yang tersisa agar progres modulmu meningkat.
                    @else
                        Kamu telah menyelesaikan semua modul yang memiliki catatan progres. Lihat kembali hasil evaluasimu untuk memantau pencapaian.
                    @endif
                </p>
                <a href="{{ $totalEvaluasiSelesai > 0 ? route('pelajar.evaluasi.index') : route('materi') }}" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gold-400 px-4 py-3 text-xs font-black text-maroon-950 transition hover:-translate-y-0.5 hover:bg-gold-300">
                    {{ $totalEvaluasiSelesai > 0 ? 'Lihat evaluasi' : 'Mulai belajar' }}
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>
                    </svg>
                </a>
            </aside>
        </section>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filter = document.getElementById('progressFilter');
    const cards = Array.from(document.querySelectorAll('.language-card'));
    const emptyMessage = document.getElementById('emptyFilterMessage');

    if (!filter) return;

    filter.addEventListener('change', function () {
        const selected = this.value;
        let visibleCount = 0;

        cards.forEach(function (card) {
            const matches = selected === 'all' || card.dataset.status === selected;
            card.classList.toggle('hidden', !matches);
            if (matches) visibleCount++;
        });

        if (emptyMessage) {
            emptyMessage.classList.toggle('hidden', visibleCount > 0 || cards.length === 0);
        }
    });
});
</script>
@endsection

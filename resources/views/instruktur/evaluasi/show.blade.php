@extends('layouts.master')

@section('title', $evaluasi->judul_evaluasi)
@section('description', 'Detail evaluasi dan soal pembelajaran.')
@section('page_label', 'Area Instruktur')
@section('page_heading', 'Detail Evaluasi')

@section('content')
@php
    $labelJenis = ['pretest' => 'Pretest', 'posttest' => 'Posttest'];
    $labelSoal = ['pilihan_ganda' => 'Pilihan ganda', 'essay' => 'Essay', 'coding' => 'Coding'];
    $sudahDikerjakan = $adaRiwayatPengerjaan ?? (($evaluasi->pengerjaan_count ?? 0) > 0);
    $isPretest = $evaluasi->jenis_evaluasi === 'pretest';
@endphp
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700"><span class="h-2 w-2 rounded-full bg-gold-500"></span> Detail Evaluasi</div>
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">{{ $evaluasi->judul_evaluasi }}</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">{{ $evaluasi->deskripsi ?: 'Tidak ada deskripsi evaluasi.' }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('instruktur.evaluasi.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Kembali</a>
            @unless ($sudahDikerjakan)
                <a href="{{ route('instruktur.evaluasi.edit', $evaluasi) }}" class="inline-flex items-center justify-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Edit Evaluasi</a>
            @endunless
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">{{ session('error') }}</div>
    @endif
    @if (session('info'))
        <div class="rounded-2xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-sky-800">{{ session('info') }}</div>
    @endif

    @if ($sudahDikerjakan)
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-800">{{ $isPretest ? 'Latihan Pretest ini sudah pernah dikerjakan. Perubahan soal dan penghapusan dikunci untuk menjaga konsistensi hasil latihan Pelajar.' : 'Posttest ini sudah memiliki ' . $evaluasi->pengerjaan_count . ' riwayat pengerjaan. Perubahan soal dan penghapusan dikunci untuk menjaga konsistensi hasil Pelajar.' }}</div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <p class="text-xs font-semibold text-slate-500">Jenis evaluasi</p>
            <p class="mt-2 font-display text-xl font-extrabold text-maroon-950">{{ $labelJenis[$evaluasi->jenis_evaluasi] ?? ucfirst($evaluasi->jenis_evaluasi) }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <p class="text-xs font-semibold text-slate-500">Modul pembelajaran</p>
            <p class="mt-2 font-display text-lg font-extrabold text-maroon-950">{{ $evaluasi->modul->nama_modul ?? 'Modul tidak tersedia' }}</p>
            <p class="mt-1 text-xs text-slate-400">{{ $evaluasi->modul->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia' }}</p>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <p class="text-xs font-semibold text-slate-500">Nilai minimal</p>
            <p class="mt-2 font-display text-3xl font-extrabold text-maroon-950">{{ $evaluasi->nilai_minimal }}<span class="ml-1 text-base font-semibold text-slate-400">/ 100</span></p>
        </div>
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
            <p class="text-xs font-semibold text-slate-500">Soal & pengerjaan</p>
            <p class="mt-2 font-display text-3xl font-extrabold text-maroon-950">{{ $evaluasi->soal_count }}</p>
            <p class="mt-1 text-xs text-slate-400">{{ $isPretest ? 'Latihan mandiri Pelajar' : $evaluasi->pengerjaan_count . ' hasil Posttest' }}</p>
        </div>
    </div>


    <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-display text-base font-extrabold text-maroon-950">Durasi pengerjaan</h2>
                <p class="mt-1 text-xs leading-5 text-slate-500">Waktu dihitung masing-masing sejak Pelajar menekan tombol Mulai Evaluasi.</p>
            </div>
            <span class="w-fit rounded-full bg-maroon-50 px-3 py-1 text-sm font-bold text-maroon-800">{{ $evaluasi->durasi_menit }} menit</span>
        </div>
    </section>

    @if ($isPretest)
        <section class="rounded-2xl border border-amber-200 bg-amber-50/70 p-5 sm:p-6">
            <div class="flex items-start gap-3">
                <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-white text-amber-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 18h6M10 22h4M8.5 14.5a6 6 0 1 1 7 0c-.8.6-1.2 1.3-1.3 2.5h-4.4c-.1-1.2-.5-1.9-1.3-2.5Z"/></svg>
                </div>
                <div>
                    <h2 class="font-display text-base font-extrabold text-amber-950">Pretest untuk latihan awal</h2>
                    <p class="mt-1 text-sm leading-6 text-amber-900/80">Pretest digunakan Pelajar untuk mengukur pemahaman sebelum pembelajaran. Jawaban dan nilai latihan hanya ditampilkan kepada Pelajar, tidak dimasukkan ke daftar hasil atau penilaian Instruktur.</p>
                </div>
            </div>
        </section>
    @else
    {{-- Riwayat hasil Posttest yang diteruskan ke area Instruktur. --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-display text-xl font-extrabold text-maroon-950">Hasil pengerjaan pelajar</h2>
                    <p class="mt-1 text-sm text-slate-500">Waktu mulai, waktu selesai, nilai tersimpan, dan akses pemeriksaan jawaban essay/coding.</p>
                </div>
                <span class="w-fit rounded-full bg-warm-100 px-3 py-1 text-xs font-semibold text-maroon-800">{{ $evaluasi->pengerjaan->count() }} pengerjaan</span>
            </div>
        </div>

        @if ($evaluasi->pengerjaan->isEmpty())
            <div class="px-6 py-10 text-center">
                <p class="font-semibold text-slate-700">Belum ada pelajar yang mengerjakan</p>
                <p class="mt-1 text-sm text-slate-500">Hasil akan tampil setelah pengerjaan evaluasi tersimpan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-warm-50">
                        <tr class="text-left text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th class="whitespace-nowrap px-5 py-3">Pelajar</th>
                            <th class="whitespace-nowrap px-5 py-3">Waktu mulai</th>
                            <th class="whitespace-nowrap px-5 py-3">Waktu selesai</th>
                            <th class="whitespace-nowrap px-5 py-3">Nilai</th>
                            <th class="whitespace-nowrap px-5 py-3">Status hasil</th>
                            <th class="whitespace-nowrap px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($evaluasi->pengerjaan as $hasil)
                            @php
                                $statusHasil = strtolower((string) $hasil->status);
                                $menungguPenilaian = $statusHasil === 'menunggu_penilaian'
                                    || ($hasil->waktu_selesai !== null && $hasil->nilai === null);
                            @endphp
                            <tr class="align-top transition hover:bg-warm-50/70">
                                <td class="min-w-[190px] px-5 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ $hasil->pelajar->nama ?? 'Akun pelajar tidak tersedia' }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $hasil->pelajar->email ?? '—' }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    @if ($hasil->waktu_mulai)
                                        <p class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($hasil->waktu_mulai)->format('d M Y') }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ \Carbon\Carbon::parse($hasil->waktu_mulai)->format('H:i') }}</p>
                                    @else
                                        <span class="text-sm text-slate-400">Belum dimulai</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    @if ($hasil->waktu_selesai)
                                        <p class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($hasil->waktu_selesai)->format('d M Y') }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ \Carbon\Carbon::parse($hasil->waktu_selesai)->format('H:i') }}</p>
                                    @else
                                        <span class="text-sm text-slate-400">Belum selesai</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    @if ($hasil->nilai !== null && !$menungguPenilaian)
                                        <span class="text-sm font-extrabold text-maroon-900">{{ number_format((float) $hasil->nilai, 0, ',', '.') }}/100</span>
                                    @else
                                        <span class="text-sm text-slate-400">Belum tersedia</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    @if (!$hasil->waktu_mulai)
                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">Belum dimulai</span>
                                    @elseif (!$hasil->waktu_selesai)
                                        <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-800">Sedang dikerjakan</span>
                                    @elseif ($menungguPenilaian)
                                        <span class="inline-flex rounded-full bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-800">Menunggu penilaian</span>
                                    @elseif ($hasil->nilai !== null && (float) $hasil->nilai >= (float) $evaluasi->nilai_minimal)
                                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Lulus</span>
                                    @elseif ($hasil->nilai !== null)
                                        <span class="inline-flex rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">Belum lulus</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">Belum dinilai</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    @if ($menungguPenilaian && $hasil->waktu_selesai)
                                        <a href="{{ route('instruktur.evaluasi.penilaian.show', [$evaluasi, $hasil]) }}" class="inline-flex items-center justify-center rounded-lg bg-maroon-800 px-3 py-2 text-xs font-semibold text-white hover:bg-maroon-700">Periksa jawaban</a>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
    @endif

    <div class="space-y-4">
        <div>
            <h2 class="font-display text-xl font-extrabold text-maroon-950">Soal evaluasi</h2>
            <p class="mt-1 text-sm text-slate-500">Bobot dan pilihan jawaban ditampilkan sebagaimana tersimpan.</p>
        </div>
        @forelse ($evaluasi->soal as $index => $itemSoal)
            <article class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-warm-50/70 px-5 py-4">
                    <div class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-maroon-800 text-sm font-bold text-white">{{ $index + 1 }}</span>
                        <span class="rounded-lg border border-maroon-100 bg-maroon-50 px-2.5 py-1 text-xs font-semibold text-maroon-800">{{ $labelSoal[$itemSoal->jenis_soal] ?? ucfirst($itemSoal->jenis_soal) }}</span>
                    </div>
                    <span class="rounded-lg bg-gold-100 px-2.5 py-1 text-xs font-bold text-maroon-900">Bobot {{ $itemSoal->bobot }}</span>
                </div>
                <div class="space-y-4 p-5 sm:p-6">
                    <p class="whitespace-pre-line text-sm leading-7 text-slate-800">{{ $itemSoal->pertanyaan }}</p>
                    @if ($itemSoal->jenis_soal === 'pilihan_ganda')
                        <div class="space-y-2">
                            @forelse ($itemSoal->pilihan as $indexPilihan => $itemPilihan)
                                <div class="flex items-start gap-3 rounded-xl border {{ $itemPilihan->adalah_jawaban_benar ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-white' }} p-3">
                                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg {{ $itemPilihan->adalah_jawaban_benar ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600' }} text-xs font-bold">{{ chr(65 + ($indexPilihan % 26)) }}</span>
                                    <div class="min-w-0 flex-1">
                                        <p class="whitespace-pre-line text-sm leading-6 {{ $itemPilihan->adalah_jawaban_benar ? 'font-semibold text-emerald-900' : 'text-slate-700' }}">{{ $itemPilihan->teks_pilihan }}</p>
                                        @if ($itemPilihan->adalah_jawaban_benar)
                                            <p class="mt-1 text-[11px] font-bold text-emerald-700">Jawaban benar</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-amber-700">Belum ada pilihan jawaban tersimpan.</p>
                            @endforelse
                        </div>
                    @elseif ($itemSoal->jenis_soal === 'essay')
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-xs leading-5 text-slate-500">Soal essay dijawab dalam bentuk teks dan tidak menggunakan pilihan jawaban.</div>
                    @else
                        <div class="rounded-xl border border-slate-200 bg-slate-950 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gold-400">Jawaban berbentuk kode</p>
                            <p class="mt-2 text-xs leading-5 text-slate-300">Pelajar akan diminta menuliskan kode program untuk soal ini. Eksekusi dan penilaian otomatis kode memerlukan implementasi Code Lab tersendiri.</p>
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white px-6 py-14 text-center">
                <h3 class="font-display font-bold text-slate-800">Belum ada soal</h3>
                <p class="mt-1 text-sm text-slate-500">Tambahkan soal untuk melengkapi evaluasi ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

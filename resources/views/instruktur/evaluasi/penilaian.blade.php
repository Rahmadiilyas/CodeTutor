@extends('layouts.master')

@section('title', 'Penilaian Evaluasi')
@section('description', 'Periksa jawaban essay dan coding Pelajar.')
@section('page_label', 'Area Instruktur')
@section('page_heading', 'Penilaian Evaluasi')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700"><span class="h-2 w-2 rounded-full bg-gold-500"></span> Penilaian Jawaban</div>
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">{{ $evaluasi->judul_evaluasi }}</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">Periksa jawaban yang dikirim oleh Pelajar, lalu berikan nilai setiap soal sesuai bobotnya.</p>
        </div>
        <a href="{{ route('instruktur.evaluasi.show', $evaluasi) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Kembali ke Evaluasi</a>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-bold">Penilaian belum tersimpan.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-6">
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pelajar</p>
                <p class="mt-2 text-base font-extrabold text-maroon-950">{{ $pengerjaan->pelajar->nama ?? 'Akun pelajar tidak tersedia' }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ $pengerjaan->pelajar->email ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Waktu mulai</p>
                <p class="mt-2 text-base font-bold text-maroon-950">{{ $pengerjaan->waktu_mulai ? \Carbon\Carbon::parse($pengerjaan->waktu_mulai)->format('d M Y, H:i') : 'Belum dimulai' }}</p>
                <p class="mt-1 text-sm text-slate-500">Waktu Pelajar memulai evaluasi</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Waktu selesai</p>
                <p class="mt-2 text-base font-bold text-maroon-950">{{ $pengerjaan->waktu_selesai ? \Carbon\Carbon::parse($pengerjaan->waktu_selesai)->format('d M Y, H:i') : 'Belum dikumpulkan' }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ $jawabanSubjektif->count() }} jawaban menunggu penilaian</p>
            </div>
        </div>
    </section>

    <form method="POST" action="{{ route('instruktur.evaluasi.penilaian.simpan', [$evaluasi, $pengerjaan]) }}" class="space-y-5">
        @csrf
        @foreach ($jawabanSubjektif as $index => $jawaban)
            @php
                $soal = $jawaban->soal;
                $jenisSoal = $soal->jenis_soal === 'coding' ? 'Coding' : 'Essay';
            @endphp
            <article class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-warm-50/70 px-5 py-4">
                    <div class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-xl bg-maroon-800 text-sm font-bold text-white">{{ $index + 1 }}</span>
                        <span class="rounded-lg border border-maroon-100 bg-maroon-50 px-2.5 py-1 text-xs font-semibold text-maroon-800">{{ $jenisSoal }}</span>
                    </div>
                    <span class="rounded-lg bg-gold-100 px-2.5 py-1 text-xs font-bold text-maroon-900">Bobot maksimal {{ (int) $soal->bobot }} poin</span>
                </div>
                <div class="space-y-4 p-5 sm:p-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Pertanyaan</p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-7 text-slate-800">{{ $soal->pertanyaan }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Jawaban Pelajar</p>
                        @if ($jawaban->jawaban_teks !== null && trim((string) $jawaban->jawaban_teks) !== '')
                            @if ($soal->jenis_soal === 'coding')
                                <pre class="mt-2 overflow-x-auto whitespace-pre-wrap break-words rounded-xl bg-slate-950 p-4 font-mono text-xs leading-6 text-slate-100">{{ $jawaban->jawaban_teks }}</pre>
                            @else
                                <div class="mt-2 whitespace-pre-line rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm leading-7 text-slate-700">{{ $jawaban->jawaban_teks }}</div>
                            @endif
                        @else
                            <p class="mt-2 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm italic text-amber-800">Pelajar tidak mengisi jawaban. Berikan nilai sesuai kebijakan penilaian, termasuk 0 apabila tidak ada poin yang diperoleh.</p>
                        @endif
                    </div>
                    <div class="max-w-xs">
                        <label for="nilai-jawaban-{{ $jawaban->id }}" class="block text-sm font-bold text-slate-700">Nilai jawaban (0–{{ (int) $soal->bobot }})</label>
                        <div class="mt-2 flex items-center gap-3">
                            <input id="nilai-jawaban-{{ $jawaban->id }}" name="nilai_jawaban[{{ $jawaban->id }}]" type="number" min="0" max="{{ max(0, (int) $soal->bobot) }}" step="1" required value="{{ old('nilai_jawaban.' . $jawaban->id, $jawaban->nilai) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm focus:border-maroon-700 focus:outline-none focus:ring-2 focus:ring-maroon-100" placeholder="Masukkan nilai">
                            <span class="shrink-0 text-sm text-slate-500">/ {{ (int) $soal->bobot }}</span>
                        </div>
                        @error('nilai_jawaban.' . $jawaban->id)
                            <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </article>
        @endforeach

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('instruktur.evaluasi.show', $evaluasi) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white hover:bg-maroon-700" onclick="return confirm('Simpan seluruh nilai jawaban ini dan hitung nilai akhir Pelajar?')">Simpan Penilaian</button>
        </div>
        <p class="text-xs leading-5 text-slate-500">Nilai akhir dihitung berdasarkan jumlah poin seluruh soal dibandingkan total bobot. Setelah disimpan, status pengerjaan menjadi selesai.</p>
    </form>
</div>
@endsection

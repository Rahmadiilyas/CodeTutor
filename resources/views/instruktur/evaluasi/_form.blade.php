@php
    $isEdit = $evaluasi->exists;
    $jenisTerpilih = old('jenis_evaluasi', $evaluasi->jenis_evaluasi ?? request('jenis_evaluasi', 'pretest'));
    $jenisTerpilih = in_array($jenisTerpilih, ['pretest', 'posttest'], true) ? $jenisTerpilih : 'pretest';
    $isPretest = $jenisTerpilih === 'pretest';
    $judulJenis = $isPretest ? 'Pretest' : 'Posttest';
    $idModulTerpilih = old('id_modul', $evaluasi->id_modul);
    $durasiTerpilih = old('durasi_menit', $evaluasi->durasi_menit ?? 60);

    $soalData = old('soal');
    if (!is_array($soalData)) {
        $soalData = $isEdit
            ? $evaluasi->soal->map(function ($itemSoal) {
                return [
                    'pertanyaan' => $itemSoal->pertanyaan,
                    'jenis_soal' => $itemSoal->jenis_soal,
                    'bobot' => $itemSoal->bobot,
                    'pilihan' => $itemSoal->pilihan->map(fn ($itemPilihan) => [
                        'teks_pilihan' => $itemPilihan->teks_pilihan,
                        'adalah_jawaban_benar' => (bool) $itemPilihan->adalah_jawaban_benar,
                    ])->all(),
                ];
            })->values()->all()
            : [];
    }

    if (empty($soalData)) {
        $soalData = [[
            'pertanyaan' => '',
            'jenis_soal' => 'pilihan_ganda',
            'bobot' => 10,
            'pilihan' => [
                ['teks_pilihan' => '', 'adalah_jawaban_benar' => false],
                ['teks_pilihan' => '', 'adalah_jawaban_benar' => false],
                ['teks_pilihan' => '', 'adalah_jawaban_benar' => false],
                ['teks_pilihan' => '', 'adalah_jawaban_benar' => false],
            ],
        ]];
    }

    // Pada Pretest, jenis semua soal dipaksa menjadi pilihan ganda.
    if ($isPretest) {
        foreach ($soalData as $index => $item) {
            $soalData[$index]['jenis_soal'] = 'pilihan_ganda';
            if (empty($soalData[$index]['pilihan']) || !is_array($soalData[$index]['pilihan'])) {
                $soalData[$index]['pilihan'] = [
                    ['teks_pilihan' => '', 'adalah_jawaban_benar' => false],
                    ['teks_pilihan' => '', 'adalah_jawaban_benar' => false],
                    ['teks_pilihan' => '', 'adalah_jawaban_benar' => false],
                    ['teks_pilihan' => '', 'adalah_jawaban_benar' => false],
                ];
            }
        }
    }
@endphp

<div class="mx-auto max-w-5xl space-y-6">
    <div>
      
        <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">
            {{ $isEdit ? 'Edit ' . $judulJenis : 'Buat ' . $judulJenis . ' Baru' }}
        </h1>
        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-500">
            @if ($isPretest)
                Pretest digunakan sebagai latihan awal untuk mengetahui pemahaman Pelajar sebelum mengikuti pembelajaran. Semua soal Pretest wajib berupa pilihan ganda dan hasilnya hanya untuk Pelajar.
            @else
                Posttest digunakan untuk mengukur pemahaman Pelajar setelah pembelajaran. Soal dapat berupa pilihan ganda, essay, maupun coding. Hasil Posttest ditampilkan pada area Instruktur.
            @endif
        </p>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            <p class="font-semibold">Periksa kembali data berikut:</p>
            <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    @if (session('error'))
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">{{ session('error') }}</div>
    @endif

    @if ($modul->isEmpty())
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
            <h2 class="font-bold text-amber-950">Modul belum tersedia</h2>
            <p class="mt-1 text-sm leading-6 text-amber-800">Buat modul terlebih dahulu sebelum membuat evaluasi.</p>
            <a href="{{ route('instruktur.modul.index') }}" class="mt-3 inline-flex rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white">Buka Kelola Modul</a>
        </div>
    @endif

    <form method="POST" action="{{ $isEdit ? route('instruktur.evaluasi.update', $evaluasi) : route('instruktur.evaluasi.store', ['jenis_evaluasi' => $jenisTerpilih]) }}" class="space-y-6">
        @csrf
        @if ($isEdit) @method('PUT') @endif
        <input type="hidden" name="jenis_evaluasi" value="{{ $jenisTerpilih }}">

        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
            <div class="border-b border-slate-100 px-5 py-4 sm:px-7">
                <h2 class="font-display text-base font-bold text-maroon-950">Informasi {{ $judulJenis }}</h2>
                <p class="mt-1 text-xs text-slate-500">Jenis evaluasi sudah ditentukan dari menu yang dipilih.</p>
            </div>
            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7">
                <div class="sm:col-span-2 rounded-2xl border {{ $isPretest ? 'border-amber-200 bg-amber-50/70' : 'border-maroon-100 bg-maroon-50/60' }} p-4">
                    <div class="flex items-start gap-3">
                        <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl {{ $isPretest ? 'bg-white text-amber-700' : 'bg-white text-maroon-800' }}">
                            @if ($isPretest)
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 18h6M10 22h4M8.5 14.5a6 6 0 1 1 7 0c-.8.6-1.2 1.3-1.3 2.5h-4.4c-.1-1.2-.5-1.9-1.3-2.5Z"/><path d="M12 2v2M4.9 4.9l1.4 1.4M19.1 4.9l-1.4 1.4"/></svg>
                            @else
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 5h12M8 12h12M8 19h12"/><path d="m3 5 1.5 1.5L6.5 4M3 12l1.5 1.5 2-2M3 19l1.5 1.5 2-2"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider {{ $isPretest ? 'text-amber-800' : 'text-maroon-800' }}">Jenis evaluasi</p>
                            <h3 class="mt-1 font-display text-lg font-extrabold {{ $isPretest ? 'text-amber-950' : 'text-maroon-950' }}">{{ $judulJenis }}</h3>
                            <p class="mt-1 text-xs leading-5 {{ $isPretest ? 'text-amber-800' : 'text-slate-600' }}">
                                {{ $isPretest ? 'Latihan awal sebelum materi dipelajari lebih lanjut. Nilai tidak masuk ke daftar hasil penilaian Instruktur.' : 'Evaluasi akhir setelah pembelajaran. Hasil pengerjaan akan masuk ke daftar hasil Posttest Instruktur.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="judul_evaluasi" class="mb-1.5 block text-sm font-semibold text-slate-700">Judul evaluasi <span class="text-rose-500">*</span></label>
                    <input id="judul_evaluasi" name="judul_evaluasi" required maxlength="255" value="{{ old('judul_evaluasi', $evaluasi->judul_evaluasi) }}" placeholder="Contoh: {{ $isPretest ? 'Latihan Awal Dasar PHP' : 'Posttest Dasar PHP' }}" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                    @error('judul_evaluasi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="id_modul" class="mb-1.5 block text-sm font-semibold text-slate-700">Modul <span class="text-rose-500">*</span></label>
                    <select id="id_modul" name="id_modul" required class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                        <option value="">Pilih modul</option>
                        @foreach ($modul as $itemModul)
                            <option value="{{ $itemModul->id }}" @selected((string) $idModulTerpilih === (string) $itemModul->id)>{{ $itemModul->nama_modul }} — {{ $itemModul->bahasa->nama_bahasa ?? 'Bahasa' }}</option>
                        @endforeach
                    </select>
                    @error('id_modul')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="nilai_minimal" class="mb-1.5 block text-sm font-semibold text-slate-700">Nilai minimal kelulusan <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input id="nilai_minimal" name="nilai_minimal" type="number" min="0" max="100" required value="{{ old('nilai_minimal', $evaluasi->nilai_minimal ?? 70) }}" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 pr-12 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">/ 100</span>
                    </div>
                    @error('nilai_minimal')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="durasi_menit" class="mb-1.5 block text-sm font-semibold text-slate-700">Durasi pengerjaan (menit) <span class="text-rose-500">*</span></label>
                    <input id="durasi_menit" name="durasi_menit" type="number" min="1" max="600" step="1" required value="{{ $durasiTerpilih }}" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100" placeholder="60">
                    @error('durasi_menit')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="deskripsi" class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi <span class="font-normal text-slate-400">(opsional)</span></label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="10000" placeholder="{{ $isPretest ? 'Petunjuk latihan awal untuk Pelajar...' : 'Petunjuk sebelum mengerjakan Posttest...' }}" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm leading-6 outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('deskripsi', $evaluasi->deskripsi) }}</textarea>
                    @error('deskripsi')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <section class="space-y-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="font-display text-xl font-extrabold text-maroon-950">Daftar soal {{ $judulJenis }}</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ $isPretest ? 'Seluruh soal harus berupa pilihan ganda. Setiap soal harus memiliki minimal dua pilihan dan tepat satu jawaban benar.' : 'Posttest dapat berisi pilihan ganda, essay, atau coding.' }}
                    </p>
                </div>
                <button type="button" id="addQuestionButton" class="inline-flex items-center justify-center gap-2 rounded-xl border border-maroon-200 bg-white px-4 py-2.5 text-sm font-semibold text-maroon-800 hover:bg-maroon-50">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>Tambah Soal
                </button>
            </div>

            <div id="questionsContainer" class="space-y-4">
                @foreach ($soalData as $indexSoal => $itemSoal)
                    @php $pilihanData = $itemSoal['pilihan'] ?? []; @endphp
                    <article class="question-card overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft" data-question-card data-question-index="{{ $indexSoal }}">
                        <div class="flex items-center justify-between gap-3 border-b border-slate-100 bg-warm-50/70 px-5 py-3">
                            <div class="flex items-center gap-3"><span class="question-number grid h-8 w-8 place-items-center rounded-lg bg-maroon-800 text-sm font-bold text-white">{{ $indexSoal + 1 }}</span><h3 class="font-display font-bold text-maroon-950">Pertanyaan</h3></div>
                            <button type="button" class="remove-question-button rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">Hapus soal</button>
                        </div>
                        <div class="space-y-5 p-5 sm:p-6">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Teks pertanyaan <span class="text-rose-500">*</span></label>
                                <textarea name="soal[{{ $indexSoal }}][pertanyaan]" rows="3" required maxlength="10000" placeholder="Tulis pertanyaan di sini..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm leading-6 outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ $itemSoal['pertanyaan'] ?? '' }}</textarea>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Jenis soal <span class="text-rose-500">*</span></label>
                                    @if ($isPretest)
                                        <input type="hidden" name="soal[{{ $indexSoal }}][jenis_soal]" data-question-type value="pilihan_ganda">
                                        <div class="rounded-xl border border-amber-200 bg-amber-50 px-3.5 py-3 text-sm font-semibold text-amber-800">Pilihan ganda (wajib)</div>
                                    @else
                                        <select name="soal[{{ $indexSoal }}][jenis_soal]" data-question-type required class="question-type-select w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                                            <option value="pilihan_ganda" @selected(($itemSoal['jenis_soal'] ?? 'pilihan_ganda') === 'pilihan_ganda')>Pilihan ganda</option>
                                            <option value="essay" @selected(($itemSoal['jenis_soal'] ?? '') === 'essay')>Essay</option>
                                            <option value="coding" @selected(($itemSoal['jenis_soal'] ?? '') === 'coding')>Coding</option>
                                        </select>
                                    @endif
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Bobot nilai <span class="text-rose-500">*</span></label>
                                    <input type="number" name="soal[{{ $indexSoal }}][bobot]" min="1" max="1000" required value="{{ $itemSoal['bobot'] ?? 10 }}" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                                </div>
                            </div>

                            <div class="choice-section rounded-xl border border-slate-200 bg-slate-50/70 p-4" data-choice-section>
                                <div class="mb-3 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                    <div><h4 class="text-sm font-bold text-slate-800">Pilihan jawaban</h4><p class="mt-1 text-xs text-slate-500">Tandai tepat satu pilihan sebagai jawaban benar.</p></div>
                                    <button type="button" class="add-choice-button text-left text-xs font-bold text-maroon-700 hover:text-maroon-950">+ Tambah pilihan</button>
                                </div>
                                <div class="choice-list space-y-2" data-choice-list data-next-choice-index="{{ count($pilihanData) }}">
                                    @foreach ($pilihanData as $indexPilihan => $itemPilihan)
                                        <div class="choice-row flex items-start gap-2" data-choice-row>
                                            <label class="mt-3 flex shrink-0 items-center gap-1.5 text-xs text-slate-500" title="Tandai jawaban benar"><input type="radio" name="soal[{{ $indexSoal }}][pilihan][{{ $indexPilihan }}][adalah_jawaban_benar]" value="1" @checked(filter_var($itemPilihan['adalah_jawaban_benar'] ?? false, FILTER_VALIDATE_BOOLEAN)) class="h-4 w-4 accent-maroon-800"><span>Benar</span></label>
                                            <input type="text" name="soal[{{ $indexSoal }}][pilihan][{{ $indexPilihan }}][teks_pilihan]" value="{{ $itemPilihan['teks_pilihan'] ?? '' }}" maxlength="5000" placeholder="Teks pilihan jawaban" class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                                            <button type="button" class="remove-choice-button rounded-lg px-3 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">Hapus</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <div class="flex flex-col-reverse gap-3 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-soft sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <a href="{{ $isEdit ? route('instruktur.evaluasi.show', $evaluasi) : route('instruktur.evaluasi.index') }}" class="inline-flex justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">Batal</a>
            <button type="submit" @disabled($modul->isEmpty()) class="inline-flex justify-center rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-maroon-700 disabled:cursor-not-allowed disabled:opacity-50">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan ' . $judulJenis }}</button>
        </div>
    </form>
</div>

<template id="questionTemplate">
    <article class="question-card overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft" data-question-card data-question-index="__Q__">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 bg-warm-50/70 px-5 py-3"><div class="flex items-center gap-3"><span class="question-number grid h-8 w-8 place-items-center rounded-lg bg-maroon-800 text-sm font-bold text-white">1</span><h3 class="font-display font-bold text-maroon-950">Pertanyaan</h3></div><button type="button" class="remove-question-button rounded-lg px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">Hapus soal</button></div>
        <div class="space-y-5 p-5 sm:p-6">
            <div><label class="mb-1.5 block text-sm font-semibold text-slate-700">Teks pertanyaan <span class="text-rose-500">*</span></label><textarea name="soal[__Q__][pertanyaan]" rows="3" required maxlength="10000" placeholder="Tulis pertanyaan di sini..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm leading-6 outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"></textarea></div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div><label class="mb-1.5 block text-sm font-semibold text-slate-700">Jenis soal <span class="text-rose-500">*</span></label>
                    @if ($isPretest)
                        <input type="hidden" name="soal[__Q__][jenis_soal]" data-question-type value="pilihan_ganda"><div class="rounded-xl border border-amber-200 bg-amber-50 px-3.5 py-3 text-sm font-semibold text-amber-800">Pilihan ganda (wajib)</div>
                    @else
                        <select name="soal[__Q__][jenis_soal]" data-question-type required class="question-type-select w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="pilihan_ganda">Pilihan ganda</option><option value="essay">Essay</option><option value="coding">Coding</option></select>
                    @endif
                </div>
                <div><label class="mb-1.5 block text-sm font-semibold text-slate-700">Bobot nilai <span class="text-rose-500">*</span></label><input type="number" name="soal[__Q__][bobot]" min="1" max="1000" required value="10" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"></div>
            </div>
            <div class="choice-section rounded-xl border border-slate-200 bg-slate-50/70 p-4" data-choice-section><div class="mb-3 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between"><div><h4 class="text-sm font-bold text-slate-800">Pilihan jawaban</h4><p class="mt-1 text-xs text-slate-500">Tandai tepat satu pilihan sebagai jawaban benar.</p></div><button type="button" class="add-choice-button text-left text-xs font-bold text-maroon-700 hover:text-maroon-950">+ Tambah pilihan</button></div><div class="choice-list space-y-2" data-choice-list data-next-choice-index="0"></div></div>
        </div>
    </article>
</template>

<template id="choiceTemplate">
    <div class="choice-row flex items-start gap-2" data-choice-row><label class="mt-3 flex shrink-0 items-center gap-1.5 text-xs text-slate-500" title="Tandai jawaban benar"><input type="radio" name="soal[__Q__][pilihan][__C__][adalah_jawaban_benar]" value="1" class="h-4 w-4 accent-maroon-800"><span>Benar</span></label><input type="text" name="soal[__Q__][pilihan][__C__][teks_pilihan]" maxlength="5000" placeholder="Teks pilihan jawaban" class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><button type="button" class="remove-choice-button rounded-lg px-3 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">Hapus</button></div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('questionsContainer');
    const addQuestionButton = document.getElementById('addQuestionButton');
    const questionTemplate = document.getElementById('questionTemplate');
    const choiceTemplate = document.getElementById('choiceTemplate');
    if (!container || !addQuestionButton || !questionTemplate || !choiceTemplate) return;

    let nextQuestionIndex = Math.max(-1, ...Array.from(container.querySelectorAll('[data-question-index]')).map(card => Number(card.dataset.questionIndex) || 0)) + 1;

    function refreshQuestionNumbers() {
        container.querySelectorAll('[data-question-card]').forEach((card, index) => {
            const number = card.querySelector('.question-number');
            if (number) number.textContent = String(index + 1);
        });
    }

    function updateChoiceVisibility(card) {
        const typeControl = card.querySelector('[data-question-type]');
        const section = card.querySelector('[data-choice-section]');
        if (!typeControl || !section) return;
        const enabled = typeControl.value === 'pilihan_ganda';
        section.classList.toggle('hidden', !enabled);
        section.querySelectorAll('input, button').forEach(input => { input.disabled = !enabled; });
    }

    function addChoice(card) {
        const choiceList = card.querySelector('[data-choice-list]');
        if (!choiceList) return;
        const questionIndex = card.dataset.questionIndex;
        const choiceIndex = Number(choiceList.dataset.nextChoiceIndex || 0);
        choiceList.dataset.nextChoiceIndex = String(choiceIndex + 1);
        const html = choiceTemplate.innerHTML.replaceAll('__Q__', questionIndex).replaceAll('__C__', choiceIndex);
        choiceList.insertAdjacentHTML('beforeend', html);
        updateChoiceVisibility(card);
    }

    container.querySelectorAll('[data-question-card]').forEach(card => {
        const choiceList = card.querySelector('[data-choice-list]');
        if (choiceList) {
            let next = 0;
            choiceList.querySelectorAll('[data-choice-row]').forEach(row => {
                const text = row.querySelector('input[type="text"]');
                const match = text?.name.match(/\[pilihan\]\[(\d+)\]\[teks_pilihan\]$/);
                if (match) next = Math.max(next, Number(match[1]) + 1);
            });
            choiceList.dataset.nextChoiceIndex = String(next);
        }
        updateChoiceVisibility(card);
    });

    addQuestionButton.addEventListener('click', function () {
        const html = questionTemplate.innerHTML.replaceAll('__Q__', nextQuestionIndex);
        container.insertAdjacentHTML('beforeend', html);
        const card = container.querySelector('[data-question-index="' + nextQuestionIndex + '"]');
        nextQuestionIndex += 1;
        if (!card) return;
        if (card.querySelector('[data-question-type]')?.value === 'pilihan_ganda') {
            addChoice(card); addChoice(card); addChoice(card); addChoice(card);
        }
        refreshQuestionNumbers();
        card.querySelector('textarea')?.focus();
    });

    container.addEventListener('click', function (event) {
        const removeQuestion = event.target.closest('.remove-question-button');
        const removeChoice = event.target.closest('.remove-choice-button');
        const addChoiceButton = event.target.closest('.add-choice-button');

        if (removeQuestion) {
            if (container.querySelectorAll('[data-question-card]').length <= 1) {
                window.alert('Evaluasi harus memiliki minimal satu soal.');
                return;
            }
            removeQuestion.closest('[data-question-card]')?.remove();
            refreshQuestionNumbers();
        } else if (removeChoice) {
            const card = removeChoice.closest('[data-question-card]');
            if ((card?.querySelectorAll('[data-choice-row]').length || 0) <= 2) {
                window.alert('Soal pilihan ganda harus memiliki minimal dua pilihan.');
                return;
            }
            removeChoice.closest('[data-choice-row]')?.remove();
        } else if (addChoiceButton) {
            const card = addChoiceButton.closest('[data-question-card]');
            if (card) addChoice(card);
        }
    });

    container.addEventListener('change', function (event) {
        if (event.target.matches('select[data-question-type]')) {
            updateChoiceVisibility(event.target.closest('[data-question-card]'));
        }
        if (event.target.matches('input[type="radio"][name*="[adalah_jawaban_benar]"]') && event.target.checked) {
            const card = event.target.closest('[data-question-card]');
            card?.querySelectorAll('input[type="radio"][name*="[adalah_jawaban_benar]"]').forEach(radio => {
                if (radio !== event.target) radio.checked = false;
            });
        }
    });
});
</script>
@endpush

@php
    $isEdit = $contohKode->exists;
    $idBahasaTerpilih = old('id_bahasa', $contohKode->id_bahasa);
    $idMateriTerpilih = old('id_materi', $contohKode->id_materi);
@endphp

<div class="mx-auto max-w-4xl space-y-6">
    <div>

        <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">{{ $isEdit ? 'Edit Contoh Kode' : 'Tambah Contoh Kode' }}</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Isi kode dengan jelas dan gunakan deskripsi untuk menjelaskan tujuan atau cara kerja contoh.</p>
    </div>

    @if (session('success'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>@endif
    @if ($errors->any())<div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"><p class="font-semibold">Periksa kembali isian berikut:</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <form method="POST" action="{{ $isEdit ? route('instruktur.code-lab.update', $contohKode) : route('instruktur.code-lab.store') }}" class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-soft">
        @csrf
        @if ($isEdit) @method('PUT') @endif
        <div class="space-y-5 p-5 sm:p-7">
            <div>
                <label for="judul" class="mb-1.5 block text-sm font-semibold text-slate-700">Judul contoh kode <span class="text-rose-500">*</span></label>
                <input id="judul" name="judul" type="text" maxlength="255" required value="{{ old('judul', $contohKode->judul) }}" placeholder="Contoh: Menampilkan teks Hello World" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                @error('judul')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="id_bahasa" class="mb-1.5 block text-sm font-semibold text-slate-700">Bahasa pemrograman <span class="text-rose-500">*</span></label>
                    <select id="id_bahasa" name="id_bahasa" required class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                        <option value="">Pilih bahasa</option>
                        @foreach ($bahasa as $itemBahasa)
                            <option value="{{ $itemBahasa->id }}" @selected((string) $idBahasaTerpilih === (string) $itemBahasa->id)>{{ $itemBahasa->nama_bahasa }}{{ !$itemBahasa->status ? ' (nonaktif)' : '' }}</option>
                        @endforeach
                    </select>
                    @error('id_bahasa')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="id_materi" class="mb-1.5 block text-sm font-semibold text-slate-700">Materi terkait <span class="font-normal text-slate-400">(opsional)</span></label>
                    <select id="id_materi" name="id_materi" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                        <option value="">Tidak dikaitkan dengan materi</option>
                        @foreach ($materiList as $itemMateri)
                            <option value="{{ $itemMateri->id }}" data-language-id="{{ $itemMateri->modul->id_bahasa ?? '' }}" @selected((string) $idMateriTerpilih === (string) $itemMateri->id)>
                                {{ $itemMateri->judul_materi }} — {{ $itemMateri->modul->nama_modul ?? 'Modul' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1.5 text-xs text-slate-400">Jika memilih materi, bahasanya harus sama dengan bahasa pemrograman di atas.</p>
                    @error('id_materi')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="deskripsi" class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="5000" placeholder="Jelaskan tujuan dan hasil dari contoh kode ini..." class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 text-sm leading-6 outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('deskripsi', $contohKode->deskripsi) }}</textarea>
                @error('deskripsi')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <div class="mb-1.5 flex items-center justify-between gap-3"><label for="kode_program" class="block text-sm font-semibold text-slate-700">Kode program <span class="text-rose-500">*</span></label><span class="text-xs text-slate-400">Gunakan format kode sesuai bahasa yang dipilih</span></div>
                <textarea id="kode_program" name="kode_program" rows="16" required spellcheck="false" placeholder="// Tulis contoh kode di sini..." class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-4 font-mono text-sm leading-6 text-emerald-100 outline-none transition placeholder:text-slate-500 focus:border-gold-400 focus:ring-4 focus:ring-maroon-100">{{ old('kode_program', $contohKode->kode_program) }}</textarea>
                @error('kode_program')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                <p class="mt-1.5 text-xs text-slate-400">Kode ini disimpan sebagai contoh kode. Halaman ini tidak menjalankan kode secara langsung.</p>
            </div>

            <div>
                <label for="hasil_diharapkan" class="mb-1.5 block text-sm font-semibold text-slate-700">Hasil yang Diharapkan <span class="font-normal text-slate-400">(opsional)</span></label>
                <textarea id="hasil_diharapkan" name="hasil_diharapkan" rows="4" maxlength="20000" spellcheck="false" placeholder="Contoh output: Halo, CodeTutor!" class="w-full rounded-xl border border-slate-200 bg-warm-50 px-3.5 py-3 font-mono text-sm leading-6 outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('hasil_diharapkan', $contohKode->hasil_diharapkan) }}</textarea>
                @error('hasil_diharapkan')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                <p class="mt-1.5 text-xs text-slate-400">Isi output yang seharusnya muncul saat kode dijalankan. Baris baru akan dipertahankan dan ditampilkan kepada Pelajar di Code Lab.</p>
            </div>
        </div>
        <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-warm-50/70 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-7">
            <a href="{{ route('instruktur.code-lab.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
            <button type="submit" @disabled($bahasa->isEmpty()) class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100 disabled:cursor-not-allowed disabled:opacity-50">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Contoh Kode' }}</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const languageSelect = document.getElementById('id_bahasa');
    const materialSelect = document.getElementById('id_materi');
    if (!languageSelect || !materialSelect) return;

    materialSelect.addEventListener('change', function () {
        const selected = materialSelect.options[materialSelect.selectedIndex];
        const languageId = selected ? selected.dataset.languageId : '';
        if (languageId) languageSelect.value = languageId;
    });

    languageSelect.addEventListener('change', function () {
        const selected = materialSelect.options[materialSelect.selectedIndex];
        const languageId = selected ? selected.dataset.languageId : '';
        if (languageId && languageId !== languageSelect.value) materialSelect.value = '';
    });
});
</script>
@endpush

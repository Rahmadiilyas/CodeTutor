@if ($errors->any())
    <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"><p class="font-semibold">Periksa kembali data berikut:</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

@if ($modul->isEmpty())
    <div class="mb-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900">Tidak ada modul milikmu yang dapat dipilih. @if (request()->routeIs('instruktur.materi.create'))Buat modul pembelajaran yang aktif terlebih dahulu.@elsePastikan modul terkait masih tersedia.@endif</div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="id_modul" class="mb-1.5 block text-sm font-semibold text-slate-700">Modul Pembelajaran <span class="text-rose-500">*</span></label>
        <select id="id_modul" name="id_modul" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100" @disabled($modul->isEmpty())>
            <option value="">Pilih modul</option>
            @foreach ($modul as $itemModul)
                <option value="{{ $itemModul->id }}" @selected((string) old('id_modul', $materi->id_modul ?? '') === (string) $itemModul->id)>{{ $itemModul->nama_modul }} — {{ $itemModul->bahasa->nama_bahasa ?? 'Bahasa tidak tersedia' }}{{ !$itemModul->status ? ' (Nonaktif)' : '' }}</option>
            @endforeach
        </select>
        @error('id_modul')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="judul_materi" class="mb-1.5 block text-sm font-semibold text-slate-700">Judul Materi <span class="text-rose-500">*</span></label>
        <input id="judul_materi" name="judul_materi" type="text" maxlength="255" required value="{{ old('judul_materi', $materi->judul_materi ?? '') }}" placeholder="Contoh: Pengenalan Variabel pada PHP" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
        @error('judul_materi')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="deskripsi" class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Ringkasan singkat tentang materi ini..." class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('deskripsi', $materi->deskripsi ?? '') }}</textarea>
        @error('deskripsi')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="isi_materi" class="mb-1.5 block text-sm font-semibold text-slate-700">Isi Materi</label>
        <textarea id="isi_materi" name="isi_materi" rows="12" placeholder="Tuliskan materi pembelajaran di sini. Kamu dapat menuliskan penjelasan, contoh, dan langkah-langkah pembelajaran..." class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm leading-6 outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('isi_materi', $materi->isi_materi ?? '') }}</textarea>
        <p class="mt-1.5 text-xs text-slate-400">Untuk saat ini isi materi disimpan sebagai teks. Editor rich text dapat ditambahkan pada tahap berikutnya.</p>
        @error('isi_materi')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="urutan" class="mb-1.5 block text-sm font-semibold text-slate-700">Urutan Materi <span class="text-rose-500">*</span></label>
        <input id="urutan" name="urutan" type="number" min="0" max="99999" required value="{{ old('urutan', $materi->urutan ?? 0) }}" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
        <p class="mt-1.5 text-xs text-slate-400">Angka lebih kecil ditampilkan lebih dahulu.</p>
        @error('urutan')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    @if (isset($materi))
        <div>
            <label for="status" class="mb-1.5 block text-sm font-semibold text-slate-700">Status Materi <span class="text-rose-500">*</span></label>
            <select id="status" name="status" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100"><option value="1" @selected((string) old('status', (int) $materi->status) === '1')>Aktif</option><option value="0" @selected((string) old('status', (int) $materi->status) === '0')>Nonaktif</option></select>
            @error('status')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
    @endif
</div>

<div class="mt-7 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
    <a href="{{ route('instruktur.materi.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
    <button type="submit" @disabled($modul->isEmpty()) class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100 disabled:cursor-not-allowed disabled:opacity-50"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>{{ isset($materi) ? 'Simpan Perubahan' : 'Simpan Materi' }}</button>
</div>

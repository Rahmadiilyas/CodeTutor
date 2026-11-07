@if ($errors->any())
    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"><p class="font-semibold">Periksa kembali data yang dimasukkan.</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="space-y-5">
    <div>
        <label for="id_bahasa" class="mb-2 block text-sm font-semibold text-slate-700">Bahasa pemrograman <span class="text-rose-500">*</span></label>
        <select id="id_bahasa" name="id_bahasa" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
            <option value="">Pilih bahasa pemrograman</option>
            @foreach ($bahasa as $itemBahasa)
                <option value="{{ $itemBahasa->id }}" @selected((string) old('id_bahasa', $modul->id_bahasa ?? '') === (string) $itemBahasa->id)>
                    {{ $itemBahasa->nama_bahasa }}{{ $itemBahasa->status ? '' : ' (Nonaktif — sudah terhubung)' }}
                </option>
            @endforeach
        </select>
        <p class="mt-1.5 text-xs text-slate-400">Modul hanya dapat dihubungkan dengan bahasa pemrograman milik akunmu.</p>
    </div>
    <div>
        <label for="nama_modul" class="mb-2 block text-sm font-semibold text-slate-700">Nama modul <span class="text-rose-500">*</span></label>
        <input id="nama_modul" name="nama_modul" type="text" required maxlength="255" value="{{ old('nama_modul', $modul->nama_modul ?? '') }}" placeholder="Contoh: Dasar-Dasar PHP" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
    </div>
    <div>
        <label for="deskripsi" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi modul</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" maxlength="10000" placeholder="Jelaskan tujuan dan materi yang akan dipelajari pada modul ini..." class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 outline-none transition placeholder:text-slate-400 focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('deskripsi', $modul->deskripsi ?? '') }}</textarea>
        <p class="mt-1.5 text-xs text-slate-400">Opsional, maksimal 10.000 karakter.</p>
    </div>
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="urutan" class="mb-2 block text-sm font-semibold text-slate-700">Urutan modul <span class="text-rose-500">*</span></label>
            <input id="urutan" name="urutan" type="number" min="0" max="99999" required value="{{ old('urutan', $modul->urutan ?? 0) }}" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
            <p class="mt-1.5 text-xs text-slate-400">Gunakan angka untuk menentukan urutan tampil.</p>
        </div>
        @isset($modul)
        <div>
            <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status modul <span class="text-rose-500">*</span></label>
            <select id="status" name="status" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                <option value="1" @selected((string) old('status', (int) $modul->status) === '1')>Aktif — dapat digunakan</option>
                <option value="0" @selected((string) old('status', (int) $modul->status) === '0')>Nonaktif — tidak digunakan</option>
            </select>
        </div>
        @endisset
    </div>
</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
    <a href="{{ route('instruktur.modul.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>{{ $submitLabel ?? 'Simpan Modul' }}</button>
</div>

@if ($errors->any())
    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
        <p class="font-semibold">Periksa kembali data yang dimasukkan.</p>
        <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="space-y-5">
    <div>
        <label for="nama_bahasa" class="mb-2 block text-sm font-semibold text-slate-700">Nama bahasa pemrograman <span class="text-rose-500">*</span></label>
        <input id="nama_bahasa" name="nama_bahasa" type="text" required maxlength="100" value="{{ old('nama_bahasa', $bahasa->nama_bahasa ?? '') }}" placeholder="Contoh: PHP, Python, Java" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
        <p class="mt-1.5 text-xs text-slate-400">Gunakan nama bahasa yang jelas dan mudah dikenali.</p>
    </div>
    <div>
        <label for="deskripsi" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" maxlength="5000" placeholder="Jelaskan penggunaan atau tujuan bahasa ini dalam pembelajaran..." class="w-full resize-y rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 outline-none transition placeholder:text-slate-400 focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('deskripsi', $bahasa->deskripsi ?? '') }}</textarea>
        <p class="mt-1.5 text-xs text-slate-400">Opsional, maksimal 5.000 karakter.</p>
    </div>
    @isset($bahasa)
        <div>
            <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status bahasa <span class="text-rose-500">*</span></label>
            <select id="status" name="status" required class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                <option value="1" @selected((string) old('status', (int) $bahasa->status) === '1')>Aktif — dapat digunakan pada konten baru</option>
                <option value="0" @selected((string) old('status', (int) $bahasa->status) === '0')>Nonaktif — tidak digunakan pada konten baru</option>
            </select>
        </div>
    @endisset
</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
    <a href="{{ route('instruktur.bahasa.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
        {{ $submitLabel ?? 'Simpan Bahasa' }}
    </button>
</div>

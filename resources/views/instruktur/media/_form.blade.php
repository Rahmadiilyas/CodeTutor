@if ($errors->any())
    <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700"><p class="font-semibold">Periksa kembali data berikut:</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

@if ($materi->isEmpty())
    <div class="mb-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900">Belum ada materi aktif dari modul aktif milikmu. Buat bahasa pemrograman, modul, dan materi terlebih dahulu sebelum menambahkan media.</div>
@endif

<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="id_materi" class="mb-1.5 block text-sm font-semibold text-slate-700">Materi Pembelajaran <span class="text-rose-500">*</span></label>
        <select id="id_materi" name="id_materi" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100" @disabled($materi->isEmpty())>
            <option value="">Pilih materi</option>
            @foreach ($materi as $itemMateri)
                <option value="{{ $itemMateri->id }}" @selected((string) old('id_materi', $media->id_materi ?? '') === (string) $itemMateri->id)>{{ $itemMateri->judul_materi }} — {{ $itemMateri->modul->nama_modul ?? 'Modul' }} ({{ $itemMateri->modul->bahasa->nama_bahasa ?? 'Bahasa' }})</option>
            @endforeach
        </select>
        @error('id_materi')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="judul_media" class="mb-1.5 block text-sm font-semibold text-slate-700">Judul Media <span class="text-rose-500">*</span></label>
        <input id="judul_media" name="judul_media" type="text" maxlength="255" required value="{{ old('judul_media', $media->judul_media ?? '') }}" placeholder="Contoh: Video Pengenalan Variabel" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
        @error('judul_media')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="jenis_media" class="mb-1.5 block text-sm font-semibold text-slate-700">Jenis Media <span class="text-rose-500">*</span></label>
        <select id="jenis_media" name="jenis_media" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
            <option value="">Pilih jenis media</option>
            @foreach ($jenisMedia as $jenis)
                <option value="{{ $jenis }}" @selected(old('jenis_media', $media->jenis_media ?? '') === $jenis)>{{ strtoupper($jenis) }}</option>
            @endforeach
        </select>
        <p class="mt-1.5 text-xs text-slate-400">Jenis YouTube harus menggunakan tautan video. Jenis lain dapat menggunakan file atau tautan eksternal.</p>
        @error('jenis_media')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="file_media" class="mb-1.5 block text-sm font-semibold text-slate-700">Unggah File <span class="text-xs font-normal text-slate-400">(opsional jika menggunakan tautan)</span></label>
        <input id="file_media" name="file_media" type="file" accept=".pdf,.ppt,.pptx,.mp4,.mov,.webm,.ogg,.gif,.png,.jpg,.jpeg,.webp,.zip" class="block w-full rounded-xl border border-slate-200 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-warm-100 file:px-4 file:py-3 file:text-sm file:font-semibold file:text-maroon-800 hover:file:bg-warm-200">
        <p class="mt-1.5 text-xs text-slate-400">Maksimal 20 MB. Format file akan divalidasi sesuai jenis media. Unggahan baru akan menggantikan file lama.</p>
        @if (isset($media) && !empty($media->lokasi_file))
            <p class="mt-2 text-xs text-slate-600">File saat ini: <a class="font-semibold text-maroon-700 underline" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($media->lokasi_file) }}" target="_blank" rel="noopener noreferrer">Buka file</a>. Biarkan kosong untuk mempertahankan file saat ini.</p>
        @endif
        @error('file_media')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="tautan" class="mb-1.5 block text-sm font-semibold text-slate-700">Tautan Media <span class="text-xs font-normal text-slate-400">(URL eksternal atau YouTube)</span></label>
        <input id="tautan" name="tautan" type="url" maxlength="2048" value="{{ old('tautan', $media->tautan ?? '') }}" placeholder="https://..." class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
        @error('tautan')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-7 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
    <a href="{{ route('instruktur.media.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
    <button type="submit" @disabled($materi->isEmpty()) class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100 disabled:cursor-not-allowed disabled:opacity-50"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>{{ isset($media) ? 'Simpan Perubahan' : 'Simpan Media' }}</button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jenis = document.getElementById('jenis_media');
    const file = document.getElementById('file_media');
    const tautan = document.getElementById('tautan');
    if (!jenis || !file || !tautan) return;
    function sinkronkanJenisMedia() {
        const isYoutube = jenis.value === 'youtube';
        file.disabled = isYoutube;
        file.classList.toggle('opacity-50', isYoutube);
        tautan.required = isYoutube;
        tautan.placeholder = isYoutube ? 'https://www.youtube.com/watch?v=...' : 'https://...';
    }
    jenis.addEventListener('change', sinkronkanJenisMedia);
    sinkronkanJenisMedia();
});
</script>
@endpush

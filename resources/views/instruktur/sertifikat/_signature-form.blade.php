@php
    $signatureStoragePath = 'signatures/instructors/' . auth()->id() . '.png';
    $hasInstructorSignature = \Illuminate\Support\Facades\Storage::disk('local')->exists($signatureStoragePath);
@endphp

<section class="mb-6 rounded-2xl border border-maroon-900/10 bg-white p-5 shadow-sm">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="max-w-xl">
            <p class="text-xs font-extrabold uppercase tracking-[.15em] text-maroon-700">Identitas penerbit</p>
            <h2 class="mt-1 font-display text-lg font-extrabold text-maroon-950">Tanda Tangan Instruktur</h2>
            <p class="mt-1 text-sm leading-6 text-slate-500">
                Unggah tanda tangan asli dalam format PNG transparan. File disimpan berdasarkan ID akun, jadi tidak memerlukan kolom database baru.
            </p>
            <p class="mt-2 text-xs font-semibold {{ $hasInstructorSignature ? 'text-emerald-700' : 'text-amber-700' }}">
                {{ $hasInstructorSignature ? 'Tanda tangan sudah tersedia dan akan dicantumkan pada sertifikat baru.' : 'Belum ada gambar tanda tangan. Sertifikat tetap menampilkan nama instruktur dan garis tanda tangan.' }}
            </p>
        </div>
        <form action="{{ route('instruktur.sertifikat.signature.store') }}" method="POST" enctype="multipart/form-data" class="w-full sm:max-w-sm">
            @csrf
            <label for="tanda_tangan" class="mb-1.5 block text-xs font-bold text-slate-700">Pilih tanda tangan (PNG, maks. 2 MB)</label>
            <input id="tanda_tangan" name="tanda_tangan" type="file" accept="image/png" required
                class="block w-full rounded-xl border border-slate-200 bg-warm-50 p-2 text-xs text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-maroon-800 file:px-3 file:py-2 file:text-xs file:font-bold file:text-white">
            @error('tanda_tangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-xl bg-maroon-800 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-maroon-700">
                Simpan Tanda Tangan
            </button>
        </form>
    </div>
</section>

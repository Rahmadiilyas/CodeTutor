@if ($errors->any())
    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
        <p class="font-semibold">Ada bagian yang perlu diperbaiki.</p>
        <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid gap-5">
    <div>
        <label for="pertanyaan" class="mb-2 block text-sm font-semibold text-slate-700">Pertanyaan <span class="text-rose-500">*</span></label>
        <textarea id="pertanyaan" name="pertanyaan" required rows="3" maxlength="10000" placeholder="Contoh: Apa itu variabel dalam pemrograman?" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('pertanyaan', $referensiChatbot->pertanyaan) }}</textarea>
        <p class="mt-1.5 text-xs text-slate-400">Tuliskan pertanyaan atau topik yang ingin dijadikan acuan chatbot.</p>
    </div>
    <div>
        <label for="jawaban_referensi" class="mb-2 block text-sm font-semibold text-slate-700">Jawaban referensi <span class="text-rose-500">*</span></label>
        <textarea id="jawaban_referensi" name="jawaban_referensi" required rows="9" placeholder="Tuliskan jawaban acuan yang akurat, jelas, dan sesuai materi pembelajaran..." class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm leading-6 outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">{{ old('jawaban_referensi', $referensiChatbot->jawaban_referensi) }}</textarea>
        <p class="mt-1.5 text-xs text-slate-400">
    Gunakan jawaban yang akurat dan sesuai materi pembelajaran.
    Referensi berstatus aktif dapat digunakan chatbot ketika relevan
    dengan pertanyaan Pelajar.
</p>
    </div>
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="id_materi" class="mb-2 block text-sm font-semibold text-slate-700">Materi terkait <span class="font-normal text-slate-400">(opsional)</span></label>
            <select id="id_materi" name="id_materi" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                <option value="">Umum / tidak terhubung ke materi</option>
                @foreach ($materiList as $materi)
                    <option value="{{ $materi->id }}" @selected((string) old('id_materi', $referensiChatbot->id_materi) === (string) $materi->id)>{{ $materi->judul_materi }}</option>
                @endforeach
            </select>
            @if ($materiList->isEmpty())<p class="mt-1.5 text-xs text-amber-700">Belum ada materi. Referensi tetap bisa dibuat tanpa menghubungkan materi.</p>@endif
        </div>
        <div>
            <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status referensi <span class="text-rose-500">*</span></label>
            <select id="status" name="status" required class="w-full rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm outline-none transition focus:border-maroon-400 focus:ring-4 focus:ring-maroon-100">
                <option value="1" @selected((string) old('status', (int) $referensiChatbot->status) === '1')>Aktif</option>
                <option value="0" @selected((string) old('status', (int) $referensiChatbot->status) === '0')>Nonaktif</option>
            </select>
        </div>
    </div>
</div>
<div class="mt-7 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
    <a href="{{ route('admin.referensi-chatbot.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Batal</a>
    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-800 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-maroon-700 focus:outline-none focus:ring-4 focus:ring-maroon-100"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>{{ $submitLabel ?? 'Simpan Referensi' }}</button>
</div>

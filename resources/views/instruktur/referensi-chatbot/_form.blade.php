<div>
    <label for="id_materi" class="mb-2 block text-xs font-bold text-slate-700">Materi Terkait <span class="font-normal text-slate-400">(opsional)</span></label>
    <select id="id_materi" name="id_materi" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-maroon-700 focus:ring-2 focus:ring-maroon-700/10">
        <option value="">Umum / tidak terhubung ke materi tertentu</option>
        @foreach ($materiList as $materi)
            <option value="{{ $materi->id }}" @selected((string) old('id_materi', $referensiChatbot->id_materi) === (string) $materi->id)>{{ $materi->judul_materi }}</option>
        @endforeach
    </select>
    @error('id_materi')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
    @if ($materiList->isEmpty())<p class="mt-2 text-xs text-amber-700">Anda belum memiliki materi pada modul yang dikelola. Referensi tetap bisa dibuat sebagai referensi umum.</p>@endif
</div>
<div>
    <label for="pertanyaan" class="mb-2 block text-xs font-bold text-slate-700">Pertanyaan / Topik <span class="text-red-600">*</span></label>
    <input id="pertanyaan" name="pertanyaan" type="text" required maxlength="10000" value="{{ old('pertanyaan', $referensiChatbot->pertanyaan) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-maroon-700 focus:ring-2 focus:ring-maroon-700/10" placeholder="Contoh: Apa fungsi variabel dalam Java?">
    @error('pertanyaan')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="jawaban_referensi" class="mb-2 block text-xs font-bold text-slate-700">Jawaban Referensi <span class="text-red-600">*</span></label>
    <textarea id="jawaban_referensi" name="jawaban_referensi" required rows="8" maxlength="100000" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm leading-6 outline-none focus:border-maroon-700 focus:ring-2 focus:ring-maroon-700/10" placeholder="Tuliskan jawaban yang akurat, jelas, dan sesuai materi...">{{ old('jawaban_referensi', $referensiChatbot->jawaban_referensi) }}</textarea>
    @error('jawaban_referensi')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
</div>
<div>
    <label for="status" class="mb-2 block text-xs font-bold text-slate-700">Status Referensi <span class="text-red-600">*</span></label>
    <select id="status" name="status" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-maroon-700 focus:ring-2 focus:ring-maroon-700/10">
        <option value="1" @selected((string) old('status', (string) ((int) ($referensiChatbot->status ?? true))) === '1')>Aktif — dapat digunakan sebagai acuan</option>
<option value="0" @selected((string) old('status', (string) ((int) ($referensiChatbot->status ?? true))) === '0')>Nonaktif — tidak digunakan sebagai acuan</option>
    </select>
    @error('status')<p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>@enderror
</div>

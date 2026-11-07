@extends('layouts.master')

@section('title', 'Chatbot AI')
@section('page_label', 'Pembelajaran')
@section('page_heading', 'Chatbot AI')
@section('description', 'Tutor AI untuk membantu memahami konsep dan latihan pemrograman.')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="mx-auto max-w-6xl space-y-5">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Tutor pembelajaran
            </div>
            <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Tanya CodeTutor AI</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Diskusikan konsep pemrograman, minta contoh kode, atau cari bantuan memahami error. Jawaban AI dapat perlu diverifikasi kembali.</p>
        </div>
        <form method="POST" action="{{ route('pelajar.chatbot.clear') }}" onsubmit="return confirm('Hapus seluruh percakapan pada sesi ini?')">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h18M8 6V4h8v2m-9 0 1 14h8l1-14M10 10v6m4-6v6"/></svg>
                Hapus percakapan
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif

    @if (!$chatbotSiap)
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
            <p class="font-bold">Chatbot belum dikonfigurasi</p>
            <p class="mt-1 leading-6">Tambahkan <code class="rounded bg-white px-1.5 py-0.5">GEMINI_API_KEY</code> ke file <code class="rounded bg-white px-1.5 py-0.5">.env</code>, kemudian jalankan <code class="rounded bg-white px-1.5 py-0.5">php artisan config:clear</code>. Jangan menaruh API key di tampilan atau mengirimkannya ke siapa pun.</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">{{ $errors->first() }}</div>
    @endif

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_250px]">
        <section class="flex min-h-[620px] flex-col overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-soft">
            <div class="flex items-center gap-3 border-b border-slate-100 bg-gradient-to-r from-maroon-950 to-maroon-800 px-5 py-4 text-white sm:px-6">
                <div class="grid h-11 w-11 place-items-center rounded-2xl border border-gold-400/30 bg-white/[.08] text-gold-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3a7 7 0 0 0-7 7v3a3 3 0 0 0 3 3h1v-6H8a4 4 0 0 0-3.8 2.8M12 3a7 7 0 0 1 7 7v3a3 3 0 0 1-3 3h-1v-6h1a4 4 0 0 1 3.8 2.8M9 20h6"/></svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-display text-sm font-extrabold">CodeTutor AI</p>
                    <p class="mt-0.5 text-xs text-white/60">Tutor coding · Bahasa Indonesia</p>
                </div>
                @if ($chatbotSiap)
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-300/20 bg-emerald-400/10 px-2.5 py-1 text-[10px] font-bold text-emerald-200"><span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span> Siap membantu</span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-300/20 bg-amber-400/10 px-2.5 py-1 text-[10px] font-bold text-amber-200"><span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span> Belum terhubung</span>
                @endif
            </div>

            <div id="chatMessages" class="flex-1 space-y-5 overflow-y-auto bg-warm-50/60 p-4 sm:p-6" aria-live="polite" aria-label="Percakapan Chatbot AI">
                @if (empty($riwayatPesan))
                    <div id="chatEmptyState" class="mx-auto flex min-h-[330px] max-w-md flex-col items-center justify-center py-10 text-center">
                        <div class="grid h-16 w-16 place-items-center rounded-3xl border border-gold-400/30 bg-white text-maroon-800 shadow-sm">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3v-7a4 4 0 0 1-1-2V7a4 4 0 0 1 4-4h14a4 4 0 0 1 4 4z" transform="translate(1 0)"/><path d="M8 10h.01M12 10h.01M16 10h.01" stroke-width="2.5"/></svg>
                        </div>
                        <h2 class="mt-5 font-display text-lg font-extrabold text-maroon-950">Mulai bertanya</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-500">Pilih salah satu ide pertanyaan atau tulis pertanyaanmu sendiri.</p>
                        <div class="mt-5 flex flex-wrap justify-center gap-2">
                            <button type="button" class="quick-prompt rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:text-maroon-800" data-prompt="Apa itu variabel dalam pemrograman?">Apa itu variabel?</button>
                            <button type="button" class="quick-prompt rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:text-maroon-800" data-prompt="Jelaskan perulangan for dengan contoh Python sederhana.">Contoh perulangan</button>
                            <button type="button" class="quick-prompt rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-maroon-200 hover:text-maroon-800" data-prompt="Bagaimana cara membuat fungsi di Python? Berikan contoh.">Membuat fungsi</button>
                        </div>
                    </div>
                @else
                    @foreach ($riwayatPesan as $pesanChat)
                        <div class="flex {{ ($pesanChat['role'] ?? '') === 'user' ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[88%] sm:max-w-[82%]">
                                <div class="mb-1.5 flex items-center gap-2 {{ ($pesanChat['role'] ?? '') === 'user' ? 'justify-end' : '' }}">
                                    <span class="text-[11px] font-extrabold {{ ($pesanChat['role'] ?? '') === 'user' ? 'text-maroon-700' : 'text-slate-500' }}">{{ ($pesanChat['role'] ?? '') === 'user' ? 'Kamu' : 'CodeTutor AI' }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $pesanChat['time'] ?? '' }}</span>
                                </div>
                                <div class="rounded-2xl {{ ($pesanChat['role'] ?? '') === 'user' ? 'rounded-tr-md bg-maroon-800 text-white' : 'rounded-tl-md border border-slate-200 bg-white text-slate-700' }} px-4 py-3 text-sm leading-6 shadow-sm">
                                    <p class="whitespace-pre-wrap break-words">{{ $pesanChat['text'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div id="typingIndicator" class="hidden justify-start">
                    <div class="rounded-2xl rounded-tl-md border border-slate-200 bg-white px-4 py-3 text-xs font-medium text-slate-500 shadow-sm">
                        CodeTutor AI sedang berpikir<span class="typing-dots">...</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 bg-white p-4 sm:p-5">
                <form id="chatForm" action="{{ route('pelajar.chatbot.send') }}" method="POST" class="flex items-end gap-2 sm:gap-3">
                    @csrf
                    <label for="messageInput" class="sr-only">Tulis pertanyaan</label>
                    <textarea id="messageInput" name="message" rows="1" maxlength="3000" required placeholder="Tulis pertanyaan pemrogramanmu..." class="max-h-36 min-h-[48px] flex-1 resize-y rounded-2xl border border-slate-200 bg-warm-50 px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-maroon-400 focus:bg-white focus:ring-4 focus:ring-maroon-100"></textarea>
                    <button id="sendButton" type="submit" class="inline-flex h-12 shrink-0 items-center justify-center gap-2 rounded-2xl bg-maroon-800 px-4 text-sm font-bold text-white shadow-sm transition hover:bg-maroon-700 disabled:cursor-not-allowed disabled:opacity-50 sm:px-5">
                        <span id="sendButtonText">Kirim</span>
                        <svg id="sendIcon" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 2-7 20-4-9-9-4 20-7Z"/><path d="M22 2 11 13"/></svg>
                    </button>
                </form>
                <div class="mt-2 flex flex-wrap items-center justify-between gap-2 px-1">
                    <p class="text-[10px] leading-5 text-slate-400">Enter untuk mengirim · Shift + Enter untuk baris baru</p>
                    <p id="characterCount" class="text-[10px] text-slate-400">0/3000</p>
                </div>
                <div id="chatError" class="mt-3 hidden rounded-xl border border-rose-200 bg-rose-50 px-3 py-2.5 text-xs leading-5 text-rose-700" role="alert"></div>
            </div>
        </section>

        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft">
                <div class="flex items-center gap-2">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-gold-100 text-maroon-800"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m12 3 1.9 5.8L20 11l-6.1 2.2L12 19l-1.9-5.8L4 11l6.1-2.2L12 3Z"/><path d="m19 14 1 2.5 2.5 1-2.5 1-1 2.5-1-2.5-2.5-1 2.5-1 1-2.5Z"/></svg></span>
                    <h2 class="font-display text-sm font-extrabold text-maroon-950">Tips bertanya</h2>
                </div>
                <ul class="mt-4 space-y-3 text-xs leading-5 text-slate-600">
                    <li class="flex gap-2"><span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-gold-500"></span><span>Sebutkan bahasa pemrograman yang sedang dipelajari.</span></li>
                    <li class="flex gap-2"><span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-gold-500"></span><span>Tempelkan potongan kode dan pesan error bila meminta bantuan debugging.</span></li>
                    <li class="flex gap-2"><span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-gold-500"></span><span>Minta penjelasan bertahap jika konsep belum dipahami.</span></li>
                </ul>
            </div>
            <div class="rounded-2xl border border-gold-200/70 bg-gradient-to-br from-white to-gold-50 p-5">
                <p class="text-xs font-extrabold uppercase tracking-[.14em] text-maroon-700">Catatan</p>
                <p class="mt-2 text-xs leading-5 text-slate-600">Jawaban dihasilkan AI dan dapat keliru. Cocokkan kembali kode serta konsep dengan materi pembelajaran dan uji kode di lingkungan yang aman.</p>
            </div>
        </aside>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const formulirChat = document.getElementById('chatForm');
    const kolomPertanyaan = document.getElementById('messageInput');
    const areaPercakapan = document.getElementById('chatMessages');
    const tombolKirim = document.getElementById('sendButton');
    const teksTombolKirim = document.getElementById('sendButtonText');
    const ikonKirim = document.getElementById('sendIcon');
    const indikatorMengetik = document.getElementById('typingIndicator');
    const kotakKesalahan = document.getElementById('chatError');
    const penghitungKarakter = document.getElementById('characterCount');
    const tokenKeamanan = document.querySelector('meta[name="csrf-token"]')?.content;

    const gulirKeBawah = () => { areaPercakapan.scrollTop = areaPercakapan.scrollHeight; };
    gulirKeBawah();

    function tampilkanPesan(peran, teks, waktu) {
        document.getElementById('chatEmptyState')?.remove();
        const wadahPesan = document.createElement('div');
        wadahPesan.className = `flex ${peran === 'user' ? 'justify-end' : 'justify-start'}`;
        const isiPesan = document.createElement('div');
        isiPesan.className = 'max-w-[88%] sm:max-w-[82%]';
        const keteranganPesan = document.createElement('div');
        keteranganPesan.className = `mb-1.5 flex items-center gap-2 ${peran === 'user' ? 'justify-end' : ''}`;
        const namaPengirim = document.createElement('span');
        namaPengirim.className = `text-[11px] font-extrabold ${peran === 'user' ? 'text-maroon-700' : 'text-slate-500'}`;
        namaPengirim.textContent = peran === 'user' ? 'Kamu' : 'CodeTutor AI';
        const waktuTampil = document.createElement('span');
        waktuTampil.className = 'text-[10px] text-slate-400';
        waktuTampil.textContent = waktu || new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
        keteranganPesan.append(namaPengirim, waktuTampil);
        const kotakPesan = document.createElement('div');
        kotakPesan.className = `rounded-2xl ${peran === 'user' ? 'rounded-tr-md bg-maroon-800 text-white' : 'rounded-tl-md border border-slate-200 bg-white text-slate-700'} px-4 py-3 text-sm leading-6 shadow-sm`;
        const paragrafPesan = document.createElement('p');
        paragrafPesan.className = 'whitespace-pre-wrap break-words';
        paragrafPesan.textContent = teks;
        kotakPesan.appendChild(paragrafPesan);
        isiPesan.append(keteranganPesan, kotakPesan);
        wadahPesan.appendChild(isiPesan);
        areaPercakapan.insertBefore(wadahPesan, indikatorMengetik);
        gulirKeBawah();
    }

    function aturStatusPengiriman(sedangMengirim) {
        tombolKirim.disabled = sedangMengirim;
        kolomPertanyaan.disabled = sedangMengirim;
        indikatorMengetik.classList.toggle('hidden', !sedangMengirim);
        indikatorMengetik.classList.toggle('flex', sedangMengirim);
        teksTombolKirim.textContent = sedangMengirim ? 'Mengirim' : 'Kirim';
        ikonKirim.classList.toggle('hidden', sedangMengirim);
        if (sedangMengirim) kotakKesalahan.classList.add('hidden');
        gulirKeBawah();
    }

    kolomPertanyaan.addEventListener('input', () => {
        penghitungKarakter.textContent = `${kolomPertanyaan.value.length}/3000`;
        kolomPertanyaan.style.height = 'auto';
        kolomPertanyaan.style.height = `${Math.min(kolomPertanyaan.scrollHeight, 144)}px`;
    });

    kolomPertanyaan.addEventListener('keydown', (kejadian) => {
        if (kejadian.key === 'Enter' && !kejadian.shiftKey) {
            kejadian.preventDefault();
            formulirChat.requestSubmit();
        }
    });

    document.querySelectorAll('.quick-prompt').forEach((tombolContoh) => {
        tombolContoh.addEventListener('click', () => {
            kolomPertanyaan.value = tombolContoh.dataset.prompt || '';
            kolomPertanyaan.dispatchEvent(new Event('input'));
            kolomPertanyaan.focus();
        });
    });

    formulirChat.addEventListener('submit', async (kejadian) => {
        kejadian.preventDefault();
        const pertanyaan = kolomPertanyaan.value.trim();
        if (!pertanyaan || tombolKirim.disabled) return;

        tampilkanPesan('user', pertanyaan);
        kolomPertanyaan.value = '';
        kolomPertanyaan.dispatchEvent(new Event('input'));
        aturStatusPengiriman(true);

        try {
            const balasanServer = await fetch(formulirChat.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': tokenKeamanan || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({message: pertanyaan})
            });
            const dataJawaban = await balasanServer.json().catch(() => ({}));
            if (!balasanServer.ok) throw new Error(dataJawaban.message || 'Pertanyaan gagal diproses. Coba kembali.');
            tampilkanPesan('model', dataJawaban.answer || 'Maaf, belum ada jawaban yang dapat ditampilkan.', dataJawaban.time);
        } catch (kesalahan) {
            kotakKesalahan.textContent = kesalahan.message || 'Koneksi bermasalah. Silakan coba kembali.';
            kotakKesalahan.classList.remove('hidden');
        } finally {
            aturStatusPengiriman(false);
            kolomPertanyaan.disabled = false;
            kolomPertanyaan.focus();
            gulirKeBawah();
        }
    });
});
</script>
@endsection

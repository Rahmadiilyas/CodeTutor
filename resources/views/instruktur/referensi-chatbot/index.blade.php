@extends('layouts.master')

@section('title', 'Referensi Chatbot Saya')

@section('content')
<div class="min-h-screen bg-slate-50 px-5 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mb-8 rounded-3xl bg-gradient-to-br from-maroon-950 via-maroon-900 to-[#3b1513] p-6 text-white shadow-sm sm:p-8">
            <div class="mb-4 text-xs font-semibold text-white/55"><a href="{{ route('dashboard') }}" class="hover:text-gold-300">Dashboard</a><span class="mx-2">/</span><span class="text-white/85">Referensi Chatbot</span></div>
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <span class="inline-flex rounded-full border border-gold-400/20 bg-gold-400/10 px-3 py-1.5 text-[11px] font-bold text-gold-300">Basis Pengetahuan AI</span>
                    <h1 class="mt-3 text-3xl font-black tracking-tight">Referensi Chatbot Saya</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-white/65">Kelola referensi jawaban untuk membantu chatbot memberikan informasi pembelajaran yang relevan. Anda hanya dapat mengelola referensi yang Anda buat sendiri.</p>
                </div>
                <a href="{{ route('instruktur.referensi-chatbot.create') }}" class="inline-flex items-center justify-center rounded-xl bg-gold-400 px-4 py-3 text-xs font-extrabold text-maroon-950 transition hover:bg-gold-300">+ Tambah Referensi</a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ session('error') }}</div>
        @endif

        <div class="mb-6 grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold text-slate-400">Total Referensi Saya</p><p class="mt-2 text-3xl font-black text-slate-800">{{ number_format($totalReferensi) }}</p></div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold text-slate-400">Referensi Aktif</p><p class="mt-2 text-3xl font-black text-emerald-700">{{ number_format($referensiAktif) }}</p></div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold text-slate-400">Referensi Nonaktif</p><p class="mt-2 text-3xl font-black text-amber-700">{{ number_format($referensiNonaktif) }}</p></div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <form method="GET" action="{{ route('instruktur.referensi-chatbot.index') }}" class="grid gap-3 border-b border-slate-100 p-5 md:grid-cols-4">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pertanyaan atau jawaban" class="rounded-xl border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-maroon-700 focus:ring-2 focus:ring-maroon-700/10">
                <select name="materi" class="rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-maroon-700 focus:ring-2 focus:ring-maroon-700/10">
                    <option value="">Semua materi saya</option>
                    @foreach ($materiList as $materi)
                        <option value="{{ $materi->id }}" @selected((string) request('materi') === (string) $materi->id)>{{ $materi->judul_materi }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-700 outline-none focus:border-maroon-700 focus:ring-2 focus:ring-maroon-700/10">
                    <option value="">Semua status</option>
                    <option value="1" @selected(request('status') === '1')>Aktif</option>
                    <option value="0" @selected(request('status') === '0')>Nonaktif</option>
                </select>
                <div class="flex gap-2"><button class="flex-1 rounded-xl bg-maroon-900 px-4 py-2.5 text-xs font-bold text-white hover:bg-maroon-800">Filter</button><a href="{{ route('instruktur.referensi-chatbot.index') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-600 hover:bg-slate-50">Reset</a></div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wide text-slate-500"><tr><th class="px-5 py-4 font-bold">Pertanyaan</th><th class="px-5 py-4 font-bold">Materi</th><th class="px-5 py-4 font-bold">Status</th><th class="px-5 py-4 font-bold">Dibuat</th><th class="px-5 py-4 text-right font-bold">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($referensi as $item)
                            <tr class="align-top hover:bg-slate-50/80">
                                <td class="max-w-lg px-5 py-4"><p class="font-bold text-slate-800">{{ $item->pertanyaan }}</p><p class="mt-1 line-clamp-2 whitespace-pre-line text-xs leading-5 text-slate-500">{{ $item->jawaban_referensi }}</p></td>
                                <td class="px-5 py-4 text-slate-600">{{ $item->materi->judul_materi ?? 'Umum (tanpa materi)' }}</td>
                                <td class="px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-bold {{ $item->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $item->status ? 'Aktif' : 'Nonaktif' }}</span></td>
                                <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500">{{ optional($item->created_at)->format('d M Y') ?? '—' }}</td>
                                <td class="whitespace-nowrap px-5 py-4"><div class="flex justify-end gap-2">
                                    <a href="{{ route('instruktur.referensi-chatbot.edit', $item) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50">Edit</a>
                                    <form method="POST" action="{{ route('instruktur.referensi-chatbot.status', $item) }}">@csrf @method('PATCH')<button class="rounded-lg border border-amber-200 px-3 py-2 text-xs font-bold text-amber-700 hover:bg-amber-50">{{ $item->status ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                                    <form method="POST" action="{{ route('instruktur.referensi-chatbot.destroy', $item) }}" onsubmit="return confirm('Hapus referensi ini?')">@csrf @method('DELETE')<button class="rounded-lg border border-red-200 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-50">Hapus</button></form>
                                </div></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-12 text-center"><p class="font-bold text-slate-700">Belum ada referensi chatbot</p><p class="mt-1 text-sm text-slate-500">Tambahkan referensi pertama agar bisa digunakan sebagai sumber jawaban chatbot.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($referensi->hasPages())<div class="border-t border-slate-100 p-5">{{ $referensi->links() }}</div>@endif
        </div>
    </div>
</div>
@endsection

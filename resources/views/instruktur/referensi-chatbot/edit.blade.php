@extends('layouts.master')
@section('title', 'Edit Referensi Chatbot')
@section('content')
<div class="min-h-screen bg-slate-50 px-5 py-8 sm:px-6 lg:px-8"><div class="mx-auto max-w-4xl">
    <div class="mb-6 rounded-3xl bg-gradient-to-br from-maroon-950 via-maroon-900 to-[#3b1513] p-6 text-white sm:p-8"><a href="{{ route('instruktur.referensi-chatbot.index') }}" class="text-xs font-semibold text-white/60 hover:text-gold-300">← Kembali ke Referensi Chatbot</a><h1 class="mt-4 text-3xl font-black">Edit Referensi Chatbot</h1><p class="mt-2 text-sm text-white/65">Perbarui referensi yang Anda kelola.</p></div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <form method="POST" action="{{ route('instruktur.referensi-chatbot.update', $referensiChatbot) }}" class="space-y-5">@csrf @method('PUT')
            @include('instruktur.referensi-chatbot._form')
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end"><a href="{{ route('instruktur.referensi-chatbot.index') }}" class="rounded-xl border border-slate-200 px-5 py-3 text-center text-xs font-bold text-slate-600 hover:bg-slate-50">Batal</a><button class="rounded-xl bg-maroon-900 px-5 py-3 text-xs font-extrabold text-white hover:bg-maroon-800">Simpan Perubahan</button></div>
        </form>
    </div>
</div></div>
@endsection

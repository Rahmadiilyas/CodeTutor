@extends('layouts.master')
@section('title', 'Edit Referensi Chatbot')
@section('description', 'Perbarui pertanyaan dan jawaban referensi chatbot.')
@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div><a href="{{ route('admin.referensi-chatbot.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 transition hover:text-maroon-950"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>Kembali ke Referensi Chatbot</a><h1 class="mt-3 font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Edit Referensi Chatbot</h1><p class="mt-2 text-sm leading-6 text-slate-500">Perbarui pertanyaan, jawaban, materi terkait, atau status referensi.</p></div>
    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-7"><form action="{{ route('admin.referensi-chatbot.update', $referensiChatbot) }}" method="POST">@csrf @method('PUT') @include('admin.referensi-chatbot._form', ['submitLabel' => 'Simpan Perubahan'])</form></div>
</div>
@endsection

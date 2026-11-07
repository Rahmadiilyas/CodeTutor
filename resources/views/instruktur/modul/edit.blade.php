@extends('layouts.master')
@section('title', 'Edit Modul Pembelajaran')
@section('description', 'Perbarui informasi modul pembelajaran.')
@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <a href="{{ route('instruktur.modul.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 hover:text-maroon-950"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>Kembali ke Modul</a>
        <div class="mt-4"><h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Edit Modul Pembelajaran</h1><p class="mt-2 text-sm leading-6 text-slate-500">Perbarui nama, deskripsi, bahasa, urutan, atau status modul.</p></div>
    </div>
    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-7"><form action="{{ route('instruktur.modul.update', $modul) }}" method="POST">@csrf @method('PUT') @include('instruktur.modul._form', ['submitLabel' => 'Simpan Perubahan'])</form></div>
</div>
@endsection

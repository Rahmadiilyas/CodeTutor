@extends('layouts.master')

@section('title', 'Edit Materi')
@section('description', 'Perbarui materi pembelajaran yang kamu kelola.')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div><a href="{{ route('instruktur.materi.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 transition hover:text-maroon-950"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>Kembali ke Materi</a><div class="mt-4 mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700"><span class="h-2 w-2 rounded-full bg-gold-500"></span> Area Instruktur</div><h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Edit Materi Pembelajaran</h1><p class="mt-2 text-sm leading-6 text-slate-500">Perbarui isi, modul, urutan, dan status materi.</p></div>
    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-7"><form method="POST" action="{{ route('instruktur.materi.update', $materi) }}">@csrf @method('PUT') @include('instruktur.materi._form')</form></div>
</div>
@endsection

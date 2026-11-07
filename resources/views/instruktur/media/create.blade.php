@extends('layouts.master')

@section('title', 'Tambah Media Pembelajaran')
@section('description', 'Tambahkan file atau tautan media ke materi pembelajaran.')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div>
        <a href="{{ route('instruktur.media.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-maroon-800"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>Kembali ke Media Pembelajaran</a>
        <div class="mt-4 mb-2 inline-flex items-center gap-2 rounded-full border border-maroon-100 bg-white px-3 py-1 text-xs font-semibold text-maroon-700"><span class="h-2 w-2 rounded-full bg-gold-500"></span> FR-009 · Media Pembelajaran</div>
        <h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Tambah Media Pembelajaran</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500">Hubungkan file atau tautan pendukung dengan salah satu materi milikmu.</p>
    </div>
    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-7">
        <form method="POST" action="{{ route('instruktur.media.store') }}" enctype="multipart/form-data">
            @csrf
            @include('instruktur.media._form')
        </form>
    </div>
</div>
@endsection

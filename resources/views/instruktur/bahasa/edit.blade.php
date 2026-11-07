@extends('layouts.master')
@section('title', 'Edit Bahasa Pemrograman')
@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div><a href="{{ route('instruktur.bahasa.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 hover:text-maroon-950"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>Kembali ke Bahasa Pemrograman</a><div class="mt-4"><h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Edit Bahasa Pemrograman</h1><p class="mt-2 text-sm leading-6 text-slate-500">Perbarui informasi dan status bahasa pemrograman milikmu.</p></div></div>
    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-7">
        <form action="{{ route('instruktur.bahasa.update', $bahasa) }}" method="POST">@csrf @method('PUT') @include('instruktur.bahasa._form', ['bahasa' => $bahasa, 'submitLabel' => 'Simpan Perubahan'])</form>
    </div>
</div>
@endsection

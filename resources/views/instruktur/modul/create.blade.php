@extends('layouts.master')
@section('title', 'Tambah Modul Pembelajaran')
@section('description', 'Buat modul pembelajaran baru.')
@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <a href="{{ route('instruktur.modul.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 hover:text-maroon-950"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>Kembali ke Modul</a>
        <div class="mt-4"><h1 class="font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">Tambah Modul Pembelajaran</h1><p class="mt-2 text-sm leading-6 text-slate-500">Lengkapi informasi modul dan pilih bahasa pemrograman yang terkait.</p></div>
    </div>
    @if ($bahasa->isEmpty())
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6 text-center"><h2 class="font-display text-lg font-bold text-amber-950">Belum ada bahasa pemrograman aktif</h2><p class="mt-2 text-sm text-amber-900/80">Kamu perlu menambahkan atau mengaktifkan bahasa pemrograman sebelum membuat modul.</p><a href="{{ route('instruktur.bahasa.index') }}" class="mt-4 inline-flex items-center justify-center rounded-xl bg-maroon-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-maroon-700">Buka Bahasa Pemrograman</a></div>
    @else
        <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-soft sm:p-7"><form action="{{ route('instruktur.modul.store') }}" method="POST">@csrf @include('instruktur.modul._form', ['submitLabel' => 'Simpan Modul'])</form></div>
    @endif
</div>
@endsection

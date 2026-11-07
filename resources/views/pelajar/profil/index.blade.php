@extends('layouts.master')

@section('title', ($editMode ? 'Edit Profil' : 'Profil Saya') . ' | CodeTutor')
@section('page_label', 'Akun')
@section('page_heading', $editMode ? 'Edit Profil' : 'Profil Saya')
@section('description', 'Lihat dan perbarui informasi akun CodeTutor kamu.')

@section('content')
@php
    $initial = strtoupper(substr(trim((string) ($user->nama ?? 'P')), 0, 1));
    $roleLabel = 'Pelajar';
@endphp

<div class="mx-auto max-w-7xl space-y-6">
    {{-- Judul halaman --}}
    <div>
        <p class="text-[10px] font-extrabold uppercase tracking-[.18em] text-maroon-700">Pengaturan Akun</p>
        <h2 class="mt-2 font-display text-2xl font-extrabold tracking-tight text-maroon-950 sm:text-3xl">
            {{ $editMode ? 'Edit Profil' : 'Profil Saya' }}
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            {{ $editMode ? 'Perbarui informasi dasar akun belajar kamu.' : 'Lihat dan perbarui informasi pribadi akun CodeTutor kamu.' }}
        </p>
    </div>

    @if (session('success'))
        <div role="status" class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
            <p class="font-bold">Profil belum bisa disimpan.</p>
            <ul class="mt-1 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid items-start gap-5 xl:grid-cols-[260px_minmax(0,1fr)]">
        {{-- Kartu profil di sisi kiri --}}
        <aside class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
            <div class="h-1.5 bg-gradient-to-r from-maroon-950 via-maroon-700 to-gold-500"></div>
            <div class="px-5 pb-6 pt-7 text-center">
                @if ($user->foto)
                    <img
                        src="{{ asset('storage/' . $user->foto) }}"
                        alt="Foto profil {{ $user->nama }}"
                        class="mx-auto h-20 w-20 rounded-2xl border border-gold-300 object-cover shadow-sm"
                    >
                @else
                    <div class="mx-auto grid h-20 w-20 place-items-center rounded-2xl bg-gold-400 font-display text-2xl font-extrabold text-maroon-950 shadow-sm">
                        {{ $initial }}
                    </div>
                @endif

                <h3 class="mt-4 break-words font-display text-lg font-extrabold text-maroon-950">{{ $user->nama }}</h3>
                <p class="mt-1 break-all text-xs text-slate-400">{{ $user->email }}</p>
                <span class="mt-3 inline-flex items-center rounded-full border border-rose-100 bg-rose-50 px-3 py-1 text-[11px] font-bold text-maroon-800">
                    {{ $roleLabel }}
                </span>
            </div>
            <div class="border-t border-slate-100 bg-warm-50/70 px-5 py-4">
                <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-slate-400">Tentang akun</p>
                <p class="mt-2 text-xs leading-6 text-slate-600">
                    Informasi ini terhubung ke akun Pelajar yang sedang login. Data akun pengguna lain tidak dapat diubah dari halaman ini.
                </p>
            </div>
        </aside>

        {{-- Kartu informasi / form edit --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-soft">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <div>
                    <h3 class="font-display text-base font-extrabold text-maroon-950">
                        {{ $editMode ? 'Edit Informasi Profil' : 'Informasi Profil' }}
                    </h3>
                    <p class="mt-1 text-xs text-slate-400">
                        {{ $editMode ? 'Nama, email, dan foto profil dapat diperbarui di sini.' : 'Informasi dasar akun dan status peran kamu.' }}
                    </p>
                </div>

                @unless ($editMode)
                    <a href="{{ route('pelajar.profil.index', ['edit' => 1]) }}" class="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-maroon-950 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-maroon-800 focus:outline-none focus:ring-4 focus:ring-maroon-100 sm:self-auto">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/></svg>
                        Edit Profil
                    </a>
                @endunless
            </div>

            @if ($editMode)
                <form action="{{ route('pelajar.profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 px-5 py-6 sm:px-7">
                    @csrf
                    @method('PUT')

                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-800">Data Pribadi</p>
                        <div class="mt-4 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="nama" class="mb-2 block text-xs font-bold text-slate-600">Nama Lengkap <span class="text-rose-500">*</span></label>
                                <input id="nama" name="nama" type="text" value="{{ old('nama', $user->nama) }}" required maxlength="255" autocomplete="name" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-300 focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10">
                                @error('nama')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="mb-2 block text-xs font-bold text-slate-600">Email <span class="text-rose-500">*</span></label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="255" autocomplete="email" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-300 focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10">
                                @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5">
                        <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-800">Foto Profil</p>
                        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-center">
                            @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto profil saat ini" class="h-16 w-16 rounded-xl border border-slate-200 object-cover">
                            @else
                                <div class="grid h-16 w-16 place-items-center rounded-xl bg-gold-400 font-display text-xl font-extrabold text-maroon-950">{{ $initial }}</div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <label for="foto" class="mb-2 block text-xs font-bold text-slate-600">Pilih foto baru (opsional)</label>
                                <input id="foto" name="foto" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-warm-100 file:px-3 file:py-2 file:text-xs file:font-bold file:text-maroon-800 hover:file:bg-warm-200">
                                <p class="mt-2 text-[11px] leading-5 text-slate-400">Format JPG, JPEG, PNG, atau WEBP. Ukuran maksimal 2 MB.</p>
                                @error('foto')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                        <a href="{{ route('pelajar.profil.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-xs font-bold text-slate-600 transition hover:bg-slate-50">Batal</a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-maroon-950 px-5 py-3 text-xs font-bold text-white transition hover:bg-maroon-800 focus:outline-none focus:ring-4 focus:ring-maroon-100">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m5 12 4 4L19 6"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            @else
                <div class="px-5 py-6 sm:px-7">
                    <p class="text-[10px] font-extrabold uppercase tracking-[.16em] text-maroon-800">Data Pribadi</p>
                    <dl class="mt-5 grid gap-x-8 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-[11px] font-semibold text-slate-400">Nama Lengkap</dt>
                            <dd class="mt-1.5 break-words text-sm font-semibold text-slate-700">{{ $user->nama }}</dd>
                        </div>
                        <div>
                            <dt class="text-[11px] font-semibold text-slate-400">Email</dt>
                            <dd class="mt-1.5 break-all text-sm font-semibold text-slate-700">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-[11px] font-semibold text-slate-400">Peran Akun</dt>
                            <dd class="mt-1.5 text-sm font-semibold text-slate-700">Pelajar</dd>
                        </div>
                        <div>
                            <dt class="text-[11px] font-semibold text-slate-400">Status Akun</dt>
                            <dd class="mt-1.5">
                                @if ($user->status)
                                    <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">Aktif</span>
                                @else
                                    <span class="inline-flex rounded-full bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700">Nonaktif</span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-7 rounded-xl border border-gold-200/70 bg-gold-400/10 p-4">
                        <div class="flex items-start gap-3">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-white text-maroon-800">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                            </span>
                            <div>
                                <p class="text-xs font-bold text-maroon-950">Informasi akun</p>
                                <p class="mt-1 text-xs leading-5 text-slate-600">Pastikan alamat email tetap aktif karena digunakan untuk identitas akun CodeTutor.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
</div>
@endsection

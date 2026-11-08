@extends('layouts.master')

@section('title', 'Edit Akun Instruktur | CodeTutor')
@section('page_label', 'Kelola Akun')
@section('page_heading', 'Edit Akun Instruktur')

@section('content')
<div class="mx-auto max-w-4xl">

    {{-- HEADER --}}
    <div class="mb-6">
        <a href="{{ route('admin.akun.index', ['tab' => 'instruktur']) }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-maroon-700 hover:text-maroon-950">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <path d="m15 18-6-6 6-6"/>
                <path d="M9 12h12"/>
            </svg>
            Kembali ke Kelola Akun
        </a>

        <h2 class="mt-4 font-display text-2xl font-extrabold text-maroon-950">
            Edit Akun Instruktur
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            Perbarui informasi akun instruktur di bawah ini.
        </p>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="font-bold text-red-800">
                Data belum berhasil disimpan.
            </p>

            <ul class="mt-2 list-inside list-disc text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM EDIT --}}
    <form
        action="{{ route('admin.akun.instruktur.update', $akun->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="overflow-hidden rounded-2xl border border-maroon-900/10 bg-white shadow-soft"
    >
        @csrf
        @method('PUT')

        <div class="space-y-6 p-5 sm:p-8">

            {{-- NAMA --}}
            <div>
                <label for="nama" class="mb-2 block text-sm font-bold text-maroon-950">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    value="{{ old('nama', $akun->nama) }}"
                    required
                    autocomplete="name"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10"
                    placeholder="Masukkan nama lengkap"
                >

                @error('nama')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div>
                <label for="email" class="mb-2 block text-sm font-bold text-maroon-950">
                    Alamat Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $akun->email) }}"
                    required
                    autocomplete="email"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10"
                    placeholder="nama@email.com"
                >

                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div>
                <label for="kata_sandi" class="mb-2 block text-sm font-bold text-maroon-950">
                    Kata Sandi Baru
                </label>

                <input
                    type="password"
                    id="kata_sandi"
                    name="kata_sandi"
                    autocomplete="new-password"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10"
                    placeholder="Kosongkan jika tidak ingin mengganti"
                >

                <p class="mt-2 text-xs text-slate-500">
                    Kosongkan jika kata sandi tidak ingin diubah.
                </p>

                @error('kata_sandi')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div>
                <label for="kata_sandi_confirmation" class="mb-2 block text-sm font-bold text-maroon-950">
                    Konfirmasi Kata Sandi Baru
                </label>

                <input
                    type="password"
                    id="kata_sandi_confirmation"
                    name="kata_sandi_confirmation"
                    autocomplete="new-password"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10"
                    placeholder="Ulangi kata sandi baru"
                >
            </div>

            {{-- STATUS --}}
            <div>
                <label for="status" class="mb-2 block text-sm font-bold text-maroon-950">
                    Status Akun
                </label>

                <select
                    id="status"
                    name="status"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-gold-500 focus:ring-4 focus:ring-gold-500/10"
                >
                    <option value="1"
                        {{ (string) old('status', (int) $akun->status) === '1' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0"
                        {{ (string) old('status', (int) $akun->status) === '0' ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>

                @error('status')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- FOTO --}}
            <div>
                <label for="foto" class="mb-2 block text-sm font-bold text-maroon-950">
                    Foto Profil
                </label>

                @if ($akun->foto)
                    <div class="mb-3 flex items-center gap-3">
                        <img
                            src="{{ asset('storage/' . $akun->foto) }}"
                            alt="Foto {{ $akun->nama }}"
                            class="h-16 w-16 rounded-full border border-slate-200 object-cover"
                        >

                        <p class="text-xs text-slate-500">
                            Foto profil saat ini
                        </p>
                    </div>
                @endif

                <input
                    type="file"
                    id="foto"
                    name="foto"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-maroon-50 file:px-4 file:py-2 file:font-semibold file:text-maroon-800"
                >

                <p class="mt-2 text-xs text-slate-500">
                    Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                </p>

                @error('foto')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- ACTION --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-warm-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-8">

            <a
                href="{{ route('admin.akun.index', ['tab' => 'instruktur']) }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50"
            >
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-maroon-800 px-5 py-3 text-sm font-bold text-white transition hover:bg-maroon-700"
            >
                Simpan Perubahan
            </button>

        </div>
    </form>

</div>
@endsection

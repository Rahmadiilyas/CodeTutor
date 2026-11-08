@extends('layouts.master')

@section('title', 'Tambah Akun Instruktur')

@section('content')
<div class="min-h-screen bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-3xl">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.akun.index', ['tab' => 'instruktur']) }}"
               class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-gray-600 transition hover:text-amber-700">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Kelola Akun
            </a>

            <h1 class="text-2xl font-bold text-gray-900">
                Tambah Akun Instruktur
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                Lengkapi informasi berikut untuk membuat akun instruktur baru.
            </p>
        </div>

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">
                <p class="mb-2 font-semibold text-red-700">
                    Periksa kembali data yang dimasukkan:
                </p>

                <ul class="list-inside list-disc space-y-1 text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 bg-gradient-to-r from-[#3C1412] to-[#170201] px-6 py-5">
                <h2 class="text-lg font-semibold text-white">
                    Informasi Instruktur
                </h2>
                <p class="mt-1 text-sm text-gray-300">
                    Masukkan data akun dengan benar.
                </p>
            </div>

            <form action="{{ route('admin.akun.instruktur.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6 p-6">

                @csrf

                {{-- Nama --}}
                <div>
                    <label for="nama"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           id="nama"
                           name="nama"
                           value="{{ old('nama') }}"
                           required
                           maxlength="255"
                           placeholder="Masukkan nama lengkap instruktur"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-amber-600 focus:ring-2 focus:ring-amber-100">

                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Email <span class="text-red-500">*</span>
                    </label>

                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           maxlength="255"
                           placeholder="contoh@email.com"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-amber-600 focus:ring-2 focus:ring-amber-100">

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kata Sandi --}}
                <div>
                    <label for="kata_sandi"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           id="kata_sandi"
                           name="kata_sandi"
                           required
                           minlength="8"
                           autocomplete="new-password"
                           placeholder="Minimal 8 karakter"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-amber-600 focus:ring-2 focus:ring-amber-100">

                    @error('kata_sandi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Kata Sandi --}}
                <div>
                    <label for="kata_sandi_confirmation"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           id="kata_sandi_confirmation"
                           name="kata_sandi_confirmation"
                           required
                           minlength="8"
                           autocomplete="new-password"
                           placeholder="Ulangi kata sandi"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-amber-600 focus:ring-2 focus:ring-amber-100">
                </div>

                {{-- Foto --}}
                <div>
                    <label for="foto"
                           class="mb-2 block text-sm font-semibold text-gray-700">
                        Foto Profil
                    </label>

                    <input type="file"
                           id="foto"
                           name="foto"
                           accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                           class="block w-full rounded-xl border border-gray-300 text-sm text-gray-600 file:mr-4 file:border-0 file:bg-amber-50 file:px-4 file:py-3 file:font-semibold file:text-amber-800 hover:file:bg-amber-100">

                    <p class="mt-2 text-xs text-gray-500">
                        Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </p>

                    @error('foto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Informasi Status --}}
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                    <p class="text-sm font-semibold text-amber-900">
                        Status Akun: Aktif
                    </p>
                    <p class="mt-1 text-sm text-amber-800">
                        Akun instruktur baru akan dibuat dalam keadaan aktif.
                    </p>
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.akun.index', ['tab' => 'instruktur']) }}"
                       class="inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-[#3C1412] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#170201] focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        Simpan Akun Instruktur
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection

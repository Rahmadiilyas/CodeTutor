@extends('layouts.master')

@section('title', 'Detail Akun')

@section('description', 'Detail informasi akun pengguna.')

@section('page_label', 'Kelola Akun')

@section('page_heading', 'Detail Akun')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">
                Kelola Akun / Detail Akun
            </p>

            <h2 class="mt-1 text-2xl font-bold text-gray-900">
                Detail Akun {{ $akun->peran === 'instruktur' ? 'Instruktur' : 'Pelajar' }}
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi lengkap akun pengguna yang dipilih.
            </p>
        </div>

        <a
            href="{{ route('admin.akun.index', ['tab' => $akun->peran]) }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"
                />
            </svg>

            Kembali
        </a>
    </div>

    {{-- Kartu Detail Akun --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        {{-- Bagian Header Kartu --}}
        <div class="bg-gradient-to-r from-[#3C1412] to-[#170201] px-6 py-8 sm:px-8">
            <div class="flex flex-col items-center gap-5 sm:flex-row">

                {{-- Foto Profil --}}
                <div class="flex-shrink-0">
                    @if ($akun->foto)
                        <img
                            src="{{ asset('storage/' . $akun->foto) }}"
                            alt="Foto {{ $akun->nama }}"
                            class="h-24 w-24 rounded-2xl border-4 border-white/20 object-cover shadow-lg"
                        >
                    @else
                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl border-4 border-white/20 bg-white/10 text-3xl font-bold text-white shadow-lg">
                            {{ strtoupper(substr($akun->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Nama dan Peran --}}
                <div class="text-center sm:text-left">
                    <h3 class="text-2xl font-bold text-white">
                        {{ $akun->nama }}
                    </h3>

                    <p class="mt-1 text-sm text-white/70">
                        {{ $akun->email }}
                    </p>

                    <div class="mt-3 flex flex-wrap items-center justify-center gap-2 sm:justify-start">
                        <span class="inline-flex items-center rounded-full bg-[#AC6F2C]/20 px-3 py-1 text-xs font-semibold capitalize text-[#F5D6A5]">
                            {{ $akun->peran }}
                        </span>

                        @if ($akun->status)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-500/20 px-3 py-1 text-xs font-semibold text-green-200">
                                <span class="h-2 w-2 rounded-full bg-green-300"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/20 px-3 py-1 text-xs font-semibold text-red-200">
                                <span class="h-2 w-2 rounded-full bg-red-300"></span>
                                Tidak Aktif
                            </span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Informasi Akun --}}
        <div class="p-6 sm:p-8">
            <div class="mb-6">
                <h4 class="text-lg font-bold text-gray-900">
                    Informasi Pengguna
                </h4>

                <p class="mt-1 text-sm text-gray-500">
                    Rincian informasi akun yang tersimpan dalam sistem.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- ID Akun --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">
                        ID Akun
                    </p>

                    <p class="mt-2 font-semibold text-gray-900">
                        #{{ $akun->id }}
                    </p>
                </div>

                {{-- Nama --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">
                        Nama Lengkap
                    </p>

                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $akun->nama }}
                    </p>
                </div>

                {{-- Email --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">
                        Alamat Email
                    </p>

                    <p class="mt-2 break-words font-semibold text-gray-900">
                        {{ $akun->email }}
                    </p>
                </div>

                {{-- Peran --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">
                        Peran Pengguna
                    </p>

                    <p class="mt-2 font-semibold capitalize text-gray-900">
                        {{ $akun->peran }}
                    </p>
                </div>

                {{-- Status --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">
                        Status Akun
                    </p>

                    <div class="mt-2">
                        @if ($akun->status)
                            <span class="inline-flex items-center gap-2 rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                                <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-3 py-1 text-sm font-semibold text-red-700">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                Tidak Aktif
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Tanggal Dibuat --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-sm text-gray-500">
                        Tanggal Pembuatan Akun
                    </p>

                    <p class="mt-2 font-semibold text-gray-900">
                        {{ $akun->created_at
                            ? $akun->created_at->format('d/m/Y H:i')
                            : '-' }}
                    </p>
                </div>

            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                <a
                    href="{{ route('admin.akun.index', ['tab' => $akun->peran]) }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Kembali ke Kelola Akun
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
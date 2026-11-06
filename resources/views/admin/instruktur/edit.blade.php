@extends('layouts.master')

@section('title', 'Edit Instruktur — CodeTutor')

@section('page_label', 'Kelola Instruktur')

@section('page_heading', 'Edit Instruktur')

@section('content')

<div class="mx-auto max-w-4xl">

    <div
        class="overflow-hidden rounded-[28px]
        border border-maroon-900/8
        bg-white shadow-soft"
    >

        <div
            class="bg-gradient-to-br from-maroon-950
            via-maroon-900 to-maroon-700
            p-6 text-white sm:p-8"
        >

            <p
                class="text-[10px] font-extrabold uppercase
                tracking-[.17em] text-gold-300"
            >
                Perbarui Data
            </p>

            <h1
                class="mt-2 font-display text-2xl
                font-extrabold"
            >
                Edit Akun Instruktur
            </h1>

        </div>


        <form
            action="{{ route('admin.instruktur.update', $instruktur) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 p-6 sm:p-8"
        >

            @csrf
            @method('PUT')


            {{-- PROFIL --}}
            <div
                class="flex items-center gap-4
                rounded-2xl bg-warm-50 p-4"
            >

                @if($instruktur->foto)

                    <img
                        src="{{ asset('storage/' . $instruktur->foto) }}"
                        alt="{{ $instruktur->nama }}"
                        class="h-16 w-16 rounded-2xl object-cover"
                    >

                @else

                    <div
                        class="grid h-16 w-16 place-items-center
                        rounded-2xl bg-maroon-900
                        text-xl font-extrabold text-gold-400"
                    >
                        {{ strtoupper(substr($instruktur->nama, 0, 1)) }}
                    </div>

                @endif

                <div>

                    <p class="font-display font-extrabold text-maroon-950">
                        {{ $instruktur->nama }}
                    </p>

                    <p class="text-xs text-slate-400">
                        {{ $instruktur->email }}
                    </p>

                </div>

            </div>


            {{-- NAMA --}}
            <div>

                <label class="mb-2 block text-sm font-bold text-maroon-950">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $instruktur->nama) }}"
                    class="w-full rounded-xl border border-slate-200
                    bg-warm-50 px-4 py-3 text-sm outline-none
                    focus:border-maroon-500"
                >

                @error('nama')
                    <p class="mt-1 text-xs text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- EMAIL --}}
            <div>

                <label class="mb-2 block text-sm font-bold text-maroon-950">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $instruktur->email) }}"
                    class="w-full rounded-xl border border-slate-200
                    bg-warm-50 px-4 py-3 text-sm outline-none
                    focus:border-maroon-500"
                >

                @error('email')
                    <p class="mt-1 text-xs text-rose-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- PASSWORD --}}
            <div class="grid gap-6 sm:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm font-bold text-maroon-950">
                        Kata Sandi Baru
                    </label>

                    <input
                        type="password"
                        name="kata_sandi"
                        placeholder="Kosongkan jika tidak diubah"
                        class="w-full rounded-xl border border-slate-200
                        bg-warm-50 px-4 py-3 text-sm outline-none
                        focus:border-maroon-500"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-bold text-maroon-950">
                        Konfirmasi Kata Sandi
                    </label>

                    <input
                        type="password"
                        name="kata_sandi_confirmation"
                        placeholder="Ulangi kata sandi"
                        class="w-full rounded-xl border border-slate-200
                        bg-warm-50 px-4 py-3 text-sm outline-none
                        focus:border-maroon-500"
                    >

                </div>

            </div>


            {{-- FOTO --}}
            <div>

                <label class="mb-2 block text-sm font-bold text-maroon-950">
                    Ganti Foto
                </label>

                <input
                    type="file"
                    name="foto"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-xl border
                    border-slate-200 bg-warm-50 text-sm"
                >

            </div>


            <div
                class="flex justify-end gap-3 border-t
                border-slate-100 pt-6"
            >

                <a
                    href="{{ route('admin.instruktur.index') }}"
                    class="rounded-xl border border-slate-200
                    px-5 py-3 text-sm font-bold text-slate-600"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-maroon-800
                    px-5 py-3 text-sm font-extrabold
                    text-white hover:bg-maroon-700"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
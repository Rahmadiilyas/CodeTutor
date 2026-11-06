@extends('layouts.master')

@section('title', 'Kelola Instruktur — CodeTutor')

@section('description', 'Kelola akun instruktur CodeTutor.')

@section('page_label', 'Kelola Instruktur')

@section('page_heading', 'Akun Instruktur')

@section('content')

<div class="mx-auto max-w-7xl space-y-6 pb-10">

    {{-- HEADER --}}
    <section
        class="relative overflow-hidden rounded-[30px]
        bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700
        p-6 text-white shadow-card sm:p-8"
    >

        <div
            class="absolute -right-24 -top-24 h-72 w-72
            rounded-full border-[35px] border-gold-400/10">
        </div>

        <div
            class="absolute -bottom-32 right-20 h-64 w-64
            rounded-full bg-gold-400/10 blur-3xl">
        </div>

        <div class="relative flex flex-col gap-6
                    lg:flex-row lg:items-center lg:justify-between">

            <div>

                <span
                    class="inline-flex items-center gap-2
                    rounded-full border border-gold-400/20
                    bg-white/5 px-3 py-1.5
                    text-[10px] font-extrabold uppercase
                    tracking-[.15em] text-gold-300"
                >
                    <span
                        class="h-1.5 w-1.5 rounded-full bg-gold-400">
                    </span>

                    Manajemen Pengguna
                </span>

                <h1
                    class="mt-5 font-display text-3xl
                    font-extrabold tracking-tight sm:text-4xl"
                >
                    Kelola Akun Instruktur
                </h1>

                <p
                    class="mt-4 max-w-2xl text-sm
                    leading-7 text-white/60"
                >
                    Kelola akun instruktur mulai dari menambahkan,
                    melihat, memperbarui, hingga mengatur status akun.
                </p>

            </div>

            <div>

                <a
                    href="{{ route('admin.instruktur.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl
                    bg-gold-400 px-5 py-3 text-sm font-extrabold
                    text-maroon-950 shadow-gold transition
                    hover:-translate-y-0.5 hover:bg-gold-300"
                >

                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                    >
                        <path d="M12 5v14"/>
                        <path d="M5 12h14"/>
                    </svg>

                    Tambah Instruktur

                </a>

            </div>

        </div>

    </section>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div
            class="rounded-2xl border border-emerald-200
            bg-emerald-50 p-4 text-sm font-semibold
            text-emerald-700"
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- STAT --}}
    <section class="grid gap-4 sm:grid-cols-3">

        <div
            class="rounded-2xl border border-maroon-900/8
            bg-white p-5 shadow-soft"
        >

            <p class="text-xs text-slate-400">
                Total Instruktur
            </p>

            <p
                class="mt-2 font-display text-3xl
                font-extrabold text-maroon-950"
            >
                {{ $totalInstruktur }}
            </p>

        </div>


        <div
            class="rounded-2xl border border-maroon-900/8
            bg-white p-5 shadow-soft"
        >

            <p class="text-xs text-slate-400">
                Instruktur Aktif
            </p>

            <p
                class="mt-2 font-display text-3xl
                font-extrabold text-emerald-600"
            >
                {{ $instrukturAktif }}
            </p>

        </div>


        <div
            class="rounded-2xl border border-maroon-900/8
            bg-white p-5 shadow-soft"
        >

            <p class="text-xs text-slate-400">
                Instruktur Nonaktif
            </p>

            <p
                class="mt-2 font-display text-3xl
                font-extrabold text-rose-600"
            >
                {{ $instrukturNonaktif }}
            </p>

        </div>

    </section>


    {{-- TABLE --}}
    <section
        class="overflow-hidden rounded-2xl
        border border-maroon-900/8 bg-white shadow-soft"
    >

        <div
            class="flex flex-col gap-4 border-b
            border-slate-100 p-5 lg:flex-row
            lg:items-center lg:justify-between"
        >

            <div>

                <p
                    class="text-[10px] font-extrabold
                    uppercase tracking-[.17em]
                    text-maroon-700"
                >
                    Data Instruktur
                </p>

                <h2
                    class="mt-1 font-display text-xl
                    font-extrabold text-maroon-950"
                >
                    Daftar Akun
                </h2>

            </div>


            <form
                action="{{ route('admin.instruktur.index') }}"
                method="GET"
                class="flex flex-col gap-2 sm:flex-row"
            >

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama / email..."
                    class="rounded-xl border border-slate-200
                    bg-warm-50 px-4 py-2.5 text-sm
                    outline-none focus:border-maroon-500"
                >

                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="rounded-xl border border-slate-200
                    bg-warm-50 px-4 py-2.5 text-sm"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="1"
                        @selected(request('status') === '1')
                    >
                        Aktif
                    </option>

                    <option
                        value="0"
                        @selected(request('status') === '0')
                    >
                        Nonaktif
                    </option>

                </select>

                <button
                    type="submit"
                    class="rounded-xl bg-maroon-800
                    px-4 py-2.5 text-sm font-bold
                    text-white hover:bg-maroon-700"
                >
                    Cari
                </button>

            </form>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-warm-50">

                    <tr>

                        <th
                            class="px-6 py-4 text-left text-[10px]
                            font-extrabold uppercase tracking-wider
                            text-slate-400"
                        >
                            Instruktur
                        </th>

                        <th
                            class="px-6 py-4 text-left text-[10px]
                            font-extrabold uppercase tracking-wider
                            text-slate-400"
                        >
                            Email
                        </th>

                        <th
                            class="px-6 py-4 text-left text-[10px]
                            font-extrabold uppercase tracking-wider
                            text-slate-400"
                        >
                            Status
                        </th>

                        <th
                            class="px-6 py-4 text-right text-[10px]
                            font-extrabold uppercase tracking-wider
                            text-slate-400"
                        >
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($instrukturs as $instruktur)

                        <tr class="hover:bg-warm-50/60">

                            {{-- PROFIL --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    @if($instruktur->foto)

                                        <img
                                            src="{{ asset('storage/' . $instruktur->foto) }}"
                                            alt="{{ $instruktur->nama }}"
                                            class="h-11 w-11 rounded-xl
                                            object-cover"
                                        >

                                    @else

                                        <div
                                            class="grid h-11 w-11 place-items-center
                                            rounded-xl bg-maroon-900
                                            font-extrabold text-gold-400"
                                        >
                                            {{ strtoupper(substr($instruktur->nama, 0, 1)) }}
                                        </div>

                                    @endif

                                    <div>

                                        <p
                                            class="text-sm font-extrabold
                                            text-maroon-950"
                                        >
                                            {{ $instruktur->nama }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            ID #{{ $instruktur->id }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- EMAIL --}}
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-600">
                                    {{ $instruktur->email }}
                                </span>

                            </td>


                            {{-- STATUS --}}
                            <td class="px-6 py-5">

                                @if($instruktur->status)

                                    <span
                                        class="inline-flex items-center gap-1.5
                                        rounded-full bg-emerald-50
                                        px-3 py-1 text-[10px]
                                        font-bold text-emerald-700"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                            bg-emerald-500">
                                        </span>

                                        Aktif
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5
                                        rounded-full bg-rose-50 px-3 py-1
                                        text-[10px] font-bold text-rose-700"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full
                                            bg-rose-500">
                                        </span>

                                        Nonaktif
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td class="px-6 py-5">

                                <div class="flex justify-end gap-2">

                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('admin.instruktur.show', $instruktur) }}"
                                        class="grid h-9 w-9 place-items-center
                                        rounded-lg bg-slate-100
                                        text-slate-600 hover:bg-maroon-900
                                        hover:text-gold-400"
                                        title="Detail"
                                    >
                                        👁
                                    </a>


                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.instruktur.edit', $instruktur) }}"
                                        class="grid h-9 w-9 place-items-center
                                        rounded-lg bg-amber-50
                                        text-amber-700 hover:bg-amber-100"
                                        title="Edit"
                                    >
                                        ✎
                                    </a>


                                    {{-- AKTIF / NONAKTIF --}}
                                    @if($instruktur->status)

                                        <form
                                            action="{{ route('admin.instruktur.deactivate', $instruktur) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menonaktifkan akun ini?')"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="grid h-9 w-9 place-items-center
                                                rounded-lg bg-rose-50
                                                text-rose-600
                                                hover:bg-rose-100"
                                                title="Nonaktifkan"
                                            >
                                                ⛔
                                            </button>

                                        </form>

                                    @else

                                        <form
                                            action="{{ route('admin.instruktur.activate', $instruktur) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="grid h-9 w-9 place-items-center
                                                rounded-lg bg-emerald-50
                                                text-emerald-600
                                                hover:bg-emerald-100"
                                                title="Aktifkan"
                                            >
                                                ✓
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="px-6 py-14 text-center"
                            >

                                <div
                                    class="font-display font-extrabold
                                    text-maroon-950"
                                >
                                    Belum ada akun instruktur
                                </div>

                                <p
                                    class="mt-2 text-sm text-slate-400"
                                >
                                    Tambahkan instruktur untuk mulai
                                    mengelola akun.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div class="border-t border-slate-100 p-5">
            {{ $instrukturs->links() }}
        </div>

    </section>

</div>

@endsection
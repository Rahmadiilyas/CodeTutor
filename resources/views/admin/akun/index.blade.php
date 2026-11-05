@extends('layouts.master')

@section('title', 'Kelola Akun — CodeTutor')
@section('description', 'Kelola akun instruktur dan pelajar CodeTutor.')
@section('page_label', 'Kelola Akun')
@section('page_heading', 'Kelola Akun')

@section('content')
<div class="mx-auto max-w-7xl space-y-6 pb-10">

    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <section
        class="relative overflow-hidden rounded-[30px] bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 p-6 text-white shadow-card sm:p-8"
    >
        <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full border-[35px] border-gold-400/10"></div>
        <div class="absolute -bottom-32 right-20 h-64 w-64 rounded-full bg-gold-400/10 blur-3xl"></div>

        <div class="relative">
            <span
                class="inline-flex items-center gap-2 rounded-full border border-gold-400/20 bg-white/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.15em] text-gold-300"
            >
                <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                Manajemen Pengguna
            </span>

            <h1 class="mt-5 font-display text-3xl font-extrabold tracking-tight sm:text-4xl">
                Kelola Akun
            </h1>

            <p class="mt-4 max-w-2xl text-sm leading-7 text-white/60">
                Kelola akun instruktur dan pelajar sesuai hak akses administrator.
            </p>
        </div>
    </section>

    {{-- =====================================================
         SUCCESS
    ====================================================== --}}
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
            <p class="text-sm font-bold text-emerald-700">
                {{ session('success') }}
            </p>
        </div>
    @endif

    {{-- =====================================================
         VALIDATION ERROR
    ====================================================== --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4">
            @foreach ($errors->all() as $error)
                <p class="text-sm text-rose-700">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- =====================================================
         STATISTIK
    ====================================================== --}}
    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft">
            <p class="text-xs text-slate-400">Total Instruktur</p>
            <p class="mt-2 font-display text-3xl font-extrabold text-maroon-950">
                {{ $totalInstruktur }}
            </p>
        </div>

        <div class="rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft">
            <p class="text-xs text-slate-400">Instruktur Aktif</p>
            <p class="mt-2 font-display text-3xl font-extrabold text-emerald-600">
                {{ $instrukturAktif }}
            </p>
        </div>

        <div class="rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft">
            <p class="text-xs text-slate-400">Total Pelajar</p>
            <p class="mt-2 font-display text-3xl font-extrabold text-maroon-950">
                {{ $totalPelajar }}
            </p>
        </div>

        <div class="rounded-2xl border border-maroon-900/8 bg-white p-5 shadow-soft">
            <p class="text-xs text-slate-400">Pelajar Aktif</p>
            <p class="mt-2 font-display text-3xl font-extrabold text-emerald-600">
                {{ $pelajarAktif }}
            </p>
        </div>
    </section>

    {{-- =====================================================
         TAB
    ====================================================== --}}
    <div class="flex gap-2 rounded-2xl border border-maroon-900/8 bg-white p-2 shadow-soft">
        <a
            href="{{ route('admin.akun.index', ['tab' => 'instruktur']) }}"
            class="flex-1 rounded-xl px-5 py-3 text-center text-sm font-extrabold transition
                {{ $tab === 'instruktur' ? 'bg-maroon-900 text-gold-400' : 'text-slate-500 hover:bg-warm-50' }}"
        >
            Akun Instruktur
        </a>

        <a
            href="{{ route('admin.akun.index', ['tab' => 'pelajar']) }}"
            class="flex-1 rounded-xl px-5 py-3 text-center text-sm font-extrabold transition
                {{ $tab === 'pelajar' ? 'bg-maroon-900 text-gold-400' : 'text-slate-500 hover:bg-warm-50' }}"
        >
            Akun Pelajar
        </a>
    </div>

    {{-- =====================================================
         INSTRUKTUR
    ====================================================== --}}
    @if ($tab === 'instruktur')
        <section class="overflow-hidden rounded-2xl border border-maroon-900/8 bg-white shadow-soft">
            {{-- HEADER TABLE --}}
            <div class="flex flex-col gap-4 border-b border-slate-100 p-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-[.17em] text-maroon-700">
                        Data Instruktur
                    </p>
                    <h2 class="mt-1 font-display text-xl font-extrabold text-maroon-950">
                        Akun Instruktur
                    </h2>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">
                    <form action="{{ route('admin.akun.index') }}" method="GET">
                        <input type="hidden" name="tab" value="instruktur">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama / email..."
                            class="w-full rounded-xl border border-slate-200 bg-warm-50 px-4 py-2.5 text-sm outline-none focus:border-maroon-500 sm:w-64"
                        >
                    </form>

                    <a
                        href="{{ route('admin.akun.instruktur.create') }}"
                        class="rounded-xl bg-maroon-800 px-4 py-2.5 text-center text-sm font-extrabold text-white hover:bg-maroon-700"
                    >
                        + Tambah Instruktur
                    </a>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-warm-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                Instruktur
                            </th>
                            <th class="px-6 py-4 text-left text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                Email
                            </th>
                            <th class="px-6 py-4 text-left text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                Status
                            </th>
                            <th class="px-6 py-4 text-right text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($instrukturs as $akun)
                            <tr class="transition hover:bg-warm-50/60">
                                {{-- PROFIL --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        @if ($akun->foto)
                                            <img
                                                src="{{ asset('storage/' . $akun->foto) }}"
                                                alt="{{ $akun->nama }}"
                                                class="h-11 w-11 rounded-xl object-cover"
                                            >
                                        @else
                                            <div class="grid h-11 w-11 place-items-center rounded-xl bg-maroon-900 font-extrabold text-gold-400">
                                                {{ strtoupper(substr($akun->nama, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <p class="text-sm font-extrabold text-maroon-950">
                                                {{ $akun->nama }}
                                            </p>
                                            <p class="text-xs text-slate-400">Instruktur</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- EMAIL --}}
                                <td class="px-6 py-5">
                                    <span class="text-sm text-slate-600">{{ $akun->email }}</span>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-5">
                                    @if ($akun->status)
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="rounded-full bg-rose-50 px-3 py-1 text-[10px] font-bold text-rose-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route('admin.akun.show', $akun) }}"
                                            class="grid h-9 w-9 place-items-center rounded-lg bg-slate-100 text-slate-600 hover:bg-maroon-900 hover:text-gold-400"
                                            title="Lihat"
                                        >
                                            👁
                                        </a>

                                        <a
                                            href="{{ route('admin.akun.instruktur.edit', $akun) }}"
                                            class="grid h-9 w-9 place-items-center rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100"
                                            title="Edit"
                                        >
                                            ✎
                                        </a>

                                        <form
                                            action="{{ route('admin.akun.instruktur.destroy', $akun) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus akun instruktur ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="grid h-9 w-9 place-items-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100"
                                                title="Hapus"
                                            >
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">
                                    <p class="font-display font-extrabold text-maroon-950">
                                        Belum ada akun instruktur.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endif

    {{-- =====================================================
         PELAJAR
    ====================================================== --}}
    @if ($tab === 'pelajar')
        <section class="overflow-hidden rounded-2xl border border-maroon-900/8 bg-white shadow-soft">
            {{-- HEADER TABLE --}}
            <div class="flex flex-col gap-4 border-b border-slate-100 p-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-[.17em] text-maroon-700">
                        Data Pelajar
                    </p>
                    <h2 class="mt-1 font-display text-xl font-extrabold text-maroon-950">
                        Akun Pelajar
                    </h2>
                </div>

                <form action="{{ route('admin.akun.index') }}" method="GET">
                    <input type="hidden" name="tab" value="pelajar">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama / email..."
                        class="w-full rounded-xl border border-slate-200 bg-warm-50 px-4 py-2.5 text-sm outline-none focus:border-maroon-500 sm:w-64"
                    >
                </form>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-warm-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                Pelajar
                            </th>
                            <th class="px-6 py-4 text-left text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                Email
                            </th>
                            <th class="px-6 py-4 text-left text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                Status
                            </th>
                            <th class="px-6 py-4 text-right text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pelajars as $akun)
                            <tr class="transition hover:bg-warm-50/60">
                                {{-- PROFIL --}}
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        @if ($akun->foto)
                                            <img
                                                src="{{ asset('storage/' . $akun->foto) }}"
                                                alt="{{ $akun->nama }}"
                                                class="h-11 w-11 rounded-xl object-cover"
                                            >
                                        @else
                                            <div class="grid h-11 w-11 place-items-center rounded-xl bg-maroon-900 font-extrabold text-gold-400">
                                                {{ strtoupper(substr($akun->nama, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div>
                                            <p class="text-sm font-extrabold text-maroon-950">
                                                {{ $akun->nama }}
                                            </p>
                                            <p class="text-xs text-slate-400">Pelajar</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- EMAIL --}}
                                <td class="px-6 py-5">
                                    <span class="text-sm text-slate-600">{{ $akun->email }}</span>
                                </td>

                                {{-- STATUS --}}
                                <td class="px-6 py-5">
                                    @if ($akun->status)
                                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="rounded-full bg-rose-50 px-3 py-1 text-[10px] font-bold text-rose-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route('admin.akun.show', $akun) }}"
                                            class="grid h-9 w-9 place-items-center rounded-lg bg-slate-100 text-slate-600 hover:bg-maroon-900 hover:text-gold-400"
                                            title="Lihat"
                                        >
                                            👁
                                        </a>

                                        <form
                                            action="{{ route('admin.akun.pelajar.status', $akun) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ $akun->status ? 'Nonaktifkan' : 'Aktifkan' }} akun pelajar ini?')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="grid h-9 min-w-9 place-items-center rounded-lg px-2 text-xs font-bold transition
                                                    {{ $akun->status
                                                        ? 'bg-amber-50 text-amber-700 hover:bg-amber-100'
                                                        : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}"
                                                title="{{ $akun->status ? 'Nonaktifkan akun' : 'Aktifkan akun' }}"
                                                aria-label="{{ $akun->status ? 'Nonaktifkan akun' : 'Aktifkan akun' }}"
                                            >
                                                {{ $akun->status ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <form
                                            action="{{ route('admin.akun.pelajar.destroy', $akun) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus akun pelajar ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="grid h-9 w-9 place-items-center rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100"
                                                title="Hapus"
                                            >
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-14 text-center">
                                    <p class="font-display font-extrabold text-maroon-950">
                                        Belum ada akun pelajar.
                                    </p>
                                    <p class="mt-2 text-sm text-slate-400">
                                        Akun pelajar berasal dari proses registrasi.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @endif
</div>
@endsection
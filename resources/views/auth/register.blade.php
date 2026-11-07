<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelajar CodeTutor</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <meta name="description" content="Buat akun Pelajar CodeTutor dan mulai belajar pemrograman.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {950:'#24040D',900:'#330711',800:'#470B18',700:'#5E1022',600:'#74172B',500:'#8C223A'},
                        gold: {300:'#F3D98E',400:'#E7C568',500:'#D6AD45',600:'#B98D2E'},
                        warm: {50:'#FFFCF8',100:'#FBF5EC',200:'#F4EBDD'}
                    },
                    fontFamily: {
                        sans:['DM Sans','sans-serif'],
                        display:['Plus Jakarta Sans','sans-serif']
                    },
                    boxShadow: { maroon:'0 24px 65px rgba(51, 7, 17, .20)' }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 font-sans text-slate-800 antialiased">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6">
        <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image:linear-gradient(rgba(231,197,104,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(231,197,104,.06) 1px,transparent 1px);background-size:48px 48px"></div>
        <div class="pointer-events-none absolute -left-32 -top-28 h-96 w-96 rounded-full border border-gold-400/10"></div>
        <div class="pointer-events-none absolute -bottom-40 -right-28 h-[30rem] w-[30rem] rounded-full border border-gold-400/10"></div>

        <section class="relative z-10 w-full max-w-lg">
            <div class="mb-6 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-xl border border-gold-400/25 bg-white/[.06] text-lg font-extrabold text-gold-400">&lt;/&gt;</span>
                    <span class="font-display text-xl font-extrabold tracking-tight text-white">MALAQBI <span class="text-gold-400">KITA</span></span>
                </a>
                <p class="mt-6 text-xs font-extrabold uppercase tracking-[.2em] text-gold-400">Mulai perjalanan belajarmu</p>
                <h1 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Buat akun Pelajar</h1>
                <p class="mx-auto mt-3 max-w-sm text-sm leading-6 text-white/60">Daftar secara gratis untuk mengakses materi, latihan, dan evaluasi pemrograman.</p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white p-6 shadow-maroon sm:p-8">
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                        <p class="font-bold">Registrasi belum berhasil</p>
                        <ul class="mt-2 list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="nama" class="mb-2 block text-xs font-bold text-maroon-950">Nama lengkap</label>
                        <input id="nama" name="nama" type="text" value="{{ old('nama') }}" maxlength="255" required autocomplete="name" autofocus placeholder="Masukkan nama lengkap"
                            class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm outline-none transition placeholder:text-slate-300 focus:border-maroon-600 focus:ring-4 focus:ring-maroon-600/10">
                        @error('nama')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-xs font-bold text-maroon-950">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" required autocomplete="email" placeholder="nama@email.com"
                            class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm outline-none transition placeholder:text-slate-300 focus:border-maroon-600 focus:ring-4 focus:ring-maroon-600/10">
                        @error('email')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="kata_sandi" class="mb-2 block text-xs font-bold text-maroon-950">Kata sandi</label>
                        <input id="kata_sandi" name="kata_sandi" type="password" minlength="8" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                            class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm outline-none transition placeholder:text-slate-300 focus:border-maroon-600 focus:ring-4 focus:ring-maroon-600/10">
                        @error('kata_sandi')<p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="kata_sandi_confirmation" class="mb-2 block text-xs font-bold text-maroon-950">Konfirmasi kata sandi</label>
                        <input id="kata_sandi_confirmation" name="kata_sandi_confirmation" type="password" minlength="8" required autocomplete="new-password" placeholder="Ulangi kata sandi"
                            class="h-12 w-full rounded-xl border border-slate-200 bg-white px-4 text-sm outline-none transition placeholder:text-slate-300 focus:border-maroon-600 focus:ring-4 focus:ring-maroon-600/10">
                    </div>

                    <div class="rounded-xl border border-gold-400/30 bg-warm-50 p-3 text-xs leading-5 text-slate-600">
                        Pendaftaran ini membuat akun dengan peran <strong class="text-maroon-800">Pelajar</strong>. Gunakan email dan kata sandi yang sama saat masuk nanti.
                    </div>

                    <button type="submit" class="inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-maroon-800 to-maroon-700 text-sm font-extrabold text-white shadow-md transition hover:-translate-y-0.5 hover:from-maroon-700 hover:to-maroon-600">
                        Buat akun
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </button>
                </form>

                <p class="mt-6 text-center text-xs text-slate-500">Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-extrabold text-maroon-700 transition hover:text-gold-700">Masuk sekarang</a>
                </p>
            </div>
            <p class="mt-4 text-center text-[10px] text-white/35">© {{ date('Y') }} CodeTutor. All rights reserved.</p>
        </section>
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi CodeTutor</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            maroon: { 950: '#24040D', 900: '#330711', 800: '#470B18', 700: '#5E1022', 600: '#74172B' },
            gold: { 400: '#E7C568', 500: '#D6AD45' },
            warm: { 50: '#FFFCF8', 100: '#FBF5EC' }
        }, fontFamily: { sans: ['DM Sans', 'sans-serif'], display: ['Plus Jakarta Sans', 'sans-serif'] } } } };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 font-sans text-slate-800">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-md rounded-3xl border border-white/10 bg-white p-7 shadow-2xl sm:p-9">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-maroon-700 hover:text-maroon-900">← Kembali ke login</a>
            <div class="mt-7 inline-flex rounded-full bg-maroon-900/5 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[.15em] text-maroon-700">Pemulihan akun</div>
            <h1 class="mt-3 font-display text-2xl font-extrabold tracking-tight text-maroon-950">Lupa kata sandi?</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">Masukkan email yang terhubung dengan akun CodeTutor. Kami akan mengirimkan tautan untuk membuat kata sandi baru.</p>

            @if (session('status'))
                <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-700">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mt-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                    @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-xs font-bold text-maroon-950">Alamat email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="nama@email.com" class="h-12 w-full rounded-xl border border-slate-200 px-4 text-sm outline-none transition placeholder:text-slate-300 focus:border-maroon-600 focus:ring-4 focus:ring-maroon-600/10">
                </div>
                <button type="submit" class="h-12 w-full rounded-xl bg-gradient-to-r from-maroon-800 to-maroon-700 text-sm font-extrabold text-white shadow-lg transition hover:-translate-y-0.5 hover:from-maroon-700 hover:to-maroon-600">Kirim tautan reset</button>
            </form>
            <p class="mt-6 text-center text-xs text-slate-400">© {{ date('Y') }} CodeTutor.</p>
        </section>
    </main>
</body>
</html>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP CodeTutor</title>
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }

        h1, h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#24040D] via-[#330711] to-[#74172B] flex items-center justify-center px-4 py-8">

    <main class="w-full max-w-md">
        <div class="mb-7 text-center">
            <div class="mx-auto mb-4 grid h-14 w-14 place-items-center rounded-2xl border border-amber-300/30 bg-white/10 text-2xl font-extrabold text-amber-300">
                &lt;/&gt;
            </div>

            <h1 class="text-3xl font-extrabold text-white">
                Verifikasi Email
            </h1>

            <p class="mt-3 text-sm leading-6 text-white/70">
                Masukkan kode OTP 6 digit yang telah kami kirim ke email kamu untuk menyelesaikan registrasi.
            </p>
        </div>

        <section class="rounded-3xl bg-white p-6 shadow-2xl sm:p-8">

            @if (session('success'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('otp.verify') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="otp" class="mb-2 block text-sm font-bold text-[#330711]">
                        Kode OTP
                    </label>

                    <input
                        id="otp"
                        name="otp"
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        maxlength="6"
                        minlength="6"
                        autocomplete="one-time-code"
                        required
                        autofocus
                        placeholder="000000"
                        class="h-14 w-full rounded-xl border border-slate-200 text-center text-2xl font-extrabold tracking-[0.5em] outline-none transition focus:border-[#74172B] focus:ring-4 focus:ring-[#74172B]/10"
                    >

                    <p class="mt-2 text-xs text-slate-500">
                        Kode berlaku selama 5 menit.
                    </p>
                </div>

                <button
                    type="submit"
                    class="flex h-12 w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#470B18] to-[#74172B] text-sm font-extrabold text-white transition hover:opacity-90"
                >
                    Verifikasi dan Buat Akun
                </button>
            </form>

            <div class="mt-5 border-t border-slate-100 pt-5 text-center">
                <p class="mb-3 text-xs text-slate-500">
                    Belum menerima kode OTP?
                </p>

                <form action="{{ route('otp.resend') }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="text-sm font-extrabold text-[#74172B] hover:underline"
                    >
                        Kirim ulang kode OTP
                    </button>
                </form>
            </div>

            <p class="mt-5 text-center text-xs text-slate-500">
                Salah memasukkan email?
                <a href="{{ route('register') }}" class="font-bold text-[#74172B] hover:underline">
                    Daftar kembali
                </a>
            </p>
        </section>

        <p class="mt-5 text-center text-xs text-white/40">
            &copy; {{ date('Y') }} CodeTutor
        </p>
    </main>

</body>
</html>

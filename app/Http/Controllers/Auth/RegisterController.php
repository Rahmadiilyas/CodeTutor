<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman registrasi pelajar.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi dan mengirim OTP ke email.
     * Akun belum disimpan ke database sebelum OTP terverifikasi.
     */
    public function register(Request $request)
    {
        // Normalisasi nama dan email.
        $namaInput = $request->input('nama');
        $emailInput = $request->input('email');

        $request->merge([
            'nama' => is_string($namaInput)
                ? trim($namaInput)
                : $namaInput,

            'email' => is_string($emailInput)
                ? strtolower(trim($emailInput))
                : $emailInput,
        ]);

        // Validasi data registrasi.
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'nama'),
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],

            'kata_sandi' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.unique' => 'Nama ini sudah digunakan. Silakan gunakan nama lain.',
            'nama.max' => 'Nama maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'email.max' => 'Email maksimal 255 karakter.',

            'kata_sandi.required' => 'Kata sandi wajib diisi.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak sama.',
        ]);

        $nama = $validated['nama'];
        $email = $validated['email'];

        // Buat OTP enam digit.
        $otp = (string) random_int(100000, 999999);

        // Simpan sementara di session, bukan database.
        session()->put('registrasi_pelajar', [
            'nama' => $nama,
            'email' => $email,

            // Password di-hash sebelum disimpan ke session.
            'kata_sandi' => Hash::make($validated['kata_sandi']),

            // OTP juga disimpan dalam bentuk hash.
            'otp_hash' => Hash::make($otp),

            // Masa berlaku OTP: 5 menit.
            'otp_expired_at' => now()->addMinutes(5)->timestamp,

            // Maksimal lima kali percobaan.
            'otp_attempts' => 0,
        ]);

        // Kirim OTP ke email pelajar.
        try {
            Mail::raw(
                "Halo {$nama},\n\n"
                . "Selamat datang di CodeTutor!\n\n"
                . "Kode OTP registrasi akun kamu adalah:\n\n"
                . "{$otp}\n\n"
                . "Kode ini berlaku selama 5 menit.\n"
                . "Jangan bagikan kode ini kepada siapa pun.\n\n"
                . "Jika kamu tidak melakukan registrasi, abaikan email ini.\n\n"
                . "Salam,\n"
                . "Tim CodeTutor",

                function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Kode OTP Registrasi CodeTutor');
                }
            );
        } catch (\Throwable $e) {

            // Hapus data sementara jika email gagal dikirim.
            session()->forget('registrasi_pelajar');

            report($e);

            return back()
                ->withInput($request->except([
                    'kata_sandi',
                    'kata_sandi_confirmation',
                ]))
                ->withErrors([
                    'email' => 'Kode OTP gagal dikirim. '
                        . 'Silakan periksa konfigurasi email aplikasi.',
                ]);
        }

        // Arahkan ke halaman verifikasi OTP.
        return redirect()
            ->route('otp.show')
            ->with(
                'success',
                'Kode OTP berhasil dikirim ke email kamu. '
                . 'Silakan periksa kotak masuk email.'
            );
    }

    /**
     * Menampilkan halaman verifikasi OTP.
     */
    public function showOtp()
    {
        $pending = session('registrasi_pelajar');

        if (!$pending) {
            return redirect()
                ->route('register')
                ->withErrors([
                    'email' => 'Sesi registrasi tidak ditemukan. '
                        . 'Silakan daftar kembali.',
                ]);
        }

        return view('auth.verify-otp');
    }

    /**
     * Memverifikasi OTP.
     * Akun pelajar dibuat hanya jika OTP benar.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus terdiri dari 6 digit.',
        ]);

        $pending = session('registrasi_pelajar');

        // Pastikan data registrasi masih tersedia.
        if (!$pending) {
            return redirect()
                ->route('register')
                ->withErrors([
                    'email' => 'Sesi registrasi sudah berakhir. '
                        . 'Silakan daftar kembali.',
                ]);
        }

        // Periksa masa berlaku OTP.
        // Data registrasi tidak dihapus agar pengguna masih bisa
        // meminta OTP baru melalui tombol kirim ulang.
        if (now()->timestamp >= $pending['otp_expired_at']) {
            return back()->withErrors([
                'otp' => 'Kode OTP sudah kedaluwarsa. '
                    . 'Silakan kirim ulang kode OTP.',
            ]);
        }

        // Periksa batas percobaan OTP.
        if ($pending['otp_attempts'] >= 5) {
            return back()->withErrors([
                'otp' => 'Batas percobaan OTP sudah tercapai. '
                    . 'Silakan kirim ulang kode OTP.',
            ]);
        }

        // Periksa apakah OTP benar.
        if (!Hash::check($request->otp, $pending['otp_hash'])) {

            $pending['otp_attempts']++;

            session()->put('registrasi_pelajar', $pending);

            if ($pending['otp_attempts'] >= 5) {
                return back()->withErrors([
                    'otp' => 'Kamu telah salah memasukkan OTP sebanyak 5 kali. '
                        . 'Silakan kirim ulang kode OTP.',
                ]);
            }

            $sisaPercobaan = 5 - $pending['otp_attempts'];

            return back()->withErrors([
                'otp' => 'Kode OTP salah. '
                    . "Sisa percobaan: {$sisaPercobaan} kali.",
            ]);
        }

        // Periksa kembali nama dan email sebelum membuat akun.
        // Ini mencegah duplikasi ketika data berubah selama
        // pengguna menunggu proses verifikasi.
        $namaSudahAda = User::where('nama', $pending['nama'])
            ->exists();

        $emailSudahAda = User::where('email', $pending['email'])
            ->exists();

        if ($namaSudahAda || $emailSudahAda) {
            session()->forget('registrasi_pelajar');

            $errors = [];

            if ($namaSudahAda) {
                $errors['nama'] = 'Nama ini sudah terdaftar. '
                    . 'Silakan gunakan nama lain.';
            }

            if ($emailSudahAda) {
                $errors['email'] = 'Email ini sudah terdaftar. '
                    . 'Silakan gunakan email lain.';
            }

            return redirect()
                ->route('register')
                ->withErrors($errors);
        }

        // Buat akun pelajar setelah OTP berhasil diverifikasi.
        try {
            DB::transaction(function () use ($pending) {

                $pelajar = User::create([
                    'nama' => $pending['nama'],
                    'email' => $pending['email'],

                    // Password sudah di-hash ketika disimpan
                    // ke session, sehingga tidak perlu di-hash lagi.
                    'kata_sandi' => $pending['kata_sandi'],

                    'peran' => 'pelajar',
                    'status' => true,
                    'foto' => null,
                ]);

                // Tandai email sebagai sudah terverifikasi.
                $pelajar->email_verified_at = now();
                $pelajar->save();

                // Catat aktivitas registrasi.
                LogAktivitas::create([
                    'id_user' => $pelajar->id,
                    'jenis_aktivitas' => 'Registrasi Pelajar',
                    'deskripsi' => 'Pelajar berhasil mendaftarkan '
                        . 'akun dan memverifikasi email menggunakan OTP.',
                    'entitas' => 'users',
                    'id_entitas' => $pelajar->id,
                    'waktu_aktivitas' => now(),
                ]);
            });

        } catch (\Throwable $e) {

            report($e);

            return back()->withErrors([
                'otp' => 'Akun belum berhasil dibuat. '
                    . 'Silakan coba kembali.',
            ]);
        }

        // Hapus seluruh data registrasi sementara.
        session()->forget('registrasi_pelajar');

        // Arahkan pelajar ke halaman login.
        return redirect()
            ->route('login')
            ->with(
                'success',
                'Verifikasi email berhasil! '
                . 'Akun pelajar berhasil dibuat. '
                . 'Silakan masuk menggunakan nama dan kata sandi.'
            );
    }

    /**
     * Mengirim ulang OTP.
     */
    public function resendOtp()
    {
        $pending = session('registrasi_pelajar');

        if (!$pending) {
            return redirect()
                ->route('register')
                ->withErrors([
                    'email' => 'Sesi registrasi sudah berakhir. '
                        . 'Silakan daftar kembali.',
                ]);
        }

        // Periksa apakah nama atau email sudah digunakan.
        if (
            User::where('nama', $pending['nama'])
                ->orWhere('email', $pending['email'])
                ->exists()
        ) {
            session()->forget('registrasi_pelajar');

            return redirect()
                ->route('register')
                ->withErrors([
                    'email' => 'Nama atau email sudah terdaftar. '
                        . 'Silakan periksa kembali data registrasi.',
                ]);
        }

        // Buat OTP baru.
        $otp = (string) random_int(100000, 999999);

        // Kirim OTP baru ke email.
        try {
            Mail::raw(
                "Halo {$pending['nama']},\n\n"
                . "Kode OTP registrasi CodeTutor yang baru adalah:\n\n"
                . "{$otp}\n\n"
                . "Kode ini berlaku selama 5 menit.\n"
                . "Jangan bagikan kode ini kepada siapa pun.\n\n"
                . "Salam,\n"
                . "Tim CodeTutor",

                function ($message) use ($pending) {
                    $message->to($pending['email'])
                        ->subject('Kode OTP Baru CodeTutor');
                }
            );

        } catch (\Throwable $e) {

            report($e);

            return back()->withErrors([
                'otp' => 'OTP gagal dikirim ulang. '
                    . 'Silakan coba beberapa saat lagi.',
            ]);
        }

        // Perbarui data OTP setelah email berhasil dikirim.
        $pending['otp_hash'] = Hash::make($otp);

        $pending['otp_expired_at'] = now()
            ->addMinutes(5)
            ->timestamp;

        $pending['otp_attempts'] = 0;

        session()->put('registrasi_pelajar', $pending);

        return back()->with(
            'success',
            'Kode OTP baru berhasil dikirim ke email kamu. '
            . 'Silakan periksa kotak masuk email.'
        );
    }
}

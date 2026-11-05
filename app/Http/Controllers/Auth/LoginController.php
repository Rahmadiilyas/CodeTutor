<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Throwable;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Memproses login menggunakan nama dan kata sandi.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama' => ['required', 'string'],
            'kata_sandi' => ['required'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // User::getAuthPassword() harus mengembalikan kolom kata_sandi.
        // Hanya akun aktif yang boleh login.
        $loginBerhasil = Auth::attempt([
            'nama' => $credentials['nama'],
            'password' => $credentials['kata_sandi'],
            'status' => true,
        ], $remember);

        if ($loginBerhasil) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Kegagalan mencatat log tidak boleh menggagalkan login.
            try {
                if ($user) {
                    LogAktivitas::create([
                        'id_user' => $user->id,
                        'jenis_aktivitas' => 'Login Berhasil',
                        'deskripsi' => 'Pengguna dengan peran '
                            . $user->peran
                            . ' berhasil login ke sistem.',
                        'entitas' => 'users',
                        'id_entitas' => $user->id,
                        'waktu_aktivitas' => now(),
                    ]);
                }
            } catch (Throwable $exception) {
                Log::warning('Pencatatan aktivitas login gagal.', [
                    'user_id' => $user?->id,
                    'exception' => class_basename($exception),
                ]);
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors([
                'nama' => 'Nama atau kata sandi salah.',
            ])
            ->withInput($request->only('nama'));
    }

    /** Menampilkan form permintaan tautan reset kata sandi. */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /** Mengirim tautan reset ke email yang terdaftar. */
    public function sendResetLinkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $status = Password::sendResetLink([
            'email' => $validated['email'],
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status',
                'Tautan untuk mengatur ulang kata sandi telah dikirim. Silakan periksa email kamu, termasuk folder spam.'
            );
        }

        if ($status === Password::RESET_THROTTLED) {
            return back()->withErrors([
                'email' => 'Permintaan reset terlalu sering. Silakan tunggu beberapa saat sebelum mencoba lagi.',
            ])->withInput($request->only('email'));
        }

        return back()->withErrors([
            'email' => 'Email tersebut belum terdaftar pada CodeTutor.',
        ])->withInput($request->only('email'));
    }

    /** Menampilkan form penetapan kata sandi baru dari tautan email. */
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /** Memvalidasi token dan menyimpan kata sandi baru ke kolom kata_sandi. */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'token.required' => 'Token reset tidak ditemukan. Silakan minta tautan reset yang baru.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
        ]);

        $status = Password::reset(
            $validated,
            function ($user, string $password) {
                // Aplikasi menggunakan kolom kata_sandi, bukan password.
                $user->forceFill([
                    'kata_sandi' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with(
                'success',
                'Kata sandi berhasil diubah. Silakan masuk menggunakan kata sandi baru.'
            );
        }

        $pesan = match ($status) {
            Password::INVALID_TOKEN => 'Tautan reset tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru.',
            Password::RESET_THROTTLED => 'Terlalu banyak percobaan. Silakan tunggu sebelum mencoba lagi.',
            Password::INVALID_USER => 'Email tidak ditemukan.',
            default => 'Kata sandi belum berhasil diubah. Silakan minta tautan reset yang baru.',
        };

        return back()->withErrors([
            'email' => $pesan,
        ])->withInput($request->only('email'));
    }

    /** Logout pengguna. */
    public function logout(Request $request)
    {
        // Simpan pengguna sebelum Auth::logout() mengakhiri autentikasi.
        $user = Auth::user();

        // Kegagalan mencatat log tidak boleh menghalangi logout.
        try {
            if ($user) {
                LogAktivitas::create([
                    'id_user' => $user->id,
                    'jenis_aktivitas' => 'Logout',
                    'deskripsi' => 'Pengguna dengan peran '
                        . $user->peran
                        . ' keluar dari sistem.',
                    'entitas' => 'users',
                    'id_entitas' => $user->id,
                    'waktu_aktivitas' => now(),
                ]);
            }
        } catch (Throwable $exception) {
            Log::warning('Pencatatan aktivitas logout gagal.', [
                'user_id' => $user?->id,
                'exception' => class_basename($exception),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

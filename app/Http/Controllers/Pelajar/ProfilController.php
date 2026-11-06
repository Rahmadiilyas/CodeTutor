<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfilController extends Controller
{
    /** Menampilkan profil akun Pelajar yang sedang login. */
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless($user && $user->peran === 'pelajar', 403, 'Halaman profil ini hanya untuk Pelajar.');

        return view('pelajar.profil.index', [
            'user' => $user,
            'editMode' => $request->boolean('edit'),
        ]);
    }

    /** Memperbarui nama, email, dan foto profil milik akun sendiri. */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user && $user->peran === 'pelajar', 403, 'Halaman profil ini hanya untuk Pelajar.');

        $request->merge([
            'nama' => trim((string) $request->input('nama', '')),
            'email' => trim((string) $request->input('email', '')),
        ]);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->getKey()),
            ],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoLama = (string) ($user->foto ?? '');

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];

        $fotoBaru = null;
        if ($request->hasFile('foto')) {
            $fotoBaru = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $fotoBaru;
        }

        $user->save();

        // Hapus foto lama hanya jika berada di disk public dan bukan path berbahaya.
        if (
            $fotoBaru !== null
            && $fotoLama !== ''
            && $fotoLama !== $fotoBaru
            && !str_contains($fotoLama, '..')
            && !str_starts_with($fotoLama, '/')
            && !str_contains($fotoLama, "\\")
            && str_starts_with($fotoLama, 'foto-profil/')
            && Storage::disk('public')->exists($fotoLama)
        ) {
            Storage::disk('public')->delete($fotoLama);
        }

        return redirect()
            ->route('pelajar.profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}

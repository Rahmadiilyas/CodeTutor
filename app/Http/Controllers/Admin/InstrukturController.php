<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InstrukturController extends Controller
{
    /**
     * Pastikan hanya Admin yang dapat mengakses
     * fitur pengelolaan akun instruktur.
     */
    private function onlyAdmin()
    {
        abort_unless(
            auth()->check() &&
            auth()->user()->peran === 'admin',
            403
        );
    }

    /**
     * Menampilkan daftar instruktur.
     */
    public function index(Request $request)
    {
        $this->onlyAdmin();

        $search = $request->search;
        $status = $request->status;

        $instrukturs = User::query()
            ->where('peran', 'instruktur')

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            })

            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalInstruktur = User::where('peran', 'instruktur')->count();

        $instrukturAktif = User::where('peran', 'instruktur')
            ->where('status', true)
            ->count();

        $instrukturNonaktif = User::where('peran', 'instruktur')
            ->where('status', false)
            ->count();

        return view('admin.instruktur.index', compact(
            'instrukturs',
            'totalInstruktur',
            'instrukturAktif',
            'instrukturNonaktif'
        ));
    }

    /**
     * Form tambah instruktur.
     */
    public function create()
    {
        $this->onlyAdmin();

        return view('admin.instruktur.create');
    }

    /**
     * Menyimpan akun instruktur baru.
     */
    public function store(Request $request)
    {
        $this->onlyAdmin();

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'kata_sandi' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'nama.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'kata_sandi.required' => 'Kata sandi wajib diisi.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',

            'foto.image' => 'File yang dipilih harus berupa gambar.',
            'foto.mimes' => 'Foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')
                ->store('foto/instruktur', 'public');
        }

        $instruktur = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'kata_sandi' => Hash::make($validated['kata_sandi']),
            'peran' => 'instruktur',
            'status' => true,
            'foto' => $foto,
        ]);

        // Simpan log aktivitas
        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => 'Tambah Instruktur',
            'deskripsi' => 'Admin menambahkan akun instruktur: ' . $instruktur->nama,
            'entitas' => 'users',
            'id_entitas' => $instruktur->id,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.instruktur.index')
            ->with('success', 'Akun instruktur berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail instruktur.
     */
    public function show(User $instruktur)
    {
        $this->onlyAdmin();

        abort_unless(
            $instruktur->peran === 'instruktur',
            404
        );

        return view(
            'admin.instruktur.show',
            compact('instruktur')
        );
    }

    /**
     * Form edit instruktur.
     */
    public function edit(User $instruktur)
    {
        $this->onlyAdmin();

        abort_unless(
            $instruktur->peran === 'instruktur',
            404
        );

        return view(
            'admin.instruktur.edit',
            compact('instruktur')
        );
    }

    /**
     * Memperbarui data instruktur.
     */
    public function update(Request $request, User $instruktur)
    {
        $this->onlyAdmin();

        abort_unless(
            $instruktur->peran === 'instruktur',
            404
        );

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($instruktur->id),
            ],

            'kata_sandi' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'nama.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',

            'foto.image' => 'File yang dipilih harus berupa gambar.',
            'foto.mimes' => 'Foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $instruktur->nama = $validated['nama'];
        $instruktur->email = $validated['email'];

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */
        if (!empty($validated['kata_sandi'])) {
            $instruktur->kata_sandi = Hash::make(
                $validated['kata_sandi']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Foto
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('foto')) {

            if (
                $instruktur->foto &&
                Storage::disk('public')->exists($instruktur->foto)
            ) {
                Storage::disk('public')
                    ->delete($instruktur->foto);
            }

            $instruktur->foto = $request->file('foto')
                ->store('foto/instruktur', 'public');
        }

        $instruktur->save();

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => 'Update Instruktur',
            'deskripsi' => 'Admin memperbarui akun instruktur: ' . $instruktur->nama,
            'entitas' => 'users',
            'id_entitas' => $instruktur->id,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.instruktur.index')
            ->with('success', 'Data instruktur berhasil diperbarui.');
    }

    /**
     * Menonaktifkan instruktur.
     */
    public function deactivate(User $instruktur)
    {
        $this->onlyAdmin();

        abort_unless(
            $instruktur->peran === 'instruktur',
            404
        );

        $instruktur->update([
            'status' => false,
        ]);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => 'Nonaktifkan Instruktur',
            'deskripsi' => 'Admin menonaktifkan akun instruktur: ' . $instruktur->nama,
            'entitas' => 'users',
            'id_entitas' => $instruktur->id,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.instruktur.index')
            ->with('success', 'Akun instruktur berhasil dinonaktifkan.');
    }

    /**
     * Mengaktifkan kembali instruktur.
     */
    public function activate(User $instruktur)
    {
        $this->onlyAdmin();

        abort_unless(
            $instruktur->peran === 'instruktur',
            404
        );

        $instruktur->update([
            'status' => true,
        ]);

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => 'Aktifkan Instruktur',
            'deskripsi' => 'Admin mengaktifkan kembali akun instruktur: ' . $instruktur->nama,
            'entitas' => 'users',
            'id_entitas' => $instruktur->id,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.instruktur.index')
            ->with('success', 'Akun instruktur berhasil diaktifkan kembali.');
    }
}
<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use App\Models\LogAktivitas;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;



class AkunController extends Controller

{

    /**

     * Hanya Admin yang boleh mengakses

     * fitur Kelola Akun.

     */

    private function onlyAdmin(): void

    {

        abort_unless(

            auth()->check() &&

            auth()->user()->peran === 'admin',

            403

        );

    }



    /*

    |--------------------------------------------------------------------------

    | HALAMAN UTAMA KELOLA AKUN

    |--------------------------------------------------------------------------

    */



    public function index(Request $request)

    {

        $this->onlyAdmin();



        $tab = $request->get('tab', 'instruktur');



        $search = trim($request->get('search', ''));



        /*

        |--------------------------------------------------------------------------

        | AKUN INSTRUKTUR

        |--------------------------------------------------------------------------

        */



        $instrukturs = User::query()

            ->where('peran', 'instruktur')

            ->when(

                $search !== '' && $tab === 'instruktur',

                function ($query) use ($search) {

                    $query->where(function ($q) use ($search) {

                        $q->where(

                            'nama',

                            'like',

                            '%' . $search . '%'

                        )->orWhere(

                            'email',

                            'like',

                            '%' . $search . '%'

                        );

                    });

                }

            )

            ->latest()

            ->get();



        /*

        |--------------------------------------------------------------------------

        | AKUN PELAJAR

        |--------------------------------------------------------------------------

        */



        $pelajars = User::query()

            ->where('peran', 'pelajar')

            ->when(

                $search !== '' && $tab === 'pelajar',

                function ($query) use ($search) {

                    $query->where(function ($q) use ($search) {

                        $q->where(

                            'nama',

                            'like',

                            '%' . $search . '%'

                        )->orWhere(

                            'email',

                            'like',

                            '%' . $search . '%'

                        );

                    });

                }

            )

            ->latest()

            ->get();



        /*

        |--------------------------------------------------------------------------

        | STATISTIK

        |--------------------------------------------------------------------------

        */



        $totalInstruktur = User::query()

            ->where('peran', 'instruktur')

            ->count();



        $instrukturAktif = User::query()

            ->where('peran', 'instruktur')

            ->where('status', true)

            ->count();



        $totalPelajar = User::query()

            ->where('peran', 'pelajar')

            ->count();



        $pelajarAktif = User::query()

            ->where('peran', 'pelajar')

            ->where('status', true)

            ->count();



        return view(

            'admin.akun.index',

            compact(

                'instrukturs',

                'pelajars',

                'totalInstruktur',

                'instrukturAktif',

                'totalPelajar',

                'pelajarAktif',

                'tab'

            )

        );

    }



    /*

    |--------------------------------------------------------------------------

    | AKUN INSTRUKTUR

    |--------------------------------------------------------------------------

    */



    /**

     * Form tambah instruktur.

     */

    public function createInstruktur()

    {

        $this->onlyAdmin();



        return view('admin.akun.create-instruktur');

    }



    /**

     * Menyimpan instruktur.

     */

    public function storeInstruktur(Request $request)

    {

        $this->onlyAdmin();



        $validated = $request->validate(

            [

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

            ],

            [

                'nama.required' =>

                    'Nama instruktur wajib diisi.',



                'email.required' =>

                    'Email wajib diisi.',



                'email.email' =>

                    'Format email tidak valid.',



                'email.unique' =>

                    'Email sudah digunakan.',



                'kata_sandi.required' =>

                    'Kata sandi wajib diisi.',



                'kata_sandi.min' =>

                    'Kata sandi minimal 8 karakter.',



                'kata_sandi.confirmed' =>

                    'Konfirmasi kata sandi tidak sesuai.',



                'foto.image' =>

                    'File harus berupa gambar.',



                'foto.mimes' =>

                    'Foto harus JPG, JPEG, PNG, atau WEBP.',



                'foto.max' =>

                    'Ukuran foto maksimal 2 MB.',

            ]

        );



        $foto = null;



        /*

        |--------------------------------------------------------------------------

        | Upload Foto

        |--------------------------------------------------------------------------

        */



        if ($request->hasFile('foto')) {

            $foto = $request

                ->file('foto')

                ->store(

                    'foto/instruktur',

                    'public'

                );

        }



        /*

        |--------------------------------------------------------------------------

        | Simpan Instruktur

        |--------------------------------------------------------------------------

        */



        $instruktur = User::create([

            'nama' => $validated['nama'],



            'email' => $validated['email'],



            'kata_sandi' => Hash::make(

                $validated['kata_sandi']

            ),



            'peran' => 'instruktur',



            'status' => true,



            'foto' => $foto,

        ]);



        /*

        |--------------------------------------------------------------------------

        | Log Aktivitas

        |--------------------------------------------------------------------------

        */



        LogAktivitas::create([

            'id_user' => auth()->id(),



            'jenis_aktivitas' =>

                'Tambah Akun Instruktur',



            'deskripsi' =>

                'Admin menambahkan akun instruktur: '

                . $instruktur->nama,



            'entitas' => 'users',



            'id_entitas' => $instruktur->id,



            'waktu_aktivitas' => now(),

        ]);



        return redirect()

            ->route(

                'admin.akun.index',

                ['tab' => 'instruktur']

            )

            ->with(

                'success',

                'Akun instruktur berhasil ditambahkan.'

            );

    }



    /**

     * Form edit instruktur.

     */

    public function editInstruktur(User $akun)

    {

        $this->onlyAdmin();



        abort_unless(

            $akun->peran === 'instruktur',

            404

        );



        return view(

            'admin.akun.edit-instruktur',

            compact('akun')

        );

    }



    /**

     * Update instruktur.

     */

    public function updateInstruktur(

        Request $request,

        User $akun

    ) {

        $this->onlyAdmin();



        abort_unless(

            $akun->peran === 'instruktur',

            404

        );



        $validated = $request->validate(

            [

                'nama' => [

                    'required',

                    'string',

                    'max:255',

                ],



                'email' => [

                    'required',

                    'email',

                    'max:255',

                    Rule::unique(

                        'users',

                        'email'

                    )->ignore($akun->id),

                ],



                'kata_sandi' => [

                    'nullable',

                    'string',

                    'min:8',

                    'confirmed',

                ],



                // Perbaikan: validasi status akun.

                'status' => [

                    'required',

                    'boolean',

                ],



                'foto' => [

                    'nullable',

                    'image',

                    'mimes:jpg,jpeg,png,webp',

                    'max:2048',

                ],

            ],

            [

                'nama.required' =>

                    'Nama wajib diisi.',



                'email.required' =>

                    'Email wajib diisi.',



                'email.email' =>

                    'Format email tidak valid.',



                'email.unique' =>

                    'Email sudah digunakan.',



                'kata_sandi.min' =>

                    'Kata sandi minimal 8 karakter.',



                'kata_sandi.confirmed' =>

                    'Konfirmasi kata sandi tidak sesuai.',



                'status.required' =>

                    'Status akun wajib dipilih.',



                'status.boolean' =>

                    'Status akun tidak valid.',



                'foto.image' =>

                    'File harus berupa gambar.',



                'foto.mimes' =>

                    'Foto harus JPG, JPEG, PNG, atau WEBP.',



                'foto.max' =>

                    'Ukuran foto maksimal 2 MB.',

            ]

        );



        /*

        |--------------------------------------------------------------------------

        | Data Dasar

        |--------------------------------------------------------------------------

        */



        $akun->nama = $validated['nama'];



        $akun->email = $validated['email'];



        // Perbaikan: simpan status aktif atau tidak aktif.

        $akun->status = (bool) $validated['status'];



        /*

        |--------------------------------------------------------------------------

        | Password

        |--------------------------------------------------------------------------

        */



        if (!empty($validated['kata_sandi'])) {

            $akun->kata_sandi = Hash::make(

                $validated['kata_sandi']

            );

        }



        /*

        |--------------------------------------------------------------------------

        | Foto

        |--------------------------------------------------------------------------

        */



        if ($request->hasFile('foto')) {

            if (

                $akun->foto &&

                Storage::disk('public')

                    ->exists($akun->foto)

            ) {

                Storage::disk('public')

                    ->delete($akun->foto);

            }



            $akun->foto = $request

                ->file('foto')

                ->store(

                    'foto/instruktur',

                    'public'

                );

        }



        $akun->save();



        /*

        |--------------------------------------------------------------------------

        | Log

        |--------------------------------------------------------------------------

        */



        LogAktivitas::create([

            'id_user' => auth()->id(),



            'jenis_aktivitas' =>

                'Edit Akun Instruktur',



            'deskripsi' =>

                'Admin memperbarui akun instruktur: '

                . $akun->nama,



            'entitas' => 'users',



            'id_entitas' => $akun->id,



            'waktu_aktivitas' => now(),

        ]);



        return redirect()

            ->route(

                'admin.akun.index',

                ['tab' => 'instruktur']

            )

            ->with(

                'success',

                'Akun instruktur berhasil diperbarui.'

            );

    }



    /**

     * Hapus instruktur.

     */

    public function destroyInstruktur(User $akun)

    {

        $this->onlyAdmin();



        abort_unless(

            $akun->peran === 'instruktur',

            404

        );



        $nama = $akun->nama;



        $id = $akun->id;



        /*

        |--------------------------------------------------------------------------

        | Hapus Foto

        |--------------------------------------------------------------------------

        */



        if (

            $akun->foto &&

            Storage::disk('public')

                ->exists($akun->foto)

        ) {

            Storage::disk('public')

                ->delete($akun->foto);

        }



        /*

        |--------------------------------------------------------------------------

        | Log Sebelum Delete

        |--------------------------------------------------------------------------

        */



        LogAktivitas::create([

            'id_user' => auth()->id(),



            'jenis_aktivitas' =>

                'Hapus Akun Instruktur',



            'deskripsi' =>

                'Admin menghapus akun instruktur: '

                . $nama,



            'entitas' => 'users',



            'id_entitas' => $id,



            'waktu_aktivitas' => now(),

        ]);



        /*

        |--------------------------------------------------------------------------

        | Hapus Akun

        |--------------------------------------------------------------------------

        */



        $akun->delete();



        return redirect()

            ->route(

                'admin.akun.index',

                ['tab' => 'instruktur']

            )

            ->with(

                'success',

                'Akun instruktur berhasil dihapus.'

            );

    }



    /*

    |--------------------------------------------------------------------------

    | DETAIL AKUN

    |--------------------------------------------------------------------------

    */



    /**

     * Detail instruktur maupun pelajar.

     *

     * Admin hanya boleh melihat akun:

     * - instruktur

     * - pelajar

     */

    public function show(User $akun)

    {

        $this->onlyAdmin();



        abort_unless(

            in_array(

                $akun->peran,

                [

                    'instruktur',

                    'pelajar',

                ]

            ),

            404

        );



        return view(

            'admin.akun.show',

            compact('akun')

        );

    }



    /*

    |--------------------------------------------------------------------------

    | AKUN PELAJAR

    |--------------------------------------------------------------------------

    |

    | Admin:

    | Bisa melihat dan menghapus akun pelajar.

    | Tidak bisa menambah atau mengedit akun pelajar.

    |

    */



    /**
     * Mengaktifkan atau menonaktifkan akun pelajar.
     * Data akun tetap disimpan; hanya status akses yang diubah.
     */
    public function toggleStatusPelajar(User $akun)
    {
        $this->onlyAdmin();

        abort_unless($akun->peran === 'pelajar', 404);

        $statusSebelumnya = (bool) $akun->status;
        $akun->status = !$statusSebelumnya;
        $akun->save();

        $aksi = $akun->status
            ? 'Aktifkan Akun Pelajar'
            : 'Nonaktifkan Akun Pelajar';

        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => $aksi,
            'deskripsi' => 'Admin ' . ($akun->status ? 'mengaktifkan' : 'menonaktifkan')
                . ' akun pelajar: ' . $akun->nama,
            'entitas' => 'users',
            'id_entitas' => $akun->id,
            'waktu_aktivitas' => now(),
        ]);

        return redirect()
            ->route('admin.akun.index', ['tab' => 'pelajar'])
            ->with(
                'success',
                $akun->status
                    ? 'Akun pelajar berhasil diaktifkan.'
                    : 'Akun pelajar berhasil dinonaktifkan.'
            );
    }

/**

 * Hapus akun pelajar.

 */

public function destroyPelajar(User $akun)

    {

        $this->onlyAdmin();



        abort_unless(

            $akun->peran === 'pelajar',

            404

        );



        $nama = $akun->nama;



        $id = $akun->id;



        /*

        |--------------------------------------------------------------------------

        | Hapus Foto

        |--------------------------------------------------------------------------

        */



        if (

            $akun->foto &&

            Storage::disk('public')

                ->exists($akun->foto)

        ) {

            Storage::disk('public')

                ->delete($akun->foto);

        }



        /*

        |--------------------------------------------------------------------------

        | Log Aktivitas

        |--------------------------------------------------------------------------

        */



        LogAktivitas::create([

            'id_user' => auth()->id(),



            'jenis_aktivitas' =>

                'Hapus Akun Pelajar',



            'deskripsi' =>

                'Admin menghapus akun pelajar: '

                . $nama,



            'entitas' => 'users',



            'id_entitas' => $id,



            'waktu_aktivitas' => now(),

        ]);



        /*

        |--------------------------------------------------------------------------

        | Hapus Akun

        |--------------------------------------------------------------------------

        */



        $akun->delete();



        return redirect()

            ->route(

                'admin.akun.index',

                ['tab' => 'pelajar']

            )

            ->with(

                'success',

                'Akun pelajar berhasil dihapus.'

            );

    }

}
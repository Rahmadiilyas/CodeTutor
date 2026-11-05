<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Materi;
use App\Models\ReferensiChatbot;
use Illuminate\Http\Request;

class ReferensiChatbotController extends Controller
{
    private function onlyAdmin(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'admin',
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    public function index(Request $request)
    {
        $this->onlyAdmin();

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:150'],
            'status' => ['nullable', 'in:1,0'],
            'materi' => ['nullable', 'integer', 'exists:materi,id'],
        ]);

        $query = ReferensiChatbot::query()
            ->with([
                'materi:id,judul_materi',
                'pengguna:id,nama,email',
            ])
            ->orderByDesc('created_at');

        if (!empty($validated['q'])) {
            $keyword = trim($validated['q']);
            $query->where(function ($builder) use ($keyword) {
                $builder
                    ->where('pertanyaan', 'like', "%{$keyword}%")
                    ->orWhere('jawaban_referensi', 'like', "%{$keyword}%")
                    ->orWhereHas('materi', function ($materiQuery) use ($keyword) {
                        $materiQuery->where('judul_materi', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('pengguna', function ($userQuery) use ($keyword) {
                        $userQuery->where('nama', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    });
            });
        }

        if (array_key_exists('status', $validated) && $validated['status'] !== null && $validated['status'] !== '') {
            $query->where('status', (int) $validated['status']);
        }

        if (!empty($validated['materi'])) {
            $query->where('id_materi', $validated['materi']);
        }

        $referensi = $query->paginate(12)->withQueryString();
        $materiList = Materi::query()->orderBy('judul_materi')->get(['id', 'judul_materi']);

        $totalReferensi = ReferensiChatbot::count();
        $referensiAktif = ReferensiChatbot::where('status', true)->count();
        $referensiNonaktif = ReferensiChatbot::where('status', false)->count();
        $referensiTerhubungMateri = ReferensiChatbot::whereNotNull('id_materi')->count();

        return view('admin.referensi-chatbot.index', compact(
            'referensi',
            'materiList',
            'totalReferensi',
            'referensiAktif',
            'referensiNonaktif',
            'referensiTerhubungMateri'
        ));
    }

    public function create()
    {
        $this->onlyAdmin();

        $referensiChatbot = new ReferensiChatbot(['status' => true]);
        $materiList = Materi::query()->orderBy('judul_materi')->get(['id', 'judul_materi']);

        return view('admin.referensi-chatbot.create', compact('referensiChatbot', 'materiList'));
    }

    public function store(Request $request)
    {
        $this->onlyAdmin();


        foreach (['pertanyaan', 'jawaban_referensi'] as $field) {
    $value = $request->input($field);

    if (is_string($value)) {
        $request->merge([
            $field => trim($value),
        ]);
    }
}
        $validated = $request->validate([
            'id_materi' => ['nullable', 'integer', 'exists:materi,id'],
            'pertanyaan' => ['required', 'string', 'max:10000'],
            'jawaban_referensi' => ['required', 'string', 'max:100000'],
            'status' => ['required', 'boolean'],
        ], [
            'id_materi.exists' => 'Materi yang dipilih tidak ditemukan.',
            'pertanyaan.required' => 'Pertanyaan wajib diisi.',
            'jawaban_referensi.required' => 'Jawaban referensi wajib diisi.',
            'status.required' => 'Status referensi wajib dipilih.',
        ]);

        $referensi = ReferensiChatbot::create([
            'id_materi' => $validated['id_materi'] ?? null,
            'id_pengguna' => auth()->id(),
            'pertanyaan' => trim($validated['pertanyaan']),
            'jawaban_referensi' => trim($validated['jawaban_referensi']),
            'status' => (bool) $validated['status'],
        ]);

        $this->logAktivitas(
            'Tambah Referensi Chatbot',
            'Admin menambahkan referensi chatbot: ' . $referensi->pertanyaan,
            $referensi->id
        );

        return redirect()->route('admin.referensi-chatbot.index')
            ->with('success', 'Referensi chatbot berhasil ditambahkan.');
    }

    public function edit(ReferensiChatbot $referensiChatbot)
    {
        $this->onlyAdmin();

        $materiList = Materi::query()->orderBy('judul_materi')->get(['id', 'judul_materi']);

        return view('admin.referensi-chatbot.edit', compact('referensiChatbot', 'materiList'));
    }

    public function update(Request $request, ReferensiChatbot $referensiChatbot)
    {
        $this->onlyAdmin();
foreach (['pertanyaan', 'jawaban_referensi'] as $field) {
    $value = $request->input($field);

    if (is_string($value)) {
        $request->merge([
            $field => trim($value),
        ]);
    }
}
        $validated = $request->validate([
            'id_materi' => ['nullable', 'integer', 'exists:materi,id'],
            'pertanyaan' => ['required', 'string', 'max:10000'],
            'jawaban_referensi' => ['required', 'string', 'max:100000'],
            'status' => ['required', 'boolean'],
        ], [
            'id_materi.exists' => 'Materi yang dipilih tidak ditemukan.',
            'pertanyaan.required' => 'Pertanyaan wajib diisi.',
            'jawaban_referensi.required' => 'Jawaban referensi wajib diisi.',
            'status.required' => 'Status referensi wajib dipilih.',
        ]);

        $referensiChatbot->update([
            'id_materi' => $validated['id_materi'] ?? null,
            'pertanyaan' => trim($validated['pertanyaan']),
            'jawaban_referensi' => trim($validated['jawaban_referensi']),
            'status' => (bool) $validated['status'],
        ]);

        $this->logAktivitas(
            'Perbarui Referensi Chatbot',
            'Admin memperbarui referensi chatbot: ' . $referensiChatbot->pertanyaan,
            $referensiChatbot->id
        );

        return redirect()->route('admin.referensi-chatbot.index')
            ->with('success', 'Referensi chatbot berhasil diperbarui.');
    }

    public function toggleStatus(ReferensiChatbot $referensiChatbot)
    {
        $this->onlyAdmin();

        $referensiChatbot->status = ! (bool) $referensiChatbot->status;
        $referensiChatbot->save();

        $aksi = $referensiChatbot->status
            ? 'Aktifkan Referensi Chatbot'
            : 'Nonaktifkan Referensi Chatbot';
        $deskripsi = 'Admin ' . ($referensiChatbot->status ? 'mengaktifkan' : 'menonaktifkan')
            . ' referensi chatbot: ' . $referensiChatbot->pertanyaan;

        $this->logAktivitas($aksi, $deskripsi, $referensiChatbot->id);

        return redirect()->route('admin.referensi-chatbot.index')
            ->with('success', $referensiChatbot->status
                ? 'Referensi chatbot berhasil diaktifkan.'
                : 'Referensi chatbot berhasil dinonaktifkan.');
    }

    public function destroy(ReferensiChatbot $referensiChatbot)
    {
        $this->onlyAdmin();

        $id = $referensiChatbot->id;
        $pertanyaan = $referensiChatbot->pertanyaan;

        $this->logAktivitas(
            'Hapus Referensi Chatbot',
            'Admin menghapus referensi chatbot: ' . $pertanyaan,
            $id
        );

        $referensiChatbot->delete();

        return redirect()->route('admin.referensi-chatbot.index')
            ->with('success', 'Referensi chatbot berhasil dihapus.');
    }

    private function logAktivitas(string $jenis, string $deskripsi, int $idReferensi): void
    {
        LogAktivitas::create([
            'id_user' => auth()->id(),
            'jenis_aktivitas' => $jenis,
            'deskripsi' => $deskripsi,
            'entitas' => 'referensi_chatbot',
            'id_entitas' => $idReferensi,
            'waktu_aktivitas' => now(),
        ]);
    }
}

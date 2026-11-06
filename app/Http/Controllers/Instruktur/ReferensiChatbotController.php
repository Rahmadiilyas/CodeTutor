<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Materi;
use App\Models\Modul;
use App\Models\ReferensiChatbot;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReferensiChatbotController extends Controller
{
    private function onlyInstruktur(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'instruktur',
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    /** Materi yang berada di dalam modul milik instruktur yang sedang login. */
    private function materiInstrukturQuery()
    {
        $modulIds = Modul::query()
            ->where('id_instruktur', auth()->id())
            ->select('id');

        return Materi::query()->whereIn('id_modul', $modulIds);
    }

    /**
     * Instruktur hanya dapat mengelola referensi yang dibuat olehnya sendiri.
     * Referensi bermateri juga dibatasi pada materi dari modul miliknya.
     */
    private function referensiInstrukturQuery()
    {
        $materiIds = $this->materiInstrukturQuery()->select('id');

        return ReferensiChatbot::query()
            ->where('id_pengguna', auth()->id())
            ->where(function ($query) use ($materiIds) {
                $query->whereNull('id_materi')
                    ->orWhereIn('id_materi', $materiIds);
            });
    }

    private function ensureCanManage(ReferensiChatbot $referensiChatbot): void
    {
        abort_unless(
            $this->referensiInstrukturQuery()
                ->whereKey($referensiChatbot->getKey())
                ->exists(),
            404,
            'Referensi chatbot tidak ditemukan.'
        );
    }

    private function validateInput(Request $request): array
    {
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

        if (!empty($validated['id_materi']) && !$this->materiInstrukturQuery()
            ->whereKey((int) $validated['id_materi'])
            ->exists()) {
            throw ValidationException::withMessages([
                'id_materi' => 'Pilih materi dari modul yang Anda kelola.',
            ]);
        }

        $validated['pertanyaan'] = trim($validated['pertanyaan']);
        $validated['jawaban_referensi'] = trim($validated['jawaban_referensi']);
        $validated['id_materi'] = $validated['id_materi'] ?? null;
        $validated['status'] = (bool) $validated['status'];

        return $validated;
    }

    public function index(Request $request)
    {
        $this->onlyInstruktur();

        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:150'],
            'status' => ['nullable', 'in:1,0'],
            'materi' => ['nullable', 'integer'],
        ]);

        $query = $this->referensiInstrukturQuery()
            ->with('materi:id,judul_materi')
            ->orderByDesc('created_at');

        if (!empty($validated['q'])) {
            $keyword = trim($validated['q']);
            $query->where(function ($builder) use ($keyword) {
                $builder->where('pertanyaan', 'like', "%{$keyword}%")
                    ->orWhere('jawaban_referensi', 'like', "%{$keyword}%")
                    ->orWhereHas('materi', function ($materiQuery) use ($keyword) {
                        $materiQuery->where('judul_materi', 'like', "%{$keyword}%");
                    });
            });
        }

        if (array_key_exists('status', $validated) && $validated['status'] !== null && $validated['status'] !== '') {
            $query->where('status', (int) $validated['status']);
        }

        if (!empty($validated['materi'])) {
            $query->where('id_materi', (int) $validated['materi']);
        }

        $referensi = $query->paginate(12)->withQueryString();
        $materiList = $this->materiInstrukturQuery()
            ->orderBy('judul_materi')
            ->get(['id', 'judul_materi']);

        $totalReferensi = $this->referensiInstrukturQuery()->count();
        $referensiAktif = $this->referensiInstrukturQuery()->where('status', true)->count();
        $referensiNonaktif = $this->referensiInstrukturQuery()->where('status', false)->count();

        return view('instruktur.referensi-chatbot.index', compact(
            'referensi',
            'materiList',
            'totalReferensi',
            'referensiAktif',
            'referensiNonaktif'
        ));
    }

    public function create()
    {
        $this->onlyInstruktur();

        $referensiChatbot = new ReferensiChatbot(['status' => true]);
        $materiList = $this->materiInstrukturQuery()
            ->orderBy('judul_materi')
            ->get(['id', 'judul_materi']);

        return view('instruktur.referensi-chatbot.create', compact('referensiChatbot', 'materiList'));
    }

    public function store(Request $request)
    {
        $this->onlyInstruktur();
        $validated = $this->validateInput($request);

        $referensi = ReferensiChatbot::create([
            'id_materi' => $validated['id_materi'],
            'id_pengguna' => auth()->id(),
            'pertanyaan' => $validated['pertanyaan'],
            'jawaban_referensi' => $validated['jawaban_referensi'],
            'status' => $validated['status'],
        ]);

        $this->logAktivitas(
            'Tambah Referensi Chatbot',
            'Instruktur menambahkan referensi chatbot: ' . $referensi->pertanyaan,
            $referensi->id
        );

        return redirect()->route('instruktur.referensi-chatbot.index')
            ->with('success', 'Referensi chatbot berhasil ditambahkan.');
    }

    public function edit(ReferensiChatbot $referensiChatbot)
    {
        $this->onlyInstruktur();
        $this->ensureCanManage($referensiChatbot);

        $materiList = $this->materiInstrukturQuery()
            ->orderBy('judul_materi')
            ->get(['id', 'judul_materi']);

        return view('instruktur.referensi-chatbot.edit', compact('referensiChatbot', 'materiList'));
    }

    public function update(Request $request, ReferensiChatbot $referensiChatbot)
    {
        $this->onlyInstruktur();
        $this->ensureCanManage($referensiChatbot);
        $validated = $this->validateInput($request);

        $referensiChatbot->update([
            'id_materi' => $validated['id_materi'],
            'pertanyaan' => $validated['pertanyaan'],
            'jawaban_referensi' => $validated['jawaban_referensi'],
            'status' => $validated['status'],
        ]);

        $this->logAktivitas(
            'Perbarui Referensi Chatbot',
            'Instruktur memperbarui referensi chatbot: ' . $referensiChatbot->pertanyaan,
            $referensiChatbot->id
        );

        return redirect()->route('instruktur.referensi-chatbot.index')
            ->with('success', 'Referensi chatbot berhasil diperbarui.');
    }

    public function toggleStatus(ReferensiChatbot $referensiChatbot)
    {
        $this->onlyInstruktur();
        $this->ensureCanManage($referensiChatbot);

        $referensiChatbot->status = !(bool) $referensiChatbot->status;
        $referensiChatbot->save();

        $aksi = $referensiChatbot->status
            ? 'Aktifkan Referensi Chatbot'
            : 'Nonaktifkan Referensi Chatbot';
        $deskripsi = 'Instruktur ' . ($referensiChatbot->status ? 'mengaktifkan' : 'menonaktifkan')
            . ' referensi chatbot: ' . $referensiChatbot->pertanyaan;

        $this->logAktivitas($aksi, $deskripsi, $referensiChatbot->id);

        return redirect()->route('instruktur.referensi-chatbot.index')
            ->with('success', $referensiChatbot->status
                ? 'Referensi chatbot berhasil diaktifkan.'
                : 'Referensi chatbot berhasil dinonaktifkan.');
    }

    public function destroy(ReferensiChatbot $referensiChatbot)
    {
        $this->onlyInstruktur();
        $this->ensureCanManage($referensiChatbot);

        $id = $referensiChatbot->id;
        $pertanyaan = $referensiChatbot->pertanyaan;

        $this->logAktivitas(
            'Hapus Referensi Chatbot',
            'Instruktur menghapus referensi chatbot: ' . $pertanyaan,
            $id
        );

        $referensiChatbot->delete();

        return redirect()->route('instruktur.referensi-chatbot.index')
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

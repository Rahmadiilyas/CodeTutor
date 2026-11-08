<?php

namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;

use App\Models\LogAktivitas;

use App\Models\Materi;

use App\Models\MediaPembelajaran;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;

use Illuminate\Validation\ValidationException;

class MediaPembelajaranController extends Controller

{

    private const JENIS_MEDIA = ['pdf', 'ppt', 'video', 'youtube', 'animasi', 'game', 'lainnya'];

    private function pastikanInstruktur(): void

    {

        abort_unless(

            auth()->check() && auth()->user()->peran === 'instruktur',

            403,

            'Halaman ini hanya dapat diakses oleh Instruktur.'

        );

    }

    private function queryMediaMilikInstruktur()

    {

        return MediaPembelajaran::query()->whereHas('materi.modul', function ($query) {

            $query->where('id_instruktur', auth()->id());

        });

    }

    private function pastikanMilikInstruktur(MediaPembelajaran $mediaPembelajaran): void

    {

        abort_unless(

            $mediaPembelajaran->materi()

                ->whereHas('modul', fn ($query) => $query->where('id_instruktur', auth()->id()))

                ->exists(),

            404,

            'Media pembelajaran tidak ditemukan.'

        );

    }

    private function catatAktivitas(string $jenis, string $deskripsi, ?int $idEntitas): void

    {

        LogAktivitas::create([

            'id_user' => auth()->id(),

            'jenis_aktivitas' => $jenis,

            'deskripsi' => $deskripsi,

            'entitas' => 'media_pembelajaran',

            'id_entitas' => $idEntitas,

            'waktu_aktivitas' => now(),

        ]);

    }

    private function materiMilikInstruktur(bool $hanyaAktif = false)

    {

        $query = Materi::query()

            ->whereHas('modul', fn ($builder) => $builder->where('id_instruktur', auth()->id()))

            ->with(['modul.bahasa'])

            ->orderBy('judul_materi');

        if ($hanyaAktif) {

            $query->where('status', true)

                ->whereHas('modul', fn ($builder) => $builder->where('status', true));

        }

        return $query->get();

    }

    private function validasiFileBerdasarkanJenis(Request $request, string $jenisMedia): void

    {

        if (!$request->hasFile('file_media')) {

            return;

        }

        if ($jenisMedia === 'youtube') {

            throw ValidationException::withMessages([

                'file_media' => 'Untuk jenis YouTube, gunakan tautan video. Tidak perlu mengunggah file.',

            ]);

        }

        $ekstensi = strtolower($request->file('file_media')->getClientOriginalExtension());

        $ekstensiDiizinkan = match ($jenisMedia) {

            'pdf' => ['pdf'],

            'ppt' => ['ppt', 'pptx'],

            'video' => ['mp4', 'mov', 'webm', 'ogg'],

            'youtube' => [],

            'animasi' => ['gif', 'png', 'jpg', 'jpeg', 'webp', 'mp4', 'webm'],

            'game' => ['zip'],

            default => ['pdf', 'ppt', 'pptx', 'mp4', 'mov', 'webm', 'ogg', 'gif', 'png', 'jpg', 'jpeg', 'webp', 'zip'],

        };

        if (!in_array($ekstensi, $ekstensiDiizinkan, true)) {

            throw ValidationException::withMessages([

                'file_media' => 'Ekstensi file tidak sesuai dengan jenis media yang dipilih. Ekstensi yang didukung: '

                    . implode(', ', $ekstensiDiizinkan) . '.',

            ]);

        }

    }

private function aturanValidasiFile(string $jenisMedia): array

{

    return match ($jenisMedia) {

        'pdf' => ['mimes:pdf'],

        'ppt' => ['mimes:ppt,pptx'],

        'video' => ['mimes:mp4,mov,webm,ogg'],

        'animasi' => ['mimes:gif,png,jpg,jpeg,webp,mp4,webm'],

        'game' => ['mimes:zip'],

        'youtube' => [],

        default => [

            'mimes:pdf,ppt,pptx,mp4,mov,webm,ogg,gif,png,jpg,jpeg,webp,zip',

        ],

    };

}

    private function validasiTautanYoutube(string $jenisMedia, ?string $tautan): void

    {

        if ($jenisMedia !== 'youtube' || !$tautan) {

            return;

        }

        $host = strtolower((string) parse_url($tautan, PHP_URL_HOST));

        $host = preg_replace('/^www\\./i', '', $host);

        if (!in_array($host, ['youtube.com', 'm.youtube.com', 'youtu.be', 'youtube-nocookie.com'], true)) {

            throw ValidationException::withMessages([

                'tautan' => 'Untuk jenis YouTube, masukkan tautan dari youtube.com atau youtu.be.',

            ]);

        }

    }

    /**

     * Mengubah tautan YouTube menjadi URL embed yang dapat diputar di popup.

     */

    private function buatUrlEmbedYoutube(?string $tautan): ?string

    {

        if (!$tautan || !filter_var($tautan, FILTER_VALIDATE_URL)) {

            return null;

        }

        $host = strtolower((string) parse_url($tautan, PHP_URL_HOST));

        $host = preg_replace('/^www\\./i', '', $host);

        $idVideo = null;

        if ($host === 'youtu.be') {

            $jalur = trim((string) parse_url($tautan, PHP_URL_PATH), '/');

            $idVideo = explode('/', $jalur)[0] ?? null;

        } elseif (in_array($host, ['youtube.com', 'm.youtube.com', 'youtube-nocookie.com'], true)) {

            $jalur = trim((string) parse_url($tautan, PHP_URL_PATH), '/');

            parse_str((string) parse_url($tautan, PHP_URL_QUERY), $parameter);

            if (!empty($parameter['v'])) {

                $idVideo = (string) $parameter['v'];

            } elseif (preg_match('~^(?:embed|shorts|live)/([^/?]+)~', $jalur, $cocok)) {

                $idVideo = $cocok[1];

            }

        }

        if (!$idVideo || !preg_match('/^[A-Za-z0-9\_-]{11}$/', $idVideo)) {

            return null;

        }

        return 'https://www.youtube-nocookie.com/embed/' . $idVideo;

    }

    /**

     * Menyiapkan URL pratinjau untuk setiap baris media pada halaman daftar.

     */

    private function siapkanDataPreview($daftarMedia)

    {

        $daftarMedia->getCollection()->transform(function (MediaPembelajaran $item) {

            $urlFile = $item->lokasi_file

                ? Storage::disk('public')->url($item->lokasi_file)

                : null;

            $urlTautan = $item->tautan && filter_var($item->tautan, FILTER_VALIDATE_URL)

                ? $item->tautan

                : null;

            $item->setAttribute('url_preview', $urlFile);

            $item->setAttribute('youtube_embed_url', $this->buatUrlEmbedYoutube($item->tautan));

            $item->setAttribute('nama_file_preview', $item->lokasi_file

                ? basename($item->lokasi_file)

                : ($urlTautan ? basename((string) parse_url($urlTautan, PHP_URL_PATH)) : ''));

            return $item;

        });

        return $daftarMedia;

    }

    public function index(Request $request)

    {

        $this->pastikanInstruktur();

        $validated = $request->validate([

            'q' => ['nullable', 'string', 'max:100'],

            'jenis_media' => ['nullable', Rule::in(self::JENIS_MEDIA)],

            'materi' => [

                'nullable', 'integer',

                Rule::exists('materi', 'id')->where(function ($query) {

                    $query->whereIn('id_modul', function ($subquery) {

                        $subquery->select('id')->from('modul')->where('id_instruktur', auth()->id());

                    });

                }),

            ],

        ]);

        $query = $this->queryMediaMilikInstruktur()

            ->with(['materi.modul.bahasa'])

            ->orderByDesc('created_at');

        if (!empty($validated['q'])) {

            $keyword = trim($validated['q']);

            $query->where(function ($builder) use ($keyword) {

                $builder->where('judul_media', 'like', "%{$keyword}%")

                    ->orWhere('jenis_media', 'like', "%{$keyword}%")

                    ->orWhere('tautan', 'like', "%{$keyword}%")

                    ->orWhereHas('materi', function ($materiQuery) use ($keyword) {

                        $materiQuery->where('judul_materi', 'like', "%{$keyword}%")

                            ->whereHas('modul', fn ($modulQuery) => $modulQuery->where('id_instruktur', auth()->id()));

                    });

            });

        }

        if (!empty($validated['jenis_media'])) {

            $query->where('jenis_media', $validated['jenis_media']);

        }

        if (!empty($validated['materi'])) {

            $query->where('id_materi', (int) $validated['materi']);

        }

        $media = $this->siapkanDataPreview($query->paginate(10)->withQueryString());

        $materiFilter = $this->materiMilikInstruktur();

        $totalMedia = $this->queryMediaMilikInstruktur()->count();

        $totalFile = $this->queryMediaMilikInstruktur()->whereNotNull('lokasi_file')->where('lokasi_file', '!=', '')->count();

        $totalTautan = $this->queryMediaMilikInstruktur()->whereNotNull('tautan')->where('tautan', '!=', '')->count();

        $jenisMedia = self::JENIS_MEDIA;

        return view('instruktur.media.index', compact(

            'media', 'materiFilter', 'totalMedia', 'totalFile', 'totalTautan', 'jenisMedia'

        ));

    }

    public function create()

    {

        $this->pastikanInstruktur();

        $materi = $this->materiMilikInstruktur(true);

        $jenisMedia = self::JENIS_MEDIA;

        return view('instruktur.media.create', compact('materi', 'jenisMedia'));

    }

    public function store(Request $request)

    {

        $this->pastikanInstruktur();

$aturanFileMedia = $this->aturanValidasiFile(

    (string) $request->input('jenis_media', '')

);

        $validated = $request->validate([

            'id_materi' => [

                'required', 'integer',

                Rule::exists('materi', 'id')->where(function ($query) {

                    $query->where('status', true)->whereIn('id_modul', function ($subquery) {

                        $subquery->select('id')->from('modul')

                            ->where('id_instruktur', auth()->id())->where('status', true);

                    });

                }),

            ],

            'judul_media' => ['required', 'string', 'max:255'],

            'jenis_media' => ['required', Rule::in(self::JENIS_MEDIA)],

            'tautan' => ['nullable', 'url:http,https', 'max:2048'],

            'file_media' => array_merge(

    ['nullable', 'file', 'max:20480'],

    $aturanFileMedia

),

        ], [

            'id_materi.required' => 'Pilih materi yang akan diberi media.',

            'id_materi.exists' => 'Materi harus aktif dan berada di bawah modul milikmu.',

            'judul_media.required' => 'Judul media wajib diisi.',

            'jenis_media.required' => 'Pilih jenis media.',

            'tautan.url' => 'Tautan harus berupa URL HTTP atau HTTPS yang valid.',

            'file_media.max' => 'Ukuran file maksimal 20 MB.',

        ]);

        $this->validasiFileBerdasarkanJenis($request, $validated['jenis_media']);

        $this->validasiTautanYoutube($validated['jenis_media'], $validated['tautan'] ?? null);

        if ($validated['jenis_media'] === 'youtube' && empty($validated['tautan'])) {

            throw ValidationException::withMessages(['tautan' => 'Tautan YouTube wajib diisi untuk jenis media YouTube.']);

        }

        if ($validated['jenis_media'] !== 'youtube' && !$request->hasFile('file_media') && empty($validated['tautan'])) {

            throw ValidationException::withMessages([

                'file_media' => 'Unggah file atau isi tautan media. Minimal salah satu harus tersedia.',

                'tautan' => 'Isi tautan jika tidak mengunggah file.',

            ]);

        }

        $lokasiFile = $request->hasFile('file_media')

            ? $request->file('file_media')->store('media-pembelajaran', 'public')

            : null;

        try {

            $media = MediaPembelajaran::create([

                'id_materi' => (int) $validated['id_materi'],

                'judul_media' => trim($validated['judul_media']),

                'jenis_media' => $validated['jenis_media'],

                'lokasi_file' => $lokasiFile,

                'tautan' => $validated['tautan'] ?? null,

            ]);

        } catch (\Throwable $exception) {

            if ($lokasiFile) {

                Storage::disk('public')->delete($lokasiFile);

            }

            throw $exception;

        }

        $this->catatAktivitas(

            'Tambah Media Pembelajaran',

            'Instruktur menambahkan media "' . $media->judul_media . '" pada materi ID ' . $media->id_materi,

            (int) $media->id

        );

        return redirect()->route('instruktur.media.index')

            ->with('success', 'Media pembelajaran berhasil ditambahkan.');

    }

    public function edit(MediaPembelajaran $mediaPembelajaran)

    {

        $this->pastikanInstruktur();

        $this->pastikanMilikInstruktur($mediaPembelajaran);

        $materi = $this->materiMilikInstruktur();

        $jenisMedia = self::JENIS_MEDIA;

        return view('instruktur.media.edit', [

            'media' => $mediaPembelajaran->load('materi.modul.bahasa'),

            'materi' => $materi,

            'jenisMedia' => $jenisMedia,

        ]);

    }

    public function update(Request $request, MediaPembelajaran $mediaPembelajaran)

    {

        $this->pastikanInstruktur();

        $this->pastikanMilikInstruktur($mediaPembelajaran);

        $aturanFileMedia = $this->aturanValidasiFile(

    (string) $request->input('jenis_media', '')

);

        $validated = $request->validate([

            'id_materi' => [

                'required', 'integer',

                Rule::exists('materi', 'id')->where(function ($query) {

                    $query->whereIn('id_modul', function ($subquery) {

                        $subquery->select('id')->from('modul')->where('id_instruktur', auth()->id());

                    });

                }),

            ],

            'judul_media' => ['required', 'string', 'max:255'],

            'jenis_media' => ['required', Rule::in(self::JENIS_MEDIA)],

            'tautan' => ['nullable', 'url:http,https', 'max:2048'],

            'file_media' => array_merge(

    ['nullable', 'file', 'max:20480'],

    $aturanFileMedia

),

        ], [

            'id_materi.required' => 'Pilih materi yang akan diberi media.',

            'id_materi.exists' => 'Materi yang dipilih tidak valid atau bukan milikmu.',

            'judul_media.required' => 'Judul media wajib diisi.',

            'tautan.url' => 'Tautan harus berupa URL HTTP atau HTTPS yang valid.',

            'file_media.max' => 'Ukuran file maksimal 20 MB.',

        ]);

        $this->validasiFileBerdasarkanJenis($request, $validated['jenis_media']);

        $this->validasiTautanYoutube($validated['jenis_media'], $validated['tautan'] ?? null);

        if ($validated['jenis_media'] === 'youtube' && empty($validated['tautan'])) {

            throw ValidationException::withMessages(['tautan' => 'Tautan YouTube wajib diisi untuk jenis media YouTube.']);

        }

        $punyaFileLama = !empty($mediaPembelajaran->lokasi_file);

        $akanUnggahFile = $request->hasFile('file_media');

        $punyaTautanBaru = !empty($validated['tautan']);

        if ($validated['jenis_media'] !== 'youtube' && !$punyaTautanBaru && !$akanUnggahFile && !$punyaFileLama) {

            throw ValidationException::withMessages([

                'file_media' => 'Unggah file atau isi tautan media. Minimal salah satu harus tersedia.',

                'tautan' => 'Isi tautan jika tidak mengunggah file.',

            ]);

        }

        $fileLama = $mediaPembelajaran->lokasi_file;

        $lokasiFile = $fileLama;

        if ($validated['jenis_media'] === 'youtube') {

            $lokasiFile = null;

        } elseif ($akanUnggahFile) {

            $lokasiFile = $request->file('file_media')->store('media-pembelajaran', 'public');

        }

        try {

            $mediaPembelajaran->update([

                'id_materi' => (int) $validated['id_materi'],

                'judul_media' => trim($validated['judul_media']),

                'jenis_media' => $validated['jenis_media'],

                'lokasi_file' => $lokasiFile,

                'tautan' => $validated['tautan'] ?? null,

            ]);

        } catch (\Throwable $exception) {

            if ($akanUnggahFile && $lokasiFile) {

                Storage::disk('public')->delete($lokasiFile);

            }

            throw $exception;

        }

        if ($fileLama && $fileLama !== $lokasiFile) {

            Storage::disk('public')->delete($fileLama);

        }

        $this->catatAktivitas(

            'Perbarui Media Pembelajaran',

            'Instruktur memperbarui media: ' . $mediaPembelajaran->judul_media,

            (int) $mediaPembelajaran->id

        );

        return redirect()->route('instruktur.media.index')

            ->with('success', 'Media pembelajaran berhasil diperbarui.');

    }

    public function destroy(MediaPembelajaran $mediaPembelajaran)

    {

        $this->pastikanInstruktur();

        $this->pastikanMilikInstruktur($mediaPembelajaran);

        $judul = $mediaPembelajaran->judul_media;

        $id = (int) $mediaPembelajaran->id;

        $lokasiFile = $mediaPembelajaran->lokasi_file;

        $mediaPembelajaran->delete();

        if ($lokasiFile) {

            Storage::disk('public')->delete($lokasiFile);

        }

        $this->catatAktivitas(

            'Hapus Media Pembelajaran',

            'Instruktur menghapus media pembelajaran: ' . $judul,

            $id

        );

        return redirect()->route('instruktur.media.index')

            ->with('success', 'Media pembelajaran berhasil dihapus.');

    }

}

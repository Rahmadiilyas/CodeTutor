<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Models\BahasaPemrograman;


class CodeExecutionController extends Controller
{
    /**
     * Menjalankan source code Pelajar melalui Judge0 CE.
     * Kode pengguna tidak pernah dijalankan langsung di proses Laravel.
     */
    public function execute(Request $request): JsonResponse
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'pelajar',
            403,
            'Fitur eksekusi kode hanya tersedia untuk Pelajar.'
        );

        $validated = $request->validate([
            'language' => ['required', 'string', 'in:java,python,javascript,php,cpp,c,csharp,dart,go,kotlin'],
            'code' => ['required', 'string', 'max:12000'],
            'stdin' => ['nullable', 'string', 'max:2000'],
        ]);

        $bahasaAktifTersedia = BahasaPemrograman::query()
    ->where('status', true)
    ->pluck('nama_bahasa')
    ->contains(
        fn ($nama) => $this->normalisasiBahasa((string) $nama)
            === $validated['language']
    );

if (!$bahasaAktifTersedia) {
    return response()->json([
        'ok' => false,
        'message' => 'Bahasa pemrograman ini sedang tidak tersedia.',
    ], 422);
}

        // CODE_EXECUTION_BASE_URL diarahkan ke https://ce.judge0.com.
        $baseUrl = rtrim((string) config('services.code_execution.base_url', 'https://ce.judge0.com'), '/');
        if ($baseUrl === '') {
            $baseUrl = 'https://ce.judge0.com';
        }

        $client = Http::acceptJson()
            ->connectTimeout(4)
            ->timeout(12);

        // Umumnya tidak diperlukan pada endpoint demo publik. Jika instance
        // Judge0 milik sendiri membutuhkan token, kirim melalui X-Auth-Token.
        $apiKey = trim((string) config('services.code_execution.api_key', ''));
        if ($apiKey !== '') {
            $client = $client->withHeaders(['X-Auth-Token' => $apiKey]);
        }

        $languagePatterns = [
            'java'       => '/^Java\s*\(/i',
            'python'     => '/^Python\s*\(3(?:\.|\))/i',
            'javascript' => '/^JavaScript\s*\(/i',
            'php'        => '/^PHP\s*\(/i',
            'cpp'        => '/^C\+\+\s*\(/i',
            'c'          => '/^C\s*\(/i',
            'csharp'     => '/^C#\s*\(/i',
            'dart'       => '/^Dart\s*\(/i',
            'go'         => '/^Go\s*\(/i',
            'kotlin'     => '/^Kotlin\s*\(/i',
        ];

        try {
            // Cache katalog bahasa selama satu jam agar setiap eksekusi tidak
            // perlu mengambil ulang daftar bahasa dari Judge0.
            $languages = Cache::remember(
                'code_execution.judge0.languages.' . sha1($baseUrl),
                3600,
                function () use ($client, $baseUrl) {
                    $response = $client->get($baseUrl . '/languages/');
                    if (!$response->successful()) {
                        throw new \RuntimeException('Judge0 tidak dapat memberikan daftar bahasa. HTTP ' . $response->status());
                    }

                    $data = $response->json();
                    if (!is_array($data)) {
                        throw new \RuntimeException('Format daftar bahasa dari Judge0 tidak valid.');
                    }

                    return $data;
                }
            );

            $pattern = $languagePatterns[$validated['language']];
            $candidates = array_values(array_filter(
                $languages,
                static fn ($item) => is_array($item)
                    && isset($item['id'], $item['name'])
                    && preg_match($pattern, (string) $item['name']) === 1
            ));

            // Pilih runtime versi terbaru berdasarkan nomor versi pada nama.
            usort($candidates, static function ($left, $right) {
                $extractVersion = static function (string $name): string {
                    return preg_match('/(\d+(?:\.\d+){1,3})/', $name, $matches)
                        ? $matches[1]
                        : '0.0.0';
                };

                return version_compare(
                    $extractVersion((string) $left['name']),
                    $extractVersion((string) $right['name'])
                );
            });

            $runtime = $candidates ? $candidates[count($candidates) - 1] : null;
            if (!$runtime) {
                return response()->json([
                    'ok' => false,
                    'message' => $validated['language'] === 'python'
                        ? 'Runtime Python 3 tidak tersedia pada layanan eksekusi saat ini.'
                        : 'Runtime untuk bahasa ' . $validated['language'] . ' belum tersedia pada layanan eksekusi.',
                ], 422);
            }

            $payload = [
                'source_code' => $validated['code'],
                'language_id' => (int) $runtime['id'],
                'stdin' => $validated['stdin'] ?? '',
                // Batas proses sesuai kebutuhan awal: CPU 2 detik, wall time 5 detik.
                'cpu_time_limit' => 2,
                'wall_time_limit' => 5,
                'memory_limit' => 128000,
            ];

            // Endpoint ini telah diuji langsung dan mengembalikan hasil beserta
            // status. Beberapa host Judge0 dapat menonaktifkan wait=true.
            $executionResponse = $client->post(
                $baseUrl . '/submissions/?base64_encoded=false&wait=true',
                $payload
            );

            if (!$executionResponse->successful()) {
                $details = $executionResponse->json('error')
                    ?? $executionResponse->json('message')
                    ?? 'Layanan eksekusi menolak permintaan.';

                Log::warning('Judge0 menolak permintaan eksekusi.', [
                    'http_status' => $executionResponse->status(),
                    'language' => $validated['language'],
                    'details' => is_string($details) ? mb_substr($details, 0, 300) : 'Tidak tersedia',
                ]);

                $status = $executionResponse->status() === 503 ? 503 : 502;
                return response()->json([
                    'ok' => false,
                    'message' => is_string($details) && stripos($details, 'wait not allowed') !== false
                        ? 'Layanan eksekusi tidak mengizinkan mode tunggu langsung. Perlu mengaktifkan mode antrean/polling.'
                        : 'Layanan eksekusi menolak permintaan. Silakan coba lagi beberapa saat.',
                ], $status);
            }

            $result = $executionResponse->json();
            if (!is_array($result) || !is_array($result['status'] ?? null)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Layanan eksekusi memberikan hasil yang tidak lengkap.',
                ], 502);
            }

            $runnerStatusId = (int) ($result['status']['id'] ?? 0);
            $runnerStatus = (string) ($result['status']['description'] ?? 'Status tidak diketahui');
            $success = $runnerStatusId === 3; // Judge0: 3 = Accepted.

            return response()->json([
                'ok' => true,
                'status' => $success ? 'success' : 'error',
                'language' => $validated['language'],
                'version' => (string) $runtime['name'],
                'stdout' => (string) ($result['stdout'] ?? ''),
                'stderr' => (string) ($result['stderr'] ?? ''),
                'compile_output' => (string) ($result['compile_output'] ?? ''),
                'runner_status' => $runnerStatus,
                'message' => (string) ($result['message'] ?? ''),
                'time' => (string) ($result['time'] ?? ''),
                'memory' => $result['memory'] ?? null,
            ]);
        } catch (ConnectionException $exception) {
            Log::warning('Judge0 tidak dapat dijangkau.', [
                'language' => $validated['language'],
                'error_class' => get_class($exception),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Layanan eksekusi tidak dapat dijangkau. Periksa internet atau coba kembali nanti.',
            ], 503);
        } catch (Throwable $exception) {
            Log::error('Kesalahan saat memproses eksekusi Judge0.', [
                'language' => $validated['language'],
                'error_class' => get_class($exception),
                'message' => mb_substr($exception->getMessage(), 0, 300),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Terjadi kesalahan saat memproses kode. Periksa log Laravel untuk detailnya.',
            ], 500);
        }
    }
    private function normalisasiBahasa(string $namaBahasa): ?string
{
    $nama = mb_strtolower(trim($namaBahasa));
    $nama = preg_replace('/\s+/', ' ', $nama) ?? $nama;

    if (
        str_contains($nama, 'javascript')
        || preg_match('/(^|\s)js($|\s)/', $nama)
    ) {
        return 'javascript';
    }

    if (
        str_contains($nama, 'c++')
        || preg_match('/(^|\s)cpp($|\s)/', $nama)
        || str_contains($nama, 'cplusplus')
    ) {
        return 'cpp';
    }

    if (
        str_contains($nama, 'c#')
        || str_contains($nama, 'c sharp')
        || str_contains($nama, 'csharp')
    ) {
        return 'csharp';
    }

    if (preg_match('/^python\b/', $nama)) {
        return 'python';
    }

    if (preg_match('/^java\b/', $nama)) {
        return 'java';
    }

    if (preg_match('/^php\b/', $nama)) {
        return 'php';
    }

    if (preg_match('/^dart\b/', $nama)) {
        return 'dart';
    }

    if (preg_match('/^(go|golang)\b/', $nama)) {
        return 'go';
    }

    if (preg_match('/^kotlin\b/', $nama)) {
        return 'kotlin';
    }

    if (preg_match('/^c(?:\s|$)/', $nama)) {
        return 'c';
    }

    return null;
}
}

<?php

namespace App\Http\Controllers\Pelajar;

use App\Http\Controllers\Controller;
use App\Models\ContohKode;
use Illuminate\Http\Request;

class CodeEditorController extends Controller
{
    /**
     * Menampilkan Code Lab untuk Pelajar beserta latihan yang disimpan
     * Instruktur melalui FR-011.
     */
    public function index(Request $request)
    {
        abort_unless(
            auth()->check() && auth()->user()->peran === 'pelajar',
            403,
            'Code Lab hanya dapat diakses oleh Pelajar.'
        );

        $contohKodeList = ContohKode::query()
            ->with([
                'bahasa:id,nama_bahasa',
                'materi:id,judul_materi',
            ])
            ->whereHas('bahasa', function ($query) {
    $query->where('status', true);
})
->where(function ($query) {
    // Contoh kode tanpa materi tetap boleh ditampilkan.
    $query->whereNull('id_materi')
        ->orWhereHas('materi', function ($materiQuery) {
            $materiQuery->where('status', true)
                ->whereHas('modul', function ($modulQuery) {
                    $modulQuery->where('status', true)
                        ->whereHas('bahasa', function ($bahasaQuery) {
                            $bahasaQuery->where('status', true);
                        });
                });
        });
})
->orderBy('id_bahasa')
            ->orderBy('judul')
            ->get()
            ->map(function (ContohKode $contohKode) {
                $namaBahasa = (string) ($contohKode->bahasa->nama_bahasa ?? '');
                $bahasaEditor = $this->normalisasiBahasa($namaBahasa);

                if ($bahasaEditor === null) {
                    return null;
                }

                return [
                    'id' => (int) $contohKode->id,
                    'language' => $bahasaEditor,
                    'language_name' => $namaBahasa,
                    'title' => (string) $contohKode->judul,
                    'description' => (string) ($contohKode->deskripsi ?? ''),
                    'code' => (string) ($contohKode->kode_program ?? ''),
                    'expected_output' => (string) ($contohKode->hasil_diharapkan ?? ''),
                    'material_title' => (string) ($contohKode->materi->judul_materi ?? ''),
                ];
            })
            ->filter()
            ->values();

        return view('code-editor', compact('contohKodeList'));
    }

    /** Petakan nama bahasa di database ke value yang didukung Code Lab/Judge0. */
    private function normalisasiBahasa(string $namaBahasa): ?string
    {
        $nama = mb_strtolower(trim($namaBahasa));
        $nama = preg_replace('/\s+/', ' ', $nama) ?? $nama;

        // Spesifik lebih dahulu supaya C++ dan C# tidak terbaca sebagai C.
        if (str_contains($nama, 'javascript') || preg_match('/(^|\s)js($|\s)/', $nama)) {
            return 'javascript';
        }
        if (str_contains($nama, 'c++') || preg_match('/(^|\s)cpp($|\s)/', $nama) || str_contains($nama, 'cplusplus')) {
            return 'cpp';
        }
        if (str_contains($nama, 'c#') || str_contains($nama, 'c sharp') || str_contains($nama, 'csharp')) {
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
        if (preg_match('/^c(?:\s|$|\(| language\b| programming\b)/', $nama) || $nama === 'bahasa c') {
            return 'c';
        }

        return null;
    }
}

@extends('layouts.master')

@section('title', 'Code Lab — CodeTutor')

@section('description', 'Tempat belajar dan mencoba source code.')

@section('page_label', 'Code Lab')

@section('page_heading', 'Code Lab')


@section('content')

<div class="mx-auto max-w-[1500px]">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="mb-6">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

            <div>

                

                <h1
                    class="font-display text-3xl font-black tracking-tight text-maroon-950 sm:text-4xl"
                >
                    Code Lab
                </h1>


                <p
                    class="mt-2 max-w-2xl text-sm leading-6 text-slate-500"
                >
                    Tulis kode, jalankan program, dan lihat hasilnya
                    secara langsung. Pilih bahasa pemrograman yang ingin
                    kamu pelajari.
                </p>

            </div>


            {{-- LANGUAGE SELECTOR --}}

            <div
                class="rounded-2xl border border-maroon-900/10 bg-white p-2 shadow-sm"
            >

                <div class="flex items-center gap-2">

                    <div
                        class="grid h-10 w-10 place-items-center rounded-xl bg-maroon-900 text-gold-400"
                    >

                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >

                            <path d="m8 9-4 3 4 3"/>

                            <path d="m16 9 4 3-4 3"/>

                            <path d="m14 5-4 14"/>

                        </svg>

                    </div>


                    <div class="pr-3">

                        <p
                            class="text-[9px] font-bold uppercase tracking-wider text-slate-400"
                        >
                            Bahasa
                        </p>


                        <select
                            id="languageSelect"
                            class="mt-0.5 border-0 bg-transparent p-0 pr-7 text-sm font-extrabold text-maroon-950 outline-none focus:ring-0"
                        >

                            <option value="java">
                                Java
                            </option>

                            <option value="python">
                                Python
                            </option>

                            <option value="javascript">
                                JavaScript
                            </option>

                            <option value="php">
                                PHP
                            </option>

                            <option value="cpp">
                                C++
                            </option>

                            <option value="c">
                                C
                            </option>

                            <option value="csharp">
                                C#
                            </option>

                            <option value="dart">
                                Dart
                            </option>

                            <option value="go">
                                Go
                            </option>

                            <option value="kotlin">
                                Kotlin
                            </option>

                        </select>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         MAIN CARD
    ========================================================== --}}

    <div
        class="overflow-hidden rounded-[28px] border border-maroon-900/10 bg-white shadow-[0_20px_70px_rgba(60,20,18,.08)]"
    >

        <div
            class="grid lg:grid-cols-[310px_minmax(0,1fr)]"
        >


            {{-- =================================================
                 LEFT : SOAL
            ================================================== --}}

            <aside
                class="border-b border-maroon-900/10 bg-[#fcfaf8] lg:border-b-0 lg:border-r"
            >

                <div class="p-6">

                    {{-- PILIH LATIHAN DARI INSTRUKTUR (FR-011) --}}
                    <div class="mb-5 rounded-2xl border border-maroon-900/10 bg-white p-4">
                        <label for="exerciseSelect" class="mb-2 block text-[10px] font-extrabold uppercase tracking-wider text-slate-500">
                            Latihan dari Instruktur
                        </label>
                        <select
                            id="exerciseSelect"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-xs font-bold text-maroon-950 outline-none focus:border-gold-500 focus:ring-gold-500"
                        >
                            <option value="">Contoh bawaan — Hello World</option>
                            @foreach(($contohKodeList ?? collect()) as $contoh)
                                <option value="{{ $contoh['id'] }}" data-language="{{ $contoh['language'] }}">
                                    {{ $contoh['title'] }} — {{ $contoh['language_name'] }}
                                </option>
                            @endforeach
                        </select>
                        <p id="exerciseSourceHint" class="mt-2 text-[10px] leading-5 text-slate-500">
                            Pilih latihan yang disiapkan Instruktur untuk memuat instruksi dan kode awal.
                        </p>
                    </div>

                    {{-- SOAL HEADER --}}

                    <div class="flex items-start gap-3">

                        <div
                            class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-maroon-900 text-gold-400"
                        >

                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <path
                                    d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"
                                />

                                <path
                                    d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"
                                />

                            </svg>

                        </div>


                        <div>

                            <p
                                class="text-[9px] font-extrabold uppercase tracking-[.15em] text-gold-700"
                            >
                                Latihan Coding
                            </p>

                            <h2
                                id="taskTitle"
                                class="mt-1 text-base font-black text-maroon-950"
                            >
                                Hello World
                            </h2>

                        </div>

                    </div>



                    {{-- DIVIDER --}}

                    <div
                        class="my-6 h-px bg-maroon-900/10"
                    ></div>



                    {{-- TUJUAN --}}

                    <div>

                        <div
                            class="mb-2 flex items-center gap-2"
                        >

                            <span
                                class="text-gold-600"
                            >
                                🎯
                            </span>

                            <h3
                                class="text-xs font-extrabold text-maroon-950"
                            >
                                Tujuan
                            </h3>

                        </div>


                        <p
                            id="taskDescription"
                            class="text-xs leading-6 text-slate-500"
                        >
                            Buat program sederhana untuk menampilkan
                            tulisan "Hello World" pada console.
                        </p>

                    </div>



                    {{-- PETUNJUK --}}

                    <div
                        class="mt-6 rounded-2xl border border-gold-500/20 bg-gold-400/10 p-4"
                    >

                        <div class="flex gap-3">

                            <div
                                class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-gold-400 text-maroon-950"
                            >

                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                    />

                                    <path d="M12 8v4"/>

                                    <path d="M12 16h.01"/>

                                </svg>

                            </div>


                            <div>

                                <p
                                    class="text-[10px] font-extrabold uppercase tracking-wider text-maroon-900"
                                >
                                    Petunjuk
                                </p>

                                <p
                                    id="taskHint"
                                    class="mt-1 text-[11px] leading-5 text-maroon-900/60"
                                >
                                    Gunakan println() untuk menampilkan
                                    tulisan ke console.
                                </p>

                            </div>

                        </div>

                    </div>



                    {{-- EXPECTED OUTPUT --}}

                    <div class="mt-6">

                        <div
                            class="mb-2 flex items-center justify-between"
                        >

                            <p
                                class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400"
                            >
                                Hasil yang diharapkan
                            </p>


                            <span
                                class="text-[10px] font-bold text-green-600"
                            >
                                ✓ Expected
                            </span>

                        </div>


                        <div
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-3"
                        >

                            <code
                                id="expectedOutput"
                                class="block whitespace-pre-wrap break-words font-mono text-xs font-bold text-maroon-900"
                            >
                                Hello World
                            </code>

                        </div>

                    </div>



                    {{-- INFO --}}

                    <div
                        class="mt-6 flex items-center gap-3 rounded-2xl bg-maroon-900 px-4 py-3"
                    >

                        <div
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-white/10 text-gold-400"
                        >

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                                <path d="M12 8v4"/>

                                <path d="M12 16h.01"/>

                            </svg>

                        </div>


                        <p
                            class="text-[10px] leading-5 text-white/60"
                        >
                            Kamu bisa mengubah kode contoh
                            sebelum menjalankannya.
                        </p>

                    </div>

                </div>

            </aside>



            {{-- =================================================
                 RIGHT : EDITOR
            ================================================== --}}

            <section
                class="min-w-0 bg-[#1b1512]"
            >


                {{-- EDITOR HEADER --}}

                <div
                    class="flex flex-col gap-3 border-b border-white/5 px-4 py-3 sm:flex-row sm:items-center sm:justify-between"
                >


                    {{-- FILE --}}

                    <div
                        class="flex items-center gap-3"
                    >

                        <div
                            class="grid h-9 w-9 place-items-center rounded-xl bg-white/5"
                        >

                            <svg
                                class="h-4 w-4 text-gold-400"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <path
                                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                />

                                <path d="M14 2v6h6"/>

                            </svg>

                        </div>


                        <div>

                            <p
                                id="fileName"
                                class="text-xs font-extrabold text-white"
                            >
                                Main.java
                            </p>

                            <p
                                id="languageLabel"
                                class="text-[9px] text-white/30"
                            >
                                Java Source File
                            </p>

                        </div>

                    </div>



                    {{-- EDITOR BUTTONS --}}

                    <div class="flex items-center gap-2">


                        {{-- COPY --}}

                        <button
                            type="button"
                            id="copyButton"
                            class="inline-flex h-9 items-center gap-2 rounded-xl border border-white/10 px-3 text-[10px] font-bold text-white/50 transition hover:border-gold-400/40 hover:text-gold-400"
                        >

                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <rect
                                    x="9"
                                    y="9"
                                    width="13"
                                    height="13"
                                    rx="2"
                                />

                                <path
                                    d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"
                                />

                            </svg>

                            Salin

                        </button>



                        {{-- RESET --}}

                        <button
                            type="button"
                            id="resetButton"
                            class="grid h-9 w-9 place-items-center rounded-xl border border-white/10 text-white/50 transition hover:border-gold-400/40 hover:text-gold-400"
                            title="Reset kode"
                        >

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <path
                                    d="M3 12a9 9 0 1 0 3-6.7"
                                />

                                <path d="M3 4v6h6"/>

                            </svg>

                        </button>



                        {{-- FULLSCREEN --}}

                        <button
                            type="button"
                            id="fullscreenButton"
                            class="grid h-9 w-9 place-items-center rounded-xl border border-white/10 text-white/50 transition hover:border-gold-400/40 hover:text-gold-400"
                            title="Fullscreen"
                        >

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >

                                <path d="M8 3H5a2 2 0 0 0-2 2v3"/>

                                <path d="M16 3h3a2 2 0 0 1 2 2v3"/>

                                <path d="M8 21H5a2 2 0 0 1-2-2v-3"/>

                                <path d="M16 21h3a2 2 0 0 0 2-2v-3"/>

                            </svg>

                        </button>



                        {{-- RUN --}}

                        <button
                            type="button"
                            id="runButton"
                            class="inline-flex h-9 items-center gap-2 rounded-xl bg-gold-400 px-4 text-[10px] font-extrabold text-maroon-950 shadow-lg shadow-gold-400/10 transition hover:bg-gold-300"
                        >

                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >

                                <path d="M8 5v14l11-7z"/>

                            </svg>

                            Jalankan

                        </button>

                    </div>

                </div>



                {{-- =================================================
                     CODE AREA
                ================================================== --}}

                <div
                    id="editorFullscreen"
                    class="relative"
                >

                    <div
                        class="flex h-[470px] overflow-auto"
                    >

                        {{-- LINE NUMBER --}}

                        <div
                            id="lineNumbers"
                            class="w-14 shrink-0 select-none border-r border-white/5 bg-[#18120f] px-3 py-5 text-right font-mono text-[12px] leading-7 text-white/20"
                        ></div>


                        {{-- TEXTAREA --}}

                        <textarea
                            id="codeEditor"
                            spellcheck="false"
                            autocomplete="off"
                            autocorrect="off"
                            autocapitalize="off"
                            class="min-w-[650px] flex-1 resize-none border-0 bg-transparent px-5 py-5 font-mono text-[12px] leading-7 text-white outline-none focus:ring-0"
                        ></textarea>

                    </div>

                </div>



                {{-- =================================================
                     OUTPUT
                ================================================== --}}

                <div
                    class="border-t border-white/5 bg-[#130f0d]"
                >

                    <div
                        class="flex items-center justify-between border-b border-white/5 px-5 py-3"
                    >

                        <div
                            class="flex items-center gap-3"
                        >

                            <div
                                class="flex items-center gap-1.5"
                            >

                                <span
                                    class="h-2 w-2 rounded-full bg-white/10"
                                ></span>

                                <span
                                    class="h-2 w-2 rounded-full bg-white/10"
                                ></span>

                                <span
                                    class="h-2 w-2 rounded-full bg-white/10"
                                ></span>

                            </div>


                            <span
                                class="text-[10px] font-extrabold uppercase tracking-wider text-white/50"
                            >
                                Output
                            </span>

                        </div>


                        <div
                            id="outputStatus"
                            class="flex items-center gap-2 text-[10px] font-bold text-white/30"
                        >

                            <span
                                class="h-1.5 w-1.5 rounded-full bg-gold-400"
                            ></span>

                            Belum dijalankan

                        </div>

                    </div>


                    <div
                        class="min-h-[150px] px-5 py-4"
                    >

                        <pre
                            id="outputContent"
                            class="whitespace-pre-wrap font-mono text-xs leading-6 text-white/70"
                        >Tekan "Jalankan" untuk melihat hasil program.</pre>

                    </div>

                </div>



                {{-- =================================================
                     FOOTER
                ================================================== --}}

                <div
                    class="flex flex-wrap items-center justify-between gap-3 border-t border-white/5 bg-[#1b1512] px-5 py-3"
                >

                    <div
                        class="flex items-center gap-4"
                    >

                        <span
                            class="flex items-center gap-1.5 text-[9px] text-white/30"
                        >

                            <span
                                class="h-1.5 w-1.5 rounded-full bg-gold-400"
                            ></span>

                            <span id="footerLanguage">
                                Java
                            </span>

                        </span>


                        <span
                            class="text-[9px] text-white/20"
                        >
                            UTF-8
                        </span>

                    </div>


                    <span
                        id="cursorPosition"
                        class="text-[9px] text-white/20"
                    >
                        Baris 1
                    </span>

                </div>

            </section>

        </div>

    </div>

</div>



{{-- =============================================================
     TOAST
============================================================== --}}

<div
    id="toast"
    class="pointer-events-none fixed bottom-6 right-6 z-[999] translate-y-4 rounded-2xl bg-maroon-900 px-5 py-3 text-xs font-bold text-white opacity-0 shadow-2xl transition-all duration-300"
>
    Berhasil
</div>



{{-- =============================================================
     JAVASCRIPT
============================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | DATA BAHASA
    |--------------------------------------------------------------------------
    */

    // Data latihan FR-011 yang dimuat oleh CodeEditorController dari tabel contoh_kode.
    const databaseExercises = @json($contohKodeList ?? []);

    const languages = {

        java: {

            name: 'Java',

            file: 'Main.java',

            label: 'Java Source File',

            title: 'Hello World',

            description:
                'Buat program sederhana untuk menampilkan tulisan "Hello World" pada console.',

            hint:
                'Gunakan System.out.println() untuk menampilkan tulisan ke console.',

            output:
                'Hello World',

            code:
`public class Main {

    public static void main(String[] args) {

        System.out.println("Hello World");

    }

}`

        },


        python: {

            name: 'Python',

            file: 'main.py',

            label: 'Python Source File',

            title: 'Hello World',

            description:
                'Buat program sederhana menggunakan Python untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan fungsi print() untuk menampilkan tulisan.',

            output:
                'Hello World',

            code:
`def main():

    print("Hello World")


if __name__ == "__main__":

    main()`

        },


        javascript: {

            name: 'JavaScript',

            file: 'main.js',

            label: 'JavaScript Source File',

            title: 'Hello World',

            description:
                'Buat program JavaScript sederhana untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan console.log() untuk menampilkan hasil.',

            output:
                'Hello World',

            code:
`function main() {

    console.log("Hello World");

}

main();`

        },


        php: {

            name: 'PHP',

            file: 'index.php',

            label: 'PHP Source File',

            title: 'Hello World',

            description:
                'Buat program PHP sederhana untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan echo untuk menampilkan tulisan.',

            output:
                'Hello World',

            code:
`<?php

echo "Hello World";

?>`

        },


        cpp: {

            name: 'C++',

            file: 'main.cpp',

            label: 'C++ Source File',

            title: 'Hello World',

            description:
                'Buat program C++ sederhana untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan cout untuk menampilkan output.',

            output:
                'Hello World',

            code:
`#include <iostream>

using namespace std;

int main() {

    cout << "Hello World" << endl;

    return 0;

}`

        },


        c: {

            name: 'C',

            file: 'main.c',

            label: 'C Source File',

            title: 'Hello World',

            description:
                'Buat program C sederhana untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan printf() untuk menampilkan output.',

            output:
                'Hello World',

            code:
`#include <stdio.h>

int main() {

    printf("Hello World\\n");

    return 0;

}`

        },


        csharp: {

            name: 'C#',

            file: 'Program.cs',

            label: 'C# Source File',

            title: 'Hello World',

            description:
                'Buat program C# sederhana untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan Console.WriteLine() untuk menampilkan output.',

            output:
                'Hello World',

            code:
`using System;

class Program {

    static void Main() {

        Console.WriteLine("Hello World");

    }

}`

        },


        dart: {

            name: 'Dart',

            file: 'main.dart',

            label: 'Dart Source File',

            title: 'Hello World',

            description:
                'Buat program Dart sederhana untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan print() untuk menampilkan hasil.',

            output:
                'Hello World',

            code:
`void main() {

    print("Hello World");

}`

        },


        go: {

            name: 'Go',

            file: 'main.go',

            label: 'Go Source File',

            title: 'Hello World',

            description:
                'Buat program Go sederhana untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan fmt.Println() untuk menampilkan output.',

            output:
                'Hello World',

            code:
`package main

import "fmt"

func main() {

    fmt.Println("Hello World")

}`

        },


        kotlin: {

            name: 'Kotlin',

            file: 'Main.kt',

            label: 'Kotlin Source File',

            title: 'Hello World',

            description:
                'Buat program Kotlin sederhana untuk menampilkan tulisan "Hello World".',

            hint:
                'Gunakan println() untuk menampilkan hasil.',

            output:
                'Hello World',

            code:
`fun main() {

    println("Hello World")

}`

        }

    };


    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const languageSelect =
        document.getElementById('languageSelect');

    const codeEditor =
        document.getElementById('codeEditor');

    const lineNumbers =
        document.getElementById('lineNumbers');

    const runButton =
        document.getElementById('runButton');

    const resetButton =
        document.getElementById('resetButton');

    const copyButton =
        document.getElementById('copyButton');

    const fullscreenButton =
        document.getElementById('fullscreenButton');

    const exerciseSelect =
        document.getElementById('exerciseSelect');

    const exerciseSourceHint =
        document.getElementById('exerciseSourceHint');

    const taskTitle =
        document.getElementById('taskTitle');

    const taskDescription =
        document.getElementById('taskDescription');

    const taskHint =
        document.getElementById('taskHint');

    const expectedOutput =
        document.getElementById('expectedOutput');

    const fileName =
        document.getElementById('fileName');

    const languageLabel =
        document.getElementById('languageLabel');

    const languageFooter =
        document.getElementById('footerLanguage');

    const outputContent =
        document.getElementById('outputContent');

    const outputStatus =
        document.getElementById('outputStatus');

    const cursorPosition =
        document.getElementById('cursorPosition');

    const toast =
        document.getElementById('toast');


    let currentLanguage =
        'java';


    /*
    |--------------------------------------------------------------------------
    | LINE NUMBER
    |--------------------------------------------------------------------------
    */

    function updateLineNumbers() {

        const totalLines =
            codeEditor.value.split('\n').length;


        let html = '';


        for (
            let i = 1;
            i <= totalLines;
            i++
        ) {

            html += `${i}<br>`;

        }


        lineNumbers.innerHTML =
            html;

    }


    /*
    |--------------------------------------------------------------------------
    | CURSOR
    |--------------------------------------------------------------------------
    */

    function updateCursor() {

        const beforeCursor =
            codeEditor.value.substring(
                0,
                codeEditor.selectionStart
            );


        const line =
            beforeCursor.split('\n').length;


        cursorPosition.textContent =
            `Baris ${line}`;

    }


    /*
    |--------------------------------------------------------------------------
    | APPLY CURRENT EXERCISE / LANGUAGE
    |--------------------------------------------------------------------------
    */

    function resetOutputState() {
        outputContent.textContent = 'Tekan "Jalankan" untuk melihat hasil program.';
        outputStatus.innerHTML = `
            <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
            Belum dijalankan
        `;
    }

    function applyBuiltinLanguage(language, notify = false) {
        const data = languages[language];
        if (!data) return;

        currentLanguage = language;
        languageSelect.value = language;
        codeEditor.value = data.code;
        taskTitle.textContent = data.title;
        taskDescription.textContent = data.description;
        taskHint.textContent = data.hint;
        expectedOutput.textContent = data.output;
        fileName.textContent = data.file;
        languageLabel.textContent = data.label;
        languageFooter.textContent = data.name;
        exerciseSourceHint.textContent = 'Menggunakan contoh bawaan Code Lab. Pilih latihan dari Instruktur bila tersedia.';
        resetOutputState();
        updateLineNumbers();
        updateCursor();

        if (notify) showToast(`${data.name} dipilih`);
    }

    function applyDatabaseExercise(exercise, notify = true) {
        if (!exercise) {
            applyBuiltinLanguage(currentLanguage);
            return;
        }

        const data = languages[exercise.language];
        if (!data) return;

        currentLanguage = exercise.language;
        languageSelect.value = exercise.language;
        codeEditor.value = exercise.code || '';
        taskTitle.textContent = exercise.title || 'Latihan Code Lab';
        taskDescription.textContent = exercise.description || 'Latihan pemrograman yang disiapkan oleh Instruktur.';
        taskHint.textContent = 'Latihan ini berasal dari database. Pelajari instruksi, ubah kode jika diperlukan, lalu klik Jalankan.';
        expectedOutput.textContent = (typeof exercise.expected_output === 'string' && exercise.expected_output.trim() !== '')
            ? exercise.expected_output
            : 'Tidak ditentukan oleh Instruktur';
        fileName.textContent = data.file;
        languageLabel.textContent = data.label;
        languageFooter.textContent = data.name;

        const materialText = exercise.material_title ? `Materi: ${exercise.material_title}. ` : '';
        exerciseSourceHint.textContent = `${materialText}Kode awal dimuat dari latihan yang dibuat Instruktur.`;
        resetOutputState();
        updateLineNumbers();
        updateCursor();

        if (notify) showToast('Latihan Instruktur berhasil dimuat');
    }

    function renderExercisesForLanguage(language, preferredId = null) {
        const data = languages[language];
        if (!data) return;

        const matching = databaseExercises.filter(item => item && item.language === language);
        exerciseSelect.replaceChildren();
        exerciseSelect.add(new Option(`Contoh bawaan — ${data.title}`, ''));

        matching.forEach(item => {
            const label = item.material_title
                ? `${item.title} — ${item.material_title}`
                : `${item.title} — ${item.language_name}`;
            exerciseSelect.add(new Option(label, String(item.id)));
        });

        const preferredExists = preferredId !== null && matching.some(item => String(item.id) === String(preferredId));
        const selectedId = preferredExists ? String(preferredId) : (matching.length ? String(matching[0].id) : '');
        exerciseSelect.value = selectedId;

        if (selectedId) {
            const selected = matching.find(item => String(item.id) === selectedId);
            applyDatabaseExercise(selected, false);
        } else {
            applyBuiltinLanguage(language, false);
            if (matching.length === 0) {
                exerciseSourceHint.textContent = 'Belum ada latihan Instruktur untuk bahasa ini. Kamu tetap bisa mencoba contoh bawaan.';
            }
        }
    }

    function loadLanguage(language) {
        if (!languages[language]) return;
        currentLanguage = language;
        renderExercisesForLanguage(language);
        showToast(`${languages[language].name} dipilih`);
    }

    /*
    |--------------------------------------------------------------------------
    | LANGUAGE / EXERCISE CHANGE
    |--------------------------------------------------------------------------
    */

    languageSelect.addEventListener('change', function () {
        loadLanguage(this.value);
    });

    exerciseSelect.addEventListener('change', function () {
        const selectedId = this.value;
        if (!selectedId) {
            applyBuiltinLanguage(currentLanguage, true);
            return;
        }

        const exercise = databaseExercises.find(item => String(item.id) === String(selectedId));
        if (exercise) applyDatabaseExercise(exercise, true);
    });


        /*
    |--------------------------------------------------------------------------
    | CODE INPUT
    |--------------------------------------------------------------------------
    */

    codeEditor.addEventListener(
        'input',
        function () {

            updateLineNumbers();

            updateCursor();

        }
    );


    codeEditor.addEventListener(
        'click',
        updateCursor
    );


    codeEditor.addEventListener(
        'keyup',
        updateCursor
    );


    /*
    |--------------------------------------------------------------------------
    | SCROLL LINE NUMBER
    |--------------------------------------------------------------------------
    */

    codeEditor.addEventListener(
        'scroll',
        function () {

            lineNumbers.scrollTop =
                codeEditor.scrollTop;

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TAB KEY
    |--------------------------------------------------------------------------
    */

    codeEditor.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Tab'
            ) {

                event.preventDefault();


                const start =
                    this.selectionStart;


                const end =
                    this.selectionEnd;


                this.value =
                    this.value.substring(
                        0,
                        start
                    )
                    +
                    '    '
                    +
                    this.value.substring(
                        end
                    );


                this.selectionStart =
                    this.selectionEnd =
                    start + 4;


                updateLineNumbers();

            }


            /*
            | CTRL + ENTER
            */

            if (
                event.ctrlKey &&
                event.key === 'Enter'
            ) {

                event.preventDefault();

                runCode();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RUN
    |--------------------------------------------------------------------------
    */

    runButton.addEventListener(
        'click',
        runCode
    );


    async function runCode() {

        const code = codeEditor.value.trim();

        if (!code) {
            outputContent.textContent = 'Error: Source code masih kosong.';
            outputStatus.innerHTML = `
                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                Error
            `;
            return;
        }

        const originalButtonContent = runButton.innerHTML;
        runButton.disabled = true;
        runButton.innerHTML = `
            <svg class="h-3.5 w-3.5 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="9" class="opacity-30" />
                <path d="M21 12a9 9 0 0 0-9-9" />
            </svg>
            Menjalankan...
        `;

        outputContent.textContent = `Mengirim ${languages[currentLanguage].file} ke layanan eksekusi...`;
        outputStatus.innerHTML = `
            <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-gold-400"></span>
            Sedang dijalankan
        `;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            const response = await fetch('{{ route('code-editor.execute') }}', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    language: currentLanguage,
                    code: codeEditor.value,
                    stdin: ''
                })
            });

            let data;
            try {
                data = await response.json();
            } catch (parseError) {
                throw new Error('Respons server tidak dapat dibaca. Muat ulang halaman lalu coba lagi.');
            }

            if (!response.ok || data.ok === false) {
                throw new Error(data.message || `Permintaan eksekusi gagal (HTTP ${response.status}).`);
            }

            const sections = [];
            if (typeof data.stdout === 'string' && data.stdout.length > 0) {
                sections.push(data.stdout.replace(/\s+$/, ''));
            }
            if (typeof data.compile_output === 'string' && data.compile_output.trim()) {
                sections.push('OUTPUT KOMPILASI:\n' + data.compile_output.trim());
            }
            if (typeof data.stderr === 'string' && data.stderr.trim()) {
                sections.push('STDERR:\n' + data.stderr.trim());
            }
            if (typeof data.message === 'string' && data.message.trim()) {
                sections.push('INFO:\n' + data.message.trim());
            }
            if (data.time) {
                sections.push(`Waktu eksekusi: ${data.time} detik`);
            }
            if (sections.length === 0) {
                sections.push('Program selesai tanpa output teks.');
            }

            outputContent.textContent =
                `$ ${languages[currentLanguage].file}\n\n` +
                sections.join('\n\n') +
                `\n\nStatus: ${data.runner_status || (data.status === 'success' ? 'Accepted' : 'Selesai dengan error')}`;

            const succeeded = data.status === 'success';
            outputStatus.innerHTML = `
                <span class="h-1.5 w-1.5 rounded-full ${succeeded ? 'bg-green-500' : 'bg-red-500'}"></span>
                ${succeeded ? 'Berhasil' : 'Perlu diperiksa'}
            `;

            showToast(succeeded ? 'Program berhasil dijalankan' : 'Program selesai dengan error');

        } catch (error) {
            outputContent.textContent =
                'Tidak dapat menjalankan program.\n\n' +
                (error?.message || 'Layanan eksekusi sedang tidak tersedia. Coba kembali nanti.');

            outputStatus.innerHTML = `
                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                Gagal
            `;

            showToast('Eksekusi gagal');

        } finally {
            runButton.disabled = false;
            runButton.innerHTML = originalButtonContent;
        }

    }



    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    resetButton.addEventListener(
        'click',
        function () {

            const data =
                languages[currentLanguage];

            const selectedExercise = exerciseSelect.value
                ? databaseExercises.find(item => String(item.id) === String(exerciseSelect.value))
                : null;

            codeEditor.value = selectedExercise
                ? (selectedExercise.code || '')
                : data.code;


            outputContent.textContent =
                'Tekan "Jalankan" untuk melihat hasil program.';


            outputStatus.innerHTML = `

                <span
                    class="h-1.5 w-1.5 rounded-full bg-gold-400"
                ></span>

                Belum dijalankan

            `;


            updateLineNumbers();

            updateCursor();


            showToast(
                'Kode berhasil di-reset'
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | COPY
    |--------------------------------------------------------------------------
    */

    copyButton.addEventListener(
        'click',
        async function () {

            try {

                await navigator.clipboard.writeText(
                    codeEditor.value
                );


                showToast(
                    'Kode berhasil disalin'
                );

            }

            catch (error) {

                codeEditor.select();

                document.execCommand(
                    'copy'
                );


                showToast(
                    'Kode berhasil disalin'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FULLSCREEN
    |--------------------------------------------------------------------------
    */

    fullscreenButton.addEventListener(
        'click',
        function () {

            const editor =
                document.getElementById(
                    'editorFullscreen'
                );


            if (
                !document.fullscreenElement
            ) {

                editor.requestFullscreen();

            }

            else {

                document.exitFullscreen();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TOAST
    |--------------------------------------------------------------------------
    */

    let toastTimer;


    function showToast(message) {

        toast.textContent =
            message;


        toast.classList.remove(
            'opacity-0',
            'translate-y-4'
        );


        toast.classList.add(
            'opacity-100',
            'translate-y-0'
        );


        clearTimeout(
            toastTimer
        );


        toastTimer =
            setTimeout(
                function () {

                    toast.classList.add(
                        'opacity-0',
                        'translate-y-4'
                    );


                    toast.classList.remove(
                        'opacity-100',
                        'translate-y-0'
                    );

                },
                2200
            );

    }


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    loadLanguage(
        'java'
    );

});

</script>



{{-- =============================================================
     STYLE
============================================================== --}}

<style>

    /*
    |--------------------------------------------------------------------------
    | SCROLLBAR
    |--------------------------------------------------------------------------
    */

    #codeEditor::-webkit-scrollbar,
    #lineNumbers::-webkit-scrollbar {

        width: 8px;

        height: 8px;

    }


    #codeEditor::-webkit-scrollbar-track,
    #lineNumbers::-webkit-scrollbar-track {

        background: #18120f;

    }


    #codeEditor::-webkit-scrollbar-thumb,
    #lineNumbers::-webkit-scrollbar-thumb {

        background: rgba(255,255,255,.12);

        border-radius: 999px;

    }


    #codeEditor::-webkit-scrollbar-thumb:hover {

        background: rgba(212,175,55,.35);

    }


    /*
    |--------------------------------------------------------------------------
    | SELECTION
    |--------------------------------------------------------------------------
    */

    #codeEditor::selection {

        background: rgba(212,175,55,.25);

    }


    /*
    |--------------------------------------------------------------------------
    | FULLSCREEN
    |--------------------------------------------------------------------------
    */

    #editorFullscreen:fullscreen {

        width: 100vw;

        height: 100vh;

        background: #1b1512;

    }


    #editorFullscreen:fullscreen > div {

        height: calc(100vh - 0px);

    }


    /*
    |--------------------------------------------------------------------------
    | MOBILE
    |--------------------------------------------------------------------------
    */

    @media (max-width: 640px) {

        #codeEditor {

            min-width: 600px;

        }

    }

</style>

@endsection
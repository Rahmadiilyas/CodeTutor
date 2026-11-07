<!DOCTYPE html>

<html lang="id">

<head>
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Masuk CodeTutor
    </title>

    <meta
        name="description"
        content="Masuk ke akun CodeTutor untuk melanjutkan pembelajaran coding."
    >


    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>


    {{-- Tailwind Configuration --}}
    <script>

        tailwind.config = {

            theme: {

                extend: {

                    colors: {

                        maroon: {

                            950: '#24040D',
                            900: '#330711',
                            800: '#470B18',
                            700: '#5E1022',
                            600: '#74172B',
                            500: '#8C223A',
                            400: '#A2384E',

                        },

                        gold: {

                            300: '#F3D98E',
                            400: '#E7C568',
                            500: '#D6AD45',
                            600: '#B98D2E',

                        },

                        warm: {

                            50: '#FFFCF8',
                            100: '#FBF5EC',
                            200: '#F4EBDD',

                        }

                    },


                    fontFamily: {

                        sans: [
                            'DM Sans',
                            'sans-serif'
                        ],

                        display: [
                            'Plus Jakarta Sans',
                            'sans-serif'
                        ],

                    },


                    boxShadow: {

                        maroon:
                            '0 24px 65px rgba(51, 7, 17, .20)',

                        gold:
                            '0 12px 30px rgba(214, 173, 69, .20)',

                    },


                    backgroundImage: {

                        'maroon-grid':
                            'linear-gradient(rgba(231,197,104,.055) 1px, transparent 1px), linear-gradient(90deg, rgba(231,197,104,.055) 1px, transparent 1px)',

                    }

                }

            }

        }

    </script>


    {{-- Google Font --}}

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- Devicon --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css"
    >


    <style>

        * {
            box-sizing: border-box;
        }


        html,
        body {

            margin: 0;

            min-height: 100%;

        }


        body {

            font-family:
                'DM Sans',
                sans-serif;

        }


        /* =====================================================
           LOGIN VISUAL
        ====================================================== */

        /* =====================================================
           HERO VISUAL — diselaraskan dengan halaman Guest
        ====================================================== */
        .login-visual {
            position: relative;
            isolation: isolate;
            width: 100%;
            min-height: 500px;
            overflow: visible;
        }

        .visual-glow {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 340px;
            height: 340px;
            border-radius: 9999px;
            background: rgba(231, 197, 104, .11);
            filter: blur(85px);
            transform: translate(-50%, -50%);
            animation: pulseGlow 4s ease-in-out infinite;
        }

        .orbit-ring {
            position: absolute;
            left: 50%;
            top: 50%;
            border: 1px solid rgba(231, 197, 104, .14);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 1;
        }

        .ring-a { width: 490px; height: 260px; transform: translate(-50%, -50%) rotate(-10deg); }
        .ring-b { width: 420px; height: 225px; transform: translate(-50%, -50%) rotate(22deg); border-color: rgba(231, 197, 104, .08); }
        .orbit-layer { position: absolute; inset: 0; pointer-events: none; }
        .orbit-back { z-index: 10; }
        .orbit-front { z-index: 50; }

        .program-logo {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 66px;
            height: 72px;
            will-change: transform, opacity;
        }

        .program-logo-card {
            display: flex;
            width: 66px;
            height: 72px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            border: 1px solid rgba(231, 197, 104, .24);
            border-radius: 15px;
            background: linear-gradient(145deg, rgba(82, 13, 31, .97), rgba(36, 4, 13, .99));
            box-shadow: 0 15px 32px rgba(0, 0, 0, .30), inset 0 1px 0 rgba(255, 255, 255, .06);
            backdrop-filter: blur(8px);
        }

        .program-logo-card i { font-size: 24px; line-height: 1; }
        .program-logo-card span { color: rgba(255, 255, 255, .68); font-size: 8px; font-weight: 800; white-space: nowrap; }

        .laptop-wrapper {
            position: relative;
            z-index: 20;
            width: 390px;
            transform: translateY(8px);
            filter: drop-shadow(0 28px 40px rgba(0, 0, 0, .28));
        }

        .laptop-screen {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 19px 19px 10px 10px;
            background: #171214;
            box-shadow: 0 28px 58px rgba(0, 0, 0, .42), 0 0 0 6px rgba(255, 255, 255, .02), inset 0 1px 0 rgba(255, 255, 255, .05);
        }

        .laptop-screen::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(125deg, rgba(255, 255, 255, .08), transparent 28%, transparent 75%, rgba(231, 197, 104, .03));
        }

        .laptop-topbar {
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 13px;
            border-bottom: 1px solid rgba(255, 255, 255, .055);
            background: #21191c;
        }

        .laptop-editor {
            display: grid;
            grid-template-columns: 36px 1fr;
            min-height: 260px;
            font-family: Consolas, Monaco, monospace;
            font-size: 10px;
            line-height: 1.9;
        }

        .editor-line-numbers {
            padding: 15px 8px 15px 0;
            border-right: 1px solid rgba(255, 255, 255, .05);
            text-align: right;
            color: rgba(255, 255, 255, .15);
        }

        .editor-code { padding: 15px 13px; color: rgba(255, 255, 255, .86); }
        .laptop-output { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 10px 12px; border-top: 1px solid rgba(255, 255, 255, .055); background: #20181b; }

        .laptop-base {
            position: relative;
            width: 106%;
            height: 88px;
            margin-left: -3%;
            border: 1px solid rgba(255, 255, 255, .09);
            border-top: 0;
            border-radius: 0 0 28px 28px;
            background: linear-gradient(180deg, #4e3b32 0%, #302723 56%, #181617 100%);
            box-shadow: 0 20px 30px rgba(0, 0, 0, .26);
            transform: perspective(800px) rotateX(49deg);
            transform-origin: top center;
        }

        .laptop-keyboard { position: absolute; left: 10%; right: 10%; top: 9px; padding: 8px; border-radius: 11px; background: rgba(18, 16, 16, .44); }
        .keyboard-row { display: flex; gap: 4px; margin-bottom: 4px; }
        .keyboard-row span { flex: 1; height: 5px; border-radius: 2px; background: rgba(240, 220, 188, .24); }
        .keyboard-space { justify-content: center; }
        .keyboard-space span { max-width: 32px; }
        .laptop-trackpad { position: absolute; left: 36%; right: 36%; bottom: 9px; height: 14px; border: 1px solid rgba(255, 255, 255, .08); border-radius: 5px; background: rgba(255, 255, 255, .025); }
        .laptop-pedestal { width: 70%; height: 20px; margin: -5px auto 0; border-radius: 9999px; background: linear-gradient(180deg, rgba(215, 173, 69, .42), rgba(215, 173, 69, .06)); box-shadow: 0 0 18px rgba(215, 173, 69, .20), 0 0 35px rgba(215, 173, 69, .08); }

        @media (max-width: 1200px) {
            .ring-a { width: 435px; height: 235px; }
            .ring-b { width: 380px; height: 205px; }
            .laptop-wrapper { width: 360px; }
        }

        @media (max-height: 820px) and (min-width: 1024px) {
            .login-visual { min-height: 420px; }
            .laptop-wrapper { width: 340px; }
            .laptop-editor { min-height: 220px; }
        }

        @media (max-width: 640px) {
            .program-logo, .program-logo-card { width: 52px; height: 58px; }
            .program-logo-card i { font-size: 19px; }
            .program-logo-card span { font-size: 7px; }
            .laptop-wrapper { width: 310px; }
            .laptop-editor { min-height: 205px; font-size: 8px; }
            .laptop-topbar { height: 34px; }
            .laptop-base { height: 70px; }
        }

        /* =====================================================
           ANIMATION
        ====================================================== */

        @keyframes pulseGlow {

            0%,
            100% {

                transform:
                    translate(-50%, -50%)
                    scale(.94);

                opacity: .60;

            }

            50% {

                transform:
                    translate(-50%, -50%)
                    scale(1.06);

                opacity: 1;

            }

        }


        /* =====================================================
           LOGIN FORM
        ====================================================== */

        .login-form-card {

            box-shadow:

                0 24px 65px
                rgba(51, 7, 17, .20),

                0 0 0 1px
                rgba(255,255,255,.03);

        }


        .login-form-card input:focus {

            transform:
                translateY(-1px);

        }


        /* =====================================================
           FEATURE CARD
        ====================================================== */

        .login-feature-card {

            min-height: 72px;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1023px) {

            .login-visual {

                display: none;

            }

        }


        @media (min-width: 1024px) {

            .login-visual {

                height: 300px;

            }

            .mini-laptop {

                width: 255px;

            }

            .mini-code {

                min-height: 145px;

            }

            .orbit-ring.one {

                width: 330px;

                height: 175px;

            }

            .orbit-ring.two {

                width: 405px;

                height: 220px;

            }

            .orbit-ring.three {

                width: 470px;

                height: 265px;

            }

            .orbit-logo {

                width: 52px;

                height: 52px;

            }

        }


        @media (max-height: 760px) and (min-width: 1024px) {

            .login-visual {

                height: 255px;

                margin-top: .75rem;

            }

            .mini-laptop {

                width: 220px;

            }

            .mini-code {

                min-height: 120px;

                font-size: 7px;

            }

            .orbit-ring.one {

                width: 290px;

                height: 150px;

            }

            .orbit-ring.two {

                width: 350px;

                height: 190px;

            }

            .orbit-ring.three {

                width: 405px;

                height: 230px;

            }

            .orbit-logo {

                width: 46px;

                height: 46px;

            }

        }


        @media (max-width: 640px) {

            .login-form-card {

                border-radius: 22px;

            }

        }


        @media (prefers-reduced-motion: reduce) {

            .visual-glow {

                animation: none;

            }

        }

    </style>

</head>


<body
    class="min-h-screen overflow-x-hidden
    overflow-y-auto bg-warm-50 font-sans
    text-slate-800 antialiased"
>


    <main
        class="relative min-h-screen overflow-hidden
        bg-gradient-to-br from-maroon-950
        via-maroon-900 to-maroon-700"
    >


        {{-- =================================================
             BACKGROUND
        ================================================== --}}

        <div
            class="absolute inset-0 bg-maroon-grid
            bg-[size:56px_56px] opacity-70"
        ></div>


        <div
            class="absolute -left-36 -top-32
            h-[500px] w-[500px]
            rounded-full border
            border-gold-400/10"
        ></div>


        <div
            class="absolute -bottom-40 -right-40
            h-[560px] w-[560px]
            rounded-full border
            border-gold-400/10"
        ></div>


        <div
            class="absolute left-[18%] top-[18%]
            h-40 w-40 rounded-full
            bg-gold-500/10 blur-3xl"
        ></div>


        <div
            class="absolute bottom-[14%] right-[15%]
            h-48 w-48 rounded-full
            bg-gold-500/10 blur-3xl"
        ></div>


        <div
            class="relative z-10 mx-auto flex min-h-screen
            max-w-7xl items-center px-4 py-8
            sm:px-6 lg:px-8 lg:py-10"
        >


            <div
                class="grid w-full items-center gap-10
                lg:grid-cols-[minmax(0,1fr)_430px]"
            >


                {{-- =================================================
                     LEFT SIDE
                ================================================== --}}

                <section class="hidden lg:block">

                    <div class="max-w-xl">


                        {{-- BRAND --}}

                        <a
                            href="{{ url('/') }}"
                            class="inline-flex items-center gap-3"
                        >

                            <span
                                class="grid h-11 w-11
                                place-items-center rounded-xl
                                border border-gold-400/25
                                bg-white/[.06]
                                text-gold-400"
                            >

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="m8 8-4 4 4 4"/>
                                    <path d="m16 8 4 4-4 4"/>
                                    <path d="m14 4-4 16"/>
                                </svg>

                            </span>


                            <span
                                class="font-display text-xl
                                font-extrabold tracking-tight
                                text-white"
                            >
                                Code
                                <span class="text-gold-400">
                                    Tutor
                                </span>
                            </span>

                        </a>


                        {{-- TITLE --}}

                        <p
                            class="mt-7 text-xs font-extrabold
                            uppercase tracking-[.2em]
                            text-gold-400"
                        >
                            Selamat Datang Kembali
                        </p>


                        <h1
                            class="mt-4 font-display text-4xl
                            font-extrabold leading-[1.08]
                            tracking-[-1.8px] text-white
                            xl:text-5xl"
                        >

                            Lanjutkan perjalanan

                            <span class="text-gold-400">
                                coding
                            </span>

                            kamu.

                        </h1>


                        <p
                            class="mt-4 max-w-lg
                            text-sm leading-6 text-white/60"
                        >
                            Masuk ke CodeTutor untuk melanjutkan
                            materi, mengerjakan latihan, mencoba
                            source code, dan melihat perkembangan
                            belajar kamu.
                        </p>


                        {{-- ANIMATED CODE EDITOR — visual mengikuti halaman Guest --}}
                        <div class="login-visual mt-3 flex items-center justify-center">
                            <div class="absolute h-[340px] w-[340px] rounded-full bg-gold-500/10 blur-[85px]"></div>
                            <div class="orbit-ring ring-a"></div>
                            <div class="orbit-ring ring-b"></div>

                            @php
                                $orbitLanguages = [
                                    ['icon' => 'devicon-python-plain', 'name' => 'Python', 'angle' => 0],
                                    ['icon' => 'devicon-javascript-plain', 'name' => 'JavaScript', 'angle' => 40],
                                    ['icon' => 'devicon-java-plain', 'name' => 'Java', 'angle' => 80],
                                    ['icon' => 'devicon-html5-plain', 'name' => 'HTML', 'angle' => 120],
                                    ['icon' => 'devicon-css3-plain', 'name' => 'CSS', 'angle' => 160],
                                    ['icon' => 'devicon-mysql-plain', 'name' => 'SQL', 'angle' => 200],
                                    ['icon' => 'devicon-cplusplus-plain', 'name' => 'C++', 'angle' => 240],
                                    ['icon' => 'devicon-csharp-plain', 'name' => 'C#', 'angle' => 280],
                                    ['icon' => 'devicon-php-plain', 'name' => 'PHP', 'angle' => 320],
                                ];
                            @endphp

                            <div id="orbitBack" class="orbit-layer orbit-back">
                                @foreach ($orbitLanguages as $language)
                                    <div class="program-logo" data-angle="{{ $language['angle'] }}">
                                        <div class="program-logo-card">
                                            <i class="{{ $language['icon'] }} colored"></i>
                                            <span>{{ $language['name'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="laptop-wrapper">
                                <div class="laptop-screen">
                                    <div class="laptop-topbar">
                                        <div class="flex gap-1.5">
                                            <span class="h-2.5 w-2.5 rounded-full bg-red-400/60"></span>
                                            <span class="h-2.5 w-2.5 rounded-full bg-gold-400/70"></span>
                                            <span class="h-2.5 w-2.5 rounded-full bg-green-400/60"></span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="rounded-md bg-white/5 px-2 py-1 text-[8px] font-semibold text-white/40">PYTHON</span>
                                            <span class="font-mono text-[10px] text-white/35">main.py</span>
                                        </div>
                                    </div>

                                    <div class="laptop-editor">
                                        <div class="editor-line-numbers">1<br>2<br>3<br>4<br>5<br>6<br>7<br>8<br>9<br>10</div>
                                        <div class="editor-code">
                                            <div><span class="text-gold-400">def</span> <span class="text-purple-300">sapa</span>(<span class="text-pink-300">nama</span>):</div>
                                            <div class="pl-5"><span class="text-gold-300">return</span> <span class="text-green-300">f"Hello, {nama}"</span></div>
                                            <div>&nbsp;</div>
                                            <div><span class="text-pink-300">nama</span> <span class="text-white/30">=</span> <span class="text-green-300">"World"</span></div>
                                            <div><span class="text-purple-300">print</span>(<span class="text-purple-300">sapa</span>(<span class="text-pink-300">nama</span>))</div>
                                            <div>&nbsp;</div>
                                            <div class="text-white/25"># Belajar → Latihan → Test</div>
                                            <div>&nbsp;</div>
                                            <div class="text-gold-300"><span class="text-purple-300">print</span>(<span class="text-green-300">"Ready to learn!"</span>)</div>
                                        </div>
                                    </div>

                                    <div class="laptop-output">
                                        <div class="flex items-center gap-2 text-[10px] font-bold text-green-300">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>
                                            Output berhasil
                                        </div>
                                        <span class="rounded-lg bg-gold-400 px-2.5 py-1.5 text-[9px] font-extrabold text-maroon-950 shadow-gold">Run Code</span>
                                    </div>
                                </div>

                                <div class="laptop-base">
                                    <div class="laptop-keyboard">
                                        @for ($r = 0; $r < 4; $r++)
                                            <div class="keyboard-row">
                                                @for ($k = 0; $k < 11; $k++)<span></span>@endfor
                                            </div>
                                        @endfor
                                        <div class="keyboard-row keyboard-space"><span></span><span></span><span></span><span></span><span></span></div>
                                    </div>
                                    <div class="laptop-trackpad"></div>
                                </div>
                                <div class="laptop-pedestal"></div>
                            </div>

                            <div id="orbitFront" class="orbit-layer orbit-front">
                                @foreach ($orbitLanguages as $language)
                                    <div class="program-logo" data-angle="{{ $language['angle'] }}">
                                        <div class="program-logo-card">
                                            <i class="{{ $language['icon'] }} colored"></i>
                                            <span>{{ $language['name'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        {{-- FEATURE CARD --}}

                        <div
                            class="mt-4 grid max-w-[600px]
                            grid-cols-3 gap-3"
                        >


                            <div
                                class="login-feature-card
                                rounded-2xl border
                                border-white/10
                                bg-white/[.045] p-3.5
                                backdrop-blur-md transition
                                hover:-translate-y-0.5
                                hover:border-gold-400/20
                                hover:bg-white/[.065]"
                            >

                                <div
                                    class="flex items-center gap-2.5"
                                >

                                    <span
                                        class="grid h-8 w-8
                                        shrink-0
                                        place-items-center
                                        rounded-lg
                                        bg-gold-400/10
                                        text-gold-400"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <path
                                                d="M4 19.5A2.5
                                                2.5 0 0 1
                                                6.5 17H20"
                                            />

                                            <path
                                                d="M6.5 2H20v20H6.5
                                                A2.5 2.5 0 0 1
                                                4 19.5v-15A2.5
                                                2.5 0 0 1
                                                6.5 2Z"
                                            />

                                        </svg>

                                    </span>


                                    <div class="min-w-0">

                                        <p
                                            class="text-[11px]
                                            font-extrabold text-white"
                                        >
                                            10+ Bahasa
                                        </p>

                                        <p
                                            class="mt-0.5 text-[9px]
                                            text-white/40"
                                        >
                                            Python, Java, PHP &
                                            lainnya
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div
                                class="login-feature-card
                                rounded-2xl border
                                border-white/10
                                bg-white/[.045] p-3.5
                                backdrop-blur-md transition
                                hover:-translate-y-0.5
                                hover:border-gold-400/20
                                hover:bg-white/[.065]"
                            >

                                <div
                                    class="flex items-center gap-2.5"
                                >

                                    <span
                                        class="grid h-8 w-8
                                        shrink-0 place-items-center
                                        rounded-lg
                                        bg-gold-400/10
                                        text-gold-400"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <path
                                                d="M8 6h13M8 12h13
                                                M8 18h13"
                                            />

                                            <path
                                                d="M3 6h.01M3 12h.01
                                                M3 18h.01"
                                            />

                                        </svg>

                                    </span>


                                    <div class="min-w-0">

                                        <p
                                            class="text-[11px]
                                            font-extrabold text-white"
                                        >
                                            Latihan Interaktif
                                        </p>

                                        <p
                                            class="mt-0.5 text-[9px]
                                            text-white/40"
                                        >
                                            Soal, practice & evaluasi
                                        </p>

                                    </div>

                                </div>

                            </div>


                            <div
                                class="login-feature-card
                                rounded-2xl border
                                border-white/10
                                bg-white/[.045] p-3.5
                                backdrop-blur-md transition
                                hover:-translate-y-0.5
                                hover:border-gold-400/20
                                hover:bg-white/[.065]"
                            >

                                <div
                                    class="flex items-center gap-2.5"
                                >

                                    <span
                                        class="grid h-8 w-8
                                        shrink-0 place-items-center
                                        rounded-lg
                                        bg-gold-400/10
                                        text-gold-400"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <path d="m8 8-4 4 4 4"/>

                                            <path
                                                d="m16 8 4-4 4 4"
                                            />

                                            <path
                                                d="m14 4-4 16"
                                            />

                                        </svg>

                                    </span>


                                    <div class="min-w-0">

                                        <p
                                            class="text-[11px]
                                            font-extrabold text-white"
                                        >
                                            Code Editor
                                        </p>

                                        <p
                                            class="mt-0.5 text-[9px]
                                            text-white/40"
                                        >
                                            Tulis & jalankan source code
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                     MOBILE VISUAL
                ================================================== --}}

                <div class="mb-5 lg:hidden">

                    <div
                        class="relative mx-auto h-32
                        w-full max-w-sm overflow-hidden
                        rounded-2xl border border-white/10
                        bg-white/[.04]"
                    >

                        <div
                            class="absolute inset-0
                            bg-maroon-grid
                            bg-[size:28px_28px]
                            opacity-50"
                        ></div>


                        <div
                            class="absolute left-1/2
                            top-1/2 z-20 w-40
                            -translate-x-1/2
                            -translate-y-1/2"
                        >

                            <div
                                class="overflow-hidden rounded-xl
                                border border-white/10
                                bg-[#151113] shadow-2xl"
                            >

                                <div
                                    class="flex h-5 items-center
                                    justify-between
                                    bg-[#21191c] px-2"
                                >

                                    <div class="flex gap-1">

                                        <span
                                            class="h-1 w-1 rounded-full
                                            bg-red-400/60"
                                        ></span>

                                        <span
                                            class="h-1 w-1 rounded-full
                                            bg-gold-400/60"
                                        ></span>

                                        <span
                                            class="h-1 w-1 rounded-full
                                            bg-green-400/60"
                                        ></span>

                                    </div>

                                    <span
                                        class="font-mono text-[5px]
                                        text-white/35"
                                    >
                                        main.py
                                    </span>

                                </div>


                                <div
                                    class="px-3 py-3
                                    font-mono text-[6px]
                                    leading-4 text-white/70"
                                >

                                    <div>

                                        <span class="text-gold-400">
                                            def
                                        </span>

                                        <span class="text-purple-300">
                                            learn
                                        </span>

                                        ():

                                    </div>


                                    <div
                                        class="pl-2 text-green-300"
                                    >
                                        return "Keep learning"
                                    </div>


                                    <div
                                        class="mt-1 text-white/25"
                                    >
                                        # Code • Practice • Test
                                    </div>

                                </div>

                            </div>


                            <div
                                class="mx-auto -mt-1 h-4
                                w-[108%] -translate-x-[4%]
                                rounded-b-lg
                                bg-gradient-to-b
                                from-[#59443a]
                                to-[#24201e]"
                            ></div>

                        </div>


                        <div
                            class="absolute left-[8%] top-[18%]
                            grid h-8 w-8 place-items-center
                            rounded-lg border
                            border-gold-400/20
                            bg-maroon-800/80 text-base
                            shadow-xl backdrop-blur"
                        >
                            <i
                                class="devicon-python-plain colored"
                            ></i>
                        </div>


                        <div
                            class="absolute right-[8%] top-[16%]
                            grid h-8 w-8 place-items-center
                            rounded-lg border
                            border-gold-400/20
                            bg-maroon-800/80 text-base
                            shadow-xl backdrop-blur"
                        >
                            <i
                                class="devicon-javascript-plain colored"
                            ></i>
                        </div>


                        <div
                            class="absolute left-[8%] bottom-[14%]
                            grid h-8 w-8 place-items-center
                            rounded-lg border
                            border-gold-400/20
                            bg-maroon-800/80 text-base
                            shadow-xl backdrop-blur"
                        >
                            <i
                                class="devicon-java-plain colored"
                            ></i>
                        </div>


                        <div
                            class="absolute right-[8%] bottom-[14%]
                            grid h-8 w-8 place-items-center
                            rounded-lg border
                            border-gold-400/20
                            bg-maroon-800/80 text-base
                            shadow-xl backdrop-blur"
                        >
                            <i
                                class="devicon-html5-plain colored"
                            ></i>
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     LOGIN FORM
                ================================================== --}}

                <section
                    class="mx-auto w-full max-w-md"
                >


                    {{-- MOBILE BRAND --}}

                    <div
                        class="mb-5 text-center lg:hidden"
                    >

                        <a
                            href="{{ url('/') }}"
                            class="inline-flex items-center gap-3"
                        >

                            <span
                                class="grid h-11 w-11
                                place-items-center rounded-xl
                                border border-gold-400/25
                                bg-white/[.06]
                                text-gold-400"
                            >

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="m8 8-4 4 4 4"/>
                                    <path d="m16 8 4 4-4 4"/>
                                    <path d="m14 4-4 16"/>
                                </svg>

                            </span>


                            <span
                                class="font-display text-xl
                                font-extrabold tracking-tight
                                text-white"
                            >

                                Code
                                <span class="text-gold-400">Tutor</span>

                            </span>

                        </a>

                    </div>


                    {{-- LOGIN CARD --}}

                    <div
                        class="login-form-card
                        rounded-3xl border border-white/10
                        bg-white p-6 shadow-maroon
                        sm:p-8"
                    >


                        <div>

                            <div
                                class="inline-flex items-center
                                rounded-full
                                bg-maroon-900/5 px-3 py-1.5
                                text-[10px] font-extrabold
                                uppercase tracking-[.15em]
                                text-maroon-700"
                            >
                                Akun CodeTutor
                            </div>


                            <h2
                                class="mt-3 font-display text-2xl
                                font-extrabold tracking-tight
                                text-maroon-950 sm:text-3xl"
                            >
                                Masuk ke akunmu
                            </h2>


                            <p
                                class="mt-2 text-sm leading-6
                                text-slate-500"
                            >
                                Masuk menggunakan username dan password akun CodeTutor kamu.
                            </p>

                        </div>


                        {{-- PESAN SUKSES --}}

                        @if(session('success'))
                            <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-xs font-semibold text-emerald-700">
                                {{ session('success') }}
                            </div>
                        @endif


                        {{-- SATU PESAN ERROR UNTUK LOGIN --}}
                        @if ($errors->any())
                            @php
                                $firstLoginError = $errors->first();
                                $isCredentialError = str_contains(strtolower($firstLoginError), 'salah');
                            @endphp
                            <div role="alert" aria-live="polite" class="mt-5 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3.5">
                                <span class="mt-0.5 grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-rose-100 text-rose-600">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <path d="M12 8v4M12 16h.01"></path>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-extrabold text-rose-800">Login tidak berhasil</p>
                                    <p class="mt-1 text-xs leading-5 text-rose-700">
                                        {{ $isCredentialError ? 'Username atau password salah. Periksa kembali data akun kamu.' : $firstLoginError }}
                                    </p>
                                </div>
                            </div>
                        @endif


                        {{-- LOGIN FORM --}}

                        <form
                            action="{{ route('login.process') }}"
                            method="POST"
                            class="mt-6 space-y-4"
                        >

                            @csrf


                            {{-- NAMA PENGGUNA --}}

                            <div>

                                <label
                                    for="nama"
                                    class="mb-2 block text-xs
                                    font-bold text-maroon-950"
                                >
                                    Username
                                </label>


                                <div class="relative">

                                    <span
                                        class="pointer-events-none
                                        absolute inset-y-0 left-0
                                        grid w-11
                                        place-items-center
                                        text-slate-400"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <circle cx="12" cy="8" r="4" />
                                            <path d="M5 21a7 7 0 0 1 14 0" />
                                        </svg>

                                    </span>


                                    <input
                                        type="text"
                                        id="nama"
                                        name="nama"
                                        value="{{ old('nama') }}"
                                        placeholder="Masukkan username atau nama akun"
                                        autocomplete="username"
                                        required
                                        autofocus
                                        class="h-12 w-full
                                        rounded-xl border
                                        border-slate-200
                                        bg-white pl-11 pr-4
                                        text-sm text-slate-800
                                        outline-none transition
                                        placeholder:text-slate-300
                                        focus:border-maroon-600
                                        focus:ring-4
                                        focus:ring-maroon-600/10"
                                    >

                                </div>
</div>


                            {{-- PASSWORD --}}

                            <div>

                                <div
                                    class="mb-2 flex items-center
                                    justify-between gap-3"
                                >

                                    <label
                                        for="password"
                                        class="block text-xs
                                        font-bold text-maroon-950"
                                    >
                                        Password
                                    </label>


                                    <a
                                        href="{{ route('password.request') }}"
                                        class="text-[11px]
                                        font-bold
                                        text-maroon-700
                                        transition
                                        hover:text-gold-700"
                                    >
                                        Lupa kata sandi?
                                    </a>

                                </div>


                                <div class="relative">

                                    <span
                                        class="pointer-events-none
                                        absolute inset-y-0 left-0
                                        grid w-11 place-items-center
                                        text-slate-400"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <rect
                                                x="4"
                                                y="10"
                                                width="16"
                                                height="11"
                                                rx="2"
                                            />

                                            <path
                                                d="M8 10V7a4 4 0 0 1
                                                8 0v3"
                                            />

                                        </svg>

                                    </span>


                                    <input
                                        type="password"
                                        id="password"
                                        name="kata_sandi"
                                        placeholder="Masukkan password"
                                        autocomplete="current-password"
                                        required
                                        class="h-12 w-full
                                        rounded-xl border
                                        border-slate-200
                                        bg-white pl-11 pr-12
                                        text-sm text-slate-800
                                        outline-none transition
                                        placeholder:text-slate-300
                                        focus:border-maroon-600
                                        focus:ring-4
                                        focus:ring-maroon-600/10"
                                    >


                                    {{-- TOGGLE PASSWORD --}}

                                    <button
                                        type="button"
                                        id="togglePassword"
                                        class="absolute inset-y-0
                                        right-0 grid w-11
                                        place-items-center
                                        text-slate-400 transition
                                        hover:text-maroon-700"
                                        aria-label="Tampilkan password"
                                    >

                                        {{-- OPEN EYE --}}

                                        <svg
                                            id="eyeOpen"
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <path
                                                d="M2 12s3.5-6 10-6
                                                10 6 10 6-3.5 6-10 6
                                                S2 12 2 12Z"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="2.5"
                                            />

                                        </svg>


                                        {{-- CLOSED EYE --}}

                                        <svg
                                            id="eyeClosed"
                                            class="hidden h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <path
                                                d="m3 3 18 18"
                                            />

                                            <path
                                                d="M10.6 10.6a2 2
                                                0 0 0 2.8 2.8"
                                            />

                                            <path
                                                d="M9.9 4.3A11.5
                                                11.5 0 0 1 12 4
                                                c6.5 0 10 6 10 6
                                                a18.8 18.8 0 0 1
                                                -3.1 3.9"
                                            />

                                            <path
                                                d="M6.6 6.6C3.8
                                                8.2 2 10 2 10s3.5
                                                6 10 6a11 11 0 0
                                                0 4.2-.8"
                                            />

                                        </svg>

                                    </button>

                                </div>
</div>


                            {{-- REMEMBER --}}

                            <div
                                class="flex items-center
                                justify-between gap-3"
                            >

                                <label
                                    class="inline-flex cursor-pointer
                                    items-center gap-2"
                                >

                                    <input
                                        type="checkbox"
                                        name="remember"
                                        value="1"
                                        class="h-4 w-4 rounded
                                        border-slate-300
                                        accent-maroon-700"
                                    >

                                    <span
                                        class="text-xs
                                        text-slate-500"
                                    >
                                        Ingat saya
                                    </span>

                                </label>


                                <span
                                    class="text-[10px]
                                    font-semibold
                                    text-slate-400"
                                >
                                    Aman & terenkripsi
                                </span>

                            </div>


                            {{-- LOGIN BUTTON --}}

                            <button
                                type="submit"
                                class="group inline-flex
                                h-12 w-full items-center
                                justify-center gap-2
                                rounded-xl
                                bg-gradient-to-r
                                from-maroon-800
                                to-maroon-700
                                text-sm font-extrabold
                                text-white shadow-maroon
                                transition
                                hover:-translate-y-0.5
                                hover:from-maroon-700
                                hover:to-maroon-600"
                            >

                                Masuk


                                <svg
                                    class="h-4 w-4 transition
                                    group-hover:translate-x-1"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <path d="M5 12h14"/>

                                    <path d="m13 6 6 6-6 6"/>

                                </svg>

                            </button>

                        </form>


                        {{-- REGISTER --}}

                        <p
                            class="mt-5 text-center text-xs
                            text-slate-500"
                        >

                            Belum punya akun?

                            <a
                                href="{{ route('register') }}"
                                class="font-extrabold
                                text-maroon-700 transition
                                hover:text-gold-700"
                            >
                                Daftar sekarang
                            </a>

                        </p>

                    </div>


                    {{-- BACK --}}

                    <div
                        class="mt-3 text-center"
                    >

                        <a
                            href="{{ url('/') }}"
                            class="inline-flex items-center
                            gap-2 text-xs font-semibold
                            text-white/55 transition
                            hover:text-gold-400"
                        >

                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path d="m15 18-6-6 6-6"/>
                            </svg>

                            Kembali ke halaman utama

                        </a>

                    </div>


                    <p
                        class="mt-2 text-center text-[10px]
                        text-white/30"
                    >
                        © 2026 CodeTutor.
                        All rights reserved.
                    </p>

                </section>

            </div>

        </div>

    </main>


    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            () => {


                /*
                |--------------------------------------------------------------------------
                | Toggle Password
                |--------------------------------------------------------------------------
                */

                const togglePassword =
                    document.getElementById(
                        'togglePassword'
                    );

                const passwordInput =
                    document.getElementById(
                        'password'
                    );

                const eyeOpen =
                    document.getElementById(
                        'eyeOpen'
                    );

                const eyeClosed =
                    document.getElementById(
                        'eyeClosed'
                    );


                if (
                    togglePassword &&
                    passwordInput &&
                    eyeOpen &&
                    eyeClosed
                ) {

                    togglePassword.addEventListener(
                        'click',
                        () => {

                            const showPassword =
                                passwordInput.type ===
                                'password';


                            passwordInput.type =
                                showPassword
                                    ? 'text'
                                    : 'password';


                            eyeOpen.classList.toggle(
                                'hidden',
                                showPassword
                            );


                            eyeClosed.classList.toggle(
                                'hidden',
                                !showPassword
                            );


                            togglePassword.setAttribute(
                                'aria-label',
                                showPassword
                                    ? 'Sembunyikan password'
                                    : 'Tampilkan password'
                            );

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Programming Language Orbit
                |--------------------------------------------------------------------------
                */

                const back = [...document.querySelectorAll('#orbitBack .program-logo')];
                const front = [...document.querySelectorAll('#orbitFront .program-logo')];

                if (back.length && back.length === front.length) {
                    let rotation = 0;
                    let last = performance.now();
                    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                    const speed = 0.00055;

                    const getRadius = () => {
                        if (window.innerWidth <= 640) return { x: 145, y: 88 };
                        if (window.innerWidth <= 1024) return { x: 200, y: 120 };
                        return { x: 225, y: 132 };
                    };

                    [...back, ...front].forEach((logo) => {
                        logo._angle = Number(logo.dataset.angle || 0) * Math.PI / 180;
                    });

                    const animate = (now) => {
                        const delta = Math.min(now - last, 40);
                        last = now;
                        if (!reduceMotion) rotation += delta * speed;
                        const radius = getRadius();

                        back.forEach((backLogo, index) => {
                            const frontLogo = front[index];
                            const angle = backLogo._angle + rotation;
                            const x = Math.cos(angle) * radius.x;
                            const y = Math.sin(angle) * radius.y;
                            const isFront = Math.sin(angle) > 0;
                            const scale = isFront
                                ? 1.02 + Math.sin(angle) * 0.10
                                : 0.84 + (Math.sin(angle) + 1) * 0.07;
                            const transform = `translate3d(calc(-50% + ${x}px), calc(-50% + ${y}px), 0) scale(${scale})`;

                            backLogo.style.transform = transform;
                            frontLogo.style.transform = transform;
                            backLogo.style.opacity = isFront ? '0' : '0.62';
                            frontLogo.style.opacity = isFront ? '1' : '0';

                            const visibleCard = isFront
                                ? frontLogo.querySelector('.program-logo-card')
                                : backLogo.querySelector('.program-logo-card');

                            if (visibleCard) {
                                visibleCard.style.filter = isFront
                                    ? 'brightness(1.15) drop-shadow(0 18px 30px rgba(0,0,0,.38))'
                                    : 'brightness(.78)';
                            }
                        });

                        if (!reduceMotion) requestAnimationFrame(animate);
                    };

                    requestAnimationFrame(animate);
                }

            }
        );

    </script>

</body>

</html>
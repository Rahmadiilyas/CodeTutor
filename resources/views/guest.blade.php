<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Pembelajaran Coding</title>
    <meta name="description" content="Platform pembelajaran coding dengan materi, latihan soal, test, dan code editor online.">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            950: '#24040D', 900: '#330711', 800: '#470B18',
                            700: '#5E1022', 600: '#74172B', 500: '#8C223A', 400: '#A2384E'
                        },
                        gold: {
                            300: '#F3D98E', 400: '#E7C568', 500: '#D6AD45',
                            600: '#B98D2E', 700: '#96721F'
                        },
                        warm: { 50: '#FFFCF8', 100: '#FBF5EC', 200: '#F4EBDD', 300: '#E9DDCB' }
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    boxShadow: {
                        maroon: '0 20px 50px rgba(51, 7, 17, .16)',
                        maroonSoft: '0 12px 35px rgba(51, 7, 17, .10)',
                        gold: '0 12px 28px rgba(214, 173, 69, .20)'
                    },
                    backgroundImage: {
                        'maroon-grid': 'linear-gradient(rgba(231,197,104,.055) 1px, transparent 1px), linear-gradient(90deg, rgba(231,197,104,.055) 1px, transparent 1px)'
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">

    <style>
        /* HERO ORBIT test j*/
        .hero-visual { isolation: isolate; overflow: visible; }
        .orbit-ring {
            position: absolute; left: 50%; top: 50%; border: 1px solid rgba(231,197,104,.14);
            border-radius: 50%; transform: translate(-50%, -50%); pointer-events: none; z-index: 1;
        }
        .ring-a { width: 490px; height: 260px; transform: translate(-50%, -50%) rotate(-10deg); }
        .ring-b { width: 420px; height: 225px; transform: translate(-50%, -50%) rotate(22deg); border-color: rgba(231,197,104,.08); }
        .orbit-layer { position: absolute; inset: 0; pointer-events: none; }
        .orbit-back { z-index: 10; }
        .orbit-front { z-index: 50; }
        .program-logo { position: absolute; left: 50%; top: 50%; width: 66px; height: 72px; will-change: transform, opacity; }
        .program-logo-card {
            width: 66px; height: 72px; display: flex; flex-direction: column; align-items: center;
            justify-content: center; gap: 4px; border: 1px solid rgba(231,197,104,.24); border-radius: 15px;
            background: linear-gradient(145deg, rgba(82,13,31,.97), rgba(36,4,13,.99));
            box-shadow: 0 15px 32px rgba(0,0,0,.30), inset 0 1px 0 rgba(255,255,255,.06);
            backdrop-filter: blur(8px);
        }
        .program-logo-card i { font-size: 24px; line-height: 1; }
        .program-logo-card span { color: rgba(255,255,255,.68); font-size: 8px; font-weight: 800; white-space: nowrap; }
        .laptop-wrapper { position: relative; z-index: 20; width: 390px; transform: translateY(8px); }
        .laptop-screen {
            position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,.12);
            border-radius: 19px 19px 10px 10px; background: #171214;
            box-shadow: 0 28px 58px rgba(0,0,0,.42), 0 0 0 6px rgba(255,255,255,.02), inset 0 1px 0 rgba(255,255,255,.05);
        }
        .laptop-screen::after {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(125deg, rgba(255,255,255,.08), transparent 28%, transparent 75%, rgba(231,197,104,.03));
        }
        .laptop-topbar {
            height: 40px; display: flex; align-items: center; justify-content: space-between;
            padding: 0 13px; border-bottom: 1px solid rgba(255,255,255,.055); background: #21191c;
        }
        .laptop-editor {
            display: grid; grid-template-columns: 36px 1fr; min-height: 260px;
            font-family: Consolas, Monaco, monospace; font-size: 10px; line-height: 1.9;
        }
        .editor-line-numbers { padding: 15px 8px 15px 0; border-right: 1px solid rgba(255,255,255,.05); text-align: right; color: rgba(255,255,255,.15); }
        .editor-code { padding: 15px 13px; color: rgba(255,255,255,.86); }
        .laptop-output { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 10px 12px; border-top: 1px solid rgba(255,255,255,.055); background: #20181b; }
        .laptop-base {
            position: relative; width: 106%; height: 88px; margin-left: -3%; border: 1px solid rgba(255,255,255,.09);
            border-top: 0; border-radius: 0 0 28px 28px;
            background: linear-gradient(180deg, #4e3b32 0%, #302723 56%, #181617 100%);
            box-shadow: 0 20px 30px rgba(0,0,0,.26); transform: perspective(800px) rotateX(49deg); transform-origin: top center;
        }
        .laptop-keyboard { position: absolute; left: 10%; right: 10%; top: 9px; padding: 8px; border-radius: 11px; background: rgba(18,16,16,.44); }
        .keyboard-row { display: flex; gap: 4px; margin-bottom: 4px; }
        .keyboard-row span { flex: 1; height: 5px; border-radius: 2px; background: rgba(240,220,188,.24); }
        .keyboard-space { justify-content: center; }
        .keyboard-space span { max-width: 32px; }
        .laptop-trackpad { position: absolute; left: 36%; right: 36%; bottom: 9px; height: 14px; border: 1px solid rgba(255,255,255,.08); border-radius: 5px; background: rgba(255,255,255,.025); }
        .laptop-pedestal { width: 70%; height: 20px; margin: -5px auto 0; border-radius: 9999px; background: linear-gradient(180deg, rgba(215,173,69,.42), rgba(215,173,69,.06)); box-shadow: 0 0 18px rgba(215,173,69,.20), 0 0 35px rgba(215,173,69,.08); }

        /* LOGO BAHASA: file SVG logo asli dari Devicon */
        .language-logo-wrap {
            display: grid; width: 58px; height: 58px; flex: 0 0 58px; place-items: center;
            border: 1px solid rgba(71,11,24,.08); border-radius: 15px; background: #fff;
            transition: .25s ease;
        }
        .language-logo-img { width: 39px; height: 39px; object-fit: contain; display: block; }
        .language-card:hover .language-logo-wrap { transform: translateY(-2px); background: #fffaf0; border-color: rgba(214,173,69,.45); }

        /* MODAL */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 200; display: flex; align-items: center; justify-content: center;
            padding: 1rem; background: rgba(24,4,10,.70); backdrop-filter: blur(10px);
            opacity: 0; visibility: hidden; transition: opacity .25s ease, visibility .25s ease;
        }
        .modal-overlay.is-open { opacity: 1; visibility: visible; }
        .modal-panel {
            width: min(100%, 640px); max-height: min(720px, calc(100vh - 32px)); overflow-y: auto;
            border: 1px solid rgba(255,255,255,.10); border-radius: 24px;
            background: linear-gradient(145deg, #3d0a18 0%, #24040d 100%);
            box-shadow: 0 35px 90px rgba(0,0,0,.42); transform: translateY(16px) scale(.98); transition: transform .25s ease;
        }
        .modal-overlay.is-open .modal-panel { transform: translateY(0) scale(1); }
        .modal-header {
            position: sticky; top: 0; z-index: 2; display: flex; align-items: flex-start; justify-content: space-between;
            gap: 20px; padding: 24px 24px 18px; border-bottom: 1px solid rgba(255,255,255,.08);
            background: rgba(61,10,24,.94); backdrop-filter: blur(14px);
        }
        .modal-kicker { margin-bottom: 6px; color: #E7C568; font-size: 10px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
        .modal-title { color: white; font-family: 'Plus Jakarta Sans',sans-serif; font-size: 23px; font-weight: 800; line-height: 1.25; }
        .modal-close { display: grid; flex: 0 0 auto; width: 38px; height: 38px; place-items: center; border: 1px solid rgba(255,255,255,.10); border-radius: 11px; color: rgba(255,255,255,.70); background: rgba(255,255,255,.05); cursor: pointer; transition: .2s ease; }
        .modal-close:hover { color: #24040D; background: #E7C568; }
        .modal-body { padding: 24px; }
        .modal-description { color: rgba(255,255,255,.68); font-size: 14px; line-height: 1.8; }
        .modal-section-title { margin-top: 24px; color: #E7C568; font-size: 11px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; }
        .modal-list { display: grid; gap: 9px; margin-top: 12px; }
        .modal-list-item { display: flex; align-items: flex-start; gap: 10px; padding: 11px 12px; border: 1px solid rgba(255,255,255,.07); border-radius: 12px; color: rgba(255,255,255,.68); background: rgba(255,255,255,.04); font-size: 12px; line-height: 1.5; }
        .modal-list-item::before { content: ''; width: 7px; height: 7px; flex: 0 0 7px; margin-top: 5px; border-radius: 9999px; background: #E7C568; box-shadow: 0 0 0 4px rgba(231,197,104,.08); }
        .modal-footer { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 25px; padding-top: 18px; border-top: 1px solid rgba(255,255,255,.08); }
        .modal-main-btn, .modal-secondary-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 42px; padding: 0 16px; border-radius: 11px; font-size: 12px; font-weight: 800; cursor: pointer; }
        .modal-main-btn { background: #E7C568; color: #24040D; }
        .modal-secondary-btn { border: 1px solid rgba(255,255,255,.12); background: rgba(255,255,255,.05); color: rgba(255,255,255,.78); }
        body.modal-open { overflow: hidden; }

        /* NAVBAR */
        .nav-link { position: relative; color: rgba(255,255,255,.65); transition: color .2s ease, background .2s ease; }
        .nav-link::after { content: ''; position: absolute; left: 0; right: 0; bottom: -10px; height: 2px; border-radius: 9999px; background: #E7C568; transform: scaleX(0); transform-origin: center; transition: transform .2s ease; }
        .nav-link:hover, .nav-link.active { color: #E7C568 !important; }
        .nav-link.active::after { transform: scaleX(1); }
        .mobile-nav-link { color: rgba(255,255,255,.70); transition: color .2s ease, background .2s ease; }
        .mobile-nav-link.active { color: #E7C568 !important; background: rgba(255,255,255,.06); }

        @media (max-width: 1024px) {
            .ring-a { width: 435px; height: 235px; }
            .ring-b { width: 380px; height: 205px; }
            .laptop-wrapper { width: 360px; }
        }
        @media (max-width: 640px) {
            .hero-visual { min-height: 430px; }
            .ring-a { width: 330px; height: 180px; }
            .ring-b { width: 290px; height: 160px; }
            .program-logo, .program-logo-card { width: 52px; height: 58px; }
            .program-logo-card i { font-size: 19px; }
            .program-logo-card span { font-size: 7px; }
            .laptop-wrapper { width: 310px; }
            .laptop-editor { min-height: 205px; font-size: 8px; }
            .laptop-topbar { height: 34px; }
            .laptop-base { height: 70px; }
            .modal-panel { border-radius: 20px; max-height: calc(100vh - 20px); }
            .modal-header, .modal-body { padding: 18px; }
            .modal-title { font-size: 20px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; animation-duration: .01ms !important; transition-duration: .01ms !important; }
        }
    </style>
</head>

<body class="bg-warm-50 font-sans text-slate-800 antialiased">

<!-- NAVBAR -->
<header class="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-maroon-900/95 text-white backdrop-blur-xl">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="#beranda" class="group flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-xl border border-gold-400/25 bg-white/[.06] text-gold-400 transition group-hover:bg-gold-400 group-hover:text-maroon-950">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m8 8-4 4 4 4"/><path d="m16 8 4 4-4 4"/><path d="m14 4-4 16"/></svg>
            </span>
            <span class="font-display text-lg font-extrabold tracking-tight">Code<span class="text-gold-400">Tutor</span></span>
        </a>

        <nav class="hidden items-center gap-8 lg:flex">
            <a href="#beranda" class="nav-link text-sm font-medium">Beranda</a>
            <a href="#bahasa" class="nav-link text-sm font-medium">Bahasa</a>
            <a href="#fitur" class="nav-link text-sm font-medium">Fitur</a>
            <a href="#materi" class="nav-link text-sm font-medium">Materi</a>
            <a href="#alur" class="nav-link text-sm font-medium">Cara Belajar</a>
        </nav>

        <div class="hidden items-center gap-2 sm:flex">
            <a href="/login" class="rounded-xl border border-white/15 px-4 py-2.5 text-sm font-bold text-white transition hover:border-gold-400/30 hover:bg-white/5">Masuk</a>
            <a href="{{ route('register') }}" class="rounded-xl bg-gradient-to-r from-gold-400 to-gold-500 px-4 py-2.5 text-sm font-extrabold text-maroon-950 shadow-gold transition hover:-translate-y-0.5">Daftar Gratis</a>
        </div>

        <button id="mobileMenuButton" type="button" class="grid h-11 w-11 place-items-center rounded-xl border border-white/10 bg-white/5 lg:hidden" aria-label="Buka menu" aria-expanded="false">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <div id="mobileMenu" class="hidden border-t border-white/10 bg-maroon-900 lg:hidden">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6">
            <div class="grid gap-1">
                <a href="#beranda" class="mobile-nav-link rounded-lg px-3 py-2.5 text-sm font-semibold">Beranda</a>
                <a href="#bahasa" class="mobile-nav-link rounded-lg px-3 py-2.5 text-sm">Bahasa</a>
                <a href="#fitur" class="mobile-nav-link rounded-lg px-3 py-2.5 text-sm">Fitur</a>
                <a href="#materi" class="mobile-nav-link rounded-lg px-3 py-2.5 text-sm">Materi</a>
                <a href="#alur" class="mobile-nav-link rounded-lg px-3 py-2.5 text-sm">Cara Belajar</a>
                <div class="mt-3 flex gap-2 border-t border-white/10 pt-3">
                    <a href="/login" class="flex-1 rounded-xl border border-white/15 px-4 py-2.5 text-center text-sm font-bold">Masuk</a>
                    <a href="{{ route('register') }}" class="flex-1 rounded-xl bg-gold-400 px-4 py-2.5 text-center text-sm font-extrabold text-maroon-950">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</header>

<main>

<!-- HERO -->
<section id="beranda" class="relative overflow-hidden bg-gradient-to-br from-maroon-950 via-maroon-900 to-maroon-700 pt-32 text-white">
    <div class="absolute inset-0 bg-maroon-grid bg-[size:55px_55px]"></div>
    <div class="absolute -right-36 -top-36 h-[520px] w-[520px] rounded-full border border-gold-400/10"></div>
    <div class="absolute -right-12 -top-12 h-[300px] w-[300px] rounded-full border border-gold-400/10"></div>
    <div class="absolute -bottom-40 -left-36 h-[500px] w-[500px] rounded-full bg-gold-500/10 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-4 pb-24 sm:px-6 lg:px-8 lg:pb-28">
        <div class="grid items-center gap-14 lg:grid-cols-[1fr_1fr]">
            <div class="max-w-2xl text-center lg:text-left">
                <div class="mx-auto mb-6 inline-flex items-center gap-2 rounded-full border border-gold-400/20 bg-white/[.06] px-3.5 py-1.5 text-xs font-bold text-gold-300 lg:mx-0">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>Platform Pembelajaran Coding
                </div>
                <h1 class="font-display text-4xl font-extrabold leading-[1.07] tracking-[-2px] sm:text-5xl lg:text-[62px]">
                    Belajar Coding<br>Jadi Lebih <span class="text-gold-400">Mudah</span><br>dan Terarah.
                </h1>
                <p class="mx-auto mt-6 max-w-xl text-sm leading-7 text-white/65 sm:text-base lg:mx-0">
                    Belajar HTML, CSS, JavaScript, PHP, Python, Java, C++, C#, Kotlin, SQL,
                    dan berbagai teknologi lainnya melalui satu platform pembelajaran yang terstruktur.
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-3 lg:justify-start">
                    <a href="#bahasa" class="group inline-flex items-center gap-2 rounded-xl bg-gold-400 px-5 py-3.5 text-sm font-extrabold text-maroon-950 shadow-gold transition hover:-translate-y-0.5 hover:bg-gold-300">
                        Mulai Belajar
                        <svg class="h-4 w-4 transition group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </a>
                    <a href="#fitur" class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/5 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-white/10">Jelajahi Platform</a>
                </div>
                <div class="mt-5 flex items-center justify-center gap-2 text-xs text-white/45 lg:justify-start">
                    <svg class="h-4 w-4 text-gold-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4l2.5 2.5"/></svg>
                    Belajar kapan saja, dari mana saja.
                </div>
                <div class="mt-9 flex flex-wrap justify-center gap-2 lg:justify-start">
                    @foreach (['HTML', 'CSS', 'JavaScript', 'PHP', 'Python', 'Java', 'C++', 'SQL'] as $mini)
                        <span class="rounded-full border border-white/10 bg-white/[.04] px-3 py-1.5 text-[10px] font-semibold text-white/45">{{ $mini }}</span>
                    @endforeach
                </div>
            </div>

            <div class="hero-visual relative mx-auto flex min-h-[500px] w-full max-w-[560px] items-center justify-center">
                <div class="absolute h-[340px] w-[340px] rounded-full bg-gold-500/10 blur-[85px]"></div>
                <div class="orbit-ring ring-a"></div><div class="orbit-ring ring-b"></div>
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
                        <div class="program-logo" data-angle="{{ $language['angle'] }}"><div class="program-logo-card"><i class="{{ $language['icon'] }} colored"></i><span>{{ $language['name'] }}</span></div></div>
                    @endforeach
                </div>

                <div class="laptop-wrapper">
                    <div class="laptop-screen">
                        <div class="laptop-topbar">
                            <div class="flex gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-red-400/60"></span><span class="h-2.5 w-2.5 rounded-full bg-gold-400/70"></span><span class="h-2.5 w-2.5 rounded-full bg-green-400/60"></span></div>
                            <div class="flex items-center gap-2"><span class="rounded-md bg-white/5 px-2 py-1 text-[8px] font-semibold text-white/40">PYTHON</span><span class="font-mono text-[10px] text-white/35">main.py</span></div>
                        </div>
                        <div class="laptop-editor">
                            <div class="editor-line-numbers">1<br>2<br>3<br>4<br>5<br>6<br>7<br>8<br>9<br>10</div>
                            <div class="editor-code">
                                <div><span class="text-gold-400">def</span> <span class="text-purple-300">sapa</span>(<span class="text-pink-300">nama</span>):</div>
                                <div class="pl-5"><span class="text-gold-300">return</span> <span class="text-green-300">f"Hello, {nama}"</span></div>
                                <div>&nbsp;</div><div><span class="text-pink-300">nama</span> <span class="text-white/30">=</span> <span class="text-green-300">"World"</span></div>
                                <div><span class="text-purple-300">print</span>(<span class="text-purple-300">sapa</span>(<span class="text-pink-300">nama</span>))</div>
                                <div>&nbsp;</div><div class="text-white/20"># Belajar → Latihan → Test</div><div>&nbsp;</div>
                                <div class="text-gold-300"><span class="text-purple-300">print</span>(<span class="text-green-300">"Ready to learn!"</span>)</div>
                            </div>
                        </div>
                        <div class="laptop-output"><div class="flex items-center gap-2 text-[10px] font-bold text-green-300"><span class="h-1.5 w-1.5 rounded-full bg-green-400"></span>Output berhasil</div><span class="rounded-lg bg-gold-400 px-2.5 py-1.5 text-[9px] font-extrabold text-maroon-950 shadow-gold">Run Code</span></div>
                    </div>
                    <div class="laptop-base">
                        <div class="laptop-keyboard">
                            @for ($r = 0; $r < 4; $r++)
                                <div class="keyboard-row">@for ($k = 0; $k < 11; $k++)<span></span>@endfor</div>
                            @endfor
                            <div class="keyboard-row keyboard-space"><span></span><span></span><span></span><span></span><span></span></div>
                        </div>
                        <div class="laptop-trackpad"></div>
                    </div>
                    <div class="laptop-pedestal"></div>
                </div>

                <div id="orbitFront" class="orbit-layer orbit-front">
                    @foreach ($orbitLanguages as $language)
                        <div class="program-logo" data-angle="{{ $language['angle'] }}"><div class="program-logo-card"><i class="{{ $language['icon'] }} colored"></i><span>{{ $language['name'] }}</span></div></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="relative z-10 -mt-8 px-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-6xl overflow-hidden rounded-2xl border border-maroon-900/10 bg-white shadow-maroonSoft">
        <div class="grid divide-y divide-maroon-900/10 sm:grid-cols-2 sm:divide-x sm:divide-y-0 lg:grid-cols-4">
            @php
                $stats = [
                    ['value' => '2.500+', 'label' => 'Pengguna Aktif', 'icon' => 'users'],
                    ['value' => '250+', 'label' => 'Materi Belajar', 'icon' => 'book'],
                    ['value' => '1.500+', 'label' => 'Latihan Soal', 'icon' => 'list'],
                    ['value' => '10+', 'label' => 'Bahasa & Teknologi', 'icon' => 'check'],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="flex items-center justify-center gap-3 px-6 py-6">
                    <span class="grid h-11 w-11 place-items-center rounded-xl bg-maroon-800 text-gold-400">
                        @if ($stat['icon'] === 'users')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        @elseif ($stat['icon'] === 'book')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
                        @elseif ($stat['icon'] === 'list')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                        @else
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m8 12 2.4 2.4L16 9"/></svg>
                        @endif
                    </span>
                    <div><p class="font-display text-xl font-extrabold text-maroon-950">{{ $stat['value'] }}</p><p class="text-xs text-slate-500">{{ $stat['label'] }}</p></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- LANGUAGE ECOSYSTEM: LOGO SVG ASLI -->
<section id="bahasa" class="px-4 py-24 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mx-auto max-w-3xl text-center">
            <p class="text-xs font-extrabold uppercase tracking-[.2em] text-maroon-700">Bahasa Pemrograman</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950 sm:text-4xl">Belajar lebih dari sekadar satu bahasa.</h2>
            <p class="mt-4 text-sm leading-7 text-slate-500">Jelajahi berbagai bahasa pemrograman dan teknologi untuk web, software, mobile, database, maupun algoritma.</p>
        </div>

        @php
            /*
             * URL di bawah mengarah ke berkas SVG logo teknologi dari Devicon.
             * Ini bukan singkatan teks atau ikon yang digambar sendiri.
             * SQL tidak mempunyai satu logo universal; kartu SQL menggunakan logo MySQL sebagai teknologi database.
             */
            $languages = [
                ['name' => 'HTML5', 'slug' => 'Markup Language', 'desc' => 'Menyusun struktur dan konten halaman web.', 'badge' => 'Pemula', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg', 'alt' => 'Logo HTML5'],
                ['name' => 'CSS3', 'slug' => 'Style Sheet', 'desc' => 'Mengatur tampilan, warna, desain, dan layout web.', 'badge' => 'Pemula', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg', 'alt' => 'Logo CSS3'],
                ['name' => 'JavaScript', 'slug' => 'Programming Language', 'desc' => 'Membangun interaksi dan logika pada website.', 'badge' => 'Pemula', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg', 'alt' => 'Logo JavaScript'],
                ['name' => 'PHP', 'slug' => 'Backend', 'desc' => 'Mengembangkan proses server-side pada aplikasi web.', 'badge' => 'Pemula', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg', 'alt' => 'Logo PHP'],
                ['name' => 'Python', 'slug' => 'General Purpose', 'desc' => 'Digunakan untuk data, AI, otomasi, dan backend.', 'badge' => 'Pemula', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/python/python-original.svg', 'alt' => 'Logo Python'],
                ['name' => 'Java', 'slug' => 'General Purpose', 'desc' => 'Membangun aplikasi dan mempelajari OOP.', 'badge' => 'Menengah', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/java/java-original.svg', 'alt' => 'Logo Java'],
                ['name' => 'C', 'slug' => 'Low Level', 'desc' => 'Memahami dasar sistem, memori, dan algoritma.', 'badge' => 'Menengah', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/c/c-original.svg', 'alt' => 'Logo bahasa C'],
                ['name' => 'C++', 'slug' => 'General Purpose', 'desc' => 'Mempelajari algoritma dan pengembangan software.', 'badge' => 'Menengah', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/cplusplus/cplusplus-original.svg', 'alt' => 'Logo C++'],
                ['name' => 'C#', 'slug' => 'General Purpose', 'desc' => 'Mengembangkan aplikasi menggunakan ekosistem .NET.', 'badge' => 'Menengah', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/csharp/csharp-original.svg', 'alt' => 'Logo C sharp'],
                ['name' => 'Kotlin', 'slug' => 'Mobile', 'desc' => 'Bahasa modern untuk pengembangan aplikasi Android.', 'badge' => 'Menengah', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/kotlin/kotlin-original.svg', 'alt' => 'Logo Kotlin'],
                ['name' => 'SQL', 'slug' => 'Database Query', 'desc' => 'Mengelola dan mengambil data dari database relasional.', 'badge' => 'Pemula', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg', 'alt' => 'Logo MySQL untuk materi SQL'],
                ['name' => 'Laravel', 'slug' => 'PHP Framework', 'desc' => 'Framework PHP untuk membangun aplikasi web modern.', 'badge' => 'Menengah', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg', 'alt' => 'Logo Laravel'],
            ];
        @endphp

        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($languages as $language)
                <a href="#materi" class="language-card group rounded-2xl border border-maroon-900/10 bg-white p-5 shadow-maroonSoft transition duration-300 hover:-translate-y-1.5 hover:border-gold-500/35 hover:shadow-maroon">
                    <div class="flex items-center justify-between gap-3">
                        <div class="language-logo-wrap">
                            <img
                                src="{{ $language['logo'] }}"
                                alt="{{ $language['alt'] }}"
                                class="language-logo-img"
                                loading="lazy"
                                decoding="async"
                                onerror="this.onerror=null; this.src='https://placehold.co/80x80/ffffff/470B18?text=Logo';"
                            >
                        </div>
                        <span class="rounded-full bg-maroon-900/5 px-2.5 py-1 text-[10px] font-bold text-maroon-700">{{ $language['badge'] }}</span>
                    </div>
                    <h3 class="mt-5 font-display text-base font-extrabold text-maroon-950">{{ $language['name'] }}</h3>
                    <p class="mt-1 text-[10px] font-semibold uppercase tracking-wide text-gold-700">{{ $language['slug'] }}</p>
                    <p class="mt-2 min-h-[40px] text-xs leading-5 text-slate-500">{{ $language['desc'] }}</p>
                    <div class="mt-4 flex items-center justify-between border-t border-maroon-900/10 pt-3">
                        <span class="text-[10px] font-semibold text-slate-400">Lihat jalur belajar</span>
                        <svg class="h-4 w-4 text-slate-300 transition group-hover:translate-x-1 group-hover:text-maroon-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="fitur" class="border-y border-maroon-900/10 bg-warm-100 px-4 py-24 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-xs font-extrabold uppercase tracking-[.2em] text-maroon-700">Fitur Unggulan</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950 sm:text-4xl">Bukan hanya belajar teori.</h2>
            <p class="mt-4 text-sm leading-7 text-slate-500">Pengguna dapat membaca materi, berlatih, menulis kode, mengerjakan soal, mengikuti test, dan melihat progres.</p>
        </div>

        @php
            $features = [
                ['title'=>'Materi Terstruktur','desc'=>'Materi disusun berdasarkan bahasa, topik, dan level.','details'=>'Setiap bahasa pemrograman memiliki urutan materi dari dasar hingga tahap lanjutan. Pengguna dapat mengikuti materi secara bertahap sehingga proses belajar lebih terarah dan tidak membingungkan.','items'=>['Materi berdasarkan level','Topik tersusun per modul','Contoh source code','Progress setiap materi'],'icon'=>'book'],
                ['title'=>'Latihan Soal','desc'=>'Soal latihan untuk memperkuat pemahaman setelah belajar.','details'=>'Setelah menyelesaikan materi, pengguna dapat mengerjakan latihan untuk menguji pemahaman konsep dan logika pemrograman.','items'=>['Soal pilihan ganda','Soal berdasarkan materi','Penilaian otomatis','Riwayat hasil latihan'],'icon'=>'list'],
                ['title'=>'Code Editor Online','desc'=>'Tulis dan jalankan source code langsung dari browser.','details'=>'Pengguna dapat mencoba source code secara langsung tanpa harus membuka aplikasi pemrograman lain. Editor disiapkan sebagai ruang praktik di dalam platform.','items'=>['Editor source code','Pilih bahasa pemrograman','Jalankan kode','Lihat output program'],'icon'=>'code'],
                ['title'=>'Test Program','desc'=>'Uji kemampuan dan lihat hasil penguasaan materi.','details'=>'Test digunakan untuk mengevaluasi kemampuan pengguna setelah mempelajari beberapa materi dan menyelesaikan latihan.','items'=>['Test per topik','Skor otomatis','Batas waktu dapat diterapkan','Hasil dan evaluasi'],'icon'=>'test'],
                ['title'=>'Progress Tracking','desc'=>'Pantau materi, latihan, nilai, dan perkembangan belajar.','details'=>'Sistem mencatat perkembangan belajar sehingga pengguna dapat melihat materi yang sudah selesai, hasil latihan, dan pencapaian secara berkala.','items'=>['Persentase progress','Materi selesai','Nilai latihan','Riwayat perkembangan'],'icon'=>'chart'],
                ['title'=>'Sertifikat','desc'=>'Bukti capaian setelah menyelesaikan jalur tertentu.','details'=>'Sertifikat dapat diberikan sebagai bukti bahwa pengguna telah menyelesaikan jalur pembelajaran atau target tertentu di dalam platform.','items'=>['Sertifikat penyelesaian','Nama peserta','Jalur yang diselesaikan','Tanggal penerbitan'],'icon'=>'award'],
            ];
        @endphp

        <div class="mt-12 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($features as $feature)
                <button type="button" class="modal-trigger group w-full cursor-pointer rounded-2xl border border-maroon-900/10 bg-white p-7 text-left shadow-maroonSoft transition duration-300 hover:-translate-y-1.5 hover:border-gold-500/35 hover:shadow-maroon focus:outline-none focus:ring-2 focus:ring-gold-400/60"
                    data-modal-kind="feature" data-modal-title="{{ $feature['title'] }}" data-modal-description="{{ $feature['details'] }}" data-modal-items='@json($feature["items"])'>
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-maroon-800 text-gold-400 transition group-hover:bg-gold-400 group-hover:text-maroon-950">
                        @if($feature['icon'] === 'book')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
                        @elseif($feature['icon'] === 'list')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                        @elseif($feature['icon'] === 'code')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m8 8-4 4 4 4M16 8l4 4-4 4M14 4l-4 16"/></svg>
                        @elseif($feature['icon'] === 'test')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10M18 20l-6-6-6 6M5 4h14"/></svg>
                        @elseif($feature['icon'] === 'chart')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5M4 19h16M7 15l3-4 3 2 4-6"/></svg>
                        @else
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 3 2 4 4 .6-3 3 .7 4.4L12 13l-3.7 2 .7-4.4-3-3L10 7l2-4Z"/><path d="M8 17h8M9 21h6"/></svg>
                        @endif
                    </div>
                    <h3 class="mt-5 font-display text-base font-extrabold text-maroon-950">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">{{ $feature['desc'] }}</p>
                    <span class="mt-5 inline-flex items-center gap-1.5 text-[10px] font-extrabold uppercase tracking-wide text-maroon-700 transition group-hover:text-gold-700">Lihat penjelasan <span aria-hidden="true">→</span></span>
                </button>
            @endforeach
        </div>
    </div>
</section>

<!-- LEARNING PATH -->
<section id="materi" class="border-y border-maroon-900/10 bg-maroon-950 px-4 py-24 text-white sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-extrabold uppercase tracking-[.2em] text-gold-400">Jalur Pembelajaran</p>
                <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight sm:text-4xl">Dari fundamental sampai teknologi modern.</h2>
                <p class="mt-4 text-sm leading-7 text-white/55">Pengguna bisa belajar berdasarkan bahasa pemrograman, bidang, atau level kemampuan.</p>
            </div>
            <a href="#bahasa" class="inline-flex items-center gap-2 text-sm font-bold text-gold-400">Lihat semua jalur <span aria-hidden="true">→</span></a>
        </div>

        @php
            $paths = [
                ['title'=>'Web Development','desc'=>'HTML, CSS, JavaScript, PHP, Laravel','meta'=>'6 Jalur','badge'=>'Populer','icon'=>'WEB','details'=>'Jalur untuk mempelajari bagaimana website dibuat dari sisi tampilan sampai backend. Cocok untuk pengguna yang ingin menjadi web developer.','items'=>['HTML & CSS','JavaScript','PHP','Laravel','REST API','Project website']],
                ['title'=>'Programming Fundamental','desc'=>'C, C++, Java, Python, C#','meta'=>'5 Jalur','badge'=>'Fundamental','icon'=>'</>','details'=>'Jalur fundamental untuk memahami dasar pemrograman, algoritma, struktur data, logika, dan konsep object oriented programming.','items'=>['Algoritma dasar','Variabel & tipe data','Kondisi & perulangan','Function','OOP','Problem solving']],
                ['title'=>'Data & Database','desc'=>'SQL, MySQL, PostgreSQL, konsep database','meta'=>'4 Jalur','badge'=>'Database','icon'=>'DB','details'=>'Jalur yang berfokus pada pengelolaan data, query, perancangan database, dan penggunaan database dalam aplikasi.','items'=>['SQL dasar','SELECT & JOIN','Relasi tabel','MySQL','PostgreSQL','Perancangan database']],
                ['title'=>'Mobile Development','desc'=>'Kotlin, Java Android, konsep mobile','meta'=>'3 Jalur','badge'=>'Mobile','icon'=>'APP','details'=>'Jalur pembelajaran untuk memahami dasar pengembangan aplikasi mobile menggunakan teknologi Android dan bahasa yang sesuai.','items'=>['Kotlin dasar','Java Android','UI mobile','Navigasi','Data aplikasi','Project mobile']],
            ];
        @endphp

        <div class="mt-10 grid gap-4 md:grid-cols-2">
            @foreach ($paths as $path)
                <button type="button" class="modal-trigger group w-full cursor-pointer rounded-2xl border border-white/10 bg-white/[.045] p-6 text-left transition duration-300 hover:-translate-y-1.5 hover:border-gold-400/30 hover:bg-white/[.07] focus:outline-none focus:ring-2 focus:ring-gold-400/60"
                    data-modal-kind="path" data-modal-title="{{ $path['title'] }}" data-modal-description="{{ $path['details'] }}" data-modal-items='@json($path["items"])'>
                    <div class="flex items-start gap-4">
                        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl border border-gold-400/10 bg-white/[.06] font-mono text-[10px] font-extrabold text-gold-400">{{ $path['icon'] }}</span>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2"><h3 class="font-display text-base font-extrabold">{{ $path['title'] }}</h3><span class="rounded-full bg-gold-400/10 px-2.5 py-1 text-[9px] font-bold text-gold-300">{{ $path['badge'] }}</span></div>
                            <p class="mt-1 text-xs leading-5 text-white/45">{{ $path['desc'] }}</p>
                            <div class="mt-4 flex items-center justify-between border-t border-white/10 pt-4 text-[11px] text-white/35"><span>{{ $path['meta'] }}</span><span class="text-gold-400 group-hover:text-gold-300">Lihat detail →</span></div>
                        </div>
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</section>

<!-- POPULAR MATERIAL -->
<section class="px-4 py-24 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="max-w-2xl">
            <p class="text-xs font-extrabold uppercase tracking-[.2em] text-maroon-700">Materi Populer</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950 sm:text-4xl">Mulai dari materi yang paling banyak dipelajari.</h2>
            <p class="mt-4 text-sm leading-7 text-slate-500">Contoh materi populer dari berbagai bahasa pemrograman.</p>
        </div>
        <div class="mt-10 grid gap-5 lg:grid-cols-[1.08fr_.92fr]">
            <article class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-maroon-900 to-maroon-700 p-8 text-white shadow-maroon sm:p-10">
                <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full border border-gold-400/10"></div><div class="absolute -bottom-32 -right-12 h-72 w-72 rounded-full bg-gold-400/10 blur-3xl"></div>
                <div class="relative">
                    <div class="inline-flex rounded-full border border-gold-400/20 bg-white/5 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-gold-300">Materi Pilihan</div>
                    <h3 class="mt-6 max-w-xl font-display text-2xl font-extrabold leading-tight sm:text-3xl">Fundamental Programming dengan Python</h3>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-white/60">Pelajari variabel, tipe data, kondisi, perulangan, function, collection, dan problem solving dari dasar.</p>
                    <div class="mt-7 flex flex-wrap gap-2"><span class="rounded-full bg-white/[.07] px-3 py-1.5 text-[10px] font-bold text-white/55">20 Modul</span><span class="rounded-full bg-white/[.07] px-3 py-1.5 text-[10px] font-bold text-white/55">15 Latihan</span><span class="rounded-full bg-white/[.07] px-3 py-1.5 text-[10px] font-bold text-white/55">Pemula</span></div>
                    <a href="#alur" class="mt-8 inline-flex items-center gap-2 rounded-xl bg-gold-400 px-5 py-3 text-sm font-extrabold text-maroon-950 shadow-gold transition hover:-translate-y-0.5 hover:bg-gold-300">Pelajari Sekarang <span aria-hidden="true">→</span></a>
                </div>
            </article>
            <div class="grid gap-3">
                @php
                    $materials = [
                        ['code'=>'PY','title'=>'Python Dasar','meta'=>'20 materi • 40 menit'],
                        ['code'=>'JV','title'=>'Java OOP Dasar','meta'=>'16 materi • 35 menit'],
                        ['code'=>'C++','title'=>'Algoritma C++','meta'=>'18 materi • 35 menit'],
                        ['code'=>'PHP','title'=>'PHP Dasar','meta'=>'12 materi • 30 menit'],
                        ['code'=>'SQL','title'=>'SQL & Database','meta'=>'14 materi • 35 menit'],
                        ['code'=>'JS','title'=>'JavaScript Dasar','meta'=>'15 materi • 30 menit'],
                    ];
                @endphp
                @foreach ($materials as $material)
                    <a href="#bahasa" class="group flex items-center gap-4 rounded-2xl border border-maroon-900/10 bg-white p-4 shadow-maroonSoft transition hover:-translate-y-0.5 hover:border-gold-500/30 hover:shadow-maroon">
                        <span class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-maroon-800 font-mono text-[10px] font-extrabold text-gold-400">{{ $material['code'] }}</span>
                        <span class="min-w-0 flex-1"><strong class="block truncate text-sm font-extrabold text-maroon-950">{{ $material['title'] }}</strong><small class="mt-1 block text-xs text-slate-400">{{ $material['meta'] }}</small></span>
                        <svg class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:translate-x-1 group-hover:text-maroon-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- HOW TO LEARN -->
<section id="alur" class="border-y border-maroon-900/10 bg-warm-200 px-4 py-24 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-xs font-extrabold uppercase tracking-[.2em] text-maroon-700">Cara Belajar</p>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-maroon-950 sm:text-4xl">Belajar bahasa apa pun dengan alur yang sama.</h2>
            <p class="mt-4 text-sm leading-7 text-slate-500">Pilih bahasa, pelajari materi, praktikkan kode, lalu ukur hasilnya.</p>
        </div>
        @php
            $steps = [
                ['num'=>'01','title'=>'Pilih Bahasa','desc'=>'Pilih Python, Java, PHP, C++, JavaScript, SQL, atau jalur lain.'],
                ['num'=>'02','title'=>'Pelajari Materi','desc'=>'Baca materi dan pahami contoh kode secara bertahap.'],
                ['num'=>'03','title'=>'Latihan & Coding','desc'=>'Kerjakan soal dan praktikkan source code melalui editor.'],
                ['num'=>'04','title'=>'Test & Evaluasi','desc'=>'Kerjakan test lalu lihat skor dan perkembanganmu.'],
            ];
        @endphp
        <div class="relative mt-14 grid gap-8 md:grid-cols-4">
            <div class="absolute left-[12%] right-[12%] top-6 hidden border-t border-dashed border-maroon-700/20 md:block"></div>
            @foreach ($steps as $step)
                <div class="relative text-center"><div class="relative mx-auto grid h-12 w-12 place-items-center rounded-full bg-maroon-800 font-display text-xs font-extrabold text-gold-400 shadow-maroon">{{ $step['num'] }}</div><h3 class="mt-5 font-display text-base font-extrabold text-maroon-950">{{ $step['title'] }}</h3><p class="mt-2 text-xs leading-5 text-slate-500">{{ $step['desc'] }}</p></div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section id="tentang" class="px-4 py-24 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="relative overflow-hidden rounded-3xl bg-maroon-900 px-7 py-12 text-center shadow-maroon sm:px-12 sm:py-16 lg:text-left">
            <div class="absolute -right-28 -top-28 h-80 w-80 rounded-full border border-gold-400/10"></div><div class="absolute -bottom-40 right-12 h-80 w-80 rounded-full bg-gold-400/10 blur-3xl"></div>
            <div class="relative max-w-3xl">
                <p class="text-xs font-extrabold uppercase tracking-[.2em] text-gold-400">Mulai Perjalananmu</p>
                <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl">Satu platform, banyak bahasa, banyak kemungkinan.</h2>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-white/60">Mulai dari Python, Java, C++, JavaScript, PHP, SQL, hingga pengembangan web dan mobile. Belajar sesuai kebutuhanmu.</p>
                <div class="mt-7 flex flex-wrap justify-center gap-3 lg:justify-start">
                    <a href="{{ route('register') }}" class="rounded-xl bg-gold-400 px-5 py-3.5 text-sm font-extrabold text-maroon-950 shadow-gold transition hover:-translate-y-0.5 hover:bg-gold-300">Buat Akun Gratis</a>
                    <a href="#bahasa" class="rounded-xl border border-white/15 bg-white/5 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-white/10">Jelajahi Bahasa</a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<!-- FOOTER -->
<footer class="bg-maroon-950 text-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-[1.35fr_.85fr_.85fr_.85fr]">
            <div>
                <a href="#beranda" class="inline-flex items-center gap-3"><span class="grid h-10 w-10 place-items-center rounded-xl border border-gold-400/20 bg-white/5 text-gold-400"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m8 8-4 4 4 4"/><path d="m16 8 4 4-4 4"/><path d="m14 4-4 16"/></svg></span><span class="font-display text-lg font-extrabold">Code<span class="text-gold-400">Tutor</span></span></a>
                <p class="mt-4 max-w-md text-xs leading-6 text-white/40">Platform pembelajaran coding interaktif untuk membantu pengguna belajar berbagai bahasa pemrograman, berlatih, dan menguji kemampuan.</p>
            </div>
            <div><h4 class="text-sm font-bold">Platform</h4><div class="mt-4 grid gap-2.5 text-xs text-white/40"><a href="#bahasa" class="transition hover:text-gold-400">Bahasa</a><a href="#fitur" class="transition hover:text-gold-400">Fitur</a><a href="#materi" class="transition hover:text-gold-400">Materi</a><a href="#alur" class="transition hover:text-gold-400">Cara Belajar</a></div></div>
            <div><h4 class="text-sm font-bold">Bahasa</h4><div class="mt-4 grid gap-2.5 text-xs text-white/40"><a href="#bahasa" class="transition hover:text-gold-400">Python</a><a href="#bahasa" class="transition hover:text-gold-400">Java</a><a href="#bahasa" class="transition hover:text-gold-400">C / C++</a><a href="#bahasa" class="transition hover:text-gold-400">PHP / Laravel</a></div></div>
            <div><h4 class="text-sm font-bold">Lainnya</h4><div class="mt-4 grid gap-2.5 text-xs text-white/40"><a href="#bahasa" class="transition hover:text-gold-400">JavaScript</a><a href="#bahasa" class="transition hover:text-gold-400">SQL</a><a href="#bahasa" class="transition hover:text-gold-400">Kotlin</a><a href="#bahasa" class="transition hover:text-gold-400">C#</a></div></div>
        </div>
        <div class="mt-12 flex flex-col justify-between gap-3 border-t border-white/10 pt-5 text-[11px] text-white/25 sm:flex-row"><span>© {{ date('Y') }} CodeTutor. All rights reserved.</span><span>Belajar coding dengan cara yang lebih terarah.</span></div>
    </div>
</footer>

<!-- DETAIL MODAL -->
<div id="detailModal" class="modal-overlay" aria-hidden="true">
    <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal-header">
            <div><div id="modalKicker" class="modal-kicker">Detail</div><h3 id="modalTitle" class="modal-title">Judul</h3></div>
            <button id="modalClose" type="button" class="modal-close" aria-label="Tutup"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
        </div>
        <div class="modal-body">
            <p id="modalDescription" class="modal-description"></p>
            <div class="modal-section-title">Yang akan dipelajari</div>
            <div id="modalItems" class="modal-list"></div>
            <div class="modal-footer">
                <button type="button" id="modalAction" class="modal-main-btn">Mulai Pelajari <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg></button>
                <button type="button" id="modalSecondary" class="modal-secondary-btn">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Menu mobile
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.toggle('hidden');
            mobileMenuButton.setAttribute('aria-expanded', String(!isHidden));
        });
        document.querySelectorAll('#mobileMenu a[href^="#"]').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // Animasi orbit logo di hero
    (() => {
        const back = [...document.querySelectorAll('#orbitBack .program-logo')];
        const front = [...document.querySelectorAll('#orbitFront .program-logo')];
        if (!back.length || back.length !== front.length) return;

        let rotation = 0;
        let last = performance.now();
        const speed = 0.00055;
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const getRadius = () => {
            if (window.innerWidth <= 640) return { x: 145, y: 88 };
            if (window.innerWidth <= 1024) return { x: 200, y: 120 };
            return { x: 225, y: 132 };
        };
        [...back, ...front].forEach(logo => { logo._angle = Number(logo.dataset.angle || 0) * Math.PI / 180; });

        function animate(now) {
            const delta = Math.min(now - last, 40);
            last = now;
            if (!reduceMotion) rotation += delta * speed;
            const radius = getRadius();

            back.forEach((backLogo, i) => {
                const frontLogo = front[i];
                const angle = backLogo._angle + rotation;
                const x = Math.cos(angle) * radius.x;
                const y = Math.sin(angle) * radius.y;
                const isFront = Math.sin(angle) > 0;
                const scale = isFront ? 1.02 + Math.sin(angle) * 0.10 : 0.84 + (Math.sin(angle) + 1) * 0.07;
                const transform = `translate3d(calc(-50% + ${x}px), calc(-50% + ${y}px), 0) scale(${scale})`;
                backLogo.style.transform = transform;
                frontLogo.style.transform = transform;
                backLogo.style.opacity = isFront ? '0' : '0.62';
                frontLogo.style.opacity = isFront ? '1' : '0';

                const visibleCard = isFront ? frontLogo.querySelector('.program-logo-card') : backLogo.querySelector('.program-logo-card');
                if (visibleCard) {
                    visibleCard.style.filter = isFront ? 'brightness(1.15) drop-shadow(0 18px 30px rgba(0,0,0,.38))' : 'brightness(.78)';
                    visibleCard.style.boxShadow = isFront
                        ? '0 18px 38px rgba(0,0,0,.40), 0 0 22px rgba(231,197,104,.13), inset 0 1px 0 rgba(255,255,255,.08)'
                        : '0 10px 20px rgba(0,0,0,.22), inset 0 1px 0 rgba(255,255,255,.05)';
                }
            });
            if (!reduceMotion) requestAnimationFrame(animate);
        }
        requestAnimationFrame(animate);
    })();

    // Modal detail fitur dan jalur belajar
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('detailModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalKicker = document.getElementById('modalKicker');
        const modalDescription = document.getElementById('modalDescription');
        const modalItems = document.getElementById('modalItems');
        const modalClose = document.getElementById('modalClose');
        const modalSecondary = document.getElementById('modalSecondary');
        const modalAction = document.getElementById('modalAction');
        const triggers = document.querySelectorAll('.modal-trigger');
        if (!modal || !triggers.length) return;

        let lastTrigger = null;
        const openModal = trigger => {
            lastTrigger = trigger;
            const kind = trigger.dataset.modalKind || 'feature';
            const title = trigger.dataset.modalTitle || 'Detail';
            const description = trigger.dataset.modalDescription || '';
            let items = [];
            try { items = JSON.parse(trigger.dataset.modalItems || '[]'); } catch (error) { items = []; }

            modalKicker.textContent = kind === 'path' ? 'Jalur Pembelajaran' : 'Fitur Platform';
            modalTitle.textContent = title;
            modalDescription.textContent = description;
            modalItems.replaceChildren();
            items.forEach(item => {
                const row = document.createElement('div');
                row.className = 'modal-list-item';
                row.textContent = item;
                modalItems.appendChild(row);
            });
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
            window.setTimeout(() => modalClose?.focus(), 30);
        };
        const closeModal = () => {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            lastTrigger?.focus();
        };
        triggers.forEach(trigger => trigger.addEventListener('click', () => openModal(trigger)));
        modalClose?.addEventListener('click', closeModal);
        modalSecondary?.addEventListener('click', closeModal);
        modal.addEventListener('click', event => { if (event.target === modal) closeModal(); });
        modalAction?.addEventListener('click', () => {
            const target = lastTrigger?.dataset.modalKind === 'path' ? '#materi' : '#fitur';
            closeModal();
            document.querySelector(target)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
        });
    });

    // Navbar active section saat klik dan scroll
    document.addEventListener('DOMContentLoaded', () => {
        const navLinks = [...document.querySelectorAll('.nav-link')];
        const mobileNavLinks = [...document.querySelectorAll('.mobile-nav-link')];
        const allNavLinks = [...navLinks, ...mobileNavLinks];
        const sections = [...document.querySelectorAll('#beranda, #bahasa, #fitur, #materi, #alur, #tentang')];
        const setActive = id => {
            allNavLinks.forEach(link => link.classList.toggle('active', link.getAttribute('href') === `#${id}`));
        };
        allNavLinks.forEach(link => link.addEventListener('click', () => {
            const id = link.getAttribute('href')?.replace('#', '');
            if (id) setActive(id);
        }));
        let ticking = false;
        const updateActiveOnScroll = () => {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(() => {
                const navbar = document.querySelector('header');
                const offset = (navbar?.offsetHeight || 80) + 90;
                const currentPosition = window.scrollY + offset;
                let activeSection = sections[0];
                sections.forEach(section => { if (currentPosition >= section.offsetTop) activeSection = section; });
                if (activeSection) setActive(activeSection.id);
                ticking = false;
            });
        };
        window.addEventListener('scroll', updateActiveOnScroll, { passive: true });
        window.addEventListener('resize', updateActiveOnScroll);
        updateActiveOnScroll();
    });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'CodeTutor')</title>
    <meta name="description" content="@yield('description', 'Platform pembelajaran coding CodeTutor.')">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            950: '#24040D', 900: '#330711', 800: '#470B18',
                            700: '#5E1022', 600: '#74172B', 500: '#8C223A', 400: '#A2384E',
                        },
                        gold: {
                            300: '#F3D98E', 400: '#E7C568', 500: '#D6AD45',
                            600: '#B98D2E', 700: '#96721F',
                        },
                        warm: {
                            50: '#FFFCF8', 100: '#FBF5EC', 200: '#F4EBDD', 300: '#E9DDCB',
                        },
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        soft: '0 12px 35px rgba(51, 7, 17, .08)',
                        card: '0 20px 55px rgba(51, 7, 17, .11)',
                        gold: '0 12px 30px rgba(214, 173, 69, .20)',
                    },
                },
            },
        };
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            background: #FBF5EC;
            color: #334155;
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
        img { max-width: 100%; }
        button, a { -webkit-tap-highlight-color: transparent; }
        main { width: 100%; min-width: 0; }

        /* SIDEBAR */
        #sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 50;
            width: 260px;
            height: 100vh;
            height: 100dvh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #24040D;
            transform: translateX(0);
            transition: transform .3s ease;
            will-change: transform;
        }

        #sidebar > div:first-child { flex: 0 0 80px; height: 80px; }

        #sidebar .sidebar-scroll {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 22px 16px;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: rgba(231,197,104,.2) transparent;
        }

        #sidebar .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        #sidebar .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(231,197,104,.2); border-radius: 20px; }
        #sidebar .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }

        #sidebar .sidebar-scroll > p {
            margin-bottom: 12px;
            padding-left: 12px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .18em;
            line-height: 1.5;
        }

        #sidebar .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            min-height: 52px;
            padding: 8px 12px;
            border-radius: 12px;
            color: rgba(255,255,255,.65);
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
            text-decoration: none;
            transition: background .2s ease, color .2s ease, transform .2s ease;
        }

        #sidebar .nav-icon {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            min-width: 36px;
            flex: 0 0 36px;
            border-radius: 10px;
            background: rgba(255,255,255,.045);
            color: rgba(255,255,255,.65);
        }

        #sidebar .nav-icon svg { width: 17px; height: 17px; }

        #sidebar .nav-item.active {
            background: rgba(255,255,255,.075);
            color: #FACC15;
            font-weight: 800;
        }

        #sidebar .nav-item.active .nav-icon {
            background: rgba(231,197,104,.13);
            color: #E7C568;
        }

        #sidebar .nav-item:not(.active):hover {
            background: rgba(255,255,255,.055);
            color: #FFFFFF;
            transform: translateX(2px);
        }

        #sidebar .nav-item:not(.active):hover .nav-icon { color: #E7C568; }
        #sidebar .nav-item:focus-visible { outline: 2px solid #E7C568; outline-offset: 2px; }

        #sidebar nav.space-y-1 > :not([hidden]) ~ :not([hidden]) { margin-top: 5px; }
        #sidebar > div:last-child { flex: 0 0 auto; background: #24040D; }

        /* MAIN CONTENT */
        .main-wrapper { width: 100%; min-width: 0; min-height: 100vh; }
        #sidebarOverlay { z-index: 40; }

        @media (min-width: 1024px) {
            #sidebar { transform: translateX(0); }
            .main-wrapper { padding-left: 260px; }
        }

        @media (max-width: 1023px) {
            #sidebar { width: min(260px, 86vw); transform: translateX(-100%); }
            #sidebar.is-open { transform: translateX(0); }
        }

        @media (max-width: 639px) { body { font-size: 14px; } }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen bg-warm-100 font-sans text-slate-800 antialiased">
    @auth
        @include('partials.sidebar')
        <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-maroon-950/60 backdrop-blur-sm lg:hidden"></div>
    @endauth

    <div class="main-wrapper">
        @auth
            @include('partials.navbar')
        @endauth

        <main class="min-h-screen w-full min-w-0 @auth px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8 @endauth">
            @yield('content')
        </main>
    </div>

    @auth
        @include('partials.scripts')
    @endauth
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $nomorSertifikat }}</title>
    <style>
        /* DomPDF: ukuran fisik A4 landscape, semua elemen diposisikan di satu halaman. */
        @page { size: A4 landscape; margin: 0; }
        * { box-sizing: border-box; }
        html, body {
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #3D3034;
            background: #FFFCF8;
        }
        .certificate-page {
            position: relative;
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #FFFCF8;
            page-break-after: avoid;
            page-break-inside: avoid;
        }
        .outer-frame {
            position: absolute;
            left: 7mm;
            top: 7mm;
            width: 283mm;
            height: 196mm;
            border: 2.2pt solid #330711;
            z-index: 1;
        }
        .inner-frame {
            position: absolute;
            left: 9mm;
            top: 9mm;
            width: 279mm;
            height: 192mm;
            border: 0.9pt solid #D6AD45;
            z-index: 1;
        }

        /* Ornamen sudut maroon-gold */
        .corner { position: absolute; width: 0; height: 0; z-index: 2; }
        .corner-tl-maroon {
            left: 0; top: 0;
            border-top: 33mm solid #330711;
            border-right: 33mm solid transparent;
        }
        .corner-tl-gold {
            left: 0; top: 0;
            border-top: 23mm solid #D6AD45;
            border-right: 23mm solid transparent;
        }
        .corner-br-maroon {
            right: 0; bottom: 0;
            border-bottom: 35mm solid #330711;
            border-left: 35mm solid transparent;
        }
        .corner-br-gold {
            right: 0; bottom: 0;
            border-bottom: 24mm solid #D6AD45;
            border-left: 24mm solid transparent;
        }
        .watermark {
            position: absolute;
            right: 17mm;
            bottom: 13mm;
            z-index: 2;
            color: #F7EFE1;
            font-family: DejaVu Sans, sans-serif;
            font-size: 42pt;
            font-weight: bold;
        }

        /* Logo dan pita berada di header yang tetap pada halaman yang sama. */
        .logo-area {
            position: absolute;
            left: 25mm;
            top: 18mm;
            width: 62mm;
            height: 19mm;
            z-index: 5;
        }
        .logo-img {
            display: block;
            max-width: 58mm;
            max-height: 17mm;
        }
        .logo-fallback {
            color: #330711;
            font-size: 21pt;
            font-weight: bold;
            letter-spacing: 1.2pt;
        }
        .ribbon-area {
            position: absolute;
            right: 23mm;
            top: 10mm;
            width: 33mm;
            height: 43mm;
            text-align: center;
            z-index: 6;
        }
        .ribbon-img {
            display: block;
            max-width: 31mm;
            max-height: 41mm;
            width: auto;
            height: auto;
            margin: 0 auto;
        }
        /* Fallback jika pita PNG belum diletakkan di public/sertif. */
        .ribbon-fallback {
            position: relative;
            width: 29mm;
            height: 41mm;
            margin: 0 auto;
        }
        .ribbon-medal {
            position: absolute;
            left: 4mm;
            top: 0;
            width: 21mm;
            height: 21mm;
            border: 2.2pt solid #B98D2E;
            border-radius: 50%;
            background: #F3D98E;
            color: #74172B;
            text-align: center;
            line-height: 18mm;
            font-size: 19pt;
            font-weight: bold;
        }
        .ribbon-tail-left, .ribbon-tail-right {
            position: absolute;
            top: 18mm;
            width: 8mm;
            height: 22mm;
            background: #74172B;
            border-left: 1pt solid #D6AD45;
            border-right: 1pt solid #D6AD45;
        }
        .ribbon-tail-left {
            left: 5mm;
            transform: rotate(8deg);
        }
        .ribbon-tail-right {
            right: 5mm;
            transform: rotate(-8deg);
        }

        /* Seluruh teks menggunakan koordinat tetap agar tidak terdorong ke halaman 2. */
        .title {
            position: absolute;
            left: 25mm;
            top: 49mm;
            z-index: 5;
            margin: 0;
            color: #330711;
            font-family: DejaVu Sans, sans-serif;
            font-size: 34pt;
            line-height: 1.05;
            font-weight: bold;
            letter-spacing: 4pt;
        }
        .certificate-number {
            position: absolute;
            left: 25mm;
            top: 68mm;
            z-index: 5;
            padding: 2.2mm 4mm;
            border: 0.9pt solid #D6AD45;
            color: #74172B;
            background: #FFFCF8;
            font-size: 8.5pt;
            font-weight: bold;
            letter-spacing: 1pt;
        }
        .subtitle {
            position: absolute;
            left: 25mm;
            top: 84mm;
            z-index: 5;
            margin: 0;
            color: #766970;
            font-size: 11pt;
        }
        .recipient {
            position: absolute;
            left: 25mm;
            top: 94mm;
            z-index: 5;
            width: 190mm;
            margin: 0;
            color: #74172B;
            font-family: DejaVu Serif, serif;
            font-size: 27pt;
            line-height: 1.12;
            font-weight: bold;
        }
        .recipient-rule {
            position: absolute;
            left: 25mm;
            top: 108mm;
            width: 125mm;
            height: 1.2pt;
            background: #D6AD45;
            z-index: 5;
        }
        .description {
            position: absolute;
            left: 25mm;
            top: 114mm;
            width: 220mm;
            z-index: 5;
            margin: 0;
            color: #5F5156;
            font-size: 10pt;
            line-height: 1.55;
        }
        .module-name {
            position: absolute;
            left: 25mm;
            top: 130mm;
            z-index: 5;
            margin: 0;
            color: #74172B;
            font-size: 16pt;
            line-height: 1.15;
            font-weight: bold;
        }
        .language-name {
            position: absolute;
            left: 25mm;
            top: 138mm;
            z-index: 5;
            margin: 0;
            color: #96721F;
            font-size: 8.5pt;
            font-weight: bold;
            letter-spacing: 1.5pt;
        }
        .closing-note {
            position: absolute;
            left: 25mm;
            top: 146mm;
            width: 220mm;
            z-index: 5;
            margin: 0;
            color: #766970;
            font-size: 8.5pt;
            line-height: 1.45;
        }

        /* Area tanda tangan berada di bagian bawah halaman, tidak memakai footer flow. */
        .signature-block {
            position: absolute;
            left: 25mm;
            top: 164mm;
            width: 85mm;
            height: 34mm;
            z-index: 5;
        }
        .issue-date {
            margin: 0 0 1mm 0;
            color: #3D3034;
            font-size: 9pt;
            font-weight: bold;
        }
        .signature-img {
            display: block;
            max-width: 43mm;
            max-height: 14mm;
            margin: 0 0 0.5mm 0;
        }
        .signature-placeholder {
            height: 12mm;
        }
        .signature-line {
            width: 60mm;
            height: 0.8pt;
            margin: 0 0 1.2mm 0;
            background: #8A777E;
        }
        .sign-name {
            margin: 0;
            color: #330711;
            font-size: 9pt;
            font-weight: bold;
        }
        .sign-role {
            margin: 0.7mm 0 0 0;
            color: #766970;
            font-size: 7.5pt;
        }
        .footer-number {
            position: absolute;
            right: 25mm;
            bottom: 13mm;
            z-index: 5;
            color: #96721F;
            font-size: 7pt;
            letter-spacing: .5pt;
        }
    </style>
</head>
<body>
@php
    $tanggal = \Illuminate\Support\Carbon::parse($tanggalTerbit)
        ->locale('id')
        ->translatedFormat('d F Y');

    $namaModul = $modul->nama_modul ?? 'Kelas Belajar Pemrograman';
    $namaBahasa = $modul->bahasa->nama_bahasa ?? 'Pemrograman';

    /*
     * DomPDF lebih stabil membaca gambar lokal melalui data URI daripada asset()/URL.
     * Letakkan gambar pada public/sertif sesuai petunjuk instalasi.
     */
    $readPublicImage = static function (string $relativePath): ?string {
        $fullPath = public_path($relativePath);

        if (!is_file($fullPath) || !is_readable($fullPath)) {
            return null;
        }

        $mime = function_exists('mime_content_type')
            ? (mime_content_type($fullPath) ?: 'image/png')
            : 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($fullPath));
    };

    $logoDataUri = $readPublicImage('sertif/logo.png')
        ?? $readPublicImage('images/favicon.png');

    $signatureDataUri = $readPublicImage('sertif/ceo.png');
    $ribbonDataUri = $readPublicImage('sertif/pita-penghargaan.png');

    $namaPenerimaTtd = 'Rahmadi';
    $jabatanPenerimaTtd = 'CEO CodeTutor';
@endphp

<div class="certificate-page">
    <div class="outer-frame"></div>
    <div class="inner-frame"></div>
    <div class="corner corner-tl-maroon"></div>
    <div class="corner corner-tl-gold"></div>
    <div class="corner corner-br-maroon"></div>
    <div class="corner corner-br-gold"></div>
    <div class="watermark">CT</div>

    <div class="logo-area">
        @if ($logoDataUri)
            <img class="logo-img" src="{{ $logoDataUri }}" alt="Logo CodeTutor">
        @else
            <div class="logo-fallback">CodeTutor</div>
        @endif
    </div>

    <div class="ribbon-area">
        @if ($ribbonDataUri)
            <img class="ribbon-img" src="{{ $ribbonDataUri }}" alt="Pita penghargaan">
        @else
            <div class="ribbon-fallback" aria-label="Pita penghargaan">
                <div class="ribbon-tail-left"></div>
                <div class="ribbon-tail-right"></div>
                <div class="ribbon-medal">★</div>
            </div>
        @endif
    </div>

    <h1 class="title">SERTIFIKAT</h1>
    <div class="certificate-number">NO. SERTIFIKAT: {{ $nomorSertifikat }}</div>
    <p class="subtitle">Dengan bangga diberikan kepada</p>
    <h2 class="recipient">{{ $pelajar->nama ?? 'Nama Pelajar' }}</h2>
    <div class="recipient-rule"></div>

    <p class="description">
        Atas keberhasilan menyelesaikan kelas <strong>{{ $namaModul }}</strong>
        dalam program pembelajaran pemrograman CodeTutor.
    </p>

    <h3 class="module-name">{{ $namaModul }}</h3>
    <p class="language-name">{{ strtoupper($namaBahasa) }}</p>

    <p class="closing-note">
        Sertifikat ini diberikan sebagai penghargaan atas ketekunan, komitmen, dan pencapaian dalam proses belajar.
        Semoga ilmu dan keterampilan yang diperoleh menjadi bekal untuk terus berkembang dan berkarya di bidang teknologi.
    </p>

    <div class="signature-block">
        <p class="issue-date">{{ $tanggal }}</p>
        @if ($signatureDataUri)
            <img class="signature-img" src="{{ $signatureDataUri }}" alt="Tanda tangan CEO CodeTutor">
        @else
            <div class="signature-placeholder"></div>
        @endif
        <div class="signature-line"></div>
        <p class="sign-name">{{ $namaPenerimaTtd }}</p>
        <p class="sign-role">{{ $jabatanPenerimaTtd }}</p>
    </div>

    <div class="footer-number">DOKUMEN ELEKTRONIK CODETUTOR</div>
</div>
</body>
</html>

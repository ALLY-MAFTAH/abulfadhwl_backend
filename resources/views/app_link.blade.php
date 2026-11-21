<!doctype html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Abul Fadhwl</title>
    <meta name="description" content="{{ $desc }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Abul Fadhwl">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $desc }}">
    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary">
    <style>
        body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;
             background:linear-gradient(160deg,#060b1d,#12204a);color:#eaf0ff;
             font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;padding:24px;box-sizing:border-box}
        .card{max-width:380px;width:100%;text-align:center;background:rgba(255,255,255,.07);
              border:1px solid rgba(255,255,255,.15);border-radius:16px;padding:32px 24px}
        h1{margin:0 0 4px;font-size:26px;color:#e9b23c}
        p{margin:0 0 24px;opacity:.85}
        a.btn{display:block;margin:10px 0;padding:14px;border-radius:16px;text-decoration:none;font-weight:700}
        .primary{background:linear-gradient(135deg,#ffd98a,#e9b23c);color:#060b1d}
        .store{background:rgba(255,255,255,.1);color:#eaf0ff}
    </style>
</head>
<body>
<div class="card">
    <h1>Abul Fadhwl</h1>
    <p><b>{{ $title }}</b><br>{{ $label }}: fungua kwenye app</p>
    <a class="btn primary" href="{{ $deepLink }}">Fungua kwenye App</a>
    @if(!empty($fileUrl))
        @if($isAudio)
            <audio controls preload="none" src="{{ $fileUrl }}" style="width:100%;margin:6px 0 4px"></audio>
        @else
            <a class="btn store" href="{{ $fileUrl }}" target="_blank" rel="noopener">Fungua faili kwenye browser</a>
        @endif
    @endif
    @if($androidUrl && $androidUrl !== '#')
        <a class="btn store" href="{{ $androidUrl }}">Pakua kwa Android</a>
    @endif
    @if($iosUrl && $iosUrl !== '#')
        <a class="btn store" href="{{ $iosUrl }}">Pakua kwa iPhone</a>
    @endif
</div>
</body>
</html>

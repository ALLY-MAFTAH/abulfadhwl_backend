<!doctype html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Abul Fadhwl: {{ $label }}</title>
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
    <p>{{ $label }}: fungua kwenye app</p>
    <a class="btn primary" href="{{ $deepLink }}">Fungua kwenye App</a>
    @if($androidUrl && $androidUrl !== '#')
        <a class="btn store" href="{{ $androidUrl }}">Pakua kwa Android</a>
    @endif
    @if($iosUrl && $iosUrl !== '#')
        <a class="btn store" href="{{ $iosUrl }}">Pakua kwa iPhone</a>
    @endif
</div>
</body>
</html>

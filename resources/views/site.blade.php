@php
    $appName = config('app.name', 'Abul Fadhwl App');
    // Weka viungo halisi vya maduka hapa ikishachapishwa (null = "inakuja karibuni").
    $playUrl = null;
    $appleUrl = null;
    $all = include resource_path('views/site_i18n.php');
    $lang = isset($lang, $all[$lang]) ? $lang : 'sw';
    $t = $all[$lang];
    $c = $counts ?? ['songs' => 0, 'books' => 0, 'articles' => 0, 'albums' => 0];
    // Picha halisi za app: weka PNG kwenye public/assets/screens/ (home, player, live, library).
    $shot = fn($n) => file_exists(public_path("assets/screens/v3/$n.webp")) ? asset("assets/screens/v3/$n.webp") : null;
    $flags = ['sw' => 'tz', 'en' => 'gb', 'ar' => 'sa'];
@endphp
<!doctype html>
<html lang="{{ $lang }}" dir="{{ $t['dir'] }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appName }}</title>
    <meta name="description" content="{{ $t['meta'] }}">
    <meta name="theme-color" content="#1e3070">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&family=Amiri+Quran&family=Scheherazade+New:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @if ($shot('home-l') ?: $shot('home'))<link rel="preload" as="image" href="{{ $shot('home-l') ?: $shot('home') }}">@endif
    <link href="{{ asset('css/site.css') }}?v=48" rel="stylesheet">
</head>
<body class="lp">
    <div class="bism-bar">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>

    <nav class="nav">
        <a class="brand" href="#top"><img src="{{ asset('assets/images/logo.png') }}" alt=""> <span>{{ $appName }}</span></a>
        <div class="links"><a href="#vipengele">{{ $t['nav_features'] }}</a><a href="#app">{{ $t['nav_app'] }}</a><a href="#pakua">{{ $t['nav_get'] }}</a></div>
        <div class="langs">
            @foreach ($flags as $code => $cc)
                <a href="?lang={{ $code }}" class="{{ $lang === $code ? 'on' : '' }}" title="{{ $all[$code]['name'] }}"><img src="https://flagcdn.com/w40/{{ $cc }}.png" alt="{{ $all[$code]['name'] }}"></a>
            @endforeach
        </div>
        <a class="login" href="{{ route('login') }}"><i class="fas fa-lock"></i> {{ $t['login'] }}</a>
    </nav>

    <!-- 1 · Hero -->
    <header class="s1" id="top">
        <div class="sun"></div><div class="cloud c1"></div><div class="cloud c2"></div>
        <div class="wrap hero">
            <div>
                <div class="logo"><img src="{{ asset('assets/images/logo.png') }}" alt="{{ $appName }}"></div>
                <div class="eyebrow mono">{{ $t['eyebrow'] }}</div>
                <h1 class="title"><span class="gold">{{ $appName }}</span><br>{{ $t['hero_tag'] }}</h1>
                <p class="sub">{{ $t['sub'] }}</p>
                <div class="sheikh">
                    <span class="sh-ic"><i class="fas fa-microphone-alt"></i></span>
                    <span class="sh-tx"><small class="mono">{{ $t['sh_l'] }}</small><b>{{ $t['sh_n'] }}</b><em>{{ $t['sh_s'] }}</em></span>
                </div>
                <div class="chips">
                    @foreach ($t['chips'] as $i => $chip)
                        <span class="chip"><i class="fas {{ ['fa-gift','fa-language','fa-download','fa-bell','fa-adjust'][$i] }}"></i> {{ $chip }}</span>
                    @endforeach
                </div>
                <div class="stores">
                    <a class="badge {{ $playUrl ? '' : 'soon' }}" @if ($playUrl) href="{{ $playUrl }}" @endif><i class="fab fa-google-play"></i><span><small>Get it on</small><b>Google Play</b>@unless ($playUrl)<span class="soon-tag">{{ $t['soon'] }}</span>@endunless</span></a>
                    <a class="badge {{ $appleUrl ? '' : 'soon' }}" @if ($appleUrl) href="{{ $appleUrl }}" @endif><i class="fab fa-apple"></i><span><small>Download on the</small><b>App Store</b>@unless ($appleUrl)<span class="soon-tag">{{ $t['soon'] }}</span>@endunless</span></a>
                </div>
            </div>
            <div class="stage">
                <div class="fchip f1"><i class="fas fa-broadcast-tower"></i> {{ $t['f1'] }}</div>
                <div class="fchip f2"><i class="fas fa-moon"></i> {{ $t['f2'] }}</div>
                <div class="fchip f3"><i class="fas fa-book-open"></i> {{ $t['f3'] }}</div>
                @if ($shot('home') && $shot('home-l'))<div class="back-wrap"><div class="phone"><img class="shotimg" src="{{ $shot('home') }}" alt="" width="432" height="888" decoding="async"></div></div>@endif
                <div class="phone front">
                    @if ($shot('home-l') ?: $shot('home'))
                        <img class="shotimg" src="{{ $shot('home-l') ?: $shot('home') }}" alt="{{ $appName }}" width="432" height="888" fetchpriority="high" decoding="async">
                    @else
                    <div class="scr">
                        <div class="s-top">{{ $appName }} <i class="fas fa-bullhorn"></i></div>
                        <div class="s-card"><span class="g"><i class="fas fa-moon"></i> {{ $t['m_hijri'] }}</span><b>{{ $t['m_fast'] }}</b>
                            <div class="s-week"><span>1</span><span>2</span><span class="on">3</span><span>4</span><span class="on">5</span><span>6</span><span>7</span></div></div>
                        <div class="s-live"><span class="dot"></span> {{ $t['m_live'] }} <i class="fas fa-chevron-right" style="margin-left:auto"></i></div>
                        <div class="s-list">
                            <div class="s-item"><i class="fas fa-headphones"></i> {{ $t['m_lessons'] }}</div>
                            <div class="s-item"><i class="fas fa-book"></i> {{ $t['m_books'] }}</div>
                            <div class="s-item"><i class="fas fa-question-circle"></i> {{ $t['m_qa'] }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="waves"><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#000" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#000" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#000" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg></div>
    </header>

    <!-- 2 · Features + app -->
    <section class="s2" id="vipengele">
        <div class="wrap">
            <div class="stats">
                <div class="stat rv" style="--c1:#3b63d6;--c2:#1b2d63;--d:0.0s"><span class="ic"><i class="fas fa-headphones"></i></span><div><div class="n" data-n="{{ $c['songs'] }}">0</div><div class="l">{{ $t['st_songs'] }}</div></div></div>
                <div class="stat rv" style="--c1:#e9b23c;--c2:#b98418;--d:0.06s"><span class="ic"><i class="fas fa-book"></i></span><div><div class="n" data-n="{{ $c['books'] }}">0</div><div class="l">{{ $t['st_books'] }}</div></div></div>
                <div class="stat rv" style="--c1:#22c27a;--c2:#0e8f57;--d:0.12s"><span class="ic"><i class="fas fa-file-alt"></i></span><div><div class="n" data-n="{{ $c['articles'] }}">0</div><div class="l">{{ $t['st_articles'] }}</div></div></div>
                <div class="stat rv" style="--c1:#8b6cf0;--c2:#5b3fc4;--d:0.18s"><span class="ic"><i class="fas fa-layer-group"></i></span><div><div class="n" data-n="{{ $c['albums'] }}">0</div><div class="l">{{ $t['st_albums'] }}</div></div></div>
                
            </div>

            <div class="feat-area">
            <div class="vframe">
                <div class="bgvid" aria-hidden="true"><video muted playsinline preload="none" data-srcs="{{ asset('assets/video/lib1_hq.mp4') }}|{{ asset('assets/video/lib2_hq.mp4') }}" data-posters="{{ asset('assets/video/lib1_hq.jpg') }}|{{ asset('assets/video/lib2_hq.jpg') }}"></video></div>
                <div class="vw w-live"><span class="dot"></span> {{ $t['f1'] }}</div>
                <div class="vw w-play"><span class="pl"><i class="fas fa-play"></i></span><span class="tx"><b>{{ $t['feats'][0][0] }}</b><i class="bar"><u></u></i></span></div>
                <div class="vw w-book"><i class="fas fa-book-open"></i> {{ $t['f3'] }}</div>
            </div>
            <div class="head rv"><span class="eb">{{ $t['feat_eb'] }}</span><h2>{{ $t['feat_h'] }}</h2><p>{{ $t['feat_p'] }}</p></div>
            <div class="feat-wrap">
            <div class="grid6">
                <div class="card rv" style="--c1:#3b63d6;--c2:#1b2d63;--d:0.0s"><div class="ic"><i class="fas fa-headphones"></i></div><h3>{{ $t['feats'][0][0] }}</h3><p>{{ $t['feats'][0][1] }}</p></div>
                <div class="card rv" style="--c1:#ff4d4d;--c2:#c42b2b;--d:0.06s"><div class="ic"><i class="fas fa-broadcast-tower"></i></div><h3>{{ $t['feats'][1][0] }}</h3><p>{{ $t['feats'][1][1] }}</p></div>
                <div class="card rv" style="--c1:#e9b23c;--c2:#b98418;--d:0.12s"><div class="ic"><i class="fas fa-book-open"></i></div><h3>{{ $t['feats'][2][0] }}</h3><p>{{ $t['feats'][2][1] }}</p></div>
                <div class="card rv" style="--c1:#22c27a;--c2:#0e8f57;--d:0.0s"><div class="ic"><i class="fas fa-question-circle"></i></div><h3>{{ $t['feats'][3][0] }}</h3><p>{{ $t['feats'][3][1] }}</p></div>
                <div class="card rv" style="--c1:#8b6cf0;--c2:#5b3fc4;--d:0.06s"><div class="ic"><i class="fas fa-moon"></i></div><h3>{{ $t['feats'][4][0] }}</h3><p>{{ $t['feats'][4][1] }}</p></div>
                <div class="card rv" style="--c1:#3fc8e4;--c2:#2b4bb5;--d:0.12s"><div class="ic"><i class="fas fa-bell"></i></div><h3>{{ $t['feats'][5][0] }}</h3><p>{{ $t['feats'][5][1] }}</p></div>
                
            </div>
            </div>
            </div>

            <div class="head rv" id="app" style="margin-top:44px"><span class="eb">{{ $t['app_eb'] }}</span><h2>{{ $t['app_h'] }}</h2></div>
            <div class="phones">
                @foreach ([['player-l', 1], ['live', 2], ['library-l', 3], ['sauti', 4], ['qa-l', 5]] as $k => [$img, $ci])
                    <div class="rv" style="--d:{{ $k * .07 }}s;{{ $k % 2 ? 'margin-top:26px' : '' }}">
                        <div class="phone sm">
                            @if ($shot($img))<img class="shotimg" src="{{ $shot($img) }}" alt="{{ $t['cap'][$ci][0] }}" width="432" height="888" decoding="async">
                            @else<div class="scr"><div class="s-top">{{ $t['cap'][$ci][0] }}</div></div>@endif
                        </div>
                        <div class="cap">{{ $t['cap'][$ci][0] }}<small>{{ $t['cap'][$ci][1] }}</small></div>
                    </div>
                @endforeach
            </div>

            @if ($stream)
                <div class="livebox rv"><span class="dot" style="display:inline-block"></span> &nbsp;{{ $t['live_now'] }}</div>
            @endif
            <div class="hist rv" id="historia">
                <div class="head"><span class="eb mono">{{ $t['hs_eb'] }}</span><h2>{{ $t['hs_t'] }}</h2><p>{{ $t['hs_s'] }}</p></div>
                <div class="hist-grid @if (count($histories ?? []) === 0) solo @endif">
                    <div class="hist-card">
                        <img class="emb" src="{{ asset('assets/images/emblem.webp') }}" alt="" width="300" height="300">
                        <div class="hc-tx">
                            <div class="ar-name">الشيخ قاسم بن مفوتا بن قاسم</div>
                            <div class="ar-du">حفظه الله ورعاه ووفقه وبارك فيه وفي علمه</div>
                            @if (count($histories ?? []) === 0)<div class="solo-note"><i class="fas fa-book-reader"></i> {{ $t['hs_empty'] }}</div>@endif
                        </div>
                    </div>
                    @if (count($histories ?? []))<div class="tl">
                        @forelse (($histories ?? []) as $i => $h)
                            <details class="tl-i" @if ($i === 0) open @endif><summary><span class="n">{{ $i + 1 }}</span><span class="h">{{ $h->heading }}</span></summary><div class="tl-b">{!! nl2br(e($h->content)) !!}</div></details>
                        @empty
                            <div class="tl-empty"><i class="fas fa-book-reader"></i> {{ $t['hs_empty'] }}</div>
                        @endforelse
                    </div>@endif
                </div>
                <div class="tafsir"><span class="tf-ic"><i class="fas fa-quran"></i></span><span class="tf-tx"><b>{{ $t['tf_t'] }}</b><em>{{ $t['tf_s'] }}</em></span><span class="tf-tag">{{ $t['soon'] }}</span></div>
            </div>
        </div>
    </section>

    <!-- 3 · Download -->
    <section class="s3" id="pakua">
        <div class="wrap">
            <div class="panel rv">
                <h2>{{ $t['cta_h'] }}</h2>
                <p class="lead">{{ str_replace(':app', $appName, $t['cta_p']) }}</p>
                <div class="dz-card">
                    <div class="dz"><span class="dz-ic"><i class="fas fa-arrow-down"></i></span><div class="dz-t">{{ $t['dz_t'] }}</div><div class="dz-s mono">{{ $t['dz_s'] }}</div></div>
                    <div class="dz-row"><span class="mono lbl">{{ $t['dz_for'] }}</span>
                        @foreach ($t['dz_chips'] as $ch)<button type="button" class="tgl on"><b>✓</b> {{ $ch }}</button>@endforeach
                    </div>
                    <div class="dz-line mono">→ <span id="dzline" data-tpl="{{ $t['dz_line'] }}"></span></div>
                    <a class="dz-btn {{ ($playUrl || $appleUrl) ? '' : 'off' }}" @if ($playUrl || $appleUrl) href="{{ $playUrl ?: $appleUrl }}" @endif><i class="fas fa-arrow-down"></i> {{ $t['dz_btn'] }} @unless ($playUrl || $appleUrl)<small>· {{ $t['soon'] }}</small>@endunless</a>
                </div>
                <div class="plats"><span class="mono lbl">{{ $t['pl_t'] }}</span><span class="pl"><i class="fab fa-windows"></i> Windows</span><span class="pl"><i class="fab fa-apple"></i> macOS</span><span class="pl"><i class="fas fa-globe"></i> {{ $t['pl_w'] }}</span></div>
                <a class="dz-foot" href="#vipengele">{{ $t['dz_foot'] }}</a>
                <div class="steps">
                    @foreach ($t['steps'] as $i => $st)
                        <div class="step"><span class="nm">{{ $i + 1 }}</span><div><b>{{ $st[0] }}</b><span>{{ $st[1] }}</span></div></div>
                        @if ($i < 2)<div class="arr"><svg viewBox="0 0 40 20"><path d="M2 10 H32 M25 3 L34 10 L25 17" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>@endif
                    @endforeach
                </div>
                <div class="dua">اللَّهُمَّ انْفَعْنَا بِمَا عَلَّمْتَنَا</div>
                <div class="dua-t">{{ $t['dua_t'] }}</div>
                <div class="pc">
                    <div class="ct-t mono">{{ $t['ct_t'] }}</div>
                    <div class="ct-row">
                        <a class="ct" href="https://wa.me/255714871033" target="_blank" rel="noopener" style="--c1:#25d366;--c2:#1ebe57"><span class="ct-ic"><i class="fab fa-whatsapp"></i></span><span dir="ltr">+255 714 871 033</span></a>
                        <a class="ct" href="mailto:allymaftah69@gmail.com" style="--c1:#ea4335;--c2:#b3261e"><span class="ct-ic"><i class="fas fa-envelope"></i></span><span dir="ltr">allymaftah69@gmail.com</span></a>
                    </div>
                </div>
                <div class="stores">
                    <a class="badge {{ $playUrl ? '' : 'soon' }}" @if ($playUrl) href="{{ $playUrl }}" @endif><i class="fab fa-google-play"></i><span><small>Get it on</small><b>Google Play</b>@unless ($playUrl)<span class="soon-tag">{{ $t['soon'] }}</span>@endunless</span></a>
                    <a class="badge {{ $appleUrl ? '' : 'soon' }}" @if ($appleUrl) href="{{ $appleUrl }}" @endif><i class="fab fa-apple"></i><span><small>Download on the</small><b>App Store</b>@unless ($appleUrl)<span class="soon-tag">{{ $t['soon'] }}</span>@endunless</span></a>
                </div>
            </div>
            @if (($links ?? collect())->count())
                @php
                    $brand = function ($l) {
                        $k = strtolower(($l->title ?? '') . ' ' . ($l->url ?? ''));
                        $has = fn ($w) => collect($w)->contains(fn ($x) => str_contains($k, $x));
                        if ($has(['whatsapp', 'wa.me'])) return ['fab fa-whatsapp', '#25d366', '#1ebe57'];
                        if ($has(['facebook', 'fb.com', 'fb.me'])) return ['fab fa-facebook-f', '#1877f2', '#0b57c7'];
                        if ($has(['instagram'])) return ['fab fa-instagram', '#f58529', '#dd2a7b'];
                        if ($has(['youtube', 'youtu.be'])) return ['fab fa-youtube', '#ff2d2d', '#b80000'];
                        if ($has(['telegram', 't.me'])) return ['fab fa-telegram-plane', '#2aabee', '#1b86c4'];
                        if ($has(['tiktok'])) return ['fab fa-tiktok', '#2b2b2b', '#000000'];
                        if ($has(['twitter', 'x.com'])) return ['fab fa-twitter', '#1d9bf0', '#0b6aa8'];
                        if ($has(['mailto', 'email', 'e-mail', 'barua', '@'])) return ['fas fa-envelope', '#ea4335', '#b3261e'];
                        if ($has(['tel:', 'simu', 'phone', 'call'])) return ['fas fa-phone-alt', '#34c759', '#1f8f3a'];
                        return ['fas fa-globe', '#38a3f5', '#1d5fd1'];
                    };
                    $href = function ($u) {
                        $u = trim((string) $u);
                        if (preg_match('~^(https?:|mailto:|tel:)~i', $u)) return $u;
                        if (str_contains($u, '@') && ! str_contains($u, '/')) return 'mailto:' . $u;
                        if (preg_match('~^\+?[0-9 ()-]{7,}$~', $u)) return 'tel:' . preg_replace('~[^0-9+]~', '', $u);
                        return 'https://' . $u;
                    };
                @endphp
                <div class="contacts rv">
                    <div class="ct-t mono">{{ $t['ct_t'] }}</div>
                    <div class="ct-row">
                        @foreach ($links as $l)
                            @php [$ic, $c1, $c2] = $brand($l); @endphp
                            <a class="ct" href="{{ $href($l->url) }}" target="_blank" rel="noopener" style="--c1:{{ $c1 }};--c2:{{ $c2 }}"><span class="ct-ic"><i class="{{ $ic }}"></i></span><span>{{ $l->title }}</span></a>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="foot">
                <img src="{{ asset('assets/images/logo.png') }}" alt=""><br>
                &copy; {{ date('Y') }} {{ $appName }} · <a href="{{ route('login') }}">{{ $t['admins'] }}</a>
            </div>
        </div>
    </section>

    <script>
        (function () {
            var io = new IntersectionObserver(function (es) {
                es.forEach(function (e) {
                    if (!e.isIntersecting) return;
                    e.target.classList.add('in'); io.unobserve(e.target);
                    var n = e.target.querySelector('[data-n]');
                    if (n) { var to = +n.dataset.n, t0 = performance.now();
                        (function tick(t) { var p = Math.min(1, (t - t0) / 1300); n.textContent = Math.round(to * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(tick); })(t0); }
                });
            }, { threshold: .12 });
            document.querySelectorAll('.rv').forEach(function (el) { io.observe(el); });
        document.querySelectorAll('.tgl').forEach(function (b) { b.addEventListener('click', function () { b.classList.toggle('on'); b.firstElementChild.textContent = b.classList.contains('on') ? '✓' : '+'; upd(); }); });
        function upd() { var n = document.querySelectorAll('.tgl.on').length, l = document.getElementById('dzline'); if (l) l.textContent = l.dataset.tpl.replace(':n', n); }
        upd();

        })();
    </script>
<script>
(function () {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    document.querySelectorAll('.bgvid').forEach(function (box) {
        var v = box.querySelector('video'), srcs = v.dataset.srcs.split('|'), posters = v.dataset.posters.split('|'), i = 0, started = false;
        v.poster = posters[0];
        box.classList.add('on');
        if (reduce) return;
        function load(n) { i = n % srcs.length; v.poster = posters[i]; v.src = srcs[i]; v.load(); }
        function play() { var p = v.play(); if (p && p.catch) p.catch(function () {}); }
        v.addEventListener('ended', function () {
            box.classList.remove('on');
            setTimeout(function () { load(i + 1); play(); box.classList.add('on'); }, 900);
        });
        new IntersectionObserver(function (es) {
            es.forEach(function (e) {
                if (e.isIntersecting) { if (!started) { started = true; load(i); } play(); }
                else if (started) { v.pause(); }
            });
        }, { threshold: 0.05 }).observe(box);
    });
})();
</script>
</body>
</html>

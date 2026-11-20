@php
    $appName = config('app.name', 'Abul Fadhwl App');
    // Weka viungo halisi vya maduka hapa ikishachapishwa (null = "inakuja karibuni").
    $playUrl = null;
    $appleUrl = null;
    $c = $counts ?? ['songs' => 0, 'books' => 0, 'articles' => 0, 'albums' => 0];
@endphp
<!doctype html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $appName }} — Elimu kwa mwongozo wa Qur'an na Sunnah</title>
    <meta name="description" content="Darsa za sauti, vitabu, makala, darsa za moja kwa moja, maswali na majibu, na funga za Sunnah — vyote ndani ya {{ $appName }}.">
    <meta name="theme-color" content="#0b1530">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Aref+Ruqaa:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/lp.css') }}?v=1" rel="stylesheet">
    <link href="{{ asset('css/lp-dusk.css') }}?v=1" rel="stylesheet">
</head>
<body class="lp">
    <div class="bism-bar">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>

    <nav class="nav">
        <a class="brand" href="#top"><img src="{{ asset('assets/images/logo.png') }}" alt=""> <span>{{ $appName }}</span></a>
        <div class="links"><a href="#vipengele">Vipengele</a><a href="#app">Ndani ya app</a><a href="#pakua">Pakua</a></div>
        <a class="login" href="{{ route('login') }}"><i class="fas fa-lock"></i> Ingia</a>
    </nav>

    <!-- 1 · Hero -->
    <header class="s1" id="top">
        <div class="sun"></div><div class="cloud c1"></div><div class="cloud c2"></div>
        <div class="wrap hero">
            <div>
                <div class="logo"><img src="{{ asset('assets/images/logo.png') }}" alt="{{ $appName }}"></div>
                <h1 class="title"><span class="gold">{{ $appName }}</span><br>Elimu mkononi mwako</h1>
                <p class="sub">Darsa za sauti, vitabu, makala, darsa za moja kwa moja, maswali na majibu, na funga za Sunnah — kwa mwongozo wa Qur'an na Sunnah kwa uelewa wa Salaf.</p>
                <div class="chips">
                    <span class="chip"><i class="fas fa-gift"></i> Bure</span>
                    <span class="chip"><i class="fas fa-language"></i> Kiswahili &amp; English</span>
                    <span class="chip"><i class="fas fa-download"></i> Offline</span>
                    <span class="chip"><i class="fas fa-bell"></i> Arifa</span>
                    <span class="chip"><i class="fas fa-adjust"></i> Mwanga &amp; Giza</span>
                </div>
                <div class="stores">
                    <a class="badge {{ $playUrl ? '' : 'soon' }}" @if ($playUrl) href="{{ $playUrl }}" @endif><i class="fab fa-google-play"></i><span><small>Get it on</small><b>Google Play</b>@unless ($playUrl)<span class="soon-tag">Inakuja karibuni</span>@endunless</span></a>
                    <a class="badge {{ $appleUrl ? '' : 'soon' }}" @if ($appleUrl) href="{{ $appleUrl }}" @endif><i class="fab fa-apple"></i><span><small>Download on the</small><b>App Store</b>@unless ($appleUrl)<span class="soon-tag">Inakuja karibuni</span>@endunless</span></a>
                </div>
            </div>
            <div class="stage">
                <div class="fchip f1"><i class="fas fa-broadcast-tower"></i> Darsa ya live</div>
                <div class="fchip f2"><i class="fas fa-moon"></i> Funga ya Sunnah</div>
                <div class="fchip f3"><i class="fas fa-book-open"></i> Vitabu &amp; makala</div>
                <div class="phone"><div class="scr">
                    <div class="s-top">{{ $appName }} <i class="fas fa-bullhorn"></i></div>
                    <div class="s-card"><span class="g"><i class="fas fa-moon"></i> Hijri</span><b>Funga ya kesho: Alhamisi</b>
                        <div class="s-week"><span>Jum</span><span>Jtu</span><span class="on">Jnn</span><span>Jtn</span><span class="on">Alh</span><span>Iju</span><span>Jmo</span></div></div>
                    <div class="s-live"><span class="dot"></span> Darsa ya moja kwa moja <i class="fas fa-chevron-right" style="margin-left:auto"></i></div>
                    <div class="s-list">
                        <div class="s-item"><i class="fas fa-headphones"></i> Darsa za hivi karibuni</div>
                        <div class="s-item"><i class="fas fa-book"></i> Vitabu</div>
                        <div class="s-item"><i class="fas fa-question-circle"></i> Maswali &amp; Majibu</div>
                    </div>
                </div></div>
            </div>
        </div>
        <div class="waves"><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#000" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#000" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#000" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg></div>
    </header>

    <!-- 2 · Vipengele na app -->
    <section class="s2" id="vipengele">
        <div class="wrap">
            <div class="stats">
                <div class="stat rv" style="--c1:#3b63d6;--c2:#1b2d63"><span class="ic"><i class="fas fa-headphones"></i></span><div><div class="n" data-n="{{ $c['songs'] }}">0</div><div class="l">Darsa</div></div></div>
                <div class="stat rv" style="--c1:#e9b23c;--c2:#b98418;--d:.06s"><span class="ic"><i class="fas fa-book"></i></span><div><div class="n" data-n="{{ $c['books'] }}">0</div><div class="l">Vitabu</div></div></div>
                <div class="stat rv" style="--c1:#22c27a;--c2:#0e8f57;--d:.12s"><span class="ic"><i class="fas fa-file-alt"></i></span><div><div class="n" data-n="{{ $c['articles'] }}">0</div><div class="l">Makala</div></div></div>
                <div class="stat rv" style="--c1:#8b6cf0;--c2:#5b3fc4;--d:.18s"><span class="ic"><i class="fas fa-layer-group"></i></span><div><div class="n" data-n="{{ $c['albums'] }}">0</div><div class="l">Albamu</div></div></div>
            </div>

            <div class="head rv"><span class="eb">Vipengele</span><h2>Kila unachohitaji kwa elimu</h2><p>Nyepesi, ya haraka na rahisi — kwa Kiswahili na English.</p></div>
            <div class="grid6">
                <div class="card rv" style="--c1:#3b63d6;--c2:#1b2d63"><div class="ic"><i class="fas fa-headphones"></i></div><h3>Darsa za sauti</h3><p>Endelea ulipoachia, kasi ya sauti, kipima-muda, na pakua usikilize offline.</p></div>
                <div class="card rv" style="--c1:#ff4d4d;--c2:#c42b2b;--d:.06s"><div class="ic"><i class="fas fa-broadcast-tower"></i></div><h3>Darsa ya live</h3><p>Arifa ikianza, app inaonyesha LIVE papo hapo; ikiisha player inajizima.</p></div>
                <div class="card rv" style="--c1:#e9b23c;--c2:#b98418;--d:.12s"><div class="ic"><i class="fas fa-book-open"></i></div><h3>Vitabu na makala</h3><p>Soma PDF ndani ya app, hifadhi, na shiriki kiungo au faili.</p></div>
                <div class="card rv" style="--c1:#22c27a;--c2:#0e8f57"><div class="ic"><i class="fas fa-question-circle"></i></div><h3>Maswali na majibu</h3><p>Tuma swali, upate jibu la maandishi au sauti.</p></div>
                <div class="card rv" style="--c1:#8b6cf0;--c2:#5b3fc4;--d:.06s"><div class="ic"><i class="fas fa-moon"></i></div><h3>Hijri na funga</h3><p>Tarehe ya Hijri na funga za Sunnah zilizo karibu.</p></div>
                <div class="card rv" style="--c1:#3fc8e4;--c2:#2b4bb5;--d:.12s"><div class="ic"><i class="fas fa-bell"></i></div><h3>Arifa za papo hapo</h3><p>Matangazo mapya na darsa za live bila kufungua app.</p></div>
            </div>

            <div class="head rv" id="app" style="margin-top:44px"><span class="eb">Ndani ya app</span><h2>Jinsi inavyoonekana</h2></div>
            <div class="phones">
                <div class="rv"><div class="phone sm"><div class="scr">
                    <div class="s-top">Sauti <i class="fas fa-chevron-down"></i></div>
                    <div style="text-align:center;margin:auto 0"><div class="s-art"><i class="fas fa-headphones"></i></div><b style="color:#fff;font-size:11px">Darsa ya leo</b>
                        <div class="wave"><i style="--i:0"></i><i style="--i:1"></i><i style="--i:2"></i><i style="--i:3"></i><i style="--i:4"></i><i style="--i:5"></i><i style="--i:6"></i><i style="--i:7"></i><i style="--i:8"></i><i style="--i:9"></i><i style="--i:10"></i><i style="--i:11"></i><i style="--i:12"></i><i style="--i:13"></i><i style="--i:14"></i><i style="--i:15"></i></div><div class="bar"><b></b></div>
                        <div class="ctl"><i class="fas fa-undo"></i><span class="play"><i class="fas fa-pause"></i></span><i class="fas fa-redo"></i></div></div>
                </div></div><div class="cap">Player<small>Sikiliza kwa utulivu</small></div></div>
                <div class="rv" style="--d:.08s;margin-top:26px"><div class="phone sm"><div class="scr">
                    <div class="s-top">Live <i class="fas fa-broadcast-tower"></i></div>
                    <div class="s-live"><span class="dot"></span> LIVE sasa</div>
                    <div class="s-card"><b>Darsa ya moja kwa moja</b>Gusa kusikiliza papo hapo</div>
                    <div class="s-card"><span class="g"><i class="fas fa-bell"></i> Arifa</span><b>Darsa imeanza</b>Fungua uungane</div>
                    <div class="s-list"><div class="s-item"><i class="fas fa-calendar-alt"></i> Ratiba</div><div class="s-item"><i class="fas fa-share-alt"></i> Sambaza kiungo</div></div>
                </div></div><div class="cap">Live<small>Darsa papo hapo</small></div></div>
                <div class="rv" style="--d:.16s"><div class="phone sm"><div class="scr">
                    <div class="s-top">Maktaba <i class="fas fa-search"></i></div>
                    <div class="s-list" style="margin-top:4px">
                        <div class="s-item"><i class="fas fa-book"></i> Aqiidah</div><div class="s-item"><i class="fas fa-book"></i> Fiqhi</div><div class="s-item"><i class="fas fa-file-alt"></i> Makala mpya</div><div class="s-item"><i class="fas fa-bookmark"></i> Ulizohifadhi</div><div class="s-item"><i class="fas fa-download"></i> Zilizopakuliwa</div>
                    </div>
                </div></div><div class="cap">Maktaba<small>Vitabu na makala</small></div></div>
            </div>

            @if ($stream)
                <div class="livebox rv"><span class="dot" style="display:inline-block"></span> &nbsp;Darsa ya moja kwa moja inaendelea sasa — fungua app kuungana.</div>
            @endif
            @if ($songs->count() || $books->count())
                <div class="list">
                    @foreach ($songs as $s)
                        <div class="row rv"><span class="ic"><i class="fas fa-headphones"></i></span><span class="t">{{ $s->title }}</span>@if ($s->file)<audio controls preload="none" src="{{ asset('storage/' . $s->file) }}"></audio>@endif</div>
                    @endforeach
                    @foreach ($books as $b)
                        <div class="row rv"><span class="ic" style="background:linear-gradient(135deg,#e9b23c,#b98418)"><i class="fas fa-book"></i></span><span class="t">{{ $b->title }}</span>@if ($b->file)<a class="chip" href="{{ asset('storage/' . $b->file) }}"><i class="fas fa-download"></i> Pakua</a>@endif</div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- 3 · Pakua -->
    <section class="s3" id="pakua">
        <div class="wrap">
            <div class="panel rv">
                <h2>Anza safari ya elimu leo</h2>
                <p class="lead">Pakua {{ $appName }} na ubebe darsa, vitabu na makala popote ulipo.</p>
                <div class="steps">
                    <div class="step"><span class="nm">1</span><div><b>Pakua app</b><span>Play Store / App Store</span></div></div><div class="arr"><svg viewBox="0 0 40 20"><path d="M2 10 H32 M25 3 L34 10 L25 17" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                    <div class="step"><span class="nm">2</span><div><b>Chagua darsa</b><span>Kategoria na albamu</span></div></div><div class="arr"><svg viewBox="0 0 40 20"><path d="M2 10 H32 M25 3 L34 10 L25 17" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                    <div class="step"><span class="nm">3</span><div><b>Sikiliza na ushiriki</b><span>Wengine nao wanufaike</span></div></div>
                </div>
                <div class="dua">اللَّهُمَّ انْفَعْنَا بِمَا عَلَّمْتَنَا</div>
                <div class="dua-t">Ee Mwenyezi Mungu, tunufaishe kwa yale uliyotufundisha.</div>
                <div class="stores">
                    <a class="badge {{ $playUrl ? '' : 'soon' }}" @if ($playUrl) href="{{ $playUrl }}" @endif><i class="fab fa-google-play"></i><span><small>Get it on</small><b>Google Play</b>@unless ($playUrl)<span class="soon-tag">Inakuja karibuni</span>@endunless</span></a>
                    <a class="badge {{ $appleUrl ? '' : 'soon' }}" @if ($appleUrl) href="{{ $appleUrl }}" @endif><i class="fab fa-apple"></i><span><small>Download on the</small><b>App Store</b>@unless ($appleUrl)<span class="soon-tag">Inakuja karibuni</span>@endunless</span></a>
                </div>
            </div>
            <div class="foot">
                <img src="{{ asset('assets/images/logo.png') }}" alt=""><br>
                &copy; {{ date('Y') }} {{ $appName }} · <a href="{{ route('login') }}">Ingia (wasimamizi)</a>
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
        })();
    </script>
</body>
</html>

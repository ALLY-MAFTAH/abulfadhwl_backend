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
    <meta name="theme-color" content="#060b1d">
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/landing.css') }}?v=2" rel="stylesheet">
    <link href="{{ asset('css/landing-classic.css') }}?v=1" rel="stylesheet">
    <style>body{margin:0;font-family:"Inter",system-ui,-apple-system,"Segoe UI",sans-serif;line-height:1.5;-webkit-font-smoothing:antialiased}*{box-sizing:border-box}h1,h2,h3{margin:0;font-family:inherit}a{text-decoration:none}</style>
</head>
<body class="lp">
    <nav class="lp-nav">
        <a class="brand" href="#top"><img src="{{ asset('assets/images/logo.png') }}" alt=""> <span>{{ $appName }}</span></a>
        <div class="links"><a href="#vipengele">Vipengele</a><a href="#app">Ndani ya app</a><a href="#hatua">Jinsi ya kuanza</a><a href="#pakua">Pakua</a></div>
        <a class="btn-login" href="{{ route('login') }}"><i class="fas fa-lock"></i> Ingia</a>
    </nav>

    <header class="sky" id="top">
        <div id="stars"></div><div class="moon"></div>
        <div class="cloud c1"></div><div class="cloud c2"></div><div class="cloud c3"></div>
        <div class="wrap hero-grid">
            <div>
                <div class="bism">بسم الله الرحمن الرحيم</div>
                <div class="logo-glow"><img src="{{ asset('assets/images/logo.png') }}" alt="{{ $appName }}"></div>
                <h1 class="hero-title"><span class="gold-text">{{ $appName }}</span><br>Elimu mkononi mwako</h1>
                <p class="hero-sub">Darsa za sauti, vitabu, makala, darsa za moja kwa moja, maswali na majibu, na funga za Sunnah zilizo karibu — vyote kwa mwongozo wa Qur'an na Sunnah kwa uelewa wa Salaf.</p>
                <div class="chips">
                    <span class="chip"><i class="fas fa-gift"></i> Bure kabisa</span>
                    <span class="chip"><i class="fas fa-language"></i> Kiswahili &amp; English</span>
                    <span class="chip"><i class="fas fa-download"></i> Pakua usikilize offline</span>
                    <span class="chip"><i class="fas fa-bell"></i> Arifa za darsa</span>
                    <span class="chip"><i class="fas fa-adjust"></i> Mwanga &amp; Giza</span>
                </div>
                <div class="stores">
                    <a class="store-badge {{ $playUrl ? '' : 'soon' }}" @if ($playUrl) href="{{ $playUrl }}" @endif><i class="fab fa-google-play"></i><span><small>Get it on</small><b>Google Play</b>@unless ($playUrl)<span class="soon-tag">Inakuja karibuni</span>@endunless</span></a>
                    <a class="store-badge {{ $appleUrl ? '' : 'soon' }}" @if ($appleUrl) href="{{ $appleUrl }}" @endif><i class="fab fa-apple"></i><span><small>Download on the</small><b>App Store</b>@unless ($appleUrl)<span class="soon-tag">Inakuja karibuni</span>@endunless</span></a>
                </div>
            </div>
            <div class="phone-stage">
                <div class="float-chip fc1"><i class="fas fa-broadcast-tower"></i> Darsa ya live</div>
                <div class="float-chip fc2"><i class="fas fa-moon"></i> Funga ya Sunnah</div>
                <div class="float-chip fc3"><i class="fas fa-book-open"></i> Vitabu &amp; makala</div>
                <div class="phone"><div class="screen">
                    <div class="s-top">{{ $appName }} <i class="fas fa-bullhorn"></i></div>
                    <div class="s-search"><i class="fas fa-search"></i>&nbsp; Tafuta darsa, kitabu…</div>
                    <div class="s-card"><span class="gold"><i class="fas fa-moon"></i> Hijri</span><b>Funga ya kesho: Alhamisi</b>
                        <div class="s-week" style="margin-top:8px"><span>Jum</span><span>Jtu</span><span class="on">Jnn</span><span>Jtn</span><span class="on">Alh</span><span>Iju</span><span>Jmo</span></div></div>
                    <div class="s-live"><span class="dot-live"></span> Darsa ya moja kwa moja <i class="fas fa-chevron-right" style="margin-left:auto"></i></div>
                    <div class="s-list">
                        <div class="s-item"><i class="fas fa-headphones"></i> Darsa za hivi karibuni</div>
                        <div class="s-item"><i class="fas fa-book"></i> Vitabu</div>
                        <div class="s-item"><i class="fas fa-question-circle"></i> Maswali &amp; Majibu</div>
                    </div>
                </div></div>
            </div>
        </div>
        <div class="waves"><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#eef2fa" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#eef2fa" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#eef2fa" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg></div>
    </header>

    <section class="sec light" id="vipengele" style="padding-top:0">
        <div class="wrap">
            <div class="stats">
                <div class="stat rv" style="--c1:#3b63d6;--c2:#1b2d63"><div class="ico"><i class="fas fa-headphones"></i></div><div class="n" data-n="{{ $c['songs'] }}">0</div><div class="l">Darsa za sauti</div></div>
                <div class="stat rv" style="--c1:#e9b23c;--c2:#b98418;--d:.08s"><div class="ico"><i class="fas fa-book"></i></div><div class="n" data-n="{{ $c['books'] }}">0</div><div class="l">Vitabu</div></div>
                <div class="stat rv" style="--c1:#22c27a;--c2:#0e8f57;--d:.16s"><div class="ico"><i class="fas fa-file-alt"></i></div><div class="n" data-n="{{ $c['articles'] }}">0</div><div class="l">Makala</div></div>
                <div class="stat rv" style="--c1:#8b6cf0;--c2:#5b3fc4;--d:.24s"><div class="ico"><i class="fas fa-layer-group"></i></div><div class="n" data-n="{{ $c['albums'] }}">0</div><div class="l">Albamu</div></div>
            </div>

            <div class="sec-head rv" style="margin-top:80px"><span class="eyebrow">Vipengele</span><h2>Kila unachohitaji kwa elimu, mahali pamoja</h2><p>Imetengenezwa kuwa nyepesi, ya haraka na rahisi — kwa Kiswahili na English.</p></div>
            <div class="bento">
                <div class="b w4 rv" style="--c1:#3b63d6;--c2:#1b2d63"><div class="ico"><i class="fas fa-headphones"></i></div><h3>Darsa za sauti zenye ubora</h3><p>Sikiliza kwa kategoria na albamu, endelea ulipoachia, weka kipima-muda cha kulala, na pakua usikilize bila mtandao. Player inaendelea hata skrini ikiwa imezimwa.</p><div class="tags"><span>Endelea ulipoachia</span><span>Kasi ya sauti</span><span>Pakua</span><span>Shiriki kiungo</span></div></div>
                <div class="b rv" style="--c1:#ff4d4d;--c2:#c42b2b;--d:.08s"><div class="ico"><i class="fas fa-broadcast-tower"></i></div><h3>Darsa ya moja kwa moja</h3><p>Darsa ikianza, arifa inakufikia na app inaonyesha LIVE papo hapo. Ikiisha, player inajizima yenyewe.</p></div>
                <div class="b rv" style="--c1:#e9b23c;--c2:#b98418"><div class="ico"><i class="fas fa-book-open"></i></div><h3>Vitabu na makala</h3><p>Soma PDF ndani ya app, hifadhi unayopenda, shiriki kiungo au faili.</p></div>
                <div class="b rv" style="--c1:#22c27a;--c2:#0e8f57;--d:.08s"><div class="ico"><i class="fas fa-question-circle"></i></div><h3>Maswali na majibu</h3><p>Tuma swali lako, upate jibu la maandishi au la sauti kutoka kwa mwalimu.</p></div>
                <div class="b rv" style="--c1:#8b6cf0;--c2:#5b3fc4;--d:.16s"><div class="ico"><i class="fas fa-moon"></i></div><h3>Hijri na funga za Sunnah</h3><p>Tarehe ya Hijri na funga zilizo karibu: Jumatatu, Alhamisi, Ayyaamul-Bidh, Arafah, Ashura.</p></div>
                <div class="b w3 rv" style="--c1:#3fc8e4;--c2:#2b4bb5"><div class="ico"><i class="fas fa-bell"></i></div><h3>Arifa za papo hapo</h3><p>Pata taarifa za matangazo mapya na darsa za live — bila kufungua app.</p></div>
                <div class="b w3 rv" style="--c1:#f2762e;--c2:#c2500f;--d:.08s"><div class="ico"><i class="fas fa-adjust"></i></div><h3>Mwanga na Giza</h3><p>Muonekano mzuri mchana na usiku, na lugha ya Kiswahili au English.</p></div>
            </div>
        </div>
    </section>

    <section class="sec dark" id="app">
        <div class="wrap">
            <div class="sec-head rv"><span class="eyebrow">Ndani ya app</span><h2>Angalia jinsi inavyoonekana</h2><p>Muundo safi wa navy na dhahabu, uliotengenezwa kwa utulivu wa kusoma na kusikiliza.</p></div>
            <div class="showcase">
                <div class="rv"><div class="phone small"><div class="screen">
                    <div class="s-top">Sauti <i class="fas fa-chevron-down"></i></div>
                    <div class="s-player"><div class="s-art"><i class="fas fa-headphones"></i></div><b style="color:#fff">Darsa ya leo</b><div style="color:#8190ba;font-size:11px">Albamu ya Elimu</div>
                        <div class="wave"><i style="--i:0"></i><i style="--i:1"></i><i style="--i:2"></i><i style="--i:3"></i><i style="--i:4"></i><i style="--i:5"></i><i style="--i:6"></i><i style="--i:7"></i><i style="--i:8"></i><i style="--i:9"></i><i style="--i:10"></i><i style="--i:11"></i><i style="--i:12"></i><i style="--i:13"></i><i style="--i:14"></i><i style="--i:15"></i><i style="--i:16"></i><i style="--i:17"></i></div><div class="bar"><b></b></div>
                        <div class="ctl"><i class="fas fa-undo"></i><span class="play"><i class="fas fa-pause"></i></span><i class="fas fa-redo"></i></div></div>
                </div></div><div class="cap">Player<small>Sikiliza kwa utulivu</small></div></div>
                <div class="rv" style="--d:.1s;margin-top:40px"><div class="phone small"><div class="screen">
                    <div class="s-top">Live <i class="fas fa-broadcast-tower"></i></div>
                    <div class="s-live" style="margin-top:6px"><span class="dot-live"></span> LIVE sasa</div>
                    <div class="s-card"><b>Darsa ya moja kwa moja</b>Gusa kusikiliza papo hapo</div>
                    <div class="s-card"><span class="gold"><i class="fas fa-bell"></i> Arifa</span><b>Darsa imeanza</b>Fungua uungane</div>
                    <div class="s-list"><div class="s-item"><i class="fas fa-calendar-alt"></i> Ratiba ya darsa</div><div class="s-item"><i class="fas fa-share-alt"></i> Sambaza kiungo</div></div>
                </div></div><div class="cap">Live<small>Darsa papo hapo</small></div></div>
                <div class="rv" style="--d:.2s"><div class="phone small"><div class="screen">
                    <div class="s-top">Maktaba <i class="fas fa-search"></i></div>
                    <div class="s-list" style="margin-top:6px">
                        <div class="s-item"><i class="fas fa-book"></i> Vitabu vya Aqiidah</div><div class="s-item"><i class="fas fa-book"></i> Fiqhi</div><div class="s-item"><i class="fas fa-file-alt"></i> Makala za karibuni</div><div class="s-item"><i class="fas fa-bookmark"></i> Ulizohifadhi</div><div class="s-item"><i class="fas fa-download"></i> Zilizopakuliwa</div>
                    </div>
                </div></div><div class="cap">Maktaba<small>Vitabu na makala</small></div></div>
            </div>
        </div>
    </section>

    <section class="sec light" id="hatua">
        <div class="wrap">
            <div class="sec-head rv"><span class="eyebrow">Jinsi ya kuanza</span><h2>Hatua tatu tu</h2><p>Kutoka kupakua hadi kunufaika — bila usumbufu.</p></div>
            <div class="steps" style="margin-top:60px">
                <div class="step rv"><div class="num">1</div><h3>Pakua app</h3><p>Itapatikana kwenye Google Play na App Store, inshaAllah.</p><svg class="arrow" viewBox="0 0 50 24"><path d="M2 12 H42 M34 4 L44 12 L34 20" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                <div class="step rv" style="--d:.12s"><div class="num">2</div><h3>Chagua darsa</h3><p>Pitia kategoria na albamu, au tafuta kwa jina.</p><svg class="arrow" viewBox="0 0 50 24"><path d="M2 12 H42 M34 4 L44 12 L34 20" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                <div class="step rv" style="--d:.24s"><div class="num">3</div><h3>Sikiliza na ushiriki</h3><p>Shiriki kiungo ili wengine nao wanufaike, na upate thawabu.</p></div>
            </div>
        </div>
    </section>

    @if ($stream || $songs->count() || $books->count())
    <section class="sec dark" id="darsa">
        <div class="wrap">
            <div class="sec-head rv"><span class="eyebrow">Moja kwa moja kutoka maktaba</span><h2>Sikiliza sasa hivi</h2></div>
            @if ($stream)
                <div class="live-big rv" style="margin-bottom:22px"><span class="dot-live" style="display:inline-block"></span> <b style="color:#fff;font-size:18px">&nbsp;Darsa ya moja kwa moja inaendelea</b><p style="color:#aab6dc;margin:6px 0 0">Fungua app kuungana nasi sasa hivi.</p></div>
            @endif
            <div class="two">
                @if ($songs->count())
                <div class="rows rv">
                    @foreach ($songs as $s)
                        <div class="row-l"><span class="ico"><i class="fas fa-headphones"></i></span><span class="t">{{ $s->title }}</span>
                            @if ($s->file)<audio controls preload="none" src="{{ asset('storage/' . $s->file) }}"></audio>@endif</div>
                    @endforeach
                </div>
                @endif
                @if ($books->count())
                <div class="rows rv" style="--d:.1s">
                    @foreach ($books as $b)
                        <div class="row-l"><span class="ico" style="background:linear-gradient(135deg,#e9b23c,#b98418)"><i class="fas fa-book"></i></span><span class="t">{{ $b->title }}</span>
                            @if ($b->file)<a class="chip" href="{{ asset('storage/' . $b->file) }}"><i class="fas fa-download"></i> Pakua</a>@endif</div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    <section class="dua"><div class="wrap rv"><div class="ar">اللَّهُمَّ انْفَعْنَا بِمَا عَلَّمْتَنَا وَعَلِّمْنَا مَا يَنْفَعُنَا</div><p>Ee Mwenyezi Mungu, tunufaishe kwa yale uliyotufundisha, na utufundishe yenye manufaa kwetu.</p></div></section>

    <section class="cta" id="pakua">
        <div class="wrap rv">
            <h2>Anza safari ya elimu leo</h2>
            <p>Pakua {{ $appName }} na ubebe darsa, vitabu na makala popote ulipo.</p>
            <div class="stores">
                <a class="store-badge {{ $playUrl ? '' : 'soon' }}" @if ($playUrl) href="{{ $playUrl }}" @endif><i class="fab fa-google-play"></i><span><small>Get it on</small><b>Google Play</b>@unless ($playUrl)<span class="soon-tag">Inakuja karibuni</span>@endunless</span></a>
                <a class="store-badge {{ $appleUrl ? '' : 'soon' }}" @if ($appleUrl) href="{{ $appleUrl }}" @endif><i class="fab fa-apple"></i><span><small>Download on the</small><b>App Store</b>@unless ($appleUrl)<span class="soon-tag">Inakuja karibuni</span>@endunless</span></a>
            </div>
        </div>
        <div class="waves"><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#060b1d" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#060b1d" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg><svg viewBox="0 0 1440 120" preserveAspectRatio="none"><path fill="#060b1d" d="M0 60 Q180 0 360 60 T720 60 T1080 60 T1440 60 V120 H0Z"/></svg></div>
    </section>

    <footer class="lp-foot">
        <img src="{{ asset('assets/images/logo.png') }}" alt=""><br>
        &copy; {{ date('Y') }} {{ $appName }} · <a href="{{ route('login') }}">Ingia (wasimamizi)</a>
    </footer>

    <script>
        (function () {
            var st = document.getElementById('stars');
            for (var i = 0; i < 90; i++) {
                var s = document.createElement('span'); s.className = 'star';
                s.style.left = Math.random() * 100 + '%'; s.style.top = Math.random() * 70 + '%';
                s.style.setProperty('--d', (2 + Math.random() * 4) + 's'); s.style.setProperty('--dl', (Math.random() * 4) + 's');
                if (Math.random() > .8) { s.style.width = s.style.height = '3px'; }
                st.appendChild(s);
            }
            var io = new IntersectionObserver(function (es) {
                es.forEach(function (e) {
                    if (!e.isIntersecting) return;
                    e.target.classList.add('in'); io.unobserve(e.target);
                    var n = e.target.querySelector('[data-n]');
                    if (n) { var to = +n.dataset.n, t0 = performance.now();
                        (function tick(t) { var p = Math.min(1, (t - t0) / 1400); n.textContent = Math.round(to * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(tick); })(t0); }
                });
            }, { threshold: .15 });
            document.querySelectorAll('.rv').forEach(function (el) { io.observe(el); });
        })();
    </script>
</body>
</html>

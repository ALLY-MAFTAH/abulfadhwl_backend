<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0b1530">
    <title>{{ config('app.name', 'Abul Fadhwl App') }}</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link href="{{ asset('css/admin.css') }}?v=2" rel="stylesheet">
    <link href="{{ asset('css/admin-pro.css') }}?v=10" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;600;700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script>try { document.documentElement.setAttribute('data-theme', localStorage.getItem('af-theme') === 'light' ? 'light' : 'dark'); } catch (e) { document.documentElement.setAttribute('data-theme', 'dark'); }</script>
    @yield('style')
</head>

<body>
    @guest
        <div class="auth-wrap">
            <div style="width:100%;max-width:560px">
                @yield('content')
            </div>
        </div>
    @else
        @php
            $is = fn(...$r) => request()->routeIs(...$r) ? 'active' : '';
            $nav = [
                ['Mwanzo', null],
                ['Dashibodi', 'home', 'fa-th-large', ['home']],
                ['Turaath', null],
                ['Sauti', 'categories', 'fa-headphones', ['categories', 'category', 'albums', 'album', 'songs', 'song']],
                ['Vitabu', 'books', 'fa-book', ['books', 'book']],
                ['Makala', 'articles', 'fa-file-alt', ['articles', 'article']],
                ['Historia', 'histories', 'fa-landmark', ['histories', 'history']],
                ['Slides', 'slides', 'fa-layer-group', ['slides', 'slide']],
                ['Mawasiliano', null],
                ['Matangazo', 'announcements', 'fa-bullhorn', ['announcements', 'announcement']],
                ['Maswali & Majibu', 'allQuestions', 'fa-question-circle', ['allQuestions', 'questions', 'question']],
                ['Maoni', 'comments', 'fa-comments', ['comments', 'comment']],
                ['Arifa (Push)', 'notifications', 'fa-bell', ['notifications']],
                ['Mfumo', null],
                ['Live / Matangazo ya moja kwa moja', 'streams', 'fa-broadcast-tower', ['streams', 'stream']],
                ['Kalenda ya Hijri', 'hijri', 'fa-moon', ['hijri']],
                ['Viungo', 'links', 'fa-link', ['links', 'link']],
                ['Watumiaji', 'users', 'fa-users', ['users', 'user']],
            ];
        @endphp

        <aside class="rail" id="rail">
            <a class="rail-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="">
                <span><b>{{ config('app.name', 'Abul Fadhwl App') }}</b><small>Usimamizi / Admin</small></span>
            </a>
            <nav class="rail-nav">
                @foreach ($nav as $n)
                    @if ($n[1] === null)
                        <div class="nav-heading">{{ $n[0] }}</div>
                    @else
                        <a class="nav-item {{ $is(...$n[3]) }}" href="{{ route($n[1]) }}">
                            <span class="ico"><i class="fas {{ $n[2] }}"></i></span>
                            <span>{{ $n[0] }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>
            <div class="rail-foot">
                <div class="who">{{ Auth::user()->name }}<small>Msimamizi</small></div>
                <a class="rail-btn" href="{{ route('logout') }}" title="Toka"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="fas fa-power-off"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </aside>

        <div class="main">
            <header class="topbar">
                <button class="burger" type="button" id="burger" aria-label="Menu"><i class="fas fa-bars"></i></button>
                <span class="title">@yield('page_title', 'Abul Fadhwl')</span>
                <div class="right">
                    <div class="seg" role="group" aria-label="Lugha / Language" data-no-i18n>
                        <button type="button" data-setlang="sw" title="Kiswahili">SW</button>
                        <button type="button" data-setlang="en" title="English">EN</button>
                    </div>
                    <button type="button" id="themeToggle" title="Mwanga / Giza" aria-label="Theme"><i class="fas fa-moon"></i><i class="fas fa-sun"></i></button>
                    <a class="btn btn-sm btn-outline" href="{{ url('/') }}" target="_blank" rel="noopener"><i class="fas fa-globe"></i> Tovuti</a>
                </div>
            </header>
            <main class="page">
                @yield('content')
            </main>
            <footer class="page-foot">&copy; <span id="year"></span> {{ config('app.name') }}</footer>
        </div>
    @endguest

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $('#year').text(new Date().getFullYear());
        $('#burger').on('click', function() { document.body.classList.toggle('rail-open'); });
        $(document).on('click', function(e) {
            if (document.body.classList.contains('rail-open') && !$(e.target).closest('#rail,#burger').length)
                document.body.classList.remove('rail-open');
        });
        $('#themeToggle').on('click', function() {
            var d = document.documentElement, next = d.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
            d.setAttribute('data-theme', next);
            try { localStorage.setItem('af-theme', next); } catch (e) {}
        });
        $('form').submit(function() { $(this).find(':submit').attr('disabled', true); });
        $(function() { if ($('#example').length) $('#example').DataTable(); });

        $('#upload-file').on('change', function() {
            var totalSize = 0;
            for (let i = 0; i < this.files.length; i++) totalSize += Math.round(this.files[i].size / 1048576);
            if (totalSize > 100) {
                alert("Samahani, huwezi kupakia faili zenye MB " + totalSize + " kwa mara moja");
                $('form').find(':submit').attr('disabled', true);
            }
        });
        $(function() {
            $('#fileUploadForm').ajaxForm({
                uploadProgress: function(event, position, total, percentComplete) {
                    $('.progress .progress-bar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
                },
                complete: function() { location.reload(); }
            });
        });
        function loadPhoto(event) {
            var reader = new FileReader();
            reader.onload = function() { document.getElementById('photo').src = reader.result; };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script>
        /* Modals must live directly under <body>: the glass cards use backdrop-filter, which traps
           position:fixed children and clips the dialog inside the card. */
        (function () {
            document.querySelectorAll('.modal').forEach(function (m) { document.body.appendChild(m); });
            document.addEventListener('show.bs.modal', function (e) {
                if (e.target && e.target.parentNode !== document.body) document.body.appendChild(e.target);
            });
        })();
    </script>
    <script src="{{ asset('js/admin-pro.js') }}?v=3"></script>
    <script src="{{ asset('js/admin-i18n.js') }}?v=7"></script>
    @if ($errors->any())
        <script>document.addEventListener('DOMContentLoaded', function () { AF.toast(@json($errors->first()), 'err'); });</script>
    @endif
    @yield('scripts')
</body>

</html>

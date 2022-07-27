<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Abulfadhwl App') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">



    <style>
        body{
            /* font-family: -apple-system, 'Open Sans', 'Helvetica Neue', sans-serif */
        }
        .card-header {
            color: white;
            width: 100%;
            text-align: center;
            font-weight: 900;
            font-size: 18px;
            background: rgb(240, 157, 4)
        }

        .card-body {
            background: rgba(207, 166, 77, 0.459);
            width: auto;
            width: 100%;
        }

        h3 {
            text-align: center;
            color: rgb(12, 3, 34);
            text-align: center;
            font-weight: 900;
            padding-top: 70px;
            padding-bottom: 10px;
        }

        .nav-items-2 {
            justify-content: center;
            color: rgb(3, 22, 107);
            text-shadow: 2px 2px 4px #e8e7f3;
            font-weight: 900;

        }

        .nav-items-2:hover {
            color: rgb(18, 3, 100);
            text-shadow: 2px 2px 4px #0a0263;
        }

        .active {
            color: #fff !important;
            font-weight: 900;
        }


        .zoom {
            transition: transform .2s;
        }

        .zoom:hover {
            transform: scale(1.3);
            /* (130% zoom)*/
        }


        .hide {
            display: none;
        }

        .row-height {
            height: 15px;
        }
        .summary-cards {
            box-shadow: 4px 4px 6px #df831a;
            border-radius: 12px;
            width: 90%;
            min-height: 100px;
            max-height: 120px;
            padding: 20px;
            margin: 20px;
            background: white;
        }

        .summary-cards:hover {
            box-shadow: 4px 4px 6px #0505bb;
            background: #df831a;
        }

        .summary-cards .summary-content {
            color: rgb(5, 5, 105);
            font-weight: bolder;
            padding: 5px;
            font-size: 12px;
        }

        .summary-cards:hover .summary-content {
            color: var(--white);
        }

    </style>
</head>

<body>

    <div id="app" style="background-color: rgba(247, 215, 185, 0.212);">
        <nav id="navbar_top" class="navbar navbar-expand-md navbar-light shadow-lg"
            style="background-color:rgb(247, 142, 5)">
            <div class="container">
                <a href="#" class=""> <img src="{{ asset('assets/images/logo.png') }}"
                        height="40px"></a>
                <h2 style=" color: white; text-shadow: 2px 2px 4px #1709e0;"> <b>{{ config('app.name')}}</b></h2>
                <button class="navbar-toggler" style="background-color: rgb(255, 255, 255)" type="button"
                    data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                        @if (Route::has('login'))
                            <div></div>
                        @endif

                        @if (Route::has('register'))
                            <div></div>
                        @endif
                    @else

                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item list-unstyled">
                                <a class="nav-link  " href="{{ route('home') }}">
                                    <p class="nav-items-2 {{ request()->routeIs('home') ? 'active' : '' }}"> Home
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item list-unstyled dropdown">
                                <a class="nav-link nav-items-2 dropdown-toggle  {{ request()->routeIs('songs') || request()->routeIs('albums') || request()->routeIs('album') || request()->routeIs('categories') || request()->routeIs('category') || request()->routeIs('articles') || request()->routeIs('article') || request()->routeIs('books') || request()->routeIs('book') ? 'active' : '' }}"
                                    href="#" data-bs-toggle="dropdown">Turaath</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item nav-items-2 {{ request()->routeIs('songs') || request()->routeIs('albums') || request()->routeIs('album') || request()->routeIs('categories') || request()->routeIs('category') ? 'active' : '' }}"
                                            href="{{ route('categories') }}">Audio</a></li>
                                    <li><a class="dropdown-item nav-items-2 {{ request()->routeIs('books') || request()->routeIs('book') ? 'active' : '' }}"
                                            href="{{ route('books') }}">Books</a></li>
                                    <li><a class="dropdown-item nav-items-2 {{ request()->routeIs('articles') || request()->routeIs('article') ? 'active' : '' }}"
                                            href="{{ route('articles') }}">Articles</a></li>
                                </ul>
                            </li>
                            <li class="nav-item list-unstyled dropdown">
                                <a class="nav-link nav-items-2 dropdown-toggle  {{ request()->routeIs('announcements') || request()->routeIs('allQuestions') || request()->routeIs('comments') ? 'active' : '' }}"
                                    href="#" data-bs-toggle="dropdown">Feeds</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item nav-items-2 {{ request()->routeIs('announcements') ? 'active' : '' }}"
                                            href="{{ route('announcements') }}">Announcements</a></li>
                                    <li><a class="dropdown-item nav-items-2 {{ request()->routeIs('allQuestions') ? 'active' : '' }}"
                                            href="{{ route('allQuestions') }}">Questions & Answers</a></li>
                                    <li><a class="dropdown-item nav-items-2 {{ request()->routeIs('comments') ? 'active' : '' }}"
                                            href="{{ route('comments') }}">Comments</a></li>
                                </ul>
                            </li>

                            <li class="nav-item  list-unstyled">
                                <a class="nav-link   " href="{{ route('slides') }}">
                                    <p class="nav-items-2 {{ request()->routeIs('slides') ? 'active' : '' }}">
                                        Slides</p>
                                </a>

                            </li>
                            <li class="nav-item  list-unstyled">

                                <a class="nav-link" href="{{ route('histories') }}">
                                    <p class="nav-items-2 {{ request()->routeIs('histories')||request()->routeIs('history') ? 'active' : '' }}">
                                        History</p>
                                </a>
                            </li>

                            <li class="nav-item  list-unstyled">
                                <a class="nav-link  " href="{{ route('streams') }}">

                                    <p class="nav-items-2 {{ request()->routeIs('streams') ? 'active' : '' }}">
                                        Streams</p>
                                </a>
                            </li>

                            <li class="nav-item  list-unstyled">
                                <a class="nav-link  " href="{{ route('links') }}">
                                    <p class="nav-items-2 {{ request()->routeIs('links') ? 'active' : '' }}">
                                        Links</p>
                                </a>
                            </li>
                        </ul>
                    @endguest
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a style="color: blue" class="nav-link"
                                        href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a style="color: blue" class="nav-link"
                                        href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a style="color: white; font-size: 17px" id="navbarDropdown" class="nav-link dropdown-toggle"
                                    href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div style="background-color: white" class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="navbarDropdown">
                                    <a style="color: rgb(241, 10, 10)" class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-power-off"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                    {{-- <a style="color: rgb(241, 10, 10)" class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('change-password-form').submit();">
                                        <i class="fas fa-key"></i> {{ __('Change Password') }}
                                    </a>

                                    <form id="change-password-form" action="{{ route('change_password') }}" method="GET"
                                        class="d-none">
                                        @csrf
                                    </form> --}}
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            <div  style="min-height: 100vh">
                @yield('content')
            </div>
        </main>
        <footer id="main-footer" class="bg-light text-dark mb-3">
            <div class="container">
                <div class="col">
                    <hr>
                    <p class="lead text-center">
                        &copy; <span id="year"></span> {{ config('app.name')}}
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>

    <script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/ripple.js') }}"></script>
    <script src="{{ asset('js/pcoded.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/plugins/timepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 1) {
                    document.getElementById('navbar_top').classList.add('fixed-top');
                    // add padding top to show content behind navbar
                    navbar_height = document.querySelector('.navbar').offsetHeight;
                    document.body.style.paddingTop = navbar_height + 'px';
                } else {
                    document.getElementById('navbar_top').classList.remove('fixed-top');
                    // remove padding top from body
                    document.body.style.paddingTop = '0';
                }
            });
        });
    </script>

@yield('scripts')

</body>

</html>

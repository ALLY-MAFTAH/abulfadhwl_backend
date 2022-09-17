<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Abulfadhwl App') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://maftah.co.tz/public/css/app.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

    @yield('style')

    <style>
        .card-header {
            color: rgb(14, 24, 72);
            width: 100%;
            text-align: center;
            font-weight: 900;
            font-size: 18px;
            background: rgb(250, 241, 221)
        }

        .navbar-light .navbar-nav .nav-link {
            color: rgb(3, 22, 107);
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: rgb(222, 161, 28);
        }

        .nav-items-2 {
            justify-content: center;
            color: rgb(3, 22, 107);
            font-weight: 900;

        }

        .nav-items-2:hover {
            color: rgb(222, 161, 28);
            /* text-shadow: 2px 2px 4px #0a0263; */
        }

        .active {
            color: rgb(222, 161, 28) !important;
            font-weight: 900;
        }


        .zoom {
            transition: transform .2s;
        }

        .zoom:hover {
            transform: scale(1.1);
            /* (110% zoom)*/
        }

        .row-height {
            height: 15px;
        }

        .summary-cards {
            box-shadow: 4px 4px 6px #e6b888;
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

    <div id="app">
        <nav id="navbar_top" class="navbar navbar-expand-md shadow-lg navbar-light"
            style="background-color:rgb(246, 242, 237)">
            <div class="container">
                <a href="{{ route('home') }}" style="text-decoration:none">
                    <h2 style=" color: rgb(6, 24, 158); text-shadow: 2px 2px 4px #f9a321;">
                        <b>{{ config('app.name') }}</b>
                    </h2>
                </a>
                <button class="navbar-toggler" style="background-color: rgb(255, 255, 255)" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
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
                                <a class="nav-link nav-items-2 dropdown-toggle {{ request()->routeIs('songs') || request()->routeIs('albums') || request()->routeIs('album') || request()->routeIs('categories') || request()->routeIs('category') || request()->routeIs('articles') || request()->routeIs('article') || request()->routeIs('books') || request()->routeIs('book') ? 'active' : '' }}"
                                    href="#" data-bs-toggle="dropdown">Turaath</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item nav-items-2 {{ request()->routeIs('songs') || request()->routeIs('albums') || request()->routeIs('album') || request()->routeIs('categories') || request()->routeIs('category') ? 'active' : '' }}"
                                            href="{{ route('categories') }}">Audio</a></li>
                                    <li><a class="dropdown-item nav-items-2 {{ request()->routeIs('books') || request()->routeIs('book') ? 'active' : '' }}"
                                            href="{{ route('books') }}">Books</a></li>
                                    <li><a class="dropdown-item" href="{{ route('articles') }}">
                                            <p
                                                class="nav-items-2 {{ request()->routeIs('articles') || request()->routeIs('article') ? 'active' : '' }}">
                                                Articles
                                            </p>
                                        </a></li>
                                </ul>
                            </li>
                            <li class="nav-item list-unstyled dropdown">
                                <a class="nav-link nav-items-2 dropdown-toggle  {{ request()->routeIs('announcements') || request()->routeIs('allQuestions') || request()->routeIs('comments') ? 'active' : '' }}"
                                    href="#" data-bs-toggle="dropdown">Feeds</a>
                                <ul class="dropdown-menu fade">
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
                                    <p
                                        class="nav-items-2 {{ request()->routeIs('histories') || request()->routeIs('history') ? 'active' : '' }}">
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
                            <li class="nav-item  list-unstyled">
                                <a class="nav-link  " href="{{ route('notifications') }}">
                                    <p class="nav-items-2 {{ request()->routeIs('notifications') ? 'active' : '' }}">
                                        Notify</p>
                                </a>
                            </li>
                        </ul>
                    @endguest
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            {{-- @if (Route::has('login'))
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
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a style="color: rgb(25, 15, 165); font-size: 17px" id="navbarDropdown"
                                    class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div style="background-color: white" class="fade dropdown-menu dropdown-menu-right"
                                    aria-labelledby="navbarDropdown">
                                    <a style="color: rgb(241, 10, 10)" class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-power-off"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            <div style="min-height: 100vh">
                @yield('content')
            </div>
        </main>
        <footer id="main-footer" class="text-dark mb-3">
            <div class="container">
                <div class="col">
                    <hr>
                    <p class="lead text-center">
                        &copy; <span id="year"></span> {{ config('app.name') }}
                    </p>
                </div>
            </div>
        </footer>
    </div>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>

    <!-- Scripts -->
    <script src="https://maftah.co.tz/public/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js "></script>

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
    <script>
        $('form').submit(function() {
            $(this).find(':submit').attr('disabled', true);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <script>
        $('#upload-file').bind('change', function() {
            var totalSize = 0;
            for (let i = 0; i < this.files.length; i++) {
                totalSize = totalSize + Math.round((this.files[i].size) / 1048576);
            }
            console.log(totalSize);
            if (totalSize > 100) {
                alert("Sorry, you can't upload files with " + totalSize + " MB at once");
                $('form').find(':submit').attr('disabled', true);
            }
        });
    </script>
    {{-- <script>
        $(function() {
            $(document).ready(function() {
                $('#fileUploadForm').ajaxForm({
                    beforeSend: function() {
                        var percentage = '0';
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage + '%', function() {
                            return $(this).attr("aria-valuenow", percentage) + '%';
                        })
                    },
                    complete: function(xhr) {
                        console.log('File has uploaded');
                        location.reload();
                    }
                });
            });
        });
    </script> --}}
     <script>
        function loadPhoto(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('photo');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    @yield('scripts')

</body>

</html>

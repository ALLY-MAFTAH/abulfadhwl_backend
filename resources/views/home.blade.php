@extends('layouts.app')
@section('sidebar')
    <div class="col-md-2">
        @include('components.left_nav')
    </div>
@endsection

@section('content')
    <div class="col-md-10">
        <div class="container">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class=" card welcome my-3 shadow-lg" style="text-align: center; padding-top:40px">
                <h1><b> WELCOME TO ADMINISTRATOR DASHBOARD</b></h1>
            </div><br><br>
            <div style="text-align: center">Summary</div>
            <hr width="60%">
            <div class=" row card-body">
                <a href="{{ route('categories') }}" class="nav-link">
                    <div class="col-3" style="padding: 5px;">
                        <button class="card btn btn-outline-danger"
                            style="width: 250px; height:250px;margin:auto; background-color:rgb(206, 247, 180)">
                            <h2 style="margin:auto; text-align:center"><span><i class="fas fa-users"></i></span><br> CATEGORIES<br>
                                ( {{count($categories)}} )
                            </h2>
                        </button>
                    </div>
                </a>
                <a href="{{ route('albums') }}" class="nav-link">

                    <div class="col-3" style="padding: 5px;">
                        <button class=" btn btn-outline-warning     card"
                            style="width: 250px; height:250px;margin:auto; background-color:rgb(247, 180, 225)">
                            <h2 style="margin:auto; text-align:center"> <span><i class="fas fa-wrench"></i></span><br>ALBUMS<br>
                                ( {{count($albums)}} )
                            </h2>
                        </button>
                    </div>
                </a>
                <a href="{{ route('songs') }}" class="nav-link">
                    <div class="col-3" style="padding: 5px;">
                        <button class="card btn btn-outline-success"
                            style="width: 250px; height:250px;margin:auto; background-color:rgb(180, 226, 247)">
                            <h2 style="margin:auto; text-align:center"> <span><i class="fas fa-book"></i></span><br>AUDIOS<br>
                                ( {{count($songs)}} )
                            </h2>
                        </button>
                    </div>
                </a>
                <a href="{{route('books') }}" class="nav-link">
                    <div class="col-3" style="padding: 5px;">
                        <button class="card btn btn-outline-primary"
                            style="width: 255px; height:250px;margin:auto; background-color:rgb(247, 245, 180)">
                            <h2 style="margin:auto; text-align:center"> <span><i class="fas fa-history"></i></span><br>BOOKS<br>
                                ( {{count($books)}} )
                            </h2>
                        </button>
                    </div>
                </a>
            </div>

            <!--FOOTER  -->
            <footer id="main-footer" class="bg-light text-dark mb-3">
                <div class="container">
                    <div class="col">
                        <hr>
                        <p class="lead text-center">
                            Copyright &copy; <span id="year"></span> ABUL FADHWL
                        </p>
                    </div>
                </div>
            </footer>


            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
                integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
                crossorigin="anonymous" />

            <script>
                // Get the current year for the copyright
                $('#year').text(new Date().getFullYear());

                CKEDITOR.replace('editor1');

            </script>
        </div>
    </div>
@endsection

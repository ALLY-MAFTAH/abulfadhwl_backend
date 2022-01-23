@extends('layouts.app')
@section('sidebar')
    <div class="col-md-2">
        @include('components.left_nav')
    </div>
@endsection

@section('content')
    <div class="col-md-10 py-3">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('errors'))
                <div class="alert alert-success" role="alert">
                    {{ session('errors') }}
                </div>
            @endif
            @if (Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}
            </p>
        @endif
            <!-- ACTIONS -->
            <section id="actions" class="py-5 mb-4 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">

                        </div>
                    </div>
                </div>
            </section>

            <section id="categories">
                <div class="container">
                   
                    <div class="card">
                        <div class="card-header">
                            <h4>ALBUMS</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>No. of Audios</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($albums as $index => $album)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $album->name }}</td>
                                        <td>{{ $album->description }}</td>
                                        <td>{{ count($album->songs) }}</td>


                                        <td>
                                            <a href="{{ route('album', $album->id) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-info-circle">
                                                    View</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_album', $album->id) }}"
                                                onclick="return confirm('This album will be deleted')"
                                                class="btn btn-outline-danger">
                                                <i class="fas fa-trash"> Delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

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
                        </script>
        </div>
    </div>
@endsection

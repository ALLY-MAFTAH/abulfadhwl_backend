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
                            <h4>AUDIOS</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Album</th>
                                    <th>Category</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($songs as $index => $song)
                                    @foreach ($categories as $category)
                                        @foreach ($category->albums as $newAlbum)
                                            @foreach ($newAlbum->songs as $newSong1)
                                                @foreach ($albums as $album)
                                                    @foreach ($album->songs as $newSong2)
                                                        @if ($newSong2->id == $song->id)
                                                            @if ($newSong1->id == $song->id)

                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $song->title }}</td>
                                                                    <td>{{ $album->name }}</td>
                                                                    <td>{{ $category->name }}</td>
                                                                    <td>
                                                                        <audio src="{{ asset('storage/' . $song->file) }}"
                                                                            controls controlslist></audio>
                                                                    </td>

                                                                    <td>
                                                                        <a href="{{ route('song', $song->id) }}"
                                                                            class="btn btn-outline-primary">
                                                                            <i class="fas fa-eye">
                                                                            </i>
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('delete_song', $song->id) }}"
                                                                            onclick="return confirm('This song will be deleted')"
                                                                            class="btn btn-outline-danger">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>


            <!-- MODALS -->

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

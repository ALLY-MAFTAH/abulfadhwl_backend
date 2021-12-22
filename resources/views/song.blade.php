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
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            <section id="actions" class="py-2 mb-4 bg-light">
                <div class="container">
                    <div class="row px-3 ">
                        <h4> <i class="fas fa-music music-icon"></i><b> {{ $song->title }} </b>
                        </h4>
                    </div>
            </section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>Audio Information <a href="#" class="btn btn-warning btn-outline" data-toggle="modal"
                                    data-target="#editSongModal">
                                    <i class="fas fa-edit"></i>
                                </a></h4>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <h5> Title: </h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $song->title }}</b></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Description:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $song->description }} </b></h5>
                                </div>
                            </div>
                            <hr>
                            @foreach ($albums as $album)
                            @foreach ($album->songs as $newSong2)
                            @if ($newSong2->id==$song->id)
                             <div class="row">
                                <div class="col-3">
                                    <h5> Album:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $album->name }} </b></h5>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endforeach
                            <hr>
                            @foreach ($categories as $category)
                            @foreach ($category->albums as $newAlbum)
                            @foreach ($newAlbum->songs as $newSong1)
                            @if ($newSong1->id==$song->id)

                            <div class="row">
                                <div class="col-3">
                                    <h5> Category:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $category->name }} </b></h5>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endforeach
                            @endforeach

                            <hr>
                            <div class="row">
                                <audio src="{{asset('storage/'.$song->file)}}" type="audio/mp3" controls controlslist style="width:100% "></audio>
                            </div>
                    <hr>

                </div>

             <!-- EDIT SONG MODAL -->
    <div class="modal fade" id="editSongModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Audio</h5>
                    <button class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="PUT" action="{{ route('edit_song',$song->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="title"
                                class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text"
                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ old('title',$song->title) }}" required autocomplete="title" autofocus>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <input id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    value="{{ old('description',$song->description) }}" required autocomplete="description" >
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

<script>
$(function () {
     $(".modal-btn").click(function (){
       var data_var = $(this).data('song-id');
       $(".modal-body h2").text(data_var);
     })
    });              // Get the current year for the copyright
                $('#year').text(new Date().getFullYear());

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />
            </script>
        </div>
    </div>
    @endsection


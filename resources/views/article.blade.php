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
                        <h4> <i class="fas fa-file music-icon"></i></i><b> {{ $article->title }} </b>
                        </h4>
                    </div>
            </section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4>Article Information <a href="#" class="btn btn-warning btn-outline" data-toggle="modal"
                                    data-target="#editArticleModal">
                                    <i class="fas fa-edit"></i>
                                </a></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="row">
                                <div class="col-3">
                                    <h5> Title: </h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $article->title }}</b></h5>
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Author:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>Sheikh Abul Fadhwl Kassim Mafuta حفظه الله ورعاه</b></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Year of Publishment:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $article->pub_year }}</b></h5>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <div class="col-3" style="background-color:rgb(224, 224, 228); text-align:center">
                            <div class="text-center"style="padding: 10px;">
                                <form action="{{asset('storage/'.$article->file)}}" target="_blank">
                                    <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-file"> Open</i>
                                    </button>
                                </form>
                        </div>
                        <div style=""><img src={{asset('storage/'.$article->cover)}} alt="Article Cover" width="100%"></div>

                    </div>
                    </div>

                    <hr>
                   <div class="row">

                   </div>
                </div>

                <!-- EDIT ARTICLE MODAL -->
                <div class="modal fade" id="editArticleModal">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Edit Article</h5>
                                <button class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="PUT" action="{{ route('edit_article', $article->id) }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="title"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                        <div class="col-md-6">
                                            <input id="title" type="text"
                                                class="form-control @error('title') is-invalid @enderror" name="title"
                                                value="{{ old('title',$article->title) }}"  autocomplete="title" autofocus>
                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="pub_year"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Year of Publishment') }}</label>
                                        <div class="col-md-6">
                                            <input id="pub_year" type="text"
                                                class="form-control @error('year') is-invalid @enderror" name="pub_year"
                                                value="{{ old('pub_year',$article->pub_year) }}" required autocomplete="pub_year" >
                                            @error('pub_year')
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
                // Get the current year for the copyright
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


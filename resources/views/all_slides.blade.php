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

            <!-- ACTIONS -->
            <section id="actions" class="py-2 mb-4 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#addSlideModal">
                                <i class="fas fa-plus"></i> Add Slide
                            </a>

                        </div>
                    </div>
                </div>
            </section>

            <section id="slides">
                <div class="container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4>SLIDES</h4>
                        </div>
                        <table class="table">
                            <tbody>

                               <div class="row ext-div" >
                                    @foreach ($slides as $index => $slide)
                                     <div class="col-4 " style="padding: 2px;">
                                       <div class="int-div">
                                            <img src="http://192.168.43.114:8000/api/slide/file/{{$slide->id}}" alt="Slide cover" style="width: 100%;padding:5px">
                                        <div class="row" style="padding: 5px">
                                            <div class="col-6">
                                            <h5>Slide No: <span style="color: blue">{{$slide->number}}</span></h4>
                                            </div>
                                            <div class="col-6" style="text-align-last: right">
                                                <a href="{{ route('delete_slide', $slide->id) }}"
                                                    onclick="return confirm('This slide will be deleted')"
                                                    class="btn btn-outline-danger">
                                                    <i class="fas fa-trash"> Delete</i>
                                                </a>
                                            </div>
                                        </div>
                                       </div>
                                    </div>
                                    @endforeach
                               </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>


            <!-- MODALS -->

            <!-- ADD SLIDE MODAL -->
            <div class="modal fade" id="addSlideModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Slide</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_slide') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="number"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Number') }}</label>
                                    <div class="col-md-6">
                                        <input id="number" type="number"
                                            class="form-control @error('number') is-invalid @enderror" name="number"
                                            value="{{ old('number') }}" required autocomplete="number" autofocus>
                                        @error('number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="file"
                                        class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>
                                    <div class="col-md-6">
                                        <input id="file" type="file"
                                            class="form-control @error('file') is-invalid @enderror" name="file"
                                            value="{{ old('file') }}" required autocomplete="file" >
                                        @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                            <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Add
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

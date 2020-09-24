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
                        <h4> <i class="fas fa-history music-icon"></i><b> Section No. {{ $history->section }} </b>
                        </h4>
                    </div>
            </section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>History Information <a href="#" class="btn btn-warning btn-outline" data-toggle="modal"
                                    data-target="#editHistoryModal">
                                    <i class="fas fa-edit"></i>
                                </a></h4>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <h5> Section: </h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $history->section }}</b></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Heading:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $history->heading }} </b></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h6><b>{{ $history->content }} </b></h6>

                            </div>
                         </div>

             <!-- EDIT HISTORY MODAL -->
    <div class="modal fade" id="editHistoryModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit History</h5>
                    <button class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="PUT" action="{{ route('edit_history',$history->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="section"
                                class="col-md-4 col-form-label text-md-right">{{ __('Section') }}</label>
                            <div class="col-md-6">
                                <input id="section" type="number"
                                    class="form-control @error('section') is-invalid @enderror" name="section"
                                    value="{{ old('section',$history->section) }}" required autocomplete="section" autofocus>
                                @error('section')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="heading"
                                class="col-md-4 col-form-label text-md-right">{{ __('Heading') }}</label>
                            <div class="col-md-6">
                                <input id="heading" type="text"
                                    class="form-control @error('heading') is-invalid @enderror" name="heading"
                                    value="{{ old('heading',$history->heading) }}" required autocomplete="heading" >
                                @error('heading')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content"
                                class="col-md-4 col-form-label text-md-right">{{ __('Content') }}</label>
                            <div class="col-md-6">
                                <input id="content" type="text"
                                    class="form-control @error('content') is-invalid @enderror" name="content"
                                    value="{{ old('content',$history->content) }}" required autocomplete="content" >
                                @error('content')
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
       var data_var = $(this).data('history-id');
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

    @endsection


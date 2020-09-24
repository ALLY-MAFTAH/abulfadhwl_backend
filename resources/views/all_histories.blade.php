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
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#addHistoryModal">
                                <i class="fas fa-plus"></i> Add History
                            </a>

                        </div>
                    </div>
                </div>
            </section>

            <section id="histories">
                <div class="container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4>HISTORIES</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Section</th>
                                    <th>Heading</th>
                                    <th>Content</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $index => $history)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $history->section }}</td>
                                        <td>{{ $history->heading }}</td>
                                        <td><p style=" width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $history->content }}</p></td>
                                        <td>
                                            <a href="{{ route('history', $history->id) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-info-circle">
                                                    View</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_history', $history->id) }}"
                                                onclick="return confirm('This history will be deleted')"
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


            <!-- MODALS -->

            <!-- ADD HISTORY MODAL -->
            <div class="modal fade" id="addHistoryModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add History</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_history') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="section"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Section') }}</label>
                                    <div class="col-md-6">
                                        <input id="section" type="number"
                                            class="form-control @error('section') is-invalid @enderror" name="section"
                                            value="{{ old('section') }}" required autocomplete="section" autofocus>
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
                                            value="{{ old('heading') }}" required autocomplete="heading" >
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
                                            value="{{ old('content') }}" required autocomplete="content" >
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
                                            Add
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

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
                integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
                crossorigin="anonymous" />

            <script>
                // Get the current year for the copyright
                $('#year').text(new Date().getFullYear());
                        </script>
@endsection

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
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#addAnswerModal">
                                <i class="fas fa-plus"></i> Jibu
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="answers">
                <div class="container">
                    @if (Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4>MASWALI YALIYOJIBIWA</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Swali</th>
                                    <th>Jibu</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($answers as $index => $answer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $answer->qn }}</td>
                                        <td>{{ $answer->ans }}</td>
                                        <td>
                                            <a href="{{route('answer',$answer->id)}}" class="btn btn-outline-primary">
                                                <i class="fas fa-eye">
                                                    Fungua</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_answer', $answer->id) }}"
                                                onclick="return confirm('This answer will be deleted')"
                                                class="btn btn-outline-danger">
                                                <i class="fas fa-trash"> Futa</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

                                            <!-- EDIT ANSWER MODAL -->
                                            <div class="modal fade" id="addAnswerModal">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Weka jibu</h5>
                                                            <button class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('add_answer') }}">
                                                                @csrf

                                                                <div class="form-group row">
                                                                    <label for="qn"
                                                                    class="col-md-4 col-form-label text-md-right">{{ __('Swali Lililoulizwa') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="qn" type="text"
                                                                        class="form-control @error('qn') is-invalid @enderror" name="qn"
                                                                        value="{{ old('qn') }}" required autocomplete="qn" >
                                                                        @error('qn')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="ans"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Jibu') }}</label>
                                                                        <div class="col-md-6">
                                                                            <input id="ans" type="text" style="height: 40px"
                                                                            class="form-control @error('ans') is-invalid @enderror" name="ans"
                                                                            value="{{ old('ans') }}" required autocomplete="ans" >
                                                                            @error('ans')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group row mb-0">
                                                                        <div class="col-md-6 offset-md-4">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                Tuma
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
        </div>
    </div>
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

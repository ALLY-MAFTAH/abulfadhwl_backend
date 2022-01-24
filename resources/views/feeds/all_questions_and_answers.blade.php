@extends('layouts.app')

@section('content')
    <div class=" py-3">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-info" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('errors'))
                <div class="alert alert-danger" role="alert">
                    {{ session('errors') }}
                </div>
            @endif
            @if (Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
            @endif

            <section id="actions" class=" mb-2">
                <div class="container">
                    <div class="row"
                        style="margin:2px;padding:20px;background-color: rgb(247, 232, 206); border-radius: 5px">
                        <div class="col-6">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section id="comments">
                <div class="container">

                    <div class="card">
                        <div class="card-header">
                            <h4>MASWALI YALIYOJIBIWA ({{ $answers->count() }})</h4>
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
                                            <a href="#" target="modal" data-toggle="modal"
                                                data-target="#editAnswerModal-{{ $answer->id }}"
                                                class="btn btn-outline-primary">
                                                <i class="fas fa-edit">
                                                    Edit</i>
                                            </a>
                                            <!-- EDIT ANSWER MODAL -->
                                            <div class="modal fade" id="editAnswerModal-{{ $answer->id }}">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Weka jibu</h5>
                                                            <button class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('edit_answer', $answer->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group row">
                                                                    <label for="qn"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Swali Lililoulizwa') }}</label>
                                                                    <div class="col-md-6">
                                                                        <textarea id="qn" type="text"
                                                                            class="form-control @error('qn') is-invalid @enderror"
                                                                            name="qn"
                                                                            value="" required
                                                                            autocomplete="qn">{{ old('qn', $answer->qn) }}</textarea>
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
                                                                        <textarea id="ans" type="text"
                                                                            class="form-control @error('ans') is-invalid @enderror"
                                                                            name="ans"
                                                                            value=""
                                                                            required autocomplete="ans">{{ old('ans', $answer->ans) }}</textarea>
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
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_answer', $answer->id) }}"
                                                onclick="return confirm('This answer will be deleted')"
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

            <!-- ADD ANSWER MODAL -->
            <div class="modal fade" id="addAnswerModal">
                <div class="modal-dialog modal-md">
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
                                        <textarea id="qn" type="text" class="form-control @error('qn') is-invalid @enderror"
                                            name="qn" value="{{ old('qn') }}" required autocomplete="qn"></textarea>
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
                                        <textarea id="ans" type="text" style="height: 40px"
                                            class="form-control @error('ans') is-invalid @enderror" name="ans"
                                            value="{{ old('ans') }}" required autocomplete="ans"></textarea>
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
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endsection

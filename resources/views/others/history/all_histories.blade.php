@extends('layouts.app')

@section('content')
    <div class=" py-3">
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
            <!-- ACTIONS -->

            <section id="actions" class=" mb-2">
                <div class="container">
                    <div class="row"
                        style="margin:2px;padding:20px;background-color: rgb(247, 232, 206); border-radius: 5px">
                        <div class="col">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>

                        <div class="col-2"></div>
                        <div class="col-2 text-right">
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal"
                                data-target="#addHistoryModal">
                                <i class="fas fa-plus"></i> Add History
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="histories">
                <div class="container">

                    <div class="card">
                        <div class="card-header">
                            <h4>HISTORIES ({{$histories->count()}})</h4>
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
                                        <td>
                                            <p
                                                style=" width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $history->content }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route('history', $history->id) }}"
                                                class="btn btn-outline-primary">
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
            <!-- ADD HISTORY MODAL -->
            <div class="modal fade" id="addHistoryModal">
                <div class="modal-dialog modal-md">
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
                                            value="{{ old('heading') }}" required autocomplete="heading">
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
                                        <textarea id="content" type="text"
                                            class="form-control @error('content') is-invalid @enderror" name="content"
                                            value="{{ old('content') }}" required autocomplete="content"></textarea>
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

@endsection

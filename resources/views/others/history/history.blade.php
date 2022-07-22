@extends('layouts.app')

@section('content')
    <div class=" py-3">
        <div class="container">
            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}
                </p>
            @endif
            @if (Session::has('success'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}
                </p>
            @endif
            <section id="actions" class=" mb-2">
                <div class="container">
                    <div class="row"
                        style="padding:20px;background-color: rgb(247, 232, 206); border-radius: 5px">
                        <div class="col">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>
                        <div class="col-8 text-center">
                            <h4><i class="fas fa-history"></i><b> Section No. {{ $history->section }} </b>
                            </h4>
                        </div>
                        <div class="col-2"></div>

                    </div>
            </section>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>History Information <a href="#" class="btn btn-outline-primary" data-toggle="modal"
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
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Edit History</h5>
                                <button class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="PUT" action="{{ route('edit_history', $history->id) }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="section"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Section') }}</label>
                                        <div class="col-md-6">
                                            <input id="section" type="number"
                                                class="form-control @error('section') is-invalid @enderror" name="section"
                                                value="{{ old('section', $history->section) }}" required
                                                autocomplete="section" autofocus>
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
                                                value="{{ old('heading', $history->heading) }}" required
                                                autocomplete="heading">
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
                                                value="{{ old('content', $history->content) }}" required
                                                autocomplete="content">{{ old('content',$history->content) }}</textarea>
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
    @endsection

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
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}
                </p>
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
                                data-target="#addStreamModal">
                                <i class="fas fa-plus"></i> Add Stream
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section id="streams">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h4>STREAMS ({{$streams->count()}})</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Timetable</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Url</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($streams as $index => $stream)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <a href="#" data-toggle="modal"
                                                data-target="#viewTimetable-{{ $stream->id }}"><img
                                                    src={{ asset('storage/' . $stream->timetable) }}
                                                    alt="Stream timetable" style="width: 50px;height:50px;"></a>
                                            <!-- EDIT STREAM MODAL -->
                                            <div class="modal fade" id="viewTimetable-{{ $stream->id }}">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Ratiba ya Masomo</h5>
                                                            <button class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="int-div">
                                                                <img src={{ asset('storage/' . $stream->timetable) }}
                                                                    alt="Ratiba ya masomo" style="width: 100%;padding:5px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $stream->title }}</td>
                                        <td>{{ $stream->description }}</td>
                                        <td>
                                            <audio src="{{ $stream->url }}" controls controlslist></audio>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                                                data-target="#editStreamModal-{{ $stream->id }}">
                                                <i class="fas fa-edit">
                                                    Edit</i>
                                            </a>

                                            <!-- EDIT STREAM MODAL -->
                                            <div class="modal fade" id="editStreamModal-{{ $stream->id }}">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Edit Stream</h5>
                                                            <button class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="PUT"
                                                                action="{{ route('edit_stream', $stream->id) }}">
                                                                @csrf

                                                                <div class="form-group row">
                                                                    <label for="title"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="title" type="text"
                                                                            class="form-control @error('title') is-invalid @enderror"
                                                                            name="title"
                                                                            value="{{ old('title', $stream->title) }}"
                                                                            required autocomplete="title" autofocus>
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
                                                                            class="form-control @error('year') is-invalid @enderror"
                                                                            name="description"
                                                                            value="{{ old('description', $stream->description) }}"
                                                                            required autocomplete="description">
                                                                        @error('description')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="url"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Url') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="url" type="text"
                                                                            class="form-control @error('year') is-invalid @enderror"
                                                                            name="url"
                                                                            value="{{ old('url', $stream->url) }}"
                                                                            required autocomplete="url">
                                                                        @error('url')
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
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_stream', $stream->id) }}"
                                                onclick="return confirm('This stream will be deleted')"
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
            <!-- ADD STREAM MODAL -->
            <div class="modal fade" id="addStreamModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Stream</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_stream') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="title"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                    <div class="col-md-6">
                                        <input id="title" type="text"
                                            class="form-control @error('title') is-invalid @enderror" name="title"
                                            value="{{ old('title') }}" required autocomplete="title" autofocus>
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
                                            class="form-control @error('year') is-invalid @enderror" name="description"
                                            value="{{ old('description') }}" required autocomplete="description">
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="url"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Url') }}</label>
                                    <div class="col-md-6">
                                        <input id="url" type="text" class="form-control @error('year') is-invalid @enderror"
                                            name="url" value="{{ old('url') }}" required autocomplete="url">
                                        @error('url')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="timetable"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Timetable') }}</label>
                                    <div class="col-md-6">
                                        <input id="timetable" type="file"
                                            class="form-control @error('timetable') is-invalid @enderror" name="timetable"
                                            value="{{ old('timetable') }}" required autocomplete="timetable">
                                        @error('timetable')
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

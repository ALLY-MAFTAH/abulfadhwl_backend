@extends('layouts.app')

@section('content')
    <div class="py-3">
        <div class="container">
            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}
                </p>
            @endif
            @if (Session::has('success'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}
                </p>
            @endif
                <div class="card bg-white  px-2 py-2">
                    <div class="card-header mb-3">
                        <h4>ALL AUDIOS</h4>
                    </div>
                    <table id="example" class="table table-striped table-responsive-lg">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Album</th>
                                <th>Category</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($songs as $index => $song)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td> <div>{{ $song->title }}</div>
                                        <div style="color: gray">{{ $song->duration }} &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$song->size." MB"}}</div>
                                    </td>
                                    <td>{{ $song->album->name }}</td>
                                    <td>{{ $song->album->category->name }}</td>
                                    <td>
                                        <audio src="{{ asset('storage/' . $song->file) }}" controls controlslist></audio>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#editSongModal-{{ $song->id }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- EDIT SONG MODAL -->
                                    <div class="modal fade" id="editSongModal-{{ $song->id }}">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Edit Audio</h5>
                                                    <button class="close" data-bs-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST"
                                                        action="{{ route('edit_song', $song->id) }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group row">
                                                            <label for="title"
                                                                class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                                            <div class="col-md-6">
                                                                <input id="title" type="text"
                                                                    class="form-control @error('title') is-invalid @enderror"
                                                                    name="title"
                                                                    value="{{ old('title', $song->title) }}"
                                                                    required autocomplete="title" autofocus>
                                                                @error('title')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="file"
                                                                class="col-md-4 col-form-label text-md-right">{{ __('Audio File') }}</label>
                                                            <div class="col-md-6">
                                                                <input id="file" type="file"
                                                                    class="form-control @error('file') is-invalid @enderror"
                                                                    name="file" autocomplete="file"
                                                                    autofocus>
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
                                        <a href="{{ route('delete_song', $song->id) }}"
                                            onclick="return confirm('This song will be deleted')"
                                            class="btn btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endsection

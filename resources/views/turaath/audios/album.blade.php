@extends('layouts.app')

@section('content')
    <div class="py-3">
        <div class="container">

            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
            @endif
            @if (Session::has('success'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
            @endif

            <section id="actions" class=" mb-2">
                <div class="container">
                    <div class="row" style="padding-top:10px;background-color: rgb(247, 232, 206); border-radius: 5px">
                        <div class="col-4">
                            <a href="{{ route('category', $album->category->id) }}" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <div class="col-4 text-center">
                            <p style="font-size: 20px;"><b style="padding-right:10px"> {{ $album->name }}</b><a
                                    href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#editAlbumModal">
                                    <i class="fas fa-edit"></i>
                                </a></p>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#" class="btn btn-primary btn-outline" data-bs-toggle="modal"
                                data-bs-target="#addSongModal">
                                <i class="fas fa-plus"></i> Add Audio
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <div class="card bg-white">
                <div class="album_list">
                    <div class="card bg-white  px-2 py-2">
                        <div class="card-header mb-3">
                            <h4>LIST OF AUDIOS ({{ count($album->songs) }})</h4>
                        </div>
                        <table id="example" class="table table-striped table-responsive-lg">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Audio Name</th>
                                    <th>Size</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($album->songs as $index => $song)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div>{{ $song->title }}</div>
                                            <div>{{ $song->duration }}</div>
                                        </td>
                                        <td>{{ $song->size . ' MB' }}</td>
                                        <td>
                                            <audio src="{{ 'https://maftah.co.tz/public/storage/' . $song->file }}"
                                                controls controlslist></audio>
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
                                                                            name="file" autocomplete="file" autofocus>
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
                <!-- ADD SONG MODAL -->
                <div class="modal fade" id="addSongModal">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Add Audios</h5>
                                <button class="close" data-bs-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="fileUploadForm" method="POST" action="{{ route('add_song', $album->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="file"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Audio Files') }}</label>
                                        <div class="col-md-6">
                                            <input id="upload-file" type="file"
                                                class="form-control @error('file') is-invalid @enderror" name="file[]"
                                                multiple value="{{ old('file') }}" required autocomplete="file">
                                            <span>Max. 100 MB</span>
                                            @error('file')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                role="progressbar" aria-valuenow="" aria-valuemin="0"
                                                aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div id="success" class="row">
                                </div>
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- EDIT ALBUM MODAL -->
                <div class="modal fade" id="editAlbumModal">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Edit Album</h5>
                                <button class="close" data-bs-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="" method="PUT" action="{{ route('edit_album', $album->id) }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="name"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                        <div class="col-md-6">
                                            <input id="name" type="text"
                                                onkeyup="this.value = this.value.toUpperCase();"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name', $album->name) }}" required autocomplete="name"
                                                autofocus>
                                            @error('name')
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
                                                class="form-control @error('description') is-invalid @enderror"
                                                name="description" value="{{ old('description', $album->description) }}"
                                                required autocomplete="description">
                                            @error('description')
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
    </div>
@endsection

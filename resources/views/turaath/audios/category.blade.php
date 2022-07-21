@extends('layouts.app')

@section('content')
    <div class=" py-3">
        <div class="container">
            @if (Session::has('error'))
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
            @endif
            @if (Session::has('success'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
            @endif

            <section id="actions" class=" mb-2">
                <div class="container">
                    <div class="row" style="padding:20px;background-color: rgb(247, 232, 206); border-radius: 5px">
                        <div class="col">
                            <a href="{{ route('categories') }}" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <div class="col-4 text-center">
                            <p style="font-size: 20px;"><b style="padding-right:10px"> {{ $category->name }}</b><a
                                    href="#" class="btn btn-outline-primary" data-toggle="modal"
                                    data-target="#editCategoryModal">
                                    <i class="fas fa-edit"></i>
                                </a></p>
                        </div>
                        <div class="col-2"></div>
                        <div class="col-2 text-right">
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal"
                                data-target="#addAlbumModal">
                                <i class="fas fa-plus"></i> Add Album
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4>LIST OF ALBUMS ({{ count($category->albums) }})</h4>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-stripped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Album Name</th>
                                <th>Description</th>
                                <th>Number of songs</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                </div>
                <div hidden> {{ $albumSize = 0 }}</div>
                @foreach ($category->albums as $index => $album)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @foreach ($album->songs as $song)
                            <div hidden> {{ $albumSize = $albumSize + $song->size }}</div>
                        @endforeach
                        <td>
                            <div>{{ $album->name }}</div>
                            <div>{{ $albumSize . ' MB' }}</div>
                        </td>
                        <td>{{ $album->description }}</td>
                        <td>{{ count($album->songs) }}</td>
                        <td>
                            <a href="{{ route('album', $album->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-info-circle">
                                    View</i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('delete_album', $album->id) }}"
                                onclick="return confirm('This category will be deleted')" class="btn btn-outline-danger">
                                <i class="fas fa-trash"> Delete</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
            </div>

            <!-- ADD ALBUM MODAL -->
            <div class="modal fade" id="addAlbumModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Album</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_album', $category->id) }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            onkeyup="this.value = this.value.toUpperCase();"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $error }}</strong>
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
                                            name="description" value="{{ old('description') }}"
                                            autocomplete="description">
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $error }}</strong>
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
            <!-- EDIT CATEGORY MODAL -->
            <div class="modal fade" id="editCategoryModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Edit Category</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="PUT" action="{{ route('edit_category', $category->id) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name', $category->name) }}" required autocomplete="name"
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
                                            name="description" value="{{ old('description', $category->description) }}"
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

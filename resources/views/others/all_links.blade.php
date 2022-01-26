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
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#addLinkModal">
                                <i class="fas fa-plus"></i> Add Link
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section id="links">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h4>LINKS ({{ $links->count() }})</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>Url</th>
                                    <th>TYpe</th>
                                    <th>Switch</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($links as $index => $link)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><img src="{{ asset('storage/' . $link->icon) }}" alt="Link icon"
                                                style="width: 30px;height:30px"></td>
                                        <td>{{ $link->title }}</td>
                                        <td>{{ $link->url }}</td>
                                        <td>{{ $link->type }}</td>

                                        <td class="text-center">
                                            <form id="toggle-status-form-{{ $link->id }}" method="post"
                                                action="{{ route('toggle_status', $link) }}">
                                                <div class="switch switch-warning d-inline m-r-10">
                                                    <input type="hidden" name="status" value="0">
                                                    <input type="checkbox" name="status"
                                                        id="link-status-switch-{{ $link->id }}" class="status-switch"
                                                        @if ($link->status) checked @endif value="1" onclick="this.form.submit()" />
                                                    <label for="link-status-switch-{{ $link->id }}"
                                                        class="cr"></label>
                                                </div>
                                                @csrf @method('put')
                                            </form>
                                        </td>
                                        <td>
                                            <a href="#" role="alert" class="btn btn-outline-primary" data-toggle="modal"
                                                data-target="#editLinkModal-{{ $link->id }}"
                                                data-title="{{ $link->title }}" data-url="{{ $link->url }} ">
                                                <i class="fas fa-edit">
                                                    Edit</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_link', $link->id) }}"
                                                onclick="return confirm('This link will be deleted')"
                                                class="btn btn-outline-danger">
                                                <i class="fas fa-trash"> Delete</i>
                                            </a>

                                            <!-- EDIT LINK MODAL -->
                                            <div class="modal fade" id="editLinkModal-{{ $link->id }}"
                                                tabIndex="-1">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Edit Link</h5>
                                                            <button class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('edit_link', $link->id) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group row">
                                                                    <label for="title"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
                                                                    <div class="col-md-6">
                                                                        <select required name="type"
                                                                            class="dropdown-select form-control livesearch">

                                                                            <option value="Ours" @if ($link->type == 'Ours') selected @endif>
                                                                                {{ 'Ours' }}
                                                                            </option>
                                                                            <option value="Others" @if ($link->type == 'Others') selected @endif>
                                                                                {{ 'Others' }}
                                                                            </option>
                                                                        </select>
                                                                        @error('type')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="title"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="title" type="text"
                                                                            class="form-control @error('title') is-invalid @enderror"
                                                                            name="title"
                                                                            value="{{ old('title', $link->title) }}"
                                                                            required autocomplete="title" autofocus>
                                                                        @error('title')
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
                                                                            class="form-control @error('url') is-invalid @enderror"
                                                                            name="url"
                                                                            value="{{ old('url', $link->url) }}" required
                                                                            autocomplete="url">
                                                                        @error('url')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="icon"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Icon') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="icon" type="file"
                                                                            class="form-control @error('icon') is-invalid @enderror"
                                                                            name="icon" value="{{ old('icon') }}"
                                                                            autocomplete="icon">{{ old('icon', $link->icon) }}
                                                                        @error('icon')
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- ADD LINK MODAL -->
            <div class="modal fade" id="addLinkModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Link</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_link') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="title"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
                                    <div class="col-md-6">
                                        <select required name="type" class="dropdown-select form-control livesearch">
                                            <option value="">--Select--</option>
                                            <option value="Ours">{{ 'Ours' }}</option>
                                            <option value="Others">{{ 'Others' }}</option>
                                        </select>
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
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
                                    <label for="icon"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Icon') }}</label>
                                    <div class="col-md-6">
                                        <input id="icon" type="file"
                                            class="form-control @error('icon') is-invalid @enderror" name="icon"
                                            value="{{ old('icon') }}" required autocomplete="icon">
                                        @error('icon')
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

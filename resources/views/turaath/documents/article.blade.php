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
                    <div class="row" style="padding:20px;background-color: rgb(247, 232, 206); border-radius: 5px">
                        <div class="col">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>
                        <div class="col-8 text-center">
                            <h4><i class="fas fa-article music-icon"></i><b> {{ $article->title }} </b>
                            </h4>
                        </div>
                        <div class="col-2"></div>

                    </div>
                </div>
            </section>
            <div class="card bg-white">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4>Article Information <a href="#" class="btn btn btn-outline-primary"
                                    data-bs-toggle="modal" data-bs-target="#editArticleModal">
                                    <i class="fas fa-edit"></i>
                                </a></h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-3">
                                    <h5> Title: </h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $article->title }}</b></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Author:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $article->author }}</b></h5>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Edition:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $article->edition }}</b></h5>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Year of Publishment:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $article->pub_year }}</b></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Description:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $article->description }} </b></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" style=" text-align:center;border-radius:10px;padding:5px">
                            <div class="text-center">
                                <form action="{{ asset('storage/' . $article->file) }}" target="_blank"
                                    style="padding-bottom: 5px">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-file"> Open</i>
                                    </button>
                                </form>
                                <div style=""><img src={{ asset('storage/' . $article->cover) }}
                                        alt="Article Cover"height="250px" width="210px">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-9"></div>
                        <div style="padding-top: 5px;  text-align:center" class="col-3">
                            <div class="row">


                            </div>
                        </div>
                    </div>
                </div>

                <!-- EDIT ARTICLE MODAL -->
                <div class="modal fade" id="editArticleModal">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Edit Article</h5>
                                <button class="close" data-bs-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="PUT" action="{{ route('edit_article', $article->id) }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="title"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                                        <div class="col-md-6">
                                            <input id="title" type="text"
                                                class="form-control @error('title') is-invalid @enderror" name="title"
                                                value="{{ old('title', $article->title) }}" autocomplete="title" autofocus>
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
                                                class="form-control @error('description') is-invalid @enderror"
                                                name="description" value="{{ old('description', $article->description) }}"
                                                autocomplete="description">
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="pub_year"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Year of Publishment') }}</label>
                                        <div class="col-md-6">
                                            <input id="pub_year" type="text"
                                                class="form-control @error('year') is-invalid @enderror" name="pub_year"
                                                value="{{ old('pub_year', $article->pub_year) }}" required
                                                autocomplete="pub_year">
                                            @error('pub_year')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="file"
                                            class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>
                                        <div class="col-md-6">
                                            <input id="file" type="file"
                                                class="form-control @error('file') is-invalid @enderror" name="file"
                                                value="{{ old('file') }}" autocomplete="file">
                                            @error('file')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cover"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Cover') }}</label>
                                        <div class="col-md-6">
                                            <input id="cover" type="file"
                                                class="form-control @error('cover') is-invalid @enderror" name="cover"
                                                value="{{ old('cover') }}" autocomplete="cover">
                                            @error('cover')
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

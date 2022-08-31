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
                            <a href="#" class="btn btn-primary btn-outline" data-bs-toggle="modal"
                                data-bs-target="#addArticleModal">
                                <i class="fas fa-plus"></i> Add Article
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="articles">
                <div class="container">

                    <div class="card bg-white">
                        <div class="card-header">
                            <h4>ARTICLES ({{ $articles->count() }})</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Year of Publish</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $index => $article)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td><img src="{{"https://maftah.co.tz/public/storage/" . $article->cover }}" alt="Article cover"
                                                style="width: 30px"></td>
                                        <td>{{ $article->title }}</td>
                                        <td>{{ $article->pub_year }}</td>


                                        <td>
                                            <a href="{{ route('article', $article->id) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-info-circle">
                                                    View</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_article', $article->id) }}"
                                                onclick="return confirm('This article will be deleted')"
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

            <!-- ADD ARTICLE MODAL -->
            <div class="modal fade" id="addArticleModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Article</h5>
                            <button class="close" data-bs-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_article') }}" enctype="multipart/form-data">
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
                                    <label for="pub_year"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Year of Publishment') }}</label>
                                    <div class="col-md-6">
                                        <input id="pub_year" type="text"
                                            class="form-control @error('year') is-invalid @enderror" name="pub_year"
                                            value="{{ old('pub_year') }}" required autocomplete="pub_year">
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
                                            value="{{ old('file') }}" required autocomplete="file">
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
                                            value="{{ old('cover') }}" required autocomplete="cover">
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

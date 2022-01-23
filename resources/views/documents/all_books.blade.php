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
                            <a href="#" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#addBookModal">
                                <i class="fas fa-plus"></i> Add Book
                            </a>
                        </div>


                    </div>
                </div>
            </section>

            <section id="books">
                <div class="container">
                                      <div class="card">
                        <div class="card-header">
                            <h4>BOOKS ({{$books->count()}})</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Cover</th>
                                    <th>Title</th>
                                    <th>Edition</th>
                                    <th>Year of Publish</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $index => $book)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><img src="{{asset('storage/'.$book->cover)}}" alt="Book cover" style="width: 30px"></td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->edition }}</td>
                                        <td>{{ $book->pub_year }}</td>


                                        <td>
                                            <a href="{{ route('book', $book->id) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-info-circle">
                                                    View</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_book', $book->id) }}"
                                                onclick="return confirm('This book will be deleted')"
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

            <!-- ADD BOOK MODAL -->
            <div class="modal fade" id="addBookModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Book</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_book') }}" enctype="multipart/form-data">
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
                                            class="form-control @error('description') is-invalid @enderror" name="description"
                                            value="{{ old('description') }}" required autocomplete="description" >
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="edition"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Edition') }}</label>
                                    <div class="col-md-6">
                                        <input id="edition" type="number"
                                            class="form-control @error('edition') is-invalid @enderror" name="edition"
                                            value="{{ old('edition') }}" required autocomplete="edition" >
                                        @error('edition')
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
                                            value="{{ old('pub_year') }}" required autocomplete="pub_year" >
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
                                            value="{{ old('file') }}" required autocomplete="file" >
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
                                            value="{{ old('cover') }}" required autocomplete="cover" >
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

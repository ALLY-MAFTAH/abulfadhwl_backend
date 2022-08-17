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
                        <div class="col-6">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" class="btn btn-primary btn-outline" data-bs-toggle="modal"
                                data-bs-target="#addCategoryModal">
                                <i class="fas fa-plus"></i> New Category
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section id="categories">
                <div class="container">
                    <div class="card bg-white">
                        <div class="card-header">
                            <h4>AUDIO CATEGORIES ({{ count($categories) }})</h4>
                        </div>
                        <div class="row">
                            <table class="table table-striped table-responsive-lg">
                                <div class="row">
                                    <tbody>
                                        <div class="row mx-2 px-3">
                                            @foreach ($categories as $index => $category)
                                                <div
                                                    style="width:150px; border-radius:5px;padding:15px;background-color:rgb(246, 232, 199); margin-right:8px; margin-top:15px">
                                                    <div class="row">
                                                        <div class="col-9"><a href="{{ route('category', $category->id) }}"
                                                                class=" zoom fas fa-folder"
                                                                style="font-size: 65px; color:rgb(179, 124, 7); text-decoration:none">
                                                                <h6
                                                                    style="margin:auto;color:rgb(3, 3, 119); text-align:left">
                                                                    <b>{{ $category->name }}</b><br>
                                                                    <div class="text-dark">{{ count($category->albums) }}
                                                                        Albums</div>
                                                                </h6>
                                                            </a></div>
                                                        <div class="col-3">
                                                            <a style="text-decoration: none;"
                                                                href="{{ route('delete_category', $category->id) }}"
                                                                onclick="return confirm('This category will be deleted')">
                                                                <i style=" margin:5px;color:red" class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </tbody>
                                </div>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ADD CATEGORY MODAL -->
            <div class="modal fade" id="addCategoryModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Category</h5>
                            <button class="close" data-bs-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_category') }}">
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
                                            name="description" value="{{ old('description') }}" required
                                            autocomplete="description">
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

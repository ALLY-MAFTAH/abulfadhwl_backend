@extends('layouts.app')
@section('sidebar')
    <div class="col-md-2">
        @include('components.left_nav')
    </div>
@endsection

@section('content')
    <div class="col-md-10 py-3">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('errors'))
                <div class="alert alert-success" role="alert">
                    {{ session('errors') }}
                </div>
            @endif

            @if (Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            <section id="actions" class="py-2 mb-4 bg-light">
                <div class="container">
                    <div class="row px-3 ">
                        <h4><b> {{ $category->name }} </b>
                        </h4>
                    </div>
            </section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <h4>Category Information <a href="#" class="btn btn-warning btn-outline" data-toggle="modal"
                                    data-target="#editCategoryModal">
                                    <i class="fas fa-edit"></i>
                                </a></h4>
                        </div>
                        <div class="col-3">
                          <h4>  <a href="#" class="btn btn-primary btn-outline" data-toggle="modal" data-target="#addAlbumModal">
                            <i class="fas fa-plus"></i> Add Album
                        </a></h4>
                    </div>
                    </div>
                </div>
                <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <h5> Name: </h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $category->name }}</b></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Description:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ $category->description }} </b></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <h5> Number of Albums:</h5>
                                </div>
                                <div class="col-9">
                                    <h5><b>{{ count($category->albums) }} </b></h5>
                                </div>
                            </div>
                    <hr>
                   <div class="row">

                   </div>
                </div>


                    <!-- ADD ALBUM MODAL -->
            <div class="modal fade" id="addAlbumModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Album</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_album',$category->id) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" onkeyup="this.value = this.value.toUpperCase();"
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
                                            class="form-control @error('description') is-invalid @enderror" name="description"
                                            value="{{ old('description') }}" required autocomplete="description" >
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
                    <!-- EDIT CATEGORY MODAL -->
            <div class="modal fade" id="editCategoryModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Edit Category</h5>
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="PUT" action="{{ route('edit_category',$category->id) }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="name"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name',$category->name) }}" required autocomplete="name" autofocus>
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
                                            class="form-control @error('description') is-invalid @enderror" name="description"
                                            value="{{ old('description',$category->description) }}" required autocomplete="description" >
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

            <div class="album_list">
               <div class="card">
                   <div style="text-align: center;padding-top:10px;">
                       <h4><b>List of Albums</b></h4>
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

                           @foreach ($category->albums as $index => $album)
                           <tr>
                           <td>{{$index+1}}</td>
                           <td>{{$album->name}}</td>
                           <td>{{$album->description}}</td>
                           <td>{{count($album->songs)}}</td>
                           <td>
                            <a href="{{ route('album', $album->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-info-circle">
                                    Open</i>
                            </a>
                           </td>
                           <td>
                            <a href="{{ route('delete_album', $album->id) }}"
                                onclick="return confirm('This category will be deleted')"
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
            </div>

            </div>

 <!--FOOTER  -->
 <footer id="main-footer" class="bg-light text-dark mb-3">
    <div class="container">
        <div class="col">
            <hr>
            <p class="lead text-center">
                Copyright &copy; <span id="year"></span> ABUL FADHWL
            </p>
        </div>
    </div>
</footer>

            <style>


            </style>

<script>


                // Get the current year for the copyright
                $('#year').text(new Date().getFullYear());

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />
            </script>
        </div>
    </div>
    @endsection


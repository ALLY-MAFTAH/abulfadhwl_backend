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
            <section id="categories">
                <div class="container">

                    <div class="card bg-white">
                        <div class="card-header">
                            <h4>ALBUMS</h4>
                        </div>
                        <table class="table table-striped table-responsive-lg">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>No. of Audios</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($albums as $index => $album)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $album->name }}</td>
                                        <td>{{ $album->description }}</td>
                                        <td>
                                            <div hidden>
                                                {{ $categoryName = App\Models\Category::findOrFail($album->category_id)->name }}
                                            </div>
                                            {{ $categoryName }}
                                        </td>
                                        <td>{{ count($album->songs) }}</td>


                                        <td>
                                            <a href="{{ route('album', $album->id) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-info-circle">
                                                    View</i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_album', $album->id) }}"
                                                onclick="return confirm('This album will be deleted')"
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
        </div>
    </div>
@endsection

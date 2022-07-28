@extends('layouts.app')

@section('content')
    <div class="col-md-10 py-3">
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
            <section id="actions" class="py-5 mb-4 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">

                        </div>
                    </div>
                </div>
            </section>

            <section id="categories">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h4>AUDIOS</h4>
                        </div>
                        <table class="table table-striped">
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
                                    @foreach ($categories as $category)
                                        @foreach ($category->albums as $newAlbum)
                                            @foreach ($newAlbum->songs as $newSong1)
                                                @foreach ($albums as $album)
                                                    @foreach ($album->songs as $newSong2)
                                                        @if ($newSong2->id == $song->id)
                                                            @if ($newSong1->id == $song->id)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $song->title }}</td>
                                                                    <td>{{ $album->name }}</td>
                                                                    <td>{{ $category->name }}</td>
                                                                    <td>
                                                                        <audio src="{{ asset('storage/' . $song->file) }}"
                                                                            controls controlslist></audio>
                                                                    </td>

                                                                    <td>
                                                                        <a href="{{ route('song', $song->id) }}"
                                                                            class="btn btn-outline-primary">
                                                                            <i class="fas fa-eye">
                                                                            </i>
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('delete_song', $song->id) }}"
                                                                            onclick="return confirm('This song will be deleted')"
                                                                            class="btn btn-outline-danger">
                                                                            <i class="fas fa-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

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
                    <div class="row"
                        style="margin:2px;padding:10px;background-color: rgb(247, 232, 206); border-radius: 5px">
                        <div class="col-6">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>

                        <div class="col-6 text-right">
                            <a href="#" class="btn btn-primary btn-outline" data-bs-toggle="modal"
                                data-bs-target="#addAnnouncementModal">
                                <i class="fas fa-plus"></i> Add Announcement
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="announcements">
                <div class="container">
                    <div class="card bg-white">
                        <div class="card-header">
                            <h4>ANNOUNCEMENTS ({{ $announcements->count() }})</h4>
                        </div>
                        <table class="table table-striped table-responsive-lg">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>News</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($announcements as $index => $announcement)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="min-width: 100px">{{ $announcement->date }}</td>
                                        <td>{{ $announcement->news }}</td>
                                        <td>
                                            <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editAnnouncementModal-{{ $announcement->id }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- EDIT ANNOUNCEMENT MODAL -->
                                            <div class="modal fade" id="editAnnouncementModal-{{ $announcement->id }}">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Edit Announcement</h5>
                                                            <button class="close" data-bs-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="PUT"
                                                                action="{{ route('edit_announcement', $announcement->id) }}">
                                                                @csrf

                                                                <div class="form-group row">
                                                                    <label for="date"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="date" type="date"
                                                                            class="form-control @error('date') is-invalid @enderror"
                                                                            name="date"
                                                                            value="{{ old('date', $announcement->date) }}"
                                                                            required autocomplete="date" autofocus>
                                                                        @error('date')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="news"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('News') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="news" type="text"
                                                                            class="form-control @error('news') is-invalid @enderror"
                                                                            name="news"
                                                                            value="{{ old('news', $announcement->news) }}"
                                                                            required autocomplete="news">
                                                                        @error('news')
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
                                        </td>
                                        <td>
                                            <a href="{{ route('delete_announcement', $announcement->id) }}"
                                                onclick="return confirm('This announcement will be deleted')"
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
            </section>
            <!-- ADD ANNOUNCEMENT MODAL -->
            <div class="modal fade" id="addAnnouncementModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Announcement</h5>
                            <button class="close" data-bs-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_announcement') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="date"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>
                                    <div class="col-md-6">
                                        <input id="date" type="date"
                                            class="form-control @error('date') is-invalid @enderror" name="date"
                                            value="{{ old('date') }}" required autocomplete="date" autofocus>
                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="news"
                                        class="col-md-4 col-form-label text-md-right">{{ __('News') }}</label>
                                    <div class="col-md-6">
                                        <input id="news" type="text"
                                            class="form-control @error('news') is-invalid @enderror" name="news"
                                            value="{{ old('description') }}" required autocomplete="news">
                                        @error('news')
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

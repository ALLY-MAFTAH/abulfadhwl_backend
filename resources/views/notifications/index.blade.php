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

            <div class="card bg-white">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h4>Notifications</h4>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('bulksend') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" aria-describedby="emailHelp"
                                placeholder="Enter Notification Title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="body">Message</label>
                            <input type="text" class="form-control" id="body" aria-describedby="emailHelp"
                                placeholder="Enter Notification Description" name="body" required>
                        </div>
                        <div class="form-group">
                            <label for="img">Image Url</label>
                            <input type="text" class="form-control" id="img" aria-describedby="emailHelp"
                                placeholder="Enter image link" name="img">
                        </div>
                        <div class="text-center">

                            <button type="submit" class="btn btn-primary">Send Notification</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="card bg-white">
                <div class="card-body">
                    <table class="table table-striped table-responsive-lg">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $index => $notification)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $notification->created_at }}</td>
                                    <td style="min-width: 100px">{{ $notification->title }}</td>
                                    <td style="min-width: 120px">{{ $notification->body }}</td>

                                    <td>
                                        {{-- <a href="{{ route('delete_notification', $notification->id) }}"
                                            onclick="return confirm('This notification will be deleted')"
                                            class="btn btn-outline-danger">
                                            <i class="fas fa-trash"> Delete</i>
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

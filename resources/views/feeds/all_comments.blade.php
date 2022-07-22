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
                        style="margin:2px;padding:20px;background-color: rgb(247, 232, 206); border-radius: 5px">
                        <div class="col-6">
                            <button onclick="history.back()" class="btn btn-primary btn-outline">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section id="comments">
                <div class="container">

                    <div class="card">
                        <div class="card-header">
                            <h4>COMMENTS ({{$comments->count()}})</h4>
                        </div>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments as $index => $comment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="min-width: 100px">{{ $comment->full_name }}</td>
                                        <td style="min-width: 120px">{{ $comment->email }}</td>
                                        <td>{{ $comment->message }}</td>

                                        <td>
                                            <a href="{{ route('delete_comment', $comment->id) }}"
                                                onclick="return confirm('This comment will be deleted')"
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

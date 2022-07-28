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
                            <a href="#" class="btn btn-primary btn-outline" data-bs-toggle
="modal"
                                data-bs-target
="#addSlideModal">
                                <i class="fas fa-plus"></i> Add Slide
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <section id="slides">
                <div class="container">
                                       <div class="card">
                        <div class="card-header">
                            <h4>SLIDES ({{ $slides->count() }})</h4>
                        </div>
                        <table class="table table-striped">
                            <tbody>
                                <div class="row " style="margin: 2px">
                                    @foreach ($slides as $index => $slide)
                                        <div class="col-3 " style="padding: 2px;">
                                            <div>
                                                <img src={{ asset('storage/' . $slide->file) }} alt="Slide file"
                                                    style="width: 100%;padding:5px">
                                                <div class="row" style="padding: 5px">
                                                    <div class="col-md-6">
                                                        <h5>Slide No: <span
                                                                style="color: blue">{{ $slide->number }}</span>
                                                            </h4>
                                                    </div>
                                                    <div class="col-md-6" style="text-align-last: right">
                                                        <a href="{{ route('delete_slide', $slide->id) }}"
                                                            onclick="return confirm('This slide will be deleted')"
                                                            class="btn btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>


            <!-- MODALS -->

            <!-- ADD SLIDE MODAL -->
            <div class="modal fade" id="addSlideModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Add Slide</h5>
                            <button class="close" data-bs-dismiss
="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_slide') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="number"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Number') }}</label>
                                    <div class="col-md-6">
                                        <input id="number" type="number"
                                            class="form-control @error('number') is-invalid @enderror" name="number"
                                            value="{{ old('number') }}" required autocomplete="number" autofocus>
                                        @error('number')
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

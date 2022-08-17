@extends('layouts.app')

@section('scripts')
    <script>
        $("#filter-form").on("submit", function(e) {
            e.preventDefault();
            var url = $("#filter-form").attr("action");
            var newUrl = `${url}?type=${$(e.target).val()}`;
            window.location.assign(newUrl);
        });
    </script>
@endsection
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
                        <div class="col-6 ">
                            <form action="{{ route('allQuestions') }}" method="GET" id="filter-form" style="float:right">
                                @csrf

                                <select name="type" id="type" class="dropdown-select form-control"
                                    style="width: 120px" onchange="document.getElementById('filter-form').submit()">
                                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="answered" {{ $type == 'answered' ? 'selected' : '' }}>Answered
                                    </option>
                                    <option value="unanswered" {{ $type == 'unanswered' ? 'selected' : '' }}>Unanswered
                                    </option>
                                </select>

                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section id="comments">
                <div class="container">

                    <div class="card bg-white">
                        <div class="card-header">
                            @if ($questions == null)
                                <h4>MASWALI YALIYOJIBIWA (0)</h4>
                            @else
                                @if ($type == 'all')
                                    <h4>MASWALI YOTE ({{ count($questions) }})</h4>
                                @elseif ($type == 'unanswered')
                                    <h4>MASWALI YASIYOJIBIWA ({{ count($questions) }})</h4>
                                @else
                                    <h4>MASWALI YALIYOJIBIWA ({{ count($questions) }})</h4>
                                @endif
                            @endif
                        </div>
                        <table class="table table-striped table-responsive-lg">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Swali</th>
                                    <th>Jibu la maandihsi</th>
                                    <th>Jibu la sauti</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($questions==null)

                                @else


                                @foreach ($questions as $index => $answer)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $answer->qn }}</td>
                                        <td>{{ $answer->textAns ?? '--' }}</td>
                                        <td>
                                            @if ($answer->audioAns != '')
                                                <audio src="{{ asset('storage/' . $answer->audioAns) }}" controls
                                                    controlslist></audio>
                                            @else
                                                {{ '--' }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" target="modal" data-bs-toggle="modal"
                                                data-bs-target="#editAnswerModal-{{ $answer->id }}"
                                                class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- EDIT ANSWER MODAL -->
                                            <div class="modal fade" id="editAnswerModal-{{ $answer->id }}">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title">Weka jibu</h5>
                                                            <button class="close" data-bs-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST"
                                                                action="{{ route('edit_answer', $answer->id) }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group row">
                                                                    <label for="qn"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Swali Lililoulizwa') }}</label>
                                                                    <div class="col-md-6">
                                                                        <textarea id="qn" type="text" class="form-control @error('qn') is-invalid @enderror" name="qn"
                                                                            value="" required autocomplete="qn">{{ old('qn', $answer->qn) }}</textarea>
                                                                        @error('qn')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="textAns"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Jibu la maandishi') }}</label>
                                                                    <div class="col-md-6">
                                                                        <textarea id="textAns" type="text" class="form-control @error('textAns') is-invalid @enderror" name="textAns"
                                                                            value="" autocomplete="textAns">{{ old('textAns', $answer->textAns) }}</textarea>
                                                                        @error('textAns')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="audioAns"
                                                                        class="col-md-4 col-form-label text-md-right">{{ __('Jibu la sauti') }}</label>
                                                                    <div class="col-md-6">
                                                                        <input id="audioAns" type="file"
                                                                            class="form-control @error('audioAns') is-invalid @enderror"
                                                                            name="audioAns" value=""
                                                                            autocomplete="audioAns">{{ old('audioAns', $answer->audioAns) }}
                                                                        @error('audioAns')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row mb-0">
                                                                    <div class="col-md-6 offset-md-4">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Tuma
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
                                            <a href="{{ route('delete_answer', $answer->id) }}"
                                                onclick="return confirm('This answer will be deleted')"
                                                class="btn btn-outline-danger">
                                                <i class="fas fa-trash"> Delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ADD ANSWER MODAL -->
            <div class="modal fade" id="addAnswerModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Weka jibu</h5>
                            <button class="close" data-bs-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('add_answer') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="qn"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Swali Lililoulizwa') }}</label>
                                    <div class="col-md-6">
                                        <textarea id="qn" type="text" class="form-control @error('qn') is-invalid @enderror" name="qn"
                                            value="{{ old('qn') }}" required autocomplete="qn"></textarea>
                                        @error('qn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ans"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Jibu') }}</label>
                                    <div class="col-md-6">
                                        <textarea id="ans" type="text" style="height: 40px" class="form-control @error('ans') is-invalid @enderror"
                                            name="ans" value="{{ old('ans') }}" required autocomplete="ans"></textarea>
                                        @error('ans')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endsection

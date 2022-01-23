@extends('layouts.app')

@section('content')
    <div class="">
        <div class="container">

            @if (session('status'))
                <div class="alert alert-info" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <br>
            <div class="row d-flex justify-content-center text-center">
                <a href="{{ route('categories') }}" class="card btn summary-cards  col-md ">
                    <div class="summary-content"><i class="fas fa-music"></i>
                        AUDIOS <br>
                        ( {{ count($categories) }} )</div>
                    </a>

                    <a href="{{ route('books') }}" class="card btn summary-cards  col-md ">
                        <div class="summary-content"> <i class="fas fa-book"></i>
                            BOOKS <br>
                            ( {{ count($books) }} )
                        </div>
                    </a>
                    <a href="{{ route('articles') }}" class="card btn summary-cards  col-md ">
                        <div class="summary-content"> <i class="fas fa-file"></i>
                            ARTICLES <br>
                            ( {{ count($articles) }} )
                        </div>
                    </a>
                    <a href="{{ route('histories') }}" class="card btn summary-cards  col-md ">
                        <div class="summary-content"> <i class="fas fa-history"></i>
                            HISTORY <br>
                            ( {{ count($histories) }} )
                        </div>
                    </a>
                    <a href="{{ route('streams') }}" class="card btn summary-cards  col-md ">
                        <div class="summary-content"> <i class="fas fa-microphone-alt"></i>
                            STREAMS <br>
                            ( {{ count($streams) }} )
                        </div>
                    </a>
                    <a href="{{ route('users') }}" class="card btn summary-cards  col-md">
                        <div class="summary-content"><i class="fas fa-users"></i>
                            USERS <br>
                            ( {{ count($users) }} )
                        </div>
                    </a>
                    </div>
                        <div class="row d-flex justify-content-center text-center">

                <a href="{{ route('announcements') }}" class="card btn summary-cards col-md">
                    <div class="summary-content"><i class="fas fa-bullhorn"></i>
                        ANNOUNCEMENTS <br>
                        ( {{ count($announcements) }} )
                    </div>
                </a>
                <a href="{{ route('comments') }}" class="card btn summary-cards  col-md">
                    <div class="summary-content"><i class="fas fa-comments"></i>
                        COMMENTS <br>
                        ( {{ count($comments) }} )
                    </div>
                </a>
                <a href="{{ route('questions') }}" class="card btn summary-cards  col-md">
                    <div class="summary-content"><i class="fas fa-question"></i>
                        QUESTIONS <br>
                        ( {{ count($questions) }} )
                    </div>
                </a>
                <a href="{{ route('slides') }}" class="card btn summary-cards  col-md">
                    <div class="summary-content"><i class="fas fa-image"></i>
                        SLIDES <br>
                        ( {{ count($slides) }} )
                    </div>
                </a>
                <a href="{{ route('links') }}" class="card btn summary-cards  col-md">
                    <div class="summary-content"><i class="fas fa-link"></i>
                        LINKS <br>
                        ( {{ count($links) }} )
                    </div>
                </a>

            </div>

        </div>
    </div>
@endsection

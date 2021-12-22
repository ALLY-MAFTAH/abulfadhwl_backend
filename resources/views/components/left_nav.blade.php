

{{-- NAVIGATION PANE --}}

<div style="background: #d8cca6 !important; min-height: 80vh;  padding-top:10px ">

    <!-- HEADER -->

    <header id="main-header" class="py-2 text-dark">
        <div class="container">
            <div class="row">
                <h2 style="padding-left: 20px">
                    <i class="fas fa-cog"> Dashboard</i>
                </h2>
            </div>
        </div>
        <style>

        </style>
    </header>
    <hr>
    <div style="padding: 1em; color:rgb(6, 5, 36); ">
        <h5 style="font-size: 23px; padding-left:5px" class="nav-item-heading">Menu</h5>
        <li class="nav-item active list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('categories') }}">

                <h5><i class="fas fa-list-alt"></i>Categories</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('albums') }}">

                <h5><i class="fas fa-database"> </i>Albums</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('songs') }}">

                <h5><i class="fas fa-music"> </i>Audios</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('books') }}">

                <h5><i class="fas fa-book"> </i>Books</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('articles') }}">

                <h5><i class="fas fa-file"> </i>Articles</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('slides') }}">

                <h5><i class="fas fa-image"> </i>Slides</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('histories') }}">

                <h5><i class="fas fa-history"> </i>Histories</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('streams') }}">

                <h5><i class="fas fa-stream"> </i>Streams</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('comments') }}">

                <h5><i class="fas fa-comments"> </i>Comments</h5>
            </a>
        </li>

        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('links') }}">

                <h5><i class="fas fa-link"> </i>Links</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('questions') }}">

                <h5><i class="fas fa-question"> </i>Questions</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('answers') }}">

                <h5><i class="fas fa-question"> </i>Answers</h5>
            </a>
        </li>
        <li class="nav-item  list-unstyled">
            <a class="nav-link left-menu-link" href="{{ route('announcements') }}">

                <h5><i class="fas fa-volume"> </i>Announcements</h5>
            </a>
        </li>
        <hr>

    </div>
</div>

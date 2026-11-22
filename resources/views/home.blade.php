@extends('layouts.app')
@section('page_title', 'Dashibodi')

@section('content')
    @if (session('status'))<div class="alert alert-info">{{ session('status') }}</div>@endif
    @if (Session::has('error'))<div class="alert alert-danger">{{ Session::get('error') }}</div>@endif
    @if (Session::has('success'))<div class="alert alert-success">{{ Session::get('success') }}</div>@endif

    <div class="page-head">
        <p class="salaam">Assalamu alaykum wa rahmatullah, {{ Auth::user()->name }}
            <small>Barakallahu feekum kwa kazi ya kueneza elimu yenye manufaa.</small></p>
        <div class="actions">
            <a class="btn btn-primary" href="{{ route('categories') }}"><i class="fas fa-plus"></i> Pakia sauti</a>
            <a class="btn btn-gold" href="{{ route('announcements') }}"><i class="fas fa-bullhorn"></i> Tangazo</a>
        </div>
    </div>

    {{-- Live toggle --}}
    <div class="live-card">
        <div>
            <h2><span class="live-dot {{ $liveStream && $liveStream->status ? 'on' : '' }}"></span>Darsa ya moja kwa moja</h2>
            <p>
                @if ($liveStream)
                    {{ $liveStream->title }} — {{ $liveStream->status ? 'Inarushwa sasa. Watumiaji wanaiona kwenye app.' : 'Haijawashwa.' }}
                @elseif (\App\Models\Stream::count())
                    Hakuna darsa iliyopangwa leo ({{ \App\Models\Stream::DAYS[\App\Models\Stream::todayKey()] }}). <a style="color:var(--gold-light)" href="{{ route('streams') }}">Simamia ratiba</a>
                @else
                    Bado hujaweka kiungo cha live. <a style="color:var(--gold-light)" href="{{ route('streams') }}">Weka sasa</a>
                @endif
            </p>
        </div>
        @if (\App\Models\Stream::count())
            <div class="state">
                <form method="post" action="{{ route('stream.toggle_live') }}">
                    @csrf @method('put')
                    <div class="switch">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" id="live-switch" value="1" @checked($liveStream && $liveStream->status)
                            onclick="this.form.submit()">
                        <label for="live-switch" class="cr"></label>
                    </div>
                </form>
                <a class="btn btn-sm btn-gold" href="{{ route('streams') }}">Simamia</a>
            </div>
        @endif
    </div>

    <div class="kpis">
        @foreach ($stats as $i => $s)
            <a class="kpi" style="--tone: {{ $s[3] }}" href="{{ route($s[4]) }}">
                <span class="ico"><i class="fas {{ $s[2] }}"></i></span>
                <div class="num">{{ $s[1] }}</div>
                <div class="lbl">{{ $s[0] }}</div>
            </a>
        @endforeach
    </div>

    <div class="grid cols-main">
        <div class="grid">
            <section class="panel">
                <div class="panel-head">
                    <h2>Maswali yanayosubiri jibu @if ($pendingCount)<span class="pill live">{{ $pendingCount }}</span>@endif</h2>
                    <div class="right"><a href="{{ route('allQuestions') }}">Yote</a></div>
                </div>
                <div class="list-rows">
                    @forelse ($pendingQuestions as $q)
                        <div class="row-item">
                            <div style="min-width:0;flex:1"><div class="t">{{ \Illuminate\Support\Str::limit($q->qn, 90) }}</div>
                                <small>{{ $q->created_at?->diffForHumans() }}</small></div>
                            <a class="btn btn-sm btn-primary" href="{{ route('allQuestions', ['type' => 'unanswered', 'answer' => $q->id]) }}">Jibu</a>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Hakuna maswali yanayosubiri. Alhamdulillah.</p>
                    @endforelse
                </div>
            </section>

            <section class="panel">
                <div class="panel-head"><h2>Vilivyopakiwa karibuni</h2></div>
                <div class="list-rows">
                    @foreach ($latestSongs as $x)
                        <div class="row-item"><span class="pill"><i class="fas fa-headphones"></i> Sauti</span>
                            <div class="t">{{ $x->title }}</div><small class="ms-auto">{{ $x->created_at?->diffForHumans() }}</small></div>
                    @endforeach
                    @foreach ($latestBooks as $x)
                        <div class="row-item"><span class="pill"><i class="fas fa-book"></i> Kitabu</span>
                            <div class="t">{{ $x->title ?? $x->name ?? 'Kitabu' }}</div><small class="ms-auto">{{ $x->created_at?->diffForHumans() }}</small></div>
                    @endforeach
                    @foreach ($latestArticles as $x)
                        <div class="row-item"><span class="pill"><i class="fas fa-file-alt"></i> Makala</span>
                            <div class="t">{{ $x->title ?? $x->name ?? 'Makala' }}</div><small class="ms-auto">{{ $x->created_at?->diffForHumans() }}</small></div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="grid">
            <section class="panel">
                <div class="panel-head"><h2>Maoni ya karibuni</h2><div class="right"><a href="{{ route('comments') }}">Yote</a></div></div>
                <div class="list-rows">
                    @forelse ($latestComments as $c)
                        <div class="row-item"><div style="min-width:0"><div class="t">{{ $c->full_name }}</div>
                            <small>{{ \Illuminate\Support\Str::limit($c->message, 80) }}</small></div></div>
                    @empty
                        <p class="text-muted mb-0">Hakuna maoni bado.</p>
                    @endforelse
                </div>
            </section>
            <section class="panel">
                <div class="panel-head"><h2>Njia za haraka</h2></div>
                <div class="quick" style="margin:0">
                    <a href="{{ route('books') }}"><i class="fas fa-book"></i> Vitabu</a>
                    <a href="{{ route('articles') }}"><i class="fas fa-file-alt"></i> Makala</a>
                    <a href="{{ route('notifications') }}"><i class="fas fa-bell"></i> Tuma arifa</a>
                    <a href="{{ route('links') }}"><i class="fas fa-link"></i> Viungo</a>
                </div>
            </section>
        </div>
    </div>
@endsection

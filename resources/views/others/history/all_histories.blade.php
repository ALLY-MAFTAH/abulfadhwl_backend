@extends('layouts.app')

@section('page_title', 'Historia')

@section('style')
<style>
  .hsec { border-bottom: 1px solid var(--pro-line); }
  .hsec:last-child { border-bottom: 0; }
  .hsec-head { display: grid; grid-template-columns: 46px 1fr auto auto; gap: 14px; align-items: center; padding: 16px 20px; cursor: pointer; transition: background .15s; }
  .hsec-head:hover { background: rgba(var(--fill),.03); }
  .hsec .no { width: 46px; height: 46px; border-radius: 15px; display: grid; place-items: center; font: 700 16px "JetBrains Mono", monospace; color: #2b1d00; background: linear-gradient(135deg, var(--pro-gold-l), var(--pro-gold)); }
  .hsec h3 { margin: 0 0 3px; font-size: 17px; font-weight: 700; }
  .hsec .ex { margin: 0; color: var(--pro-mut); font-size: 13.5px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
  .hsec.open .ex { display: none; }
  .hsec .acts { display: flex; gap: 6px; }
  .hsec .chev { width: 34px; height: 34px; display: grid; place-items: center; color: var(--pro-mut); transition: transform .25s; }
  .hsec.open .chev { transform: rotate(180deg); color: var(--pro-gold); }
  .hsec-body { display: none; padding: 0 20px 22px 80px; }
  .hsec.open .hsec-body { display: block; }
  .paper { background: #f7f8fc; color: #1b2440; border-radius: 18px; padding: 26px 30px; line-height: 1.85; font-size: 16px; overflow-x: auto; box-shadow: 0 20px 40px -30px rgba(0,0,0,.6); }
  .paper h1, .paper h2, .paper h3, .paper h4 { color: #14224d; letter-spacing: 0; margin: 1.1em 0 .4em; }
  .paper p { margin: 0 0 .9em; } .paper ul, .paper ol { padding-left: 1.4em; margin: 0 0 .9em; }
  .paper table { border-collapse: collapse; max-width: 100%; margin: 0 0 1em; } .paper td, .paper th { border: 1px solid #b9c2dc; padding: 7px 10px; }
  .paper a { color: #1f4e9c; } .paper > :last-child { margin-bottom: 0; }
  .hsec-foot { display: flex; justify-content: space-between; gap: 10px; align-items: center; margin-top: 12px; color: var(--pro-dim); font-size: 12.5px; }
  .tools { display: flex; gap: 8px; }
  @media (max-width: 640px) { .hsec-head { grid-template-columns: 46px 1fr auto; } .hsec .acts { display: none; } .hsec-body { padding: 0 14px 18px; } .paper { padding: 18px; } }
</style>
@endsection

@section('content')
<div class="py-2"><div class="container">
    @if (Session::has('error'))<p class="alert alert-danger">{{ Session::get('error') }}</p>@endif
    @if (Session::has('success'))<p class="alert alert-success">{{ Session::get('success') }}</p>@endif

    <div class="pro-head">
        <div class="ph-tx">
            <span class="pro-eyebrow">Turaath · Historia</span>
            <h1>Historia ya Sheikh</h1>
            <p>Sehemu zinaonekana kwenye app kwa mpangilio wa namba. Kila sehemu ina kichwa na maandishi marefu yenye mapambo.</p>
        </div>
        <div class="ph-act"><a class="pbtn pbtn-gold" href="{{ route('history_new') }}"><i class="fas fa-plus"></i> Sehemu mpya</a></div>
    </div>

    @if ($histories->count() > 1)
        <div class="tools mb-3">
            <button type="button" class="pbtn pbtn-ghost pbtn-sm" id="openAll"><i class="fas fa-angle-double-down"></i> Panua zote</button>
            <button type="button" class="pbtn pbtn-ghost pbtn-sm" id="closeAll"><i class="fas fa-angle-double-up"></i> Funga zote</button>
        </div>
    @endif

    <div class="pro-sheet">
        @forelse ($histories as $h)
            <div class="hsec {{ $loop->first ? 'open' : '' }}">
                <div class="hsec-head" role="button" tabindex="0" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                    <span class="no">{{ $h->section }}</span>
                    <div style="min-width:0">
                        <h3>{{ $h->heading }}</h3>
                        <p class="ex">{{ \App\Support\HtmlCleaner::excerpt($h->content, 160) }}</p>
                    </div>
                    <div class="acts">
                        <a class="iconbtn" title="Hariri" href="{{ route('history_edit', $h->id) }}" onclick="event.stopPropagation()"><i class="fas fa-pen"></i></a>
                        <button type="button" class="iconbtn del" title="Futa" onclick="event.stopPropagation();AF.confirm({title:'Futa sehemu hii?',text:{{ json_encode($h->heading) }},ok:'Futa',danger:true}).then(function(y){if(y)location.href='{{ route('delete_history', $h->id) }}'})"><i class="fas fa-trash"></i></button>
                    </div>
                    <span class="chev"><i class="fas fa-chevron-down"></i></span>
                </div>
                <div class="hsec-body">
                    <article class="paper">{!! \App\Support\HtmlCleaner::clean($h->content) !!}</article>
                    <div class="hsec-foot">
                        <span>Hii ni muonekano wa kusoma tu. Hakuna kinachobadilika hapa.</span>
                        <a class="pbtn pbtn-ghost pbtn-sm" href="{{ route('history_edit', $h->id) }}"><i class="fas fa-pen"></i> Hariri sehemu hii</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="pro-empty"><i class="fas fa-book-reader"></i><b>Bado hakuna historia</b>Bonyeza "Sehemu mpya" kuandika ya kwanza, mf. kuzaliwa kwake.</div>
        @endforelse
    </div>
</div></div>
<script>
(function () {
  function toggle(sec, force) {
    var open = force === undefined ? !sec.classList.contains('open') : force;
    sec.classList.toggle('open', open);
    sec.querySelector('.hsec-head').setAttribute('aria-expanded', open ? 'true' : 'false');
  }
  document.querySelectorAll('.hsec-head').forEach(function (h) {
    h.addEventListener('click', function () { toggle(h.parentNode); });
    h.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(h.parentNode); } });
  });
  var o = document.getElementById('openAll'), c = document.getElementById('closeAll');
  if (o) o.onclick = function () { document.querySelectorAll('.hsec').forEach(function (s) { toggle(s, true); }); };
  if (c) c.onclick = function () { document.querySelectorAll('.hsec').forEach(function (s) { toggle(s, false); }); };
})();
</script>
@endsection

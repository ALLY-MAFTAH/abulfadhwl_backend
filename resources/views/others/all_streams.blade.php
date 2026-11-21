@extends('layouts.app')

@section('page_title', 'Live')

@section('style')
<style>
  .lv-now { display: flex; align-items: center; gap: 16px; padding: 18px 22px; border-radius: 22px; margin-bottom: 18px; border: 1px solid var(--pro-line2); background: var(--pro-sheet); }
  .lv-now.on { border-color: rgba(47,210,79,.6); background: linear-gradient(120deg, rgba(47,210,79,.16), rgba(47,210,79,.03) 60%); box-shadow: 0 0 50px -20px rgba(47,210,79,.6); }
  .lv-now .ic { width: 52px; height: 52px; border-radius: 16px; display: grid; place-items: center; font-size: 22px; background: rgba(var(--fill),.07); color: var(--pro-mut); }
  .lv-now.on .ic { background: var(--pro-em); color: #04210b; }
  .lv-now b { display: block; font-size: 18px; } .lv-now small { color: var(--pro-mut); }
  .lrow { display: grid; grid-template-columns: auto 1fr auto auto; gap: 18px; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--pro-line); transition: background .2s; }
  .lrow:last-child { border-bottom: 0; } .lrow:hover { background: rgba(var(--fill),.03); }
  .lrow.live { background: linear-gradient(90deg, rgba(47,210,79,.12), transparent 70%); }
  .lrow .ix { width: 40px; height: 40px; border-radius: 13px; display: grid; place-items: center; font: 700 14px "JetBrains Mono", monospace; color: var(--pro-gold); background: rgba(233,178,60,.1); border: 1px solid rgba(233,178,60,.3); }
  .lrow.live .ix { color: #04210b; background: var(--pro-em); border-color: transparent; }
  .lrow h3 { margin: 0; font-size: 17px; font-weight: 700; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
  .lrow p { margin: 3px 0 0; color: var(--pro-mut); font-size: 13.5px; }
  .lrow .url { font: 500 11.5px "JetBrains Mono", monospace; color: var(--pro-dim); display: block; margin-top: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 46ch; }
  .lrow .swl { display: grid; justify-items: center; gap: 4px; font: 600 10px "JetBrains Mono", monospace; letter-spacing: .12em; color: var(--pro-dim); text-transform: uppercase; }
  .lrow.live .swl { color: var(--pro-em-l); }
  .lrow .acts { display: flex; gap: 6px; }
  .listen.on { background: var(--pro-em) !important; color: #04210b !important; border-color: transparent !important; }
  #nowListen.on { background: #fff !important; }
  .rt { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px; padding: 18px 20px 20px; }
  .rd { border-radius: 18px; overflow: hidden; border: 1px solid var(--pro-line2); background: rgba(var(--fill),.03); }
  .rd-h { padding: 10px 14px; font: 700 13px "JetBrains Mono", monospace; letter-spacing: .1em; text-transform: uppercase; color: #fff; display: flex; justify-content: space-between; }
  .rd-i { padding: 11px 14px; border-top: 1px solid var(--pro-line); display: grid; gap: 2px; }
  .rd-i b { font-size: 14.5px; } .rd-i small { color: var(--pro-mut); }
  .rd-i.live { background: rgba(47,210,79,.14); } .rd-i.live b::after { content: " · LIVE"; color: var(--pro-em-l); font-size: 11px; }
  .dchip { font: 600 11px "JetBrains Mono", monospace; letter-spacing: .06em; padding: 3px 9px; border-radius: 99px; border: 1px solid var(--pro-line2); color: var(--pro-mut); }
  .tt { display: flex; gap: 16px; align-items: center; flex-wrap: wrap; padding: 16px 20px; }
  .tt img { width: 120px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid var(--pro-line2); cursor: zoom-in; }
  .tt .txt { flex: 1 1 240px; } .tt b { display: block; } .tt small { color: var(--pro-mut); }
  @media (max-width: 760px) { .lrow { grid-template-columns: auto 1fr auto; } .lrow .acts { grid-column: 1 / -1; justify-content: flex-end; } }
</style>
@endsection

@section('content')
@php
    $live = $streams->firstWhere('status', true);
    $days = \App\Models\Stream::DAYS;
    $dayColors = ['mon' => '#2b4bb5', 'tue' => '#0e7c4c', 'wed' => '#8b6cf0', 'thu' => '#d4780f', 'fri' => '#b3261e', 'sat' => '#0f8aa6', 'sun' => '#a8860f'];
    $byDay = $streams->groupBy(fn ($x) => $x->day ?: '');
@endphp
<div class="py-2"><div class="container">

    @if (Session::has('error'))<p class="alert alert-danger">{{ Session::get('error') }}</p>@endif
    @if (Session::has('success'))<p class="alert alert-success">{{ Session::get('success') }}</p>@endif
    @if ($errors->any())<p class="alert alert-danger">{{ $errors->first() }}</p>@endif

    <div class="pro-head">
        <div class="ph-tx">
            <span class="pro-eyebrow">Matangazo ya moja kwa moja</span>
            <h1>Live</h1>
            <p>Andika darsa za wiki (kila kitabu safu moja). Washa swichi ya darsa inayoendelea sasa. Zingine zote zinazimwa zenyewe.</p>
        </div>
        <div class="ph-act"><button class="pbtn pbtn-gold" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus"></i> Ongeza darsa</button></div>
    </div>

    <div class="lv-now {{ $live ? 'on' : '' }}" id="now">
        <div class="ic"><i class="fas fa-broadcast-tower"></i></div>
        <div style="flex:1;min-width:0">
            <b id="nowT">{{ $live ? $live->title : 'Hakuna darsa ya moja kwa moja sasa' }}</b>
            <small id="nowS">{{ $live ? 'Inarushwa sasa. Watumiaji wa app wanaiona.' : 'Washa swichi ya darsa ili kuanza kurusha.' }}</small>
        </div>
        <button type="button" class="pbtn pbtn-gold pbtn-sm" id="nowListen" {{ $live ? '' : 'hidden' }} data-url="{{ $live ? $live->url : '' }}"><i class="fas fa-headphones"></i> <span>Sikiliza live</span></button>
        <span class="pchip live" id="nowC" {{ $live ? '' : 'hidden' }}>Live</span>
    </div>

    <div class="pro-sheet mb-3" id="rows">
        @forelse ($streams as $i => $s)
            <div class="lrow {{ $s->status ? 'live' : '' }}" data-id="{{ $s->id }}" data-title="{{ $s->title }}" data-url="{{ $s->url }}">
                <span class="ix">{{ $i + 1 }}</span>
                <div style="min-width:0">
                    <h3>{{ $s->title }} @if ($s->status)<span class="pchip live">Live</span>@endif</h3>
                    <p>@if ($s->day)<span class="dchip">{{ $days[$s->day] ?? $s->day }}</span> @endif{{ $s->time_label ?: $s->description }}@if ($s->teacher) · {{ $s->teacher }}@endif</p>
                    <span class="url">{{ $s->url }}</span>
                </div>
                <div class="swl">
                    <label class="pro-switch lg"><input type="checkbox" class="sw" {{ $s->status ? 'checked' : '' }}><i></i></label>
                    <span>{{ $s->status ? 'Live' : 'Zima' }}</span>
                </div>
                <div class="acts">
                    <button type="button" class="iconbtn" title="Hariri" data-bs-toggle="modal" data-bs-target="#edit-{{ $s->id }}"><i class="fas fa-pen"></i></button>
                    <button type="button" class="iconbtn del" title="Futa"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        @empty
            <div class="pro-empty"><i class="fas fa-calendar-plus"></i><b>Hakuna darsa bado</b>Bonyeza "Ongeza darsa" kuandika kitabu cha kwanza cha wiki.</div>
        @endforelse
    </div>

    <div class="pro-sheet">
        <div class="pro-sheet-h"><h2>Ratiba ya wiki</h2><small>Hivi ndivyo ratiba inavyoonekana kwenye app. Chagua siku na mwalimu kwenye kila darsa.</small></div>
        @if ($streams->whereNotNull('day')->count())
            <div class="rt">
                @foreach ($days as $k => $label)
                    @if (isset($byDay[$k]))
                        <div class="rd">
                            <div class="rd-h" style="background: {{ $dayColors[$k] }}"><span>{{ $label }}</span><span>{{ $byDay[$k]->count() }}</span></div>
                            @foreach ($byDay[$k] as $x)
                                <div class="rd-i {{ $x->status ? 'live' : '' }}">
                                    <b>{{ $x->book ?: $x->title }}</b>
                                    <small>{{ $x->time_label }}@if ($x->time_label && $x->teacher) · @endif{{ $x->teacher }}</small>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="pro-empty"><i class="fas fa-calendar-week"></i><b>Ratiba bado haina siku</b>Hariri kila darsa uchague siku (na mwalimu), kisha ratiba itatokea hapa na kwenye app.</div>
        @endif
    </div>

    {{-- ADD --}}
    <div class="modal fade" id="addModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="{{ route('add_stream') }}">@csrf
            <div class="modal-header"><h5 class="modal-title">Darsa mpya</h5><button type="button" class="close" data-bs-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <div class="pro-field"><span>Kichwa cha live</span><input class="form-control" name="title" required placeholder="mf. LIVE - DARSA YA HADITHI"></div>
                <div class="pro-field"><span>Jina la kitabu kwenye ratiba (hiari)</span><input class="form-control" name="book" placeholder="mf. Al Jawharun Naqiyyu"></div>
                <div class="pro-field"><span>Siku</span>
                    <select class="form-select" name="day">
                        <option value="">— Chagua siku —</option>
                        @foreach ($days as $k => $label)<option value="{{ $k }}">{{ $label }}</option>@endforeach
                    </select></div>
                <div class="pro-field"><span>Kichwa kidogo (hiari)</span><input class="form-control" name="description" placeholder="mf. الجوهر النقي الملتقط من أحاديث النبي ﷺ"></div>
                <div class="pro-field"><span>Muda</span><input class="form-control" name="time_label" placeholder="mf. Baada ya Magharibi"></div>
                <div class="pro-field"><span>Mwalimu</span><input class="form-control" name="teacher" placeholder="mf. Abul Fadhwl"></div>
                <div class="pro-field"><span>Link ya live (YouTube / nyingine)</span><input class="form-control" name="url" required placeholder="https://" value="{{ optional($streams->sortByDesc('id')->first())->url }}"></div>
                            @include('partials.lang_tabs', ['uid' => 'add-stream', 'tr' => null, 'fields' => [['title','Kichwa cha live','input','mf. LIVE LESSON - HADITH'],['description','Kichwa kidogo','input'],['book','Jina la kitabu kwenye ratiba','input'],['time_label','Muda','input','e.g. After Maghrib'],['teacher','Mwalimu','input']]])
            </div>
            <div class="modal-footer"><button type="button" class="pbtn pbtn-ghost" data-bs-dismiss="modal">Funga</button><button class="pbtn pbtn-gold">Hifadhi</button></div>
        </form>
    </div></div></div>

    {{-- EDIT --}}
    @foreach ($streams as $s)
    <div class="modal fade" id="edit-{{ $s->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="{{ route('edit_stream', $s->id) }}">@csrf @method('PUT')
            <div class="modal-header"><h5 class="modal-title">Hariri darsa</h5><button type="button" class="close" data-bs-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <div class="pro-field"><span>Kichwa cha live</span><input class="form-control" name="title" required placeholder="mf. LIVE - DARSA YA HADITHI" value="{{ $s->title }}"></div>
                <div class="pro-field"><span>Jina la kitabu kwenye ratiba (hiari)</span><input class="form-control" name="book" value="{{ $s->book }}" placeholder="Likiachwa wazi, kichwa cha juu kinatumika"></div>
                <div class="pro-field"><span>Siku</span>
                    <select class="form-select" name="day">
                        <option value="">— Chagua siku —</option>
                        @foreach ($days as $k => $label)<option value="{{ $k }}" @selected($s->day === $k)>{{ $label }}</option>@endforeach
                    </select></div>
                <div class="pro-field"><span>Kichwa kidogo (hiari)</span><input class="form-control" name="description" value="{{ $s->description }}" placeholder="mf. الجوهر النقي الملتقط من أحاديث النبي ﷺ"></div>
                <div class="pro-field"><span>Muda</span><input class="form-control" name="time_label" value="{{ $s->time_label }}"></div>
                <div class="pro-field"><span>Mwalimu</span><input class="form-control" name="teacher" value="{{ $s->teacher }}"></div>
                <div class="pro-field"><span>Link ya live</span><input class="form-control" name="url" required value="{{ $s->url }}"></div>
                            @include('partials.lang_tabs', ['uid' => 'edit-stream-'.$s->id, 'tr' => $s->translations, 'fields' => [['title','Kichwa cha live','input','mf. LIVE LESSON - HADITH'],['description','Kichwa kidogo','input'],['book','Jina la kitabu kwenye ratiba','input'],['time_label','Muda','input','e.g. After Maghrib'],['teacher','Mwalimu','input']]])
            </div>
            <div class="modal-footer"><button type="button" class="pbtn pbtn-ghost" data-bs-dismiss="modal">Funga</button><button class="pbtn pbtn-gold">Hifadhi</button></div>
        </form>
    </div></div></div>
    @endforeach
</div></div>
@endsection

@section('scripts')
<script>
(function () {
  var base = @json(url('stream')), delBase = @json(url('delete_stream'));
  var rows = document.getElementById('rows');
  function paint(liveId, title) {
    [].forEach.call(rows.querySelectorAll('.lrow'), function (r) {
      var on = +r.dataset.id === liveId; r.classList.toggle('live', on);
      r.querySelector('.sw').checked = on; r.querySelector('.swl span').textContent = on ? 'Live' : 'Zima';
      var h = r.querySelector('h3'), c = h.querySelector('.pchip');
      if (on && !c) h.insertAdjacentHTML('beforeend', '<span class="pchip live">Live</span>'); if (!on && c) c.remove();
    });
    var n = document.getElementById('now'); n.classList.toggle('on', !!liveId);
    document.getElementById('nowT').textContent = liveId ? title : 'Hakuna darsa ya moja kwa moja sasa';
    document.getElementById('nowS').textContent = liveId ? 'Inarushwa sasa. Watumiaji wa app wanaiona.' : 'Washa swichi ya darsa ili kuanza kurusha.';
    document.getElementById('nowC').hidden = !liveId;
    var nl = document.getElementById('nowListen'); nl.hidden = !liveId; var lr = liveId ? rows.querySelector('.lrow[data-id="' + liveId + '"]') : null; nl.dataset.url = lr ? lr.dataset.url : '';
  }

  /* ---- listen in the browser ---- */
  var player = new Audio(), cur = null; player.preload = 'none';
  function reset() { [].forEach.call(document.querySelectorAll('.listen, #nowListen'), function (b) { b.classList.remove('on'); var sp = b.querySelector('span'); if (sp) sp.textContent = b.id === 'nowListen' ? 'Sikiliza live' : 'Sikiliza'; b.querySelector('i').className = 'fas fa-headphones'; }); }
  function listen(btn, url) {
    if (!url) return;
    if (cur === btn) { player.pause(); player.removeAttribute('src'); player.load(); cur = null; reset(); return; }
    reset(); cur = btn; player.src = url;
    player.play().then(function () { btn.classList.add('on'); btn.querySelector('span').textContent = 'Simamisha'; btn.querySelector('i').className = 'fas fa-stop'; })
      .catch(function () { cur = null; reset(); window.open(url, '_blank', 'noopener'); AF.toast('Link hii si ya sauti moja kwa moja. Imefunguliwa kwenye ukurasa mpya.', 'err'); });
  }
  player.addEventListener('error', function () { if (!cur) return; var u = player.src; cur = null; reset(); window.open(u, '_blank', 'noopener'); });
  document.addEventListener('click', function (e) {
    var b = e.target.closest('.listen, #nowListen'); if (!b) return;
    var row = b.closest('.lrow'); listen(b, row ? row.dataset.url : b.dataset.url);
  });
  rows.addEventListener('change', function (e) {
    if (!e.target.classList.contains('sw')) return;
    var sw = e.target, row = sw.closest('.lrow'), id = +row.dataset.id, on = sw.checked, wrap = sw.closest('.pro-switch');
    var go = on ? AF.confirm({ title: 'Anza live: ' + row.dataset.title + '?', text: 'Darsa nyingine zote zitazimwa, na arifa itatumwa kwa watumiaji wote wa app.', ok: 'Washa live' })
               : AF.confirm({ title: 'Maliza live?', text: 'Watumiaji watapata arifa kuwa darsa imekwisha.', ok: 'Zima' });
    go.then(function (y) {
      if (!y) { sw.checked = !on; return; }
      wrap.classList.add('busy');
      AF.api(base + '/' + id + '/status', 'PUT', { status: on ? 1 : 0 }).then(function (j) {
        paint(j.live_id, row.dataset.title); AF.toast(on ? 'Iko live sasa' : 'Imezimwa');
      }).catch(function (er) { sw.checked = !on; AF.toast(er.message, 'err'); }).then(function () { wrap.classList.remove('busy'); });
    });
  });
  rows.addEventListener('click', function (e) {
    var b = e.target.closest('.del'); if (!b) return; var row = b.closest('.lrow');
    AF.confirm({ title: 'Futa darsa hii?', text: '"' + row.dataset.title + '" itafutwa.', ok: 'Futa', danger: true }).then(function (y) { if (y) location.href = delBase + '/' + row.dataset.id; });
  });
})();
</script>
@endsection

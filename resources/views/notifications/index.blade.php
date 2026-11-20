@extends('layouts.app')

@section('page_title', 'Arifa')

@section('style')
<style>
  .nlay { display: grid; grid-template-columns: minmax(300px, 400px) 1fr; gap: 18px; align-items: start; }
  @media (max-width: 960px) { .nlay { grid-template-columns: 1fr; } }
  .prev { margin: 4px 0 16px; padding: 12px 14px; border-radius: 16px; background: rgba(0,0,0,.28); border: 1px solid var(--pro-line); display: flex; gap: 12px; }
  .prev .ic { width: 36px; height: 36px; border-radius: 10px; flex: none; display: grid; place-items: center; background: linear-gradient(135deg, var(--pro-gold-l), var(--pro-gold)); color: #2b1d00; }
  .prev b { display: block; font-size: 14px; } .prev span { color: var(--pro-mut); font-size: 13px; word-break: break-word; }
  .nrow { display: grid; grid-template-columns: 1fr auto; gap: 14px; align-items: center; padding: 14px 20px; border-bottom: 1px solid var(--pro-line); }
  .nrow:last-child { border-bottom: 0; } .nrow:hover { background: rgba(var(--fill),.03); }
  .nrow h3 { margin: 0 0 3px; font-size: 15.5px; font-weight: 700; } .nrow p { margin: 0 0 8px; color: var(--pro-mut); font-size: 13.5px; word-break: break-word; }
  .nrow .meta { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; font: 500 11.5px "JetBrains Mono", monospace; color: var(--pro-dim); }
  .nrow .err { color: #ffb3b3; font-size: 12.5px; margin-top: 6px; }
  .nrow .acts { display: flex; gap: 6px; flex-wrap: wrap; justify-content: flex-end; }
  @media (max-width: 640px) { .nrow { grid-template-columns: 1fr; } .nrow .acts { justify-content: flex-start; } }
</style>
@endsection

@section('content')
<div class="py-2"><div class="container">
    @if (Session::has('error'))<p class="alert alert-danger">{{ Session::get('error') }}</p>@endif
    @if (Session::has('success'))<p class="alert alert-success">{{ Session::get('success') }}</p>@endif

    <div class="pro-head">
        <div class="ph-tx">
            <span class="pro-eyebrow">Mawasiliano · Push</span>
            <h1>Arifa</h1>
            <p>Tuma arifa kwa watumiaji wote wa app. Kila utumaji unaandikwa kwenye historia pamoja na jibu halisi la Firebase, na unaweza kutuma tena arifa ya zamani bila kuandika upya.</p>
        </div>
    </div>

    <div class="nlay">
        {{-- COMPOSE --}}
        <div class="pro-sheet">
            <div class="pro-sheet-h"><h2>Arifa mpya</h2><span class="pchip gold"><i class="fas fa-users"></i> Watumiaji wote</span></div>
            <form class="pro-pad" id="sendForm" action="{{ route('bulksend') }}" method="post">
                @csrf
                <div class="pro-field"><span>Kichwa</span><input class="form-control" id="f-title" name="title" maxlength="120" required placeholder="mf. Darsa inaanza sasa" value="{{ old('title') }}"></div>
                <div class="pro-field"><span>Ujumbe</span><textarea class="form-control" id="f-body" name="body" rows="3" maxlength="500" required placeholder="Maelezo mafupi">{{ old('body') }}</textarea></div>
                <div class="pro-field"><span>Link ya picha (hiari)</span><input type="url" class="form-control" id="f-img" name="img" placeholder="https://" value="{{ old('img') }}"></div>
                <div class="prev"><span class="ic"><i class="fas fa-bell"></i></span><div><b id="p-title">Kichwa cha arifa</b><span id="p-body">Ujumbe utaonekana hapa kama kwenye simu.</span></div></div>
                <button class="pbtn pbtn-gold w-100" id="sendBtn" type="submit"><i class="fas fa-paper-plane"></i> Tuma kwa wote</button>
            </form>
        </div>

        {{-- HISTORY --}}
        <div class="pro-sheet">
            <div class="pro-sheet-h"><h2>Historia ya arifa ({{ $notifications->count() }})</h2><small>Bonyeza "Tuma tena" au "Tumia tena" kutumia arifa ya zamani</small></div>
            @forelse ($notifications as $n)
                @php
                    $st = $n->status ?? 'unknown';
                    $chip = ['sent' => ['live', 'Imetumwa'], 'failed' => ['red', 'Imeshindwa'], 'pending' => ['gold', 'Inasubiri'], 'unknown' => ['', 'Haijathibitishwa']][$st] ?? ['', $st];
                @endphp
                <div class="nrow" data-title="{{ $n->title }}" data-body="{{ $n->body }}" data-img="{{ $n->img }}">
                    <div style="min-width:0">
                        <h3>{{ $n->title }}</h3>
                        <p>{{ $n->body }}</p>
                        <div class="meta">
                            <span class="pchip {{ $chip[0] }}">{{ $chip[1] }}</span>
                            <span><i class="fas fa-satellite-dish"></i> {{ $n->topic ?? 'all' }}</span>
                            <span><i class="far fa-clock"></i> {{ ($n->sent_at ?? $n->created_at)->format('d M Y H:i') }}</span>
                            @if ($n->resent_from)<span><i class="fas fa-redo"></i> imetumwa tena</span>@endif
                            @if ($n->fcm_message_id)<span title="Kitambulisho cha Firebase">#{{ \Illuminate\Support\Str::limit(basename($n->fcm_message_id), 12, '…') }}</span>@endif
                        </div>
                        @if ($st === 'failed' && $n->error)<div class="err"><i class="fas fa-exclamation-triangle"></i> {{ $n->error }}</div>@endif
                    </div>
                    <div class="acts">
                        <button type="button" class="pbtn pbtn-gold pbtn-sm resend" data-url="{{ route('notification.resend', $n) }}"><i class="fas fa-redo"></i> Tuma tena</button>
                        <button type="button" class="pbtn pbtn-ghost pbtn-sm reuse" title="Weka kwenye fomu ili uhariri"><i class="fas fa-copy"></i> Tumia tena</button>
                        <button type="button" class="iconbtn del" title="Futa kwenye historia" onclick="AF.confirm({title:'Futa kwenye historia?',text:'Arifa hii itaondolewa kwenye orodha. Haiwezi kuvutwa kutoka kwenye simu zilizokwisha ipokea.',ok:'Futa',danger:true}).then(function(y){if(y)location.href='{{ route('delete-notification', $n) }}'})"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            @empty
                <div class="pro-empty"><i class="fas fa-bell-slash"></i><b>Hakuna arifa bado</b>Arifa utakazotuma zitaonekana hapa.</div>
            @endforelse
        </div>
    </div>

    <form id="resendForm" method="post" hidden>@csrf</form>
</div></div>
@endsection

@section('scripts')
<script>
(function () {
  var $ = function (i) { return document.getElementById(i); };
  function preview() { $('p-title').textContent = $('f-title').value || 'Kichwa cha arifa'; $('p-body').textContent = $('f-body').value || 'Ujumbe utaonekana hapa kama kwenye simu.'; }
  ['f-title', 'f-body'].forEach(function (i) { $(i).addEventListener('input', preview); }); preview();

  $('sendForm').addEventListener('submit', function (e) {
    var f = this; if (f.dataset.ok) return; e.preventDefault();
    AF.confirm({ title: 'Tuma kwa watumiaji wote?', text: '"' + $('f-title').value + '" itatumwa sasa kwa kila mtu mwenye app.', ok: 'Tuma sasa' }).then(function (y) { if (y) { f.dataset.ok = 1; $('sendBtn').disabled = true; $('sendBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inatuma…'; f.submit(); } });
  });

  document.addEventListener('click', function (e) {
    var row = e.target.closest('.nrow'); if (!row) return;
    if (e.target.closest('.reuse')) {
      $('f-title').value = row.dataset.title; $('f-body').value = row.dataset.body; $('f-img').value = row.dataset.img || ''; preview();
      window.scrollTo({ top: 0, behavior: 'smooth' }); $('f-title').focus(); AF.toast('Imewekwa kwenye fomu. Hariri kisha tuma.');
    } else if (e.target.closest('.resend')) {
      var b = e.target.closest('.resend');
      AF.confirm({ title: 'Tuma tena kwa wote?', text: '"' + row.dataset.title + '" itatumwa upya sasa na kuandikwa kama utumaji mpya kwenye historia.', ok: 'Tuma tena' }).then(function (y) {
        if (!y) return; b.disabled = true; b.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inatuma…';
        var f = $('resendForm'); f.action = b.dataset.url; f.submit();
      });
    }
  });
})();
</script>
@endsection

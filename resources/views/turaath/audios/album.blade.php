@extends('layouts.app')

@section('page_title', $album->name)

@section('style')
<style>
  .up-drop { border: 2px dashed var(--pro-line2); border-radius: 22px; padding: 30px 20px; text-align: center; transition: .25s; background: radial-gradient(60% 120% at 50% 0, rgba(233,178,60,.10), transparent 70%); }
  .up-drop.over { border-color: var(--pro-gold); background: radial-gradient(60% 120% at 50% 0, rgba(233,178,60,.22), transparent 70%); transform: scale(1.005); }
  .up-drop .big { width: 64px; height: 64px; margin: 0 auto 12px; border-radius: 20px; display: grid; place-items: center; font-size: 26px; color: #2b1d00; background: linear-gradient(135deg, var(--pro-gold-l), var(--pro-gold)); box-shadow: 0 16px 34px -14px rgba(233,178,60,.9); }
  .up-drop h3 { margin: 0 0 4px; font-size: 20px; } .up-drop p { margin: 0 0 16px; color: var(--pro-mut); }
  .up-drop .acts { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }

  .qbar { position: sticky; top: 8px; z-index: 20; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; padding: 12px 16px; border-radius: 16px; background: rgba(13,23,58,.94); border: 1px solid var(--pro-line2); backdrop-filter: blur(14px); box-shadow: 0 18px 40px -22px #000; }
  .qbar .grow { flex: 1 1 200px; min-width: 0; } .qbar b { font-size: 15px; } .qbar small { color: var(--pro-mut); display: block; }
  .gprog { height: 6px; border-radius: 99px; background: rgba(255,255,255,.1); overflow: hidden; margin-top: 6px; } .gprog i { display: block; height: 100%; width: 0; background: linear-gradient(90deg, var(--pro-gold), var(--pro-em)); transition: width .3s; }

  .arow { position: relative; display: grid; grid-template-columns: 26px 34px 1fr auto auto auto; gap: 12px; align-items: center; padding: 10px 14px; border-bottom: 1px solid var(--pro-line); transition: background .15s, opacity .2s; overflow: hidden; }
  .arow:last-child { border-bottom: 0; } .arow:hover { background: rgba(255,255,255,.03); }
  .arow .grip { cursor: grab; color: var(--pro-dim); text-align: center; user-select: none; } .arow .grip:active { cursor: grabbing; }
  .arow .no { font: 600 12px "JetBrains Mono", monospace; color: var(--pro-gold); text-align: right; }
  .arow .nm { min-width: 0; }
  .arow .nm input { width: 100%; background: transparent !important; border: 1px solid transparent !important; border-radius: 9px !important; padding: 6px 9px; font-weight: 600; color: var(--pro-text) !important; font-size: 15px; }
  .arow .nm input:hover { border-color: var(--pro-line2) !important; } .arow .nm input:focus { border-color: var(--pro-gold) !important; background: rgba(255,255,255,.07) !important; }
  .arow .meta { font: 500 11.5px "JetBrains Mono", monospace; color: var(--pro-dim); padding: 0 9px; display: flex; gap: 10px; flex-wrap: wrap; }
  .arow .meta .err { color: #ff9b9b; } .arow .meta .okc { color: var(--pro-em-l); } .arow .meta .warn { color: var(--pro-gold-l); }
  .arow .sz { font: 500 12px "JetBrains Mono", monospace; color: var(--pro-mut); white-space: nowrap; }
  .arow .acts { display: flex; gap: 6px; align-items: center; }
  .arow.off { opacity: .5; } .arow.off .nm input { text-decoration: line-through; text-decoration-color: rgba(255,255,255,.3); }
  .arow.drag { opacity: .35; } .arow.dropbefore { box-shadow: inset 0 3px 0 var(--pro-gold); } .arow.dropafter { box-shadow: inset 0 -3px 0 var(--pro-gold); }
  .arow .bar { position: absolute; left: 0; bottom: 0; height: 3px; width: 0; background: linear-gradient(90deg, var(--pro-gold), var(--pro-em)); transition: width .15s; }
  .arow.done { background: rgba(47,210,79,.07); } .arow.fail { background: rgba(255,90,90,.08); }
  .iconbtn { width: 34px; height: 34px; display: inline-grid; place-items: center; border-radius: 10px; border: 1px solid var(--pro-line); background: rgba(255,255,255,.04); color: var(--pro-mut); cursor: pointer; transition: .15s; }
  .iconbtn:hover { color: #fff; border-color: var(--pro-gold); } .iconbtn.del:hover { border-color: var(--pro-red); background: rgba(255,90,90,.15); }
  .iconbtn.play.on { background: var(--pro-gold); color: #2b1d00; border-color: transparent; }
  .listtools { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; padding: 12px 18px; border-bottom: 1px solid var(--pro-line); }
  .listtools input[type=search] { max-width: 280px; }
  .tip { color: var(--pro-dim); font-size: 12.5px; padding: 10px 18px; border-top: 1px solid var(--pro-line); }
  .qsum { display: flex; gap: 8px; flex-wrap: wrap; }
  @media (max-width: 760px) { .arow { grid-template-columns: 22px 1fr auto; } .arow .no, .arow .sz, .arow .meta { display: none; } .arow .acts { gap: 4px; } }
</style>
@endsection

@section('content')
@php
    $songs = $album->allSongs;
    $maxPos = (int) $songs->max('position');
    $toBytes = function ($v) { $v = trim($v); $n = (float) $v; switch (strtolower(substr($v, -1))) { case 'g': $n *= 1024; case 'm': $n *= 1024; case 'k': $n *= 1024; } return (int) $n; };
    $limit = min($toBytes(ini_get('upload_max_filesize')) ?: PHP_INT_MAX, $toBytes(ini_get('post_max_size')) ?: PHP_INT_MAX);
@endphp
<div class="py-2">
<div class="container">

    @if (Session::has('error'))<p class="alert alert-danger">{{ Session::get('error') }}</p>@endif
    @if (Session::has('success'))<p class="alert alert-success">{{ Session::get('success') }}</p>@endif

    <div class="pro-head">
        <a class="pbtn pbtn-ghost pbtn-icon ph-back" href="{{ route('category', $album->category->id) }}" title="Rudi"><i class="fas fa-arrow-left"></i></a>
        <div class="ph-tx">
            <span class="pro-eyebrow">{{ $album->category->name }} · Albamu</span>
            <h1>{{ $album->name }}</h1>
            <p>{{ $album->description }}</p>
        </div>
        <div class="ph-act">
            <span class="pchip gold"><i class="fas fa-music"></i> {{ $songs->count() }} sauti</span>
            <span class="pchip">{{ $songs->where('active', true)->count() }} zinaonekana</span>
            <button class="pbtn pbtn-ghost pbtn-sm" data-bs-toggle="modal" data-bs-target="#editAlbumModal"><i class="fas fa-pen"></i> Hariri albamu</button>
            <button class="pbtn pbtn-danger pbtn-sm" id="delAlbum"><i class="fas fa-trash"></i></button>
        </div>
    </div>

    {{-- ===== DROP ZONE ===== --}}
    <div class="up-drop mb-3" id="drop">
        <div class="big"><i class="fas fa-cloud-upload-alt"></i></div>
        <h3>Weka sauti hapa</h3>
        <p>Buruta folda nzima au faili nyingi. Tutazipanga kwa majina yake, kisha unahariri na kupakia zote kwa mkupuo.</p>
        <div class="acts">
            <button type="button" class="pbtn pbtn-gold" id="pickDir"><i class="fas fa-folder-open"></i> Chagua folda</button>
            <button type="button" class="pbtn pbtn-ghost" id="pickFiles"><i class="fas fa-file-audio"></i> Chagua faili</button>
        </div>
        <input type="file" id="inDir" webkitdirectory directory multiple hidden>
        <input type="file" id="inFiles" accept="audio/*,.mp3,.m4a,.aac,.wav,.ogg,.opus,.flac,.wma" multiple hidden>
    </div>

    {{-- ===== QUEUE ===== --}}
    <div id="queueWrap" class="mb-4" hidden>
        <div class="qbar mb-2">
            <div class="grow">
                <b id="qTitle">Zinasubiri kupakiwa</b>
                <small id="qSub"></small>
                <div class="gprog"><i id="gprog"></i></div>
            </div>
            <button class="pbtn pbtn-ghost pbtn-sm" id="qClean" title="Ondoa mistari-chini, namba za mwanzo na nafasi nyingi"><i class="fas fa-magic"></i> Safisha majina</button>
            <button class="pbtn pbtn-ghost pbtn-sm" id="qClear"><i class="fas fa-times"></i> Futa orodha</button>
            <button class="pbtn pbtn-gold" id="qGo"><i class="fas fa-upload"></i> <span>Pakia zote</span></button>
        </div>
        <div class="pro-sheet" id="queue"></div>
    </div>

    {{-- ===== EXISTING ===== --}}
    <div class="pro-sheet" id="listSheet">
        <div class="pro-sheet-h"><h2>Sauti zilizomo ndani ya albamu hii</h2><small>Buruta <i class="fas fa-grip-vertical"></i> kupanga. Mpangilio unahifadhiwa papo hapo.</small></div>
        <div class="listtools">
            <input type="search" class="form-control" id="filter" placeholder="Tafuta sauti…">
            <button class="pbtn pbtn-ghost pbtn-sm" id="sortAz"><i class="fas fa-sort-alpha-down"></i> Panga A–Z</button>
            <button class="pbtn pbtn-ghost pbtn-sm" id="allOn"><i class="fas fa-eye"></i> Washa zote</button>
            <button class="pbtn pbtn-ghost pbtn-sm" id="allOff"><i class="fas fa-eye-slash"></i> Zima zote</button>
        </div>
        <div id="songs">
            @forelse ($songs as $i => $song)
                <div class="arow {{ $song->active ? '' : 'off' }}" data-id="{{ $song->id }}" data-src="{{ asset('storage/' . $song->file) }}">
                    <span class="grip" title="Buruta"><i class="fas fa-grip-vertical"></i></span>
                    <span class="no">{{ $i + 1 }}</span>
                    <div class="nm">
                        <input type="text" value="{{ $song->title }}" data-orig="{{ $song->title }}" aria-label="Jina">
                        <div class="meta"><span>{{ $song->duration }}</span><span>{{ $song->size }} MB</span></div>
                    </div>
                    <span class="sz"></span>
                    <label class="pro-switch" title="Onyesha kwenye app"><input type="checkbox" class="tgl" {{ $song->active ? 'checked' : '' }}><i></i></label>
                    <span class="acts">
                        <button type="button" class="iconbtn play" title="Sikiliza"><i class="fas fa-play"></i></button>
                        <button type="button" class="iconbtn del" title="Futa"><i class="fas fa-trash"></i></button>
                    </span>
                </div>
            @empty
                <div class="pro-empty"><i class="fas fa-headphones"></i><b>Hakuna sauti bado</b>Buruta folda juu ili kuanza.</div>
            @endforelse
        </div>
        <div class="tip">Zilizozimwa hazionekani kwenye app lakini hazifutwi. Kubonyeza jina kunaruhusu kulihariri.</div>
    </div>

    {{-- ===== EDIT ALBUM ===== --}}
    <div class="modal fade" id="editAlbumModal" tabindex="-1">
        <div class="modal-dialog"><div class="modal-content">
            <form method="GET" action="{{ route('edit_album', $album->id) }}">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Hariri albamu</h5><button type="button" class="close" data-bs-dismiss="modal">&times;</button></div>
                <div class="modal-body">
                    <div class="pro-field"><span>Jina</span><input type="text" class="form-control" name="name" value="{{ old('name', $album->name) }}" required onkeyup="this.value=this.value.toUpperCase()"></div>
                    <div class="pro-field"><span>Maelezo</span><input type="text" class="form-control" name="description" value="{{ old('description', $album->description) }}" required></div>
                </div>
                <div class="modal-footer"><button type="button" class="pbtn pbtn-ghost" data-bs-dismiss="modal">Funga</button><button class="pbtn pbtn-gold">Hifadhi</button></div>
            </form>
        </div></div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
(function () {
  var ALBUM = {{ $album->id }}, MAXPOS = {{ $maxPos }}, LIMIT = {{ $limit === PHP_INT_MAX ? 0 : $limit }};
  var URL_UP = @json(route('song_upload', $album->id)), URL_ACTIVE = @json(url('song')), URL_REORDER = @json(route('album_reorder', $album->id));
  var AUDIO_EXT = /\.(mp3|m4a|aac|wav|ogg|opus|flac|wma|amr|mp4)$/i;
  var $ = function (s, r) { return (r || document).querySelector(s); }, $$ = function (s, r) { return [].slice.call((r || document).querySelectorAll(s)); };
  var existing = {}; $$('#songs .arow input[type=text]').forEach(function (i) { existing[i.value.trim().toLowerCase()] = 1; });

  /* ---------- helpers ---------- */
  function fmtSize(b) { return b >= 1048576 ? (b / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(b / 1024)) + ' KB'; }
  function fmtDur(s) { if (!s) return ''; s = Math.round(s); var h = Math.floor(s / 3600), m = Math.floor(s % 3600 / 60), x = s % 60; return (h ? h + ':' + String(m).padStart(2, '0') : m) + ':' + String(x).padStart(2, '0'); }
  function baseName(n) { return n.replace(/\.[^.]+$/, ''); }
  function clean(n) { return n.replace(/_+/g, ' ').replace(/^\s*\d{1,3}\s*[-._)]+\s*/, '').replace(/\s{2,}/g, ' ').trim(); }
  function renumber(box) { $$('.arow .no', box).forEach(function (n, i) { n.textContent = i + 1; }); }

  /* ---------- drag-sort (handle only) ---------- */
  function sortable(box, onDone) {
    var drag = null;
    box.addEventListener('mousedown', function (e) { var g = e.target.closest('.grip'); if (g) g.closest('.arow').draggable = true; });
    box.addEventListener('mouseup', function () { $$('.arow', box).forEach(function (r) { r.draggable = false; }); });
    box.addEventListener('dragstart', function (e) { var r = e.target.closest && e.target.closest('.arow'); if (!r) return; drag = r; r.classList.add('drag'); e.dataTransfer.effectAllowed = 'move'; try { e.dataTransfer.setData('text/plain', 'x'); } catch (x) {} });
    box.addEventListener('dragover', function (e) {
      if (!drag) return; e.preventDefault();
      var r = e.target.closest('.arow'); $$('.dropbefore,.dropafter', box).forEach(function (x) { x.classList.remove('dropbefore', 'dropafter'); });
      if (!r || r === drag) return; var b = r.getBoundingClientRect(); r.classList.add(e.clientY < b.top + b.height / 2 ? 'dropbefore' : 'dropafter');
    });
    box.addEventListener('drop', function (e) {
      if (!drag) return; e.preventDefault();
      var r = e.target.closest('.arow');
      if (r && r !== drag) { var b = r.getBoundingClientRect(); if (e.clientY < b.top + b.height / 2) box.insertBefore(drag, r); else box.insertBefore(drag, r.nextSibling); }
    });
    box.addEventListener('dragend', function () {
      if (!drag) return; drag.classList.remove('drag'); drag.draggable = false; drag = null;
      $$('.dropbefore,.dropafter', box).forEach(function (x) { x.classList.remove('dropbefore', 'dropafter'); });
      renumber(box); onDone && onDone();
    });
    // touch / keyboard fallback: long-press not needed — buttons for move are skipped, desktop is the target
  }

  /* ---------- existing songs ---------- */
  var songsBox = $('#songs'), audio = new Audio(), playing = null;
  sortable(songsBox, saveOrder);
  function saveOrder() {
    var ids = $$('.arow', songsBox).map(function (r) { return +r.dataset.id; });
    AF.api(URL_REORDER, 'POST', { ids: ids }).then(function () { AF.toast('Mpangilio umehifadhiwa'); }).catch(function (e) { AF.toast(e.message, 'err'); });
  }
  songsBox.addEventListener('change', function (e) {
    var row = e.target.closest('.arow'); if (!row) return;
    if (e.target.classList.contains('tgl')) {
      var on = e.target.checked; row.classList.toggle('off', !on);
      AF.api(URL_ACTIVE + '/' + row.dataset.id + '/active', 'PUT', { active: on }).then(function () { AF.toast(on ? 'Inaonekana kwenye app' : 'Imefichwa kwenye app'); })
        .catch(function (er) { e.target.checked = !on; row.classList.toggle('off', on); AF.toast(er.message, 'err'); });
    } else if (e.target.type === 'text') {
      var inp = e.target, t = inp.value.trim();
      if (!t || t === inp.dataset.orig) { inp.value = inp.dataset.orig; return; }
      AF.api(URL_ACTIVE + '/' + row.dataset.id + '/title', 'PUT', { title: t }).then(function (j) { inp.dataset.orig = j.title; inp.value = j.title; AF.toast('Jina limebadilishwa'); })
        .catch(function (er) { inp.value = inp.dataset.orig; AF.toast(er.message, 'err'); });
    }
  });
  songsBox.addEventListener('keydown', function (e) { if (e.key === 'Enter' && e.target.type === 'text') e.target.blur(); });
  songsBox.addEventListener('click', function (e) {
    var row = e.target.closest('.arow'); if (!row) return;
    if (e.target.closest('.del')) {
      AF.confirm({ title: 'Futa sauti hii?', text: '"' + $('input', row).value + '" itafutwa kabisa pamoja na faili lake.', ok: 'Futa', danger: true }).then(function (y) {
        if (!y) return;
        AF.api(URL_ACTIVE + '/' + row.dataset.id, 'DELETE').then(function () { row.remove(); renumber(songsBox); AF.toast('Imefutwa'); }).catch(function (er) { AF.toast(er.message, 'err'); });
      });
    } else if (e.target.closest('.play')) {
      var btn = e.target.closest('.play');
      if (playing === row) { audio.pause(); btn.classList.remove('on'); btn.innerHTML = '<i class="fas fa-play"></i>'; playing = null; return; }
      $$('.play.on', songsBox).forEach(function (b) { b.classList.remove('on'); b.innerHTML = '<i class="fas fa-play"></i>'; });
      audio.src = row.dataset.src; audio.play().catch(function () { AF.toast('Imeshindwa kucheza faili hili', 'err'); });
      btn.classList.add('on'); btn.innerHTML = '<i class="fas fa-pause"></i>'; playing = row;
    }
  });
  audio.addEventListener('ended', function () { $$('.play.on', songsBox).forEach(function (b) { b.classList.remove('on'); b.innerHTML = '<i class="fas fa-play"></i>'; }); playing = null; });
  $('#filter').addEventListener('input', function () { var q = this.value.trim().toLowerCase(); $$('.arow', songsBox).forEach(function (r) { r.style.display = !q || $('input', r).value.toLowerCase().indexOf(q) > -1 ? '' : 'none'; }); });
  $('#sortAz').onclick = function () {
    var rows = $$('.arow', songsBox).sort(function (a, b) { return $('input', a).value.localeCompare($('input', b).value, undefined, { numeric: true, sensitivity: 'base' }); });
    rows.forEach(function (r) { songsBox.appendChild(r); }); renumber(songsBox); saveOrder();
  };
  function setAll(on) { $$('.arow', songsBox).forEach(function (r) { var c = $('.tgl', r); if (c.checked !== on) { c.checked = on; c.dispatchEvent(new Event('change', { bubbles: true })); } }); }
  $('#allOn').onclick = function () { setAll(true); }; $('#allOff').onclick = function () { setAll(false); };
  $('#delAlbum').onclick = function () { AF.confirm({ title: 'Futa albamu nzima?', text: 'Sauti zote ndani ya "{{ addslashes($album->name) }}" zitafutwa.', ok: 'Futa albamu', danger: true }).then(function (y) { if (y) location.href = @json(route('delete_album', $album->id)); }); };

  /* ---------- queue ---------- */
  var Q = [], uid = 0, running = false, qBox = $('#queue');
  var drop = $('#drop'), inDir = $('#inDir'), inFiles = $('#inFiles');
  $('#pickDir').onclick = function () { inDir.click(); }; $('#pickFiles').onclick = function () { inFiles.click(); };
  inDir.onchange = function () { addFiles([].slice.call(inDir.files)); inDir.value = ''; };
  inFiles.onchange = function () { addFiles([].slice.call(inFiles.files)); inFiles.value = ''; };
  ['dragenter', 'dragover'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.add('over'); }); });
  ['dragleave', 'drop'].forEach(function (ev) { drop.addEventListener(ev, function () { drop.classList.remove('over'); }); });
  drop.addEventListener('drop', function (e) {
    e.preventDefault();
    var items = e.dataTransfer.items, out = [], pending = 0;
    if (items && items[0] && items[0].webkitGetAsEntry) {
      var entries = [].slice.call(items).map(function (i) { return i.webkitGetAsEntry(); }).filter(Boolean);
      var walk = function (en, path) {
        pending++;
        if (en.isFile) { en.file(function (f) { f._path = path + f.name; out.push(f); if (!--pending) addFiles(out); }, function () { if (!--pending) addFiles(out); }); }
        else { var rd = en.createReader(), all = []; (function rd1() { rd.readEntries(function (ch) { if (ch.length) { all = all.concat([].slice.call(ch)); rd1(); } else { all.forEach(function (c) { walk(c, path + en.name + '/'); }); if (!--pending) addFiles(out); } }); })(); }
      };
      entries.forEach(function (en) { walk(en, ''); });
    } else addFiles([].slice.call(e.dataTransfer.files));
  });
  document.addEventListener('dragover', function (e) { if (!e.target.closest('.arow')) e.preventDefault(); });
  document.addEventListener('drop', function (e) { if (!drop.contains(e.target) && !e.target.closest('.arow')) e.preventDefault(); });

  function addFiles(files) {
    var list = files.filter(function (f) { return (f.type && f.type.indexOf('audio/') === 0) || AUDIO_EXT.test(f.name); });
    var skipped = files.length - list.length;
    if (!list.length) { AF.toast('Hakuna faili la sauti lililopatikana', 'err'); return; }
    list.sort(function (a, b) { return (a._path || a.webkitRelativePath || a.name).localeCompare(b._path || b.webkitRelativePath || b.name, undefined, { numeric: true, sensitivity: 'base' }); });
    list.forEach(function (f) { var it = { id: ++uid, file: f, title: baseName(f.name).trim(), active: true, state: 'wait', pct: 0, dur: 0, err: '' }; Q.push(it); });
    $('#queueWrap').hidden = false; render();
    if (skipped) AF.toast('Faili ' + skipped + ' zisizo za sauti ziliruka');
    probe(list.length);
  }
  function probe() { // read durations one at a time, in the background
    var todo = Q.filter(function (i) { return !i.dur && !i.probed; }); if (!todo.length) return;
    var it = todo[0]; it.probed = true;
    var a = new Audio(), u = URL.createObjectURL(it.file), done = function () { URL.revokeObjectURL(u); a.src = ''; var r = rowOf(it); if (r) $('.dur', r).textContent = fmtDur(it.dur); probe(); };
    a.preload = 'metadata'; a.onloadedmetadata = function () { it.dur = isFinite(a.duration) ? a.duration : 0; done(); }; a.onerror = done; setTimeout(function () { if (!it.dur) done(); }, 4000); a.src = u;
  }
  function rowOf(it) { return qBox.querySelector('[data-q="' + it.id + '"]'); }
  function dupe(it) { var t = it.title.trim().toLowerCase(); return existing[t] || Q.some(function (o) { return o !== it && o.state !== 'done' && o.title.trim().toLowerCase() === t; }); }
  function render() {
    qBox.innerHTML = '';
    Q.forEach(function (it, i) {
      var r = document.createElement('div'); r.className = 'arow ' + (it.active ? '' : 'off ') + (it.state === 'done' ? 'done ' : '') + (it.state === 'fail' ? 'fail' : ''); r.dataset.q = it.id;
      r.innerHTML = '<span class="grip"><i class="fas fa-grip-vertical"></i></span><span class="no">' + (i + 1) + '</span><div class="nm"><input type="text"><div class="meta"><span class="dur">' + fmtDur(it.dur) + '</span><span class="st"></span></div></div>' +
        '<span class="sz">' + fmtSize(it.file.size) + '</span><label class="pro-switch" title="Onyesha kwenye app"><input type="checkbox" class="atg"><i></i></label>' +
        '<span class="acts"><button type="button" class="iconbtn del" title="Ondoa"><i class="fas fa-times"></i></button></span><span class="bar"></span>';
      $('input[type=text]', r).value = it.title; $('.atg', r).checked = it.active; qBox.appendChild(r); status(it);
    });
    summary();
  }
  function status(it) {
    var r = rowOf(it); if (!r) return; var st = $('.st', r), msg = '';
    r.classList.toggle('done', it.state === 'done'); r.classList.toggle('fail', it.state === 'fail'); r.classList.toggle('off', !it.active);
    if (it.state === 'done') msg = '<span class="okc"><i class="fas fa-check"></i> Imepakiwa</span>';
    else if (it.state === 'up') msg = '<span class="warn">' + it.pct + '%</span>';
    else if (it.state === 'fail') msg = '<span class="err"><i class="fas fa-exclamation-triangle"></i> ' + AF.esc(it.err) + '</span>';
    else if (!it.title.trim()) msg = '<span class="err">Weka jina</span>';
    else if (dupe(it)) msg = '<span class="err">Jina hili lipo tayari</span>';
    else if (LIMIT && it.file.size > LIMIT) msg = '<span class="err">Faili kubwa kuliko kikomo cha server (' + fmtSize(LIMIT) + ')</span>';
    st.innerHTML = msg; $('.bar', r).style.width = (it.state === 'done' ? 100 : it.pct) + '%';
    $('input', r).disabled = it.state === 'up' || it.state === 'done';
  }
  function problems(it) { return it.state === 'wait' || it.state === 'fail' ? (!it.title.trim() || dupe(it) || (LIMIT && it.file.size > LIMIT)) : false; }
  function summary() {
    var wait = Q.filter(function (i) { return i.state !== 'done'; }), done = Q.length - wait.length, bad = Q.filter(problems).length, total = Q.reduce(function (s, i) { return s + i.file.size; }, 0);
    $('#qTitle').textContent = running ? 'Inapakia… ' + done + ' / ' + Q.length : (wait.length ? wait.length + ' zinasubiri kupakiwa' : 'Zote zimepakiwa');
    $('#qSub').textContent = fmtSize(total) + (bad ? ' · ' + bad + ' zina tatizo la jina' : '') + (running ? '' : ' · hariri majina, washa/zima, au panga kwa kuburuta');
    var sum = Q.reduce(function (s, i) { return s + i.file.size * (i.state === 'done' ? 1 : i.pct / 100); }, 0);
    $('#gprog').style.width = (total ? Math.round(sum / total * 100) : 0) + '%';
    $('#qGo').disabled = running || !wait.length; $('#qGo span').textContent = running ? 'Inapakia…' : 'Pakia zote (' + wait.length + ')';
    $('#qClear').disabled = running; $('#qClean').disabled = running;
  }
  sortable(qBox, function () { var ids = $$('.arow', qBox).map(function (r) { return +r.dataset.q; }); Q.sort(function (a, b) { return ids.indexOf(a.id) - ids.indexOf(b.id); }); });
  qBox.addEventListener('input', function (e) { if (e.target.type !== 'text') return; var it = byRow(e.target); it.title = e.target.value; Q.forEach(status); summary(); });
  qBox.addEventListener('change', function (e) { if (!e.target.classList.contains('atg')) return; var it = byRow(e.target); it.active = e.target.checked; status(it); });
  qBox.addEventListener('click', function (e) { var b = e.target.closest('.del'); if (!b) return; var it = byRow(b); if (it.state === 'up') return; Q = Q.filter(function (x) { return x !== it; }); if (!Q.length) $('#queueWrap').hidden = true; render(); });
  function byRow(el) { var id = +el.closest('.arow').dataset.q; return Q.filter(function (x) { return x.id === id; })[0]; }
  $('#qClear').onclick = function () { Q = []; $('#queueWrap').hidden = true; render(); };
  $('#qClean').onclick = function () { Q.forEach(function (i) { if (i.state !== 'done') i.title = clean(i.title) || i.title; }); render(); AF.toast('Majina yamesafishwa'); };

  $('#qGo').onclick = function () {
    var todo = Q.filter(function (i) { return i.state === 'wait' || i.state === 'fail'; });
    if (todo.some(problems)) { AF.toast('Rekebisha majina yenye tatizo kwanza', 'err'); var bad = Q.filter(problems)[0]; var r = rowOf(bad); r && r.scrollIntoView({ behavior: 'smooth', block: 'center' }); return; }
    running = true; var pos = MAXPOS, order = {}; Q.forEach(function (i) { order[i.id] = ++pos; }); summary();
    var idx = 0, active = 0, MAXC = 2, failed = 0;
    function next() {
      if (idx >= todo.length && !active) { finish(); return; }
      while (active < MAXC && idx < todo.length) { (function (it) { active++; send(it, order[it.id], function (ok) { if (!ok) failed++; active--; summary(); next(); }); })(todo[idx++]); }
    }
    function finish() {
      running = false; summary();
      if (!failed) { AF.toast('Sauti zote zimepakiwa'); setTimeout(function () { location.reload(); }, 1100); }
      else AF.toast('Zimeshindikana ' + failed + '. Rekebisha na ubonyeze Pakia tena.', 'err');
    }
    next();
  };
  function send(it, pos, cb) {
    it.state = 'up'; it.pct = 0; status(it);
    var fd = new FormData(); fd.append('file', it.file); fd.append('title', it.title.trim()); fd.append('active', it.active ? 1 : 0); fd.append('position', pos); if (it.dur) fd.append('duration_sec', Math.round(it.dur));
    var x = new XMLHttpRequest(); x.open('POST', URL_UP); x.setRequestHeader('X-CSRF-TOKEN', AF.csrf); x.setRequestHeader('Accept', 'application/json'); x.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    x.upload.onprogress = function (e) { if (e.lengthComputable) { it.pct = Math.min(99, Math.round(e.loaded / e.total * 100)); status(it); summary(); } };
    x.onload = function () {
      var j = {}; try { j = JSON.parse(x.responseText); } catch (e) {}
      if (x.status >= 200 && x.status < 300 && j.ok) { it.state = 'done'; it.pct = 100; existing[it.title.trim().toLowerCase()] = 1; status(it); cb(true); }
      else { it.state = 'fail'; it.err = j.error || (x.status === 413 ? 'Faili ni kubwa kuliko kikomo cha server' : 'Hitilafu ' + x.status); it.pct = 0; status(it); cb(false); }
    };
    x.onerror = function () { it.state = 'fail'; it.err = 'Mtandao umekatika'; it.pct = 0; status(it); cb(false); };
    x.send(fd);
  }
  window.addEventListener('beforeunload', function (e) { if (running) { e.preventDefault(); e.returnValue = ''; } });
})();
</script>
@endsection

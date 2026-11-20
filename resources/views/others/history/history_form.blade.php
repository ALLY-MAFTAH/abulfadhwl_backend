@extends('layouts.app')

@section('page_title', $history ? 'Hariri sehemu' : 'Sehemu mpya')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@4/es2021/jodit.min.css">
<style>
  .hf { display: grid; grid-template-columns: 120px 1fr; gap: 14px; }
  @media (max-width: 640px) { .hf { grid-template-columns: 1fr; } }
  .ed-wrap { border-radius: 20px; overflow: hidden; border: 1px solid var(--pro-line2); background: #fff; }
  .ed-wrap .jodit-container:not(.jodit_inline) { border: 0 !important; border-radius: 0; }
  .ed-wrap .jodit-workplace, .ed-wrap .jodit-wysiwyg { background: #fff; color: #1b2440; font-family: "Inter Tight", system-ui, sans-serif; line-height: 1.8; font-size: 16px; }
  .ed-wrap .jodit-wysiwyg { padding: 22px 28px !important; }
  .ed-wrap .jodit-wysiwyg table { border-collapse: collapse; max-width: 100%; }
  .ed-wrap .jodit-wysiwyg blockquote { border-left: 4px solid #e9b23c; background: #fdf6e3; padding: 8px 14px; margin: 8px 0; }
  .ed-foot { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; justify-content: space-between; margin-top: 14px; }
  .ed-foot small { color: var(--pro-dim); }
  .tipbox { margin: 0 0 14px; padding: 12px 16px; border-radius: 14px; border: 1px solid rgba(233,178,60,.35); background: rgba(233,178,60,.08); color: var(--pro-gold-t); font-size: 13.5px; }
</style>
@endsection

@section('content')
<div class="py-2"><div class="container">
    <div class="pro-head">
        <a class="pbtn pbtn-ghost pbtn-icon ph-back" href="{{ route('histories') }}" title="Rudi"><i class="fas fa-arrow-left"></i></a>
        <div class="ph-tx">
            <span class="pro-eyebrow">Historia ya Sheikh</span>
            <h1>{{ $history ? 'Hariri sehemu' : 'Sehemu mpya' }}</h1>
            <p>Andika kwa uhuru kama kwenye document. Mpangilio na mapambo yote yataonekana kwenye app kama ulivyoyaweka.</p>
        </div>
    </div>

    @if ($errors->any())<p class="alert alert-danger">{{ $errors->first() }}</p>@endif

    <form id="hform" method="POST" action="{{ $history ? route('update_history', $history->id) : route('add_history') }}">
        @csrf
        @if ($history) @method('PUT') @endif
        <div class="hf">
            <div class="pro-field"><span>Namba</span><input type="number" min="1" class="form-control" name="section" value="{{ old('section', $nextSection) }}"></div>
            <div class="pro-field"><span>Kichwa cha sehemu</span><input type="text" class="form-control" name="heading" maxlength="190" required placeholder="mf. Kuzaliwa kwake na malezi" value="{{ old('heading', $history->heading ?? '') }}"></div>
        </div>

        <div class="tipbox"><i class="fas fa-lightbulb"></i> Kidokezo: usiweke rangi nyeusi au nyeupe kabisa kwenye maandishi. App ina mandhari ya giza na mwanga, na rangi hizo zinaweza kutoweka kwenye mojawapo. Rangi ya kawaida ya maandishi inajirekebisha yenyewe.</div>

        <div class="ed-wrap"><textarea id="editor"></textarea></div>
        <input type="hidden" name="content" id="content">

        <div class="ed-foot">
            <small id="count">0 maneno</small>
            <div style="display:flex;gap:10px">
                <a class="pbtn pbtn-ghost" href="{{ route('histories') }}">Ghairi</a>
                <button class="pbtn pbtn-gold" type="submit"><i class="fas fa-check"></i> Hifadhi sehemu</button>
            </div>
        </div>
    </form>
</div></div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jodit@4/es2021/jodit.min.js"></script>
<script>
(function () {
  // Right-to-left (Arabic) for the current paragraph
  var rtlButton = {
    name: 'rtl', tooltip: 'Kiarabu (kulia kwenda kushoto)', iconURL: '', icon: 'rtl',
    exec: function (ed) {
      var n = ed.s.current();
      while (n && n !== ed.editor && !/^(P|H[1-6]|LI|DIV|BLOCKQUOTE|TD|TH)$/.test(n.nodeName)) n = n.parentNode;
      if (!n || n === ed.editor) return;
      var on = n.style.direction === 'rtl';
      n.style.direction = on ? '' : 'rtl'; n.style.textAlign = on ? '' : 'right';
      ed.synchronizeValues();
    }
  };

  var ed = Jodit.make('#editor', {
    height: 680, minHeight: 420,
    placeholder: 'Anza kuandika hapa, au bandika kutoka Word / Google Docs…',
    toolbarSticky: true, toolbarStickyOffset: 8,
    showCharsCounter: false, showWordsCounter: true, showXPathInStatusbar: false,
    buttons: ['paragraph', 'font', 'fontsize', '|', 'bold', 'italic', 'underline', 'strikethrough', '|', 'brush', 'eraser', '|',
      'ul', 'ol', 'indent', 'outdent', '|', 'align', 'rtl', '|', 'table', 'link', 'hr', 'superscript', 'subscript', '|', 'undo', 'redo', '|', 'source', 'fullsize'],
    controls: { font: { list: {
      '': 'Kawaida (default)',
      'Arial,Helvetica,sans-serif': 'Arial',
      'Tahoma,Geneva,sans-serif': 'Tahoma',
      'Verdana,Geneva,sans-serif': 'Verdana',
      'Georgia,serif': 'Georgia',
      'Times New Roman,Times,serif': 'Times New Roman',
      'Courier New,Courier,monospace': 'Courier New',
      'Amiri,Traditional Arabic,serif': 'Amiri (Kiarabu)',
      'Noto Naskh Arabic,Arial,sans-serif': 'Naskh (Kiarabu)'
    } } },
    extraButtons: [rtlButton],
    // Word / Docs paste: keep structure, tables and colours
    askBeforePasteHTML: false, askBeforePasteFromWord: false,
    defaultActionOnPaste: 'insert_as_html', defaultActionOnPasteFromWord: 'insert_as_html',
    uploader: { insertImageAsBase64URI: false }, disablePlugins: ['image', 'file', 'video', 'media']
  });

  var initial = @json(old('content', $history->content ?? ''));
  if (initial) {
    if (!/<[a-z][\s\S]*>/i.test(initial)) initial = '<p>' + initial.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/\n/g, '<br>') + '</p>';
    ed.value = initial;
  }

  function words() { var t = (ed.editor.innerText || '').trim(); document.getElementById('count').textContent = (t ? t.split(/\s+/).length : 0) + ' maneno'; }
  ed.events.on('change keyup', words); words();

  document.getElementById('hform').addEventListener('submit', function (e) {
    var html = ed.value, text = (ed.editor.innerText || '').trim();
    if (!text && html.indexOf('<table') < 0) { e.preventDefault(); AF.toast('Andika maudhui kwanza', 'err'); return; }
    document.getElementById('content').value = html;
  });
})();
</script>
@endsection

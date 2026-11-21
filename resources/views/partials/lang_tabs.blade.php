{{--
    Optional English / Arabic versions of admin-written text.
    $uid    unique id for this block
    $fields [[name, label, 'input'|'textarea', placeholder?], ...]
    $tr     existing translations array (or null)
--}}
@php $tr = $tr ?? []; $langs = \App\Support\Translations::LANGS; @endphp
<div class="ltabs" id="lt-{{ $uid }}">
    <div class="lt-head">
        <span class="lt-title"><i class="fas fa-language"></i> Lugha nyingine <small>(hiari — ukiacha wazi, Kiswahili kinatumika)</small></span>
        <div class="seg" data-no-i18n>
            @foreach ($langs as $code => $name)
                <button type="button" data-lt="{{ $code }}" class="{{ $loop->first ? 'on' : '' }}">{{ strtoupper($code) }}</button>
            @endforeach
        </div>
    </div>
    @foreach ($langs as $code => $name)
        <div class="lt-pane" data-pane="{{ $code }}" {!! $loop->first ? '' : 'hidden' !!}>
            @foreach ($fields as $f)
                <div class="pro-field">
                    <span data-no-i18n>{{ __($f[1]) }} · {{ $name }}</span>
                    @if (($f[2] ?? 'input') === 'textarea')
                        <textarea class="form-control" rows="3" name="tr[{{ $code }}][{{ $f[0] }}]" @if ($code === 'ar') dir="rtl" @endif placeholder="{{ $f[3] ?? '' }}">{{ $tr[$code][$f[0]] ?? '' }}</textarea>
                    @else
                        <input class="form-control" name="tr[{{ $code }}][{{ $f[0] }}]" value="{{ $tr[$code][$f[0]] ?? '' }}" @if ($code === 'ar') dir="rtl" @endif placeholder="{{ $f[3] ?? '' }}">
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>

@once
<style>
  .ltabs { margin-top: 16px; padding: 14px 14px 4px; border: 1px dashed var(--pro-line2); border-radius: 16px; background: rgba(var(--fill),.03); }
  .ltabs .lt-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; margin-bottom: 10px; }
  .ltabs .lt-title { font-weight: 700; font-size: 13.5px; } .ltabs .lt-title small { color: var(--pro-mut); font-weight: 500; }
  .ltabs .lt-title i { color: var(--pro-gold-t); margin-right: 6px; }
</style>
<script>
  document.addEventListener('click', function (e) {
    var b = e.target.closest('.ltabs [data-lt]'); if (!b) return;
    var box = b.closest('.ltabs');
    box.querySelectorAll('[data-lt]').forEach(function (x) { x.classList.toggle('on', x === b); });
    box.querySelectorAll('.lt-pane').forEach(function (p) { p.hidden = p.dataset.pane !== b.dataset.lt; });
  });
</script>
@endonce

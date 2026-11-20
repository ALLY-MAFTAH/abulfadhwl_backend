@extends('layouts.app')
@section('page_title', $category->name)
@section('style')
<style>
  .tiles { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 16px; padding: 20px; }
  .tile { position: relative; display: block; padding: 20px; border-radius: 20px; text-decoration: none !important; color: var(--pro-text) !important; border: 1px solid var(--pro-line); background: linear-gradient(160deg, rgba(var(--fill),.08), rgba(var(--fill),.025)); transition: transform .25s, border-color .25s, box-shadow .25s; overflow: hidden; }
  .tile:hover { transform: translateY(-4px); border-color: var(--pro-gold); box-shadow: 0 24px 40px -24px rgba(233,178,60,.6); }
  .tile .ic { width: 44px; height: 44px; border-radius: 14px; display: grid; place-items: center; font-size: 18px; color: var(--pro-gold-t); background: rgba(233,178,60,.14); border: 1px solid rgba(233,178,60,.4); margin-bottom: 14px; }
  .tile h3 { margin: 0 0 4px; font-size: 17px; font-weight: 700; word-break: break-word; }
  .tile p { margin: 0 0 14px; color: var(--pro-mut); font-size: 13px; min-height: 18px; }
  .tile .st { display: flex; gap: 8px; flex-wrap: wrap; }
  .tile .x { position: absolute; right: 12px; top: 12px; }
  .tile.add { display: grid; place-items: center; text-align: center; min-height: 170px; border-style: dashed; border-color: var(--pro-line2); background: transparent; cursor: pointer; color: var(--pro-mut) !important; }
  .tile.add i { font-size: 26px; color: var(--pro-gold); margin-bottom: 8px; display: block; } .tile.add:hover { color: var(--pro-hi) !important; }
</style>
@endsection
@section('content')
<div class="py-2"><div class="container">
    @if (Session::has('error'))<p class="alert alert-danger">{{ Session::get('error') }}</p>@endif
    @if (Session::has('success'))<p class="alert alert-success">{{ Session::get('success') }}</p>@endif
    <div class="pro-head">
        <a class="pbtn pbtn-ghost pbtn-icon ph-back" href="{{ route('categories') }}" title="Rudi"><i class="fas fa-arrow-left"></i></a>
        <div class="ph-tx">
            <span class="pro-eyebrow">Kundi la sauti</span>
            <h1>{{ $category->name }}</h1>
            <p>{{ $category->description }}</p>
        </div>
        <div class="ph-act">
            <button class="pbtn pbtn-ghost pbtn-sm" data-bs-toggle="modal" data-bs-target="#editCategoryModal"><i class="fas fa-pen"></i> Hariri kundi</button>
            <button class="pbtn pbtn-gold" data-bs-toggle="modal" data-bs-target="#addAlbumModal"><i class="fas fa-plus"></i> Albamu mpya</button>
        </div>
    </div>
    <div class="pro-sheet">
        <div class="tiles">
            @foreach ($category->albums as $album)
                @php $all = $album->allSongs; @endphp
                <a class="tile" href="{{ route('album', $album->id) }}">
                    <div class="ic"><i class="fas fa-compact-disc"></i></div>
                    <h3>{{ $album->name }}</h3>
                    <p>{{ $album->description }}</p>
                    <div class="st"><span class="pchip gold">{{ $all->count() }} sauti</span>@if ($all->where('active', false)->count())<span class="pchip">{{ $all->where('active', false)->count() }} zimezimwa</span>@endif</div>
                    <button type="button" class="iconbtn del x" title="Futa" onclick="event.preventDefault();event.stopPropagation();AF.confirm({title:'Futa albamu hii?',text:'Sauti zote ndani yake zitafutwa.',ok:'Futa',danger:true}).then(function(y){if(y)location.href='{{ route('delete_album', $album->id) }}'})"><i class="fas fa-trash"></i></button>
                </a>
            @endforeach
            <a class="tile add" href="#" data-bs-toggle="modal" data-bs-target="#addAlbumModal"><div><i class="fas fa-plus-circle"></i>Albamu mpya</div></a>
        </div>
    </div>

    <div class="modal fade" id="addAlbumModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="{{ route('add_album', $category->id) }}">@csrf
            <div class="modal-header"><h5 class="modal-title">Albamu mpya</h5><button type="button" class="close" data-bs-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <div class="pro-field"><span>Jina</span><input class="form-control" name="name" required onkeyup="this.value=this.value.toUpperCase()" value="{{ old('name') }}"></div>
                <div class="pro-field"><span>Maelezo</span><input class="form-control" name="description" value="{{ old('description') }}"></div>
            </div>
            <div class="modal-footer"><button type="button" class="pbtn pbtn-ghost" data-bs-dismiss="modal">Funga</button><button class="pbtn pbtn-gold">Hifadhi</button></div>
        </form>
    </div></div></div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
        <form method="GET" action="{{ route('edit_category', $category->id) }}">
            <div class="modal-header"><h5 class="modal-title">Hariri kundi</h5><button type="button" class="close" data-bs-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <div class="pro-field"><span>Jina</span><input class="form-control" name="name" required onkeyup="this.value=this.value.toUpperCase()" value="{{ old('name', $category->name) }}"></div>
                <div class="pro-field"><span>Maelezo</span><input class="form-control" name="description" required value="{{ old('description', $category->description) }}"></div>
            </div>
            <div class="modal-footer"><button type="button" class="pbtn pbtn-ghost" data-bs-dismiss="modal">Funga</button><button class="pbtn pbtn-gold">Hifadhi</button></div>
        </form>
    </div></div></div>
</div></div>
@endsection

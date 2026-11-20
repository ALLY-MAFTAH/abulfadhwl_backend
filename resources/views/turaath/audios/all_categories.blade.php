@extends('layouts.app')
@section('page_title', 'Sauti')
@section('style')
<style>
  .tiles { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px; padding: 20px; }
  .tile { position: relative; display: block; padding: 22px 20px 18px; border-radius: 20px; text-decoration: none !important; color: var(--pro-text) !important; border: 1px solid var(--pro-line); background: linear-gradient(160deg, rgba(255,255,255,.08), rgba(255,255,255,.025)); transition: transform .25s, border-color .25s, box-shadow .25s; overflow: hidden; }
  .tile::before { content: ""; position: absolute; right: -30px; top: -30px; width: 120px; height: 120px; border-radius: 50%; background: radial-gradient(circle, rgba(233,178,60,.28), transparent 70%); }
  .tile:hover { transform: translateY(-4px); border-color: var(--pro-gold); box-shadow: 0 24px 40px -24px rgba(233,178,60,.6); }
  .tile .ic { width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center; font-size: 19px; color: #2b1d00; background: linear-gradient(135deg, var(--pro-gold-l), var(--pro-gold)); margin-bottom: 16px; position: relative; }
  .tile h3 { margin: 0 0 4px; font-size: 18px; font-weight: 700; position: relative; word-break: break-word; }
  .tile p { margin: 0 0 14px; color: var(--pro-mut); font-size: 13px; min-height: 18px; position: relative; }
  .tile .st { display: flex; gap: 8px; flex-wrap: wrap; position: relative; }
  .tile .x { position: absolute; right: 12px; bottom: 12px; z-index: 2; }
  .tile.add { display: grid; place-items: center; text-align: center; min-height: 190px; border-style: dashed; border-color: var(--pro-line2); background: transparent; cursor: pointer; color: var(--pro-mut) !important; }
  .tile.add i { font-size: 26px; color: var(--pro-gold); margin-bottom: 8px; display: block; } .tile.add:hover { color: #fff !important; }
  .tile.add::before { display: none; }
</style>
@endsection
@section('content')
<div class="py-2"><div class="container">
    @if (Session::has('error'))<p class="alert alert-danger">{{ Session::get('error') }}</p>@endif
    @if (Session::has('success'))<p class="alert alert-success">{{ Session::get('success') }}</p>@endif
    <div class="pro-head">
        <div class="ph-tx">
            <span class="pro-eyebrow">Turaath · Sauti</span>
            <h1>Makundi ya sauti</h1>
            <p>Chagua kundi ufungue albamu zake, kisha pakia sauti ndani ya albamu.</p>
        </div>
        <div class="ph-act"><button class="pbtn pbtn-gold" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="fas fa-plus"></i> Kundi jipya</button></div>
    </div>
    <div class="pro-sheet">
        <div class="tiles">
            @foreach ($categories as $category)
                <a class="tile" href="{{ route('category', $category->id) }}">
                    <div class="ic"><i class="fas fa-folder-open"></i></div>
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description }}</p>
                    <div class="st"><span class="pchip gold">{{ count($category->albums) }} albamu</span></div>
                    <button type="button" class="iconbtn del x" title="Futa" onclick="event.preventDefault();event.stopPropagation();AF.confirm({title:'Futa kundi hili?',text:'Albamu na sauti zake zote zitafutwa.',ok:'Futa',danger:true}).then(function(y){if(y)location.href='{{ route('delete_category', $category->id) }}'})"><i class="fas fa-trash"></i></button>
                </a>
            @endforeach
            <a class="tile add" href="#" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><div><i class="fas fa-plus-circle"></i>Kundi jipya</div></a>
        </div>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="{{ route('add_category') }}">@csrf
            <div class="modal-header"><h5 class="modal-title">Kundi jipya</h5><button type="button" class="close" data-bs-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <div class="pro-field"><span>Jina</span><input class="form-control" name="name" required onkeyup="this.value=this.value.toUpperCase()" value="{{ old('name') }}"></div>
                <div class="pro-field"><span>Maelezo</span><input class="form-control" name="description" required value="{{ old('description') }}"></div>
            </div>
            <div class="modal-footer"><button type="button" class="pbtn pbtn-ghost" data-bs-dismiss="modal">Funga</button><button class="pbtn pbtn-gold">Hifadhi</button></div>
        </form>
    </div></div></div>
</div></div>
@endsection

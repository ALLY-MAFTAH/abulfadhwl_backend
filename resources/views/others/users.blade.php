@extends('layouts.app')

@section('page_title', 'Watumiaji')

@section('style')
<style>
  .urow { display: grid; grid-template-columns: 46px 1fr auto; gap: 16px; align-items: center; padding: 14px 20px; border-bottom: 1px solid var(--pro-line); }
  .urow:last-child { border-bottom: 0; } .urow:hover { background: rgba(var(--fill),.03); }
  .av { width: 46px; height: 46px; border-radius: 15px; display: grid; place-items: center; font: 700 17px "Inter Tight", sans-serif; color: #2b1d00; background: linear-gradient(135deg, var(--pro-gold-l), var(--pro-gold)); }
  .urow b { font-size: 16px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap; } .urow small { color: var(--pro-mut); }
  .urow .acts { display: flex; gap: 6px; }
  .pw-hint { color: var(--pro-dim); font-size: 12.5px; margin: -6px 0 12px; }
</style>
@endsection

@section('content')
<div class="py-2"><div class="container">
    @if (Session::has('error'))<p class="alert alert-danger">{{ Session::get('error') }}</p>@endif
    @if (Session::has('success'))<p class="alert alert-success">{{ Session::get('success') }}</p>@endif

    <div class="pro-head">
        <div class="ph-tx">
            <span class="pro-eyebrow">Mfumo</span>
            <h1>Wasimamizi</h1>
            <p>Watu wanaoweza kuingia kwenye dashibodi hii. Kila msimamizi anaona na kubadilisha kila kitu.</p>
        </div>
        <div class="ph-act"><button class="pbtn pbtn-gold" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-user-plus"></i> Ongeza msimamizi</button></div>
    </div>

    <div class="pro-sheet">
        @foreach ($users as $user)
            <div class="urow">
                <span class="av">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                <div style="min-width:0">
                    <b>{{ $user->name }} @if ($user->id === auth()->id())<span class="pchip gold">Wewe</span>@endif</b>
                    <small>{{ $user->email }}</small>
                </div>
                <div class="acts">
                    <button type="button" class="iconbtn" title="Hariri" data-bs-toggle="modal" data-bs-target="#editUser-{{ $user->id }}"><i class="fas fa-pen"></i></button>
                    @if ($user->id !== auth()->id())
                        <button type="button" class="iconbtn del" title="Futa" onclick="AF.confirm({title:'Futa msimamizi huyu?',text:{{ json_encode($user->name) }} + ' hataweza kuingia tena.',ok:'Futa',danger:true}).then(function(y){if(y)location.href='{{ route('delete_user', $user->id) }}'})"><i class="fas fa-trash"></i></button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- ADD --}}
    <div class="modal fade" id="addUserModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="{{ route('add_user') }}" autocomplete="off">@csrf
            <div class="modal-header"><h5 class="modal-title">Msimamizi mpya</h5><button type="button" class="close" data-bs-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <div class="pro-field"><span>Jina</span><input class="form-control" name="name" required value="{{ old('name') }}"></div>
                <div class="pro-field"><span>Email</span><input type="email" class="form-control" name="email" required value="{{ old('email') }}"></div>
                <div class="pro-field"><span>Nenosiri</span><input type="password" class="form-control" name="password" required minlength="8" autocomplete="new-password"></div>
                <div class="pro-field"><span>Thibitisha nenosiri</span><input type="password" class="form-control" name="password_confirmation" required minlength="8" autocomplete="new-password"></div>
                <div class="pw-hint">Angalau herufi 8.</div>
            </div>
            <div class="modal-footer"><button type="button" class="pbtn pbtn-ghost" data-bs-dismiss="modal">Funga</button><button class="pbtn pbtn-gold">Hifadhi</button></div>
        </form>
    </div></div></div>

    {{-- EDIT --}}
    @foreach ($users as $user)
    <div class="modal fade" id="editUser-{{ $user->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
        <form method="POST" action="{{ route('edit_user', $user->id) }}" autocomplete="off">@csrf @method('PUT')
            <div class="modal-header"><h5 class="modal-title">Hariri msimamizi</h5><button type="button" class="close" data-bs-dismiss="modal">&times;</button></div>
            <div class="modal-body">
                <div class="pro-field"><span>Jina</span><input class="form-control" name="name" required value="{{ $user->name }}"></div>
                <div class="pro-field"><span>Email</span><input type="email" class="form-control" name="email" required value="{{ $user->email }}"></div>
                <div class="pro-field"><span>Nenosiri jipya (hiari)</span><input type="password" class="form-control" name="password" minlength="8" autocomplete="new-password"></div>
                <div class="pro-field"><span>Thibitisha nenosiri jipya</span><input type="password" class="form-control" name="password_confirmation" minlength="8" autocomplete="new-password"></div>
                <div class="pw-hint">Acha wazi kama hutaki kubadilisha nenosiri.</div>
            </div>
            <div class="modal-footer"><button type="button" class="pbtn pbtn-ghost" data-bs-dismiss="modal">Funga</button><button class="pbtn pbtn-gold">Hifadhi</button></div>
        </form>
    </div></div></div>
    @endforeach
</div></div>
@endsection

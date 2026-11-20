@extends('layouts.app')

@section('content')
    <div class="auth-card" style="margin:62px auto 0">
        <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="">
        <h1>Nenosiri jipya</h1>
        <p class="sub">Weka nenosiri jipya la akaunti yako</p>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">Barua pepe</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="password">Nenosiri jipya</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  required autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="password-confirm">Rudia nenosiri</label>
                <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"  required autocomplete="new-password">
                @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Hifadhi nenosiri</button>
        </form>
    </div>
@endsection

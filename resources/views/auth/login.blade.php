@extends('layouts.app')

@section('content')
    <div class="auth-card" style="margin:62px auto 0">
        <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="">
        <h1>{{ config('app.name') }}</h1>
        <p class="sub">Ingia kama msimamizi</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Barua pepe</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="password">Nenosiri</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Nikumbuke</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Ingia</button>
            @if (Route::has('password.request'))
                <div class="text-center mt-3"><a href="{{ route('password.request') }}">Umesahau nenosiri?</a></div>
            @endif
        </form>
    </div>
@endsection

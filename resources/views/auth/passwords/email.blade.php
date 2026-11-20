@extends('layouts.app')

@section('content')
    <div class="auth-card" style="margin:62px auto 0">
        <img class="logo" src="{{ asset('assets/images/logo.png') }}" alt="">
        <h1>Weka upya nenosiri</h1>
        <p class="sub">Tutakutumia kiungo cha kuweka nenosiri jipya kwa barua pepe</p>
        @if (session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Barua pepe</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Tuma kiungo</button>
            <div class="text-center mt-3"><a href="{{ route('login') }}">&larr; Rudi kuingia</a></div>
        </form>
    </div>
@endsection

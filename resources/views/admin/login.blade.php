@extends('layouts.app')
@section('content')
<div class="login-panel">
    <h1 class="login-title">
        Puryaideu<span class="light">App</span>
    </h1>

    <p class="login-text">Admin Login</p>

    <form method="POST" action="/login/admin">
        @csrf

        <div class="form-field">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>

        <div class="form-field">
            <label for="password"><i class="fas fa-key"></i>  Password</label>
            <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="form-field">
            <button type="submit" class="login-btn">Login</button>
        </div>
    </form>

    <div class="login-footer">
        <p>Copyright 2021 Puryaideu</p>
    </div>
</div>
@endsection

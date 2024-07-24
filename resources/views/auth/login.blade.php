@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6 text-center">
        <img src="{{ asset('images/put.png') }}" alt="Login Image" class="img-fluid mb-4">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>

                <div class="col-md-8">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>

                <div class="col-md-8">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-0">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-pink btn-lg btn-block">
                        {{ __('ログイン') }}
                    </button>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12 text-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('パスワードを忘れた場合') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-pink {
        border-radius: 0;
        background-color: #5f5d5d;
        border-color: #000000;
        color: #ffffff;
        font-size: 1.2rem;
        padding: 0.75rem 1.5rem;
    }
    .btn-pink:hover {
        background-color: #141414;
        border-color: #000000;
        color: #ffffff;
    }
    .container {
        min-height: 100vh;
    }
</style>
@endsection

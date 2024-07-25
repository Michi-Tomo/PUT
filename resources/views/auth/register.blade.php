@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6 text-center">
        <img src="{{ asset('images/put.png') }}" alt="Register Image" class="img-fluid mb-4">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('ニックネーム') }}</label>
                <div class="col-md-8">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>
                <div class="col-md-8">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('電話番号') }}</label>
                <div class="col-md-8">
                    <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>
                <div class="col-md-8">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('確認パスワード') }}</label>
                <div class="col-md-8">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end">{{ __('') }}</label>
                <div class="col-md-8 d-flex justify-content-center align-items-center">
                    <div class="form-check form-check-inline">
                        <input id="乗客" type="radio" name="user_type" value="0" class="form-check-input" onclick="handleClick(this);">
                        <label for="乗客" class="form-check-label">{{ __('乗客') }}</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="ドライバー" type="radio" name="user_type" value="1" class="form-check-input" onclick="handleClick(this);">
                        <label for="ドライバー" class="form-check-label">{{ __('ドライバー') }}</label>
                    </div>
                </div>
            </div>

            <div id="driver_infos" style="display: none">
                <div class="row mb-3">
                    <label for="driver_image" class="col-md-4 col-form-label text-md-end">{{ __('登録用の顔写真') }}</label>
                    <div class="col-md-8">
                        <input id="driver_image" type="file" name="driver_image" class="form-control @error('driver_image') is-invalid @enderror">
                        @error('driver_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="age" class="col-md-4 col-form-label text-md-end">{{ __('年齢') }}</label>
                    <div class="col-md-8">
                        <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" autocomplete="age" autofocus>
                        @error('age')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="driver_license" class="col-md-4 col-form-label text-md-end">{{ __('運転免許証') }}</label>
                    <div class="col-md-8">
                        <input id="driver_license" type="text" class="form-control @error('driver_license') is-invalid @enderror" name="driver_license" value="{{ old('driver_license') }}" autocomplete="driver_license" autofocus>
                        @error('driver_license')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="license_plate" class="col-md-4 col-form-label text-md-end">{{ __('車両番号') }}</label>
                    <div class="col-md-8">
                        <input id="license_plate" type="text" class="form-control @error('license_plate') is-invalid @enderror" name="license_plate" value="{{ old('license_plate') }}" autocomplete="license_plate" autofocus>
                        @error('license_plate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-0 justify-content-center">
                <div class="col-md-6 text-center">
                    <button type="submit" class="btn btn-pink btn-lg btn-block">
                        <i class="bi bi-pencil-square"></i> {{ __('新規登録する') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<a href="javascript:history.back()">前のページに戻る</a>

<script>
    function handleClick(value) {
        const driver_infos = document.getElementById('driver_infos');
        if (value.value == 0){
            driver_infos.style.display="none";
        }else if (value.value == 1){
            driver_infos.style.display="block";
        }
    }
</script>

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

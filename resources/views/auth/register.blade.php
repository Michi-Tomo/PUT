@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('新規登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('ニックネーム') }}</label>

                            <div class="col-md-6">
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

                            <div class="col-md-6">
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

                            <div class="col-md-6">
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

                            <div class="col-md-6">
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

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="乗客" class="col-md-4 col-form-label text-md-end">{{ __('乗客') }}</label>

                            <div class="col-md-6">
                                <input id="乗客" type="radio" name="user_type" value="0" onclick="handleClick(this);">
                            </div>

                            <label for="ドライバー" class="col-md-4 col-form-label text-md-end">{{ __('ドライバー') }}</label>

                            <div class="col-md-6">
                                <input id="ドライバー" type="radio" name="user_type" value="1" onclick="handleClick(this);">
                            </div>
                        </div>

                        {{-- ドライバー専用の追加項目 --}}
                        <div id="driver_infos" style="display: none">
                            <div class="row mb-3">
                                <input id="driver_image" type="file" name="driver_image" class="col-md-4 col-form-label text-md-end">{{ __('登録用の顔写真') }}

                            <div class="col-md-6">
                                {{-- <input id="driver_image" type="text" class="form-control @error('driver_image') is-invalid @enderror" name="driver_image" value="{{ old('driver_image') }}" required autocomplete="driver_image" autofocus> --}}

                                @error('driver_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="age" class="col-md-4 col-form-label text-md-end">{{ __('年齢') }}</label>

                            <div class="col-md-6">
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

                            <div class="col-md-6">
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

                            <div class="col-md-6">
                                <input id="license_plate" type="text" class="form-control @error('license_plate') is-invalid @enderror" name="license_plate" value="{{ old('license_plate') }}" autocomplete="license_plate" autofocus>

                                @error('license_plate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        </div>


                        <div style="display: flex; justify-content: space-between;">
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('新規登録') }}
                                    </button>
                                </div>

                            </div>
                         </div>
                    </form>

                    {{-- <div class="row mb-0">
                        <div class="col-md-6 offset-md-4" >
                            <form action="/driver" method="get">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    {{  __('ドライバーの新規登録') }}
                                </button>
                            </form>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function handleClick(value) {
        // alert(value.value);
        const driver_infos = document.getElementById('driver_infos');
        if (value.value == 0){
            driver_infos.style.display="none";
        }else if (value.value == 1){
            driver_infos.style.display="block";
        }
    }
</script>
@endsection

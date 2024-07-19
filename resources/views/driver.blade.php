@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ドライバー専用登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                                <input id="driver_image" type="file" name="image" class="col-md-4 col-form-label text-md-end">{{ __('登録用の顔写真') }}

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
                                <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="age" autofocus>

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
                                <input id="driver_license" type="text" class="form-control @error('driver_license') is-invalid @enderror" name="driver_license" value="{{ old('driver_license') }}" required autocomplete="driver_license" autofocus>

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
                                <input id="license_plate" type="text" class="form-control @error('license_plate') is-invalid @enderror" name="license_plate" value="{{ old('license_plate') }}" required autocomplete="license_plate" autofocus>

                                @error('license_plate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
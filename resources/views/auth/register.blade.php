@extends('layouts.app')

@section('js')
    <script src="{{asset('libraries/maskedinput/maskedinput.min.js')}}" defer></script>
    <script src="{{asset('js/registration.js')}}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-xl-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form enctype="multipart/form-data" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row required">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" required
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row required">
                                <label for="surname"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" required
                                           class="form-control @error('surname') is-invalid @enderror" name="surname"
                                           value="{{ old('surname') }}" autocomplete="surname" autofocus>

                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nickname"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Nickname') }}</label>

                                <div class="col-md-6">
                                    <input id="nickname" type="text"
                                           class="form-control @error('nickname') is-invalid @enderror" name="nickname"
                                           value="{{ old('nickname') }}" autocomplete="nickname" autofocus>

                                    @error('nickname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row required">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-group row required">
                                <label for="nickname"
                                       class="col-md-4 col-form-label text-md-right">{{ __('User type') }}</label>

                                <div class="col-md-6">
                                    <select class="custom-select" name="role_id" id="role_id">
                                        <option {{ old('role_id') == 3 ? ' selected' : '' }} value="3">Student</option>
                                        <option {{ old('role_id') == 4 ? ' selected' : '' }} value="4">Representative</option>
                                    </select>

                                    @error('nickname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="representative" @if(old('role_id') == 4) style="display: none" @endif>
                                <div class="d-flex justify-content-center bd-highlight mb-3">
                                    <div class="p-2 bd-highlight">
                                        <div class="custom-control custom-checkbox align-content-center">
                                            <input name="adult_checkbox" value="1"
                                                   {{ (old('adult_checkbox') ?? false) == 1 ? ' checked' : '' }}
                                                   type="checkbox" class="custom-control-input" id="adult_checkbox">
                                            <label class="custom-control-label" for="adult_checkbox">Есть 18 лет</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="representative-fields" @if(old('adult_checkbox') == 1) style="display: none" @endif>
                                    <div class="form-group row required">
                                        <label for="email"
                                               class="col-md-4 col-form-label text-md-right">{{ __('Representative E-Mail') }}</label>

                                        <div class="col-md-6">
                                            <input id="representative_email" type="email"
                                                   class="form-control @error('representative_email') is-invalid @enderror" name="representative_email"
                                                   value="{{ old('representative_email') }}" autocomplete="representative_email">

                                            @error('representative_email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text"
                                           class="form-control @error('city') is-invalid @enderror" name="city"
                                           value="{{ old('city') }}" autocomplete="city" autofocus>

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row required">
                                <label for="phone"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                           class="form-control @error('phone') is-invalid @enderror" name="phone"
                                           value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="avatar"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>

                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input name="avatar" type="file"
                                               class="custom-file-input @error('avatar') is-invalid @enderror"
                                               id="avatar">
                                        <label class="custom-file-label" for="avatar">@lang('Choose file')</label>
                                        @error('avatar')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="form-group row required">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row required">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
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

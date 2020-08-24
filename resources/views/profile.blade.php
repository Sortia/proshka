@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">@lang('User data')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">@lang('Students')</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row mt-4">
                                    <div class="col-lg-6 mb-3">
                                        <img class="w-100" src="{{asset($user->avatar)}}" alt="">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="col-sm-12 my-1 mb-3">
                                            <label class="sr-only" for="name">@lang('auth.name')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@lang('auth.name')</div>
                                                </div>
                                                <input value="{{$user->name}}" class="form-control" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-1 mb-3">
                                            <label class="sr-only" for="surname">@lang('auth.surname')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@lang('auth.surname')</div>
                                                </div>
                                                <input value="{{$user->surname}}" class="form-control" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-1 mb-3">
                                            <label class="sr-only" for="nickname">@lang('auth.nickname')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@lang('auth.nickname')</div>
                                                </div>
                                                <input value="{{$user->nickname}}" class="form-control" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-1 mb-3">
                                            <label class="sr-only" for="email">@lang('auth.email')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@lang('auth.email')</div>
                                                </div>
                                                <input value="{{$user->email}}" class="form-control" id="representative_email" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-1 mb-3">
                                            <label class="sr-only" for="city">@lang('auth.city')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@lang('auth.city')</div>
                                                </div>
                                                <input value="{{$user->city}}" class="form-control" disabled="">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 my-1 mb-3">
                                            <label class="sr-only" for="phone">@lang('auth.phone')</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@lang('auth.phone')</div>
                                                </div>
                                                <input value="{{$user->phone}}" class="form-control" disabled="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade pt-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <student-registration></student-registration>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
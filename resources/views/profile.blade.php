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
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                   aria-controls="home" aria-selected="true">@lang('User data')</a>
                            </li>
                            @if(Gate::allows('is_representative'))
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#students"
                                       role="tab" aria-controls="students"
                                       aria-selected="false">@lang('Students')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                       aria-controls="profile" aria-selected="false">@lang('Student registration')</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row mt-4">
                                    {{--                                    <div class="col-lg-6 mb-3">--}}
                                    {{--                                        <img class="w-100" src="{{asset($user->avatar)}}" alt="">--}}
                                    {{--                                    </div>--}}
                                    <div class="col-lg-12 mb-3">
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
                                                <input value="{{$user->email}}" class="form-control"
                                                       id="representative_email" disabled="">
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
                                        @if(Gate::allows('is_student') and !auth()->user()->isAdult())
                                            <hr>
                                            <div class="col-sm-12 my-1 mb-3">
                                                <label class="sr-only" for="representative">@lang('auth.representative')</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">@lang('auth.representative')</div>
                                                    </div>
                                                    <input value="{{$user->representative->fullName()}} ({{$user->representative->email}})" class="form-control" disabled="">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            @if(Gate::allows('is_representative'))

                                <div class="tab-pane fade pt-4" id="profile" role="tabpanel"
                                     aria-labelledby="profile-tab">
                                    <student-registration></student-registration>
                                </div>
                                <div class="tab-pane fade" id="students" role="tabpanel"
                                     aria-labelledby="nav-profile-tab">
                                    <div class="mt-4">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">@lang('auth.name')</th>
                                                <th scope="col">@lang('auth.surname')</th>
                                                <th scope="col">@lang('auth.nickname')</th>
                                                <th scope="col">@lang('auth.email')</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($user->students as $student)
                                                <tr>
                                                    <th scope="row">{{$loop->index + 1}}</th>
                                                    <td>{{$student->name}}</td>
                                                    <td>{{$student->surname}}</td>
                                                    <td>{{$student->nickname}}</td>
                                                    <td>{{$student->email}}</td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>


                                </div>
                                </div>

                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

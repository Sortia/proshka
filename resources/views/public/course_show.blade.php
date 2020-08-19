@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2 h5">
                        <span>{{$course->name}} @lang('Tasks')</span>
                        @if($course->isBought())
                            <span class="float-right">
                                @lang('Balance'): {{$course->user->balance}}
                            </span>
                        @else
                            <span>
                            <a href="{{route('course.buy', $course)}}" class="btn btn-sm btn-success float-right">@lang('Buy')</a>
                            </span>
                        @endif

                    </div>

                    <div class="card-body">
                        <div class="list-group">
                            @foreach($course->lessons->sortBy('order_number') as $lesson)
                                @if($course->isBought())
                                    <a href="{{route('lesson.show', $lesson)}}" class="list-group-item list-group-item-action @unless($lesson->available()) disabled @endunless">
                                        <div class="row">
                                            <div class="col-lg-2">{{$lesson->name}}</div>
                                            <div class="col-lg-8">{{$lesson->description}}</div>
                                            @if($lesson->user)
                                                <div class="col-lg-2">{{__(Str::ucfirst($lesson->user->status))}}</div>
                                            @else
                                                <div class="col-lg-2">{{(__('Cost') . ': ' . $lesson->cost)}}</div>
                                            @endif
                                        </div>
                                    </a>
                                @else
                                    <div class="list-group-item list-group-item-action">
                                        <div class="row">
                                            <div class="col-lg-2">{{$lesson->name}}</div>
                                            <div class="col-lg-10">{{$lesson->description}}</div>
                                        </div>
                                    </div>
                                @endif

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

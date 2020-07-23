@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('Lessons')</div>

                    <div class="card-body">
                        <div class="list-group">
                            @foreach($userLessons as $lesson)
                                <a href="{{route('teacher.lesson.show', $lesson)}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-lg-4">{{$lesson->lesson->course->name}}/{{$lesson->lesson->name}}</div>
                                        <div class="col-lg-8">{{$lesson->user->name}}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

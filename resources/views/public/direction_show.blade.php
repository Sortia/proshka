@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Direction') }}</div>

                    <div class="card-body">
                        <div class="list-group">
                            @foreach($direction->courses as $course)
                                <a href="{{route('course.show', $course)}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-lg-2">{{$course->name}}</div>
                                        <div class="col-lg-10">{{$course->description}}</div>
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

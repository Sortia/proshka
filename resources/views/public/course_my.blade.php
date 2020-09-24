@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5">
        <div class="row page-header no-gutters"><h3 class="page-title">@lang('My courses')</h3></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($courses as $course)
                                <a href="{{route('course.show', $course)}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-sm-2">{{$course->name}}</div>
                                        <div class="col-sm-10">{{$course->description}}</div>
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

@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row page-header no-gutters"><h3 class="page-title">@lang('Directions')</h3></div>
                <div class="card">
                    <div class="card-body">


                        <div id="accordion">

                            <div class="list-group">
                                @foreach($directions as $direction)
                                    <a
                                        id="direction_{{$direction->id}}"
                                        href="{{route('direction.show', $direction)}}"
                                        class="list-group-item list-group-item-action"
                                        data-toggle="collapse"
                                        data-target="#direction_collapse_{{$direction->id}}"
                                        aria-expanded="true"
                                        aria-controls="direction_collapse_{{$direction->id}}"
                                    >
                                        <div class="row">
                                            <div class="col-sm-2">{{$direction->name}}</div>
                                            <div class="col-sm-10">{{$direction->description}}</div>
                                        </div>
                                    </a>
                                    <div id="direction_collapse_{{$direction->id}}" class="collapse"
                                         aria-labelledby="direction_{{$direction->id}}" data-parent="#accordion">
                                        <div class="list-group">
                                            @foreach($direction->courses as $course)
                                                <a href="{{route('course.show', $course)}}" class="list-group-item list-group-item-action">
                                                    <div class="row">
                                                        <div class="col-sm-2">- {{$course->name}}</div>
                                                        <div class="col-sm-10">{{$course->description}}</div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

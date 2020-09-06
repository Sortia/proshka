@extends('layouts.app')

@section('js')
    <script src="{{asset('js/course_show.js')}}" defer></script>
@endsection

@section('content')
    <div class="container-fluid px-5">
        <div class="row page-header no-gutters"><h3 class="page-title">@lang('Tasks') {{$course->name}}</h3></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($course->lessons->sortBy('order_number') as $lesson)
                                @if($course->isBought())
                                    <a href="{{route('lesson.show', $lesson)}}" data-lesson_name="{{$lesson->name}}" data-lesson_id="{{$lesson->id}}" class="list-group-item @unless($lesson->user) buy-course-link @endunless list-group-item-action @unless($lesson->available()) disabled @endunless">
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
                    @unless($course->isBought())
                    <div class="card-footer py-2">
                        <span>
                            <a href="{{route('course.buy', $course)}}" class="btn btn-sm btn-success float-right">@lang('Buy')</a>
                        </span>
                    </div>
                    @endunless
                </div>
            </div>
        </div>
    </div>

@endsection

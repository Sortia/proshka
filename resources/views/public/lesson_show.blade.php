@extends('layouts.app')

@section('js')
    <script src="{{asset('js/lesson_show.js')}}?v={{config('app.version')}}" defer></script>
@endsection

@section('css')
    <link href="{{asset('libraries/quilljs/quill.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid px-5">
        <div class="row page-header no-gutters"><h3 class="page-title">{{$lesson->name}}</h3></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="description">{{$lesson->description}}</div>
                        <hr>
                        <div class="text">{{$lesson->text}}</div>
                        <div class="task ql-editor">{!! $lesson->printTask() !!}</div>
                        <div class="files">
                            @foreach($lesson->files as $file)
                                <a href="{{route('file.show', $file)}}">{{$file->name}}</a>
                            @endforeach
                        </div>

                        @if($lesson->test && $lesson->user->status === 'active')
                            <div class="row justify-content-center">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                                    <a href="{{route('test.show', $lesson->test)}}"
                                       class="btn btn-outline-primary btn-block">Ответить на вопросы и подтвердить выполнение задания</a>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if($lesson->user and $lesson->user->status === 'active')
                        <div class="card-footer py-2">
                        <span>
                            @if($lesson->test)
                                <button id="refuse_task" class="btn btn-sm btn-danger float-right">@lang('Отказаться от задания')</button>
                            @else
                                <button id="complete_task" class="btn btn-sm btn-success float-right ml-3">@lang('Сдать задание')</button>
                            @endif
                        </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection



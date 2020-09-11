@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('libraries/dropzone/dropzone.css')}}">
@endsection

@section('js')
    <script src="{{asset('libraries/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('js/test.js')}}" defer></script>
@endsection

@section('content')
    <div class="container-fluid px-5">
        <div class="row page-header no-gutters"><h3 class="page-title">@lang('Test')</h3></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <div id="carouselExampleControls" data-keyboard="false" data-wrap="false" data-interval="false"
                             class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($test->questions as $question)
                                    <div class="carousel-item @if ($loop->first) active @endif">
                                        <fieldset @unless($question->isActive()) disabled @endunless>
                                            <div class="test-item @if($loop->last) final @endif">
                                                <input type="hidden" class="answer_type" value="{{$question->type}}">
                                                <input type="hidden" class="question_id" value="{{$question->id}}">
                                                <input type="hidden" class="is_active"
                                                       value="{{$question->isActive()}}">
                                                <input type="hidden" class="question_user_id"
                                                       value="{{$question->user->id ?? ''}}">
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                    <div class="form-group mb-0">
                                                        {{$question->question}}
                                                    </div>
                                                        <div class="form-group mb-0">
                                                            @foreach($question->files as $file)
                                                                <a href="{{route('file.show', $file)}}">{{$file->name}}</a>
                                                                <br>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="container-fluid">

                                                        @switch($question->type)
                                                            @case('select')
                                                            @include('public.components.question_select')
                                                            @break
                                                            @case('text')
                                                            @include('public.components.question_text')
                                                            @break
                                                        @endswitch
                                                        <div class="teacher-comment mt-3">
                                                            {{$question->user->comment ?? ''}}
                                                        </div>
                                                        <div class="teacher_files mt-3">
                                                            @if($question->user->teacherFiles ?? false)
                                                                @foreach($question->user->teacherFiles as $file)
                                                                    <a href="{{route('file.show', $file)}}">{{$file->name}}</a>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        @if($question->accept_file)
                                                            <div class="student_files">
                                                                @if($question->user->studentFiles ?? false)
                                                                    @foreach($question->user->studentFiles as $file)
                                                                        <a href="{{route('file.show', $file)}}">{{$file->name}}</a>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="files mt-3">
                                                                <div class="dropzone"
                                                                     @unless($question->isActive()) data-disable="true" @endunless></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>
                                @endforeach
                                <div class="carousel-item">
                                    <div class="test-item">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                                                <div class="m-5"><h1 class="text-center text-uppercase">Тест пройден!</h1></div>
                                                <a href="{{route('tasks', $test->lesson->course)}}"
                                                   class="btn btn-primary btn-block">@lang('Next')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer py-2">
                        <a class="btn btn-primary btn-sm float-right text-white" id="save_answer"
                           role="button"
                           data-slide="next">
                            @lang('Next')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

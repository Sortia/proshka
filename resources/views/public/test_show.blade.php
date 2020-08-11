@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('libraries/dropzone/dropzone.css')}}">
@endsection

@section('js')
    <script src="{{asset('libraries/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('js/test.js')}}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-header">@lang('Test')</div>

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
                                            <input type="hidden" class="is_active" value="{{$question->isActive()}}">

                                            <div class="form-group">
                                                {{$question->question}}
                                            </div>

                                            <div class="form-group">
                                                @foreach($question->files as $file)
                                                    <a href="{{route('file.show', $file)}}">{{$file->name}}</a><br>
                                                @endforeach
                                            </div>

                                            @switch($question->type)
                                                @case('select')
                                                @include('public.components.question_select')
                                                @break
                                                @case('text')
                                                @include('public.components.question_text')
                                                @break
                                            @endswitch

                                            @if($question->accept_file)
                                                <hr>
                                                <div class="files">
                                                    <div class="dropzone" @unless($question->isActive()) data-disable="true" @endunless></div>
                                                </div>
                                            @endif
                                        </div>

                                    </fieldset>
                                    </div>
                                @endforeach
                                <div class="carousel-item">
                                    <div class="test-item">
                                        <div class="m-5"><h1 class="text-center text-uppercase">Тест пройден!</h1></div>
                                        <a href="{{route('course.show', $test->lesson->course)}}" class="btn btn-primary btn-block">@lang('Next')</a>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-primary btn-sm float-right mt-2 text-white" id="save_answer"
                               role="button"
                               data-slide="next">
                                @lang('Next')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

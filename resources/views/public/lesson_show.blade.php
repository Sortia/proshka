@extends('layouts.app')

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

                        @if($lesson->test)
                            <div class="row justify-content-center">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                                    <a href="{{route('test.show', $lesson->test)}}"
                                       class="btn btn-outline-primary btn-block">Перейти к выполнению теста</a>
                                </div>
                            </div>
                        @endif

                        {{--                        <fieldset @if(Gate::denies('update', $lesson->user   )) disabled @endif>--}}

                        {{--                            <div class="answer mt-5">--}}
                        {{--                                <h5>@lang('Answer')</h5>--}}
                        {{--                                <form action="{{route('lesson.complete', $lesson)}}" method="post"--}}
                        {{--                                      enctype="multipart/form-data">--}}
                        {{--                                    @csrf--}}
                        {{--                                    <textarea name="text" id="text" class="form-control"--}}
                        {{--                                              rows="10">{{$lesson->user->text ?? ''}}</textarea>--}}
                        {{--                                    @foreach($lesson->user->files as $file)--}}
                        {{--                                        <a href="{{route('file.show', $file)}}">{{$file->name}}</a><br>--}}
                        {{--                                    @endforeach--}}
                        {{--                                    <div class="custom-file mt-3">--}}
                        {{--                                        <input type="file" class="custom-file-input change-file-input" id="file"--}}
                        {{--                                               name="file">--}}
                        {{--                                        <label id="file-label" class="custom-file-label"--}}
                        {{--                                               for="customFile">@lang('Choose file')</label>--}}
                        {{--                                    </div>--}}
                        {{--                                    <button class="btn btn-success mt-3 float-right">@lang('Send')</button>--}}
                        {{--                                </form>--}}
                        {{--                            </div>--}}
                        {{--                        </fieldset>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



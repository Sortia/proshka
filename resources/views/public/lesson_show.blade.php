@extends('layouts.app')

@section('css')
    <link href="{{asset('libraries/quilljs/quill.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-header">{{$lesson->name}}</div>

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

                        <a href="{{route('test.show', $lesson->test)}}" class="btn btn-outline-primary btn-block">@lang('Test')</a>

                        <fieldset @if(Gate::denies('update', $lessonUser)) disabled @endif>

                            <div class="answer mt-5">
                                <h5>@lang('Answer')</h5>
                                <form action="{{route('lesson.complete', $lesson)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <textarea name="text" id="text" class="form-control"
                                              rows="10">{{$lessonUser->text ?? ''}}</textarea>
                                    @foreach($lessonUser->files as $file)
                                        <a href="{{route('file.show', $file)}}">{{$file->name}}</a><br>
                                    @endforeach
                                    <div class="custom-file mt-3">
                                        <input type="file" class="custom-file-input change-file-input" id="file"
                                               name="file">
                                        <label id="file-label" class="custom-file-label"
                                               for="customFile">@lang('Choose file')</label>
                                    </div>
                                    <button class="btn btn-success mt-3 float-right">@lang('Send')</button>
                                </form>
                            </div>
                        </fieldset>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



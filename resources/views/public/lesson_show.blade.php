@extends('layouts.app')

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
                        <hr>
                        <div class="videos">
                            @foreach($lesson->videos->sortBy('type') as $video)
                                @if($video->type === 'file')
                                    <video controls width="100%">
                                        <source src="{{asset($video->path)}}">
                                    </video>
                                @else
                                    <a href="{{$video->path}}">{{$video->path}}</a>
                                @endif
                            @endforeach
                        </div>
                        <hr>
                        <div class="files">
                            @foreach($lesson->files as $file)
                                <a href="{{route('lesson.file', $file)}}">{{$file->name}}</a>
                            @endforeach
                        </div>
                        <fieldset @if(Gate::allows('is_teacher') or Gate::denies('update', $lessonUser)) disabled @endif>

                            <div class="answer mt-5">
                                <h3>Answer</h3>
                                <form action="{{route('lesson.complete', $lesson)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <textarea name="text" id="text" class="form-control"
                                              rows="10">{{$lessonUser->text ?? ''}}</textarea>
                                    @foreach($lessonUser->files as $file)
                                        <a href="{{route('lesson.file', $file)}}">{{$file->name}}</a><br>
                                    @endforeach
                                    @if(Gate::allows('is_student'))
                                        <div class="custom-file mt-3">
                                            <input type="file" class="custom-file-input" id="file" name="file">
                                            <label id="file-label" class="custom-file-label" for="customFile">Choose
                                                file</label>
                                        </div>
                                        <button class="btn btn-success mt-3 float-right">@lang('Send')</button>
                                    @endif
                                </form>
                            </div>
                        </fieldset>

                        @if(Gate::allows('is_teacher'))
                            <div class="mt-3">
                                <form action="{{route('teacher.lesson.wrong', $lessonUser)}}" method="post">
                                    @csrf
                                    <button class="btn-danger btn float-left">@lang('Wrong')</button>
                                </form>
                                <form action="{{route('teacher.lesson.right', $lessonUser)}}" method="post">
                                    @csrf
                                    <button class="btn-success btn float-right">@lang('Right')</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


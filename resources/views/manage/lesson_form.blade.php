@extends('layouts.app')

@section('css')
    <link href="{{asset('libraries/quilljs/quill.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('libraries/dropzone/dropzone.css')}}">
@endsection

@section('js')
    <script src="{{asset('libraries/quilljs/quill.js')}}"></script>
    <script src="{{asset('js/editor.js')}}" defer></script>
    <script src="{{asset('js/manage_lesson.js')}}" defer></script>
    <script src="{{asset('js/manage_test.js')}}" defer></script>
    <script src="{{asset('libraries/dropzone/dropzone.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Lessons') }}
                        <span><button id="create_lesson" data-toggle="modal" data-target="#createLessonModal"
                                      class="btn btn-sm btn-success float-right">@lang('Create')</button></span>
                    </div>

                    <div class="card-body">
                        <form action="{{route('manage.lesson.index')}}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group mt-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@lang('Direction')</span>
                                        </div>
                                        <select name="direction_id" id="search_direction_id"
                                                class="form-control input-lg">
                                            <option>@lang('Select direction')</option>
                                            @foreach($directions as $direction)
                                                <option @if(request()->direction_id == $direction->id) selected
                                                        @endif value="{{$direction->id}}">{{$direction->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group mt-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@lang('Course')</span>
                                        </div>
                                        <select name="course_id" id="search_course_id"
                                                class="form-control input-lg">
                                            <option>@lang('Select course')</option>
                                            @foreach($courses as $course)
                                                <option @if(request()->course_id == $course->id) selected
                                                        @endif value="{{$course->id}}">{{$course->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table class="table mt-3" data-toggle="table">
                            <thead>
                            <tr>
                                <th data-sortable="true" data-field="#">@lang('#')</th>
                                <th data-sortable="true" data-field="name">@lang('Name')</th>
                                <th data-sortable="true" data-field="complexity">@lang('Complexity')</th>
                                <th data-sortable="true" data-field="cost">@lang('Cost')</th>
                                <th data-sortable="true" data-field="bonus">@lang('Bonus')</th>
                                <th data-sortable="true" data-field="description">@lang('Description')</th>
                                <th data-sortable="true" data-field="available_at">@lang('Available at')</th>
                                <th data-sortable="true" data-field="actions">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lessons->sortBy('order_number') as $lesson)
                                <tr class="lesson_row" data-lesson_id="{{$lesson->id}}">
                                    <td class="row-order_number">{{$lesson->order_number}}</td>
                                    <td class="row-name">{{$lesson->name}}</td>
                                    <td class="row-complexity">{{$lesson->complexity}}</td>
                                    <td class="row-cost">{{$lesson->cost}}</td>
                                    <td class="row-bonus">{{$lesson->bonus}}</td>
                                    <td class="row-description">{{$lesson->description}}</td>
                                    <td class="row-available_at">{{$lesson->available_at}}</td>
                                    <td class="">
                                        <button class="btn btn-sm btn-outline-primary mt-1 edit-lesson">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                                <path fill-rule="evenodd"
                                                      d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm mt-1 btn-outline-primary edit-test" data-toggle="modal"
                                                data-target="#testModal">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                                <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary mt-1 set-politics" data-toggle="modal"
                                                data-target="#politicsModal">
                                            @if($lesson->constraints->isEmpty())
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-flag"
                                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                          d="M3.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z"/>
                                                    <path fill-rule="evenodd"
                                                          d="M3.762 2.558C4.735 1.909 5.348 1.5 6.5 1.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126a8.89 8.89 0 0 0 .593-.25c.058-.027.117-.053.18-.08.57-.255 1.278-.544 2.14-.544a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5c-.638 0-1.18.21-1.734.457l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 0 1 9 9.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916a.5.5 0 1 1-.515-.858C4.735 7.909 5.348 7.5 6.5 7.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126.187-.068.376-.153.593-.25.058-.027.117-.053.18-.08.456-.204 1-.43 1.64-.512V2.543c-.433.074-.83.234-1.234.414l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 0 1 9 3.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916a.5.5 0 0 1-.554-.832l.04-.026z"/>
                                                </svg>
                                            @else
                                                <svg width="1em" height="1em" viewBox="0 0 16 16"
                                                     class="bi bi-flag-fill" fill="currentColor"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                          d="M3.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z"/>
                                                    <path fill-rule="evenodd"
                                                          d="M3.762 2.558C4.735 1.909 5.348 1.5 6.5 1.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126a8.89 8.89 0 0 0 .593-.25c.058-.027.117-.053.18-.08.57-.255 1.278-.544 2.14-.544a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5c-.638 0-1.18.21-1.734.457l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 0 1 9 9.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916A.5.5 0 0 1 3.5 9V3a.5.5 0 0 1 .223-.416l.04-.026z"/>
                                                </svg>
                                            @endif
                                        </button>

                                        <button class="btn btn-sm btn-outline-primary mt-1 set-files" data-toggle="modal"
                                                data-target="#filesModal">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-files"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M3 2h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3z"/>
                                                <path
                                                    d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/>
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger mt-1 delete-lesson">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd"
                                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('manage.modals.create_lesson')
    @include('manage.modals.lesson_files')
    @include('manage.modals.lesson_politics')
    @include('manage.modals.lesson_test')
@endsection

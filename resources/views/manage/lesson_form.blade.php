@extends('layouts.app')

@section('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="{{asset('js/editor.js')}}" defer></script>
    <script src="{{asset('js/manage_lesson.js')}}" defer></script>
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
                        <div class="col-lg-12">
                            <form action="{{route('manage.lesson.index')}}" method="get">
                                @csrf
                                <div class="row">

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">@lang('Course')</span>
                                        </div>
                                        <select name="course_id" id="search_course_id"
                                                class="form-control select2-enable input-lg">
                                            <option>@lang('Select course')</option>
                                            @foreach($courses as $course)
                                                <option value="{{$course->id}}">{{$course->name}}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-primary ml-3">@lang('Search')</button>

                                    </div>
                                </div>
                            </form>
                        </div>

                        <br>
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th scope="col">@lang('#')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Complexity')</th>
                                <th scope="col">@lang('Cost')</th>
                                <th scope="col">@lang('Bonus')</th>
                                <th scope="col">@lang('Description')</th>
                                <th scope="col">@lang('Task')</th>
                                <th scope="col">@lang('Available at')</th>
                                <th scope="col">@lang('Time')</th>
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lessons->sortBy('order_number') as $lesson)
                                <tr class="lesson_row" data-lesson_id="{{$lesson->id}}">
                                    <th class="row-order_number" scope="row">{{$lesson->order_number}}</th>
                                    <th class="row-name" scope="row">{{$lesson->name}}</th>
                                    <th class="row-complexity" scope="row">{{$lesson->complexity}}</th>
                                    <th class="row-cost" scope="row">{{$lesson->cost}}</th>
                                    <th class="row-bonus" scope="row">{{$lesson->bonus}}</th>
                                    <th class="row-description" scope="row">{{$lesson->description}}</th>
                                    <th scope="row">
                                        <button data-toggle="modal" data-target="#createLessonTaskModal"
                                                class="add_task btn btn-sm btn-outline-primary">+
                                        </button>
                                    </th>
                                    <th class="row-available_at" scope="row">{{$lesson->available_at}}</th>
                                    <th class="row-time" scope="row">{{$lesson->time}}</th>
                                    <th class="row-time" scope="row">
                                        <button
                                            class="btn btn-sm btn-outline-primary edit-lesson">@lang('Edit')</button>
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createLessonModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form action="{{route('manage.lesson.store')}}" method="post">
                    @csrf
                    <input type="hidden" id="course_id" name="course_id">
                    <input type="hidden" id="id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('Lesson')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="name">@lang('Name')</label>
                                    <input required type="text" class="form-control" id="name" name="name"
                                           placeholder="@lang('Enter name')">
                                </div>
                                <div class="col-lg-6">
                                    <label for="description">@lang('Description')</label>
                                    <input required type="text" class="form-control" id="description" name="description"
                                           placeholder="@lang('Enter description')">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-4">
                                    <label for="complexity">@lang('Complexity')</label>
                                    <input required type="number" class="form-control" id="complexity" name="complexity"
                                           placeholder="@lang('Enter complexity')">
                                </div>
                                <div class="col-lg-4">
                                    <label for="cost">@lang('Cost')</label>
                                    <input required type="number" class="form-control" id="cost" name="cost"
                                           placeholder="@lang('Enter cost')">
                                </div>
                                <div class="col-lg-4">
                                    <label for="bonus">@lang('Bonus')</label>
                                    <input required type="number" class="form-control" id="bonus" name="bonus"
                                           placeholder="@lang('Enter bonus')">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12">
                                    <label for="text">@lang('Theory')</label>
                                    <textarea rows="8" class="form-control" id="text" name="text"></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-4">
                                    <label for="available_at">@lang('Available at')</label>
                                    <input required type="number" class="form-control" id="available_at"
                                           name="available_at"
                                           placeholder="@lang('Enter available at')">
                                </div>
                                <div class="col-lg-4">
                                    <label for="time">@lang('Time')</label>
                                    <input required type="number" class="form-control" id="time" name="time"
                                           placeholder="@lang('Enter time')">
                                </div>
                                <div class="col-lg-4">
                                    <label for="order_number">@lang('Order number')</label>
                                    <input required type="number" class="form-control" id="order_number"
                                           name="order_number"
                                           placeholder="@lang('Enter order number')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button class="btn btn-primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createLessonTaskModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Task')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Create the editor container -->
                    <div id="editor"></div>
                    <input type="hidden" id="task_lesson_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button id="save_task" type="button" class="btn btn-primary">@lang('Save')</button>
                </div>
            </div>
        </div>
    </div>


@endsection

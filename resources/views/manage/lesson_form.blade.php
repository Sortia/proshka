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
                                                <option @if(request()->course_id == $course->id) selected
                                                        @endif value="{{$course->id}}">{{$course->name}}</option>
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
                                    <th class="row-available_at" scope="row">{{$lesson->available_at}}</th>
                                    <th class="row-time" scope="row">{{$lesson->time}}</th>
                                    <th class="" scope="row">
                                        <button data-toggle="modal" data-target="#createLessonTaskModal"
                                                class="add_task btn btn-sm btn-outline-primary">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-book"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M3.214 1.072C4.813.752 6.916.71 8.354 2.146A.5.5 0 0 1 8.5 2.5v11a.5.5 0 0 1-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 0 1 0 13.5v-11a.5.5 0 0 1 .276-.447L.5 2.5l-.224-.447.002-.001.004-.002.013-.006a5.017 5.017 0 0 1 .22-.103 12.958 12.958 0 0 1 2.7-.869zM1 2.82v9.908c.846-.343 1.944-.672 3.074-.788 1.143-.118 2.387-.023 3.426.56V2.718c-1.063-.929-2.631-.956-4.09-.664A11.958 11.958 0 0 0 1 2.82z"/>
                                                <path fill-rule="evenodd"
                                                      d="M12.786 1.072C11.188.752 9.084.71 7.646 2.146A.5.5 0 0 0 7.5 2.5v11a.5.5 0 0 0 .854.354c.843-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.276-.447L15.5 2.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 0 0-.799-.34 12.96 12.96 0 0 0-2.073-.609zM15 2.82v9.908c-.846-.343-1.944-.672-3.074-.788-1.143-.118-2.387-.023-3.426.56V2.718c1.063-.929 2.631-.956 4.09-.664A11.956 11.956 0 0 1 15 2.82z"/>
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary edit-lesson">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                                <path fill-rule="evenodd"
                                                      d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                            </svg>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary set-politics" data-toggle="modal"
                                                data-target="#politicsModal">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-command"
                                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M2 3.5A1.5 1.5 0 0 0 3.5 5H5V3.5a1.5 1.5 0 1 0-3 0zM6 6V3.5A2.5 2.5 0 1 0 3.5 6H6zm8-2.5A1.5 1.5 0 0 1 12.5 5H11V3.5a1.5 1.5 0 0 1 3 0zM10 6V3.5A2.5 2.5 0 1 1 12.5 6H10zm-8 6.5A1.5 1.5 0 0 1 3.5 11H5v1.5a1.5 1.5 0 0 1-3 0zM6 10v2.5A2.5 2.5 0 1 1 3.5 10H6zm8 2.5a1.5 1.5 0 0 0-1.5-1.5H11v1.5a1.5 1.5 0 0 0 3 0zM10 10v2.5a2.5 2.5 0 1 0 2.5-2.5H10z"/>
                                                <path fill-rule="evenodd" d="M10 6H6v4h4V6zM5 5v6h6V5H5z"/>
                                            </svg>
                                        </button>
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

    <div class="modal fade" id="politicsModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Politics')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">Задания:</div>
                    </div>
                    <div class="offset-1">
                        <div id="policy_lesson_list" class="row my-3 ml-3"></div>
                    </div>
                    <p>Доступны при:</p>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@lang('Direction')</span>
                                </div>
                                <select id="policy_constraint_direction_id"
                                        class="form-control input-lg">
                                    <option value="">@lang('Select direction')</option>
                                    @foreach($directions as $direction)
                                        <option value="{{$direction->id}}">{{$direction->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@lang('Direction')</span>
                                </div>
                                <select name="course_id" id="policy_constraint_course_id"
                                        class="form-control input-lg direction-select"></select>
                            </div>
                        </div>
                    </div>
                    <div class="offset-1">
                        <div id="policy_constraint_lesson_list" class="row my-3 ml-3"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button id="save_policy" type="button" class="btn btn-primary">@lang('Save')</button>
                    </div>
                </div>
            </div>
        </div>


@endsection

@extends('layouts.app')

@section('css')
    <link href="{{asset('libraries/quilljs/quill.css')}}" rel="stylesheet">
@endsection

@section('js')
    <script src="{{asset('libraries/quilljs/quill.js')}}"></script>
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
                        <form action="{{route('manage.lesson.index')}}" method="get">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">@lang('Direction')</span>
                                        </div>
                                        <select name="direction_id" id="search_direction_id"
                                                class="form-control select2-enable input-lg">
                                            <option>@lang('Select direction')</option>
                                            @foreach($directions as $direction)
                                                <option @if(request()->direction_id == $direction->id) selected
                                                        @endif value="{{$direction->id}}">{{$direction->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
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

                                <th class="d-none" data-sortable="true" data-field="theory">@lang('Theory')</th>
                                <th class="d-none" data-sortable="true" data-field="time">@lang('Time')</th>
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
                                            @if($lesson->constraints->isEmpty())
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-flag" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M3.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z"/>
                                                <path fill-rule="evenodd" d="M3.762 2.558C4.735 1.909 5.348 1.5 6.5 1.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126a8.89 8.89 0 0 0 .593-.25c.058-.027.117-.053.18-.08.57-.255 1.278-.544 2.14-.544a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5c-.638 0-1.18.21-1.734.457l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 0 1 9 9.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916a.5.5 0 1 1-.515-.858C4.735 7.909 5.348 7.5 6.5 7.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126.187-.068.376-.153.593-.25.058-.027.117-.053.18-.08.456-.204 1-.43 1.64-.512V2.543c-.433.074-.83.234-1.234.414l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 0 1 9 3.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916a.5.5 0 0 1-.554-.832l.04-.026z"/>
                                            </svg>
                                            @else
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-flag-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M3.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z"/>
                                                    <path fill-rule="evenodd" d="M3.762 2.558C4.735 1.909 5.348 1.5 6.5 1.5c.653 0 1.139.325 1.495.562l.032.022c.391.26.646.416.973.416.168 0 .356-.042.587-.126a8.89 8.89 0 0 0 .593-.25c.058-.027.117-.053.18-.08.57-.255 1.278-.544 2.14-.544a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5c-.638 0-1.18.21-1.734.457l-.159.07c-.22.1-.453.205-.678.287A2.719 2.719 0 0 1 9 9.5c-.653 0-1.139-.325-1.495-.562l-.032-.022c-.391-.26-.646-.416-.973-.416-.833 0-1.218.246-2.223.916A.5.5 0 0 1 3.5 9V3a.5.5 0 0 1 .223-.416l.04-.026z"/>
                                                </svg>
                                            @endif
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-lesson">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="row-text d-none">{{$lesson->text}}</td>
                                    <td class="row-time d-none">{{$lesson->time}}</td>
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
                                    <input step="0.01" required type="number" class="form-control" id="complexity"
                                           name="complexity"
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

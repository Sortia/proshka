@extends('layouts.app')

@section('js')
    <script src="{{asset('js/tasks.js')}}?v={{config('app.version')}}" defer></script>
@endsection

@section('content')
    <div class="container px-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row page-header no-gutters"><h3 class="page-title">@lang('Tasks')</h3></div>
                <div class="card">
                    <div class="card-body">

                        <div class="form-row align-items-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="input-group mt-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('Direction')</span>
                                    </div>
                                    <select name="direction_id" id="direction_id"
                                            class="form-control input-lg">
                                        <option value="">@lang('Select direction')</option>
                                        @foreach($directions as $direction)
                                            <option value="{{$direction->id}}">{{$direction->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-md-2 pl-lg-3">
                                <div class="custom-control custom-radio custom-control-inline my-1">
                                    <input type="radio" id="customRadioInline1" value="new" name="task_type"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline1">Только
                                        новые</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input checked type="radio" id="customRadioInline2" value="all" name="task_type"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline2">Все задания</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline my-1 pl-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="my_courses">
                                        <label class="form-check-label" for="my_courses">
                                            Мои курсы
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table
                            class="mt-3"
                            id="table"
                            data-locale="ru-RU"
                            data-undefined-text="-"
                            data-toggle="table"
                            data-row-style="rowStyle"
                            data-id-field="id">
                            <thead>
                            <tr>
                                <th data-field="id" data-class='hidden id' >#</th>
                                <th data-field="name" data-class="name">@lang('Name')</th>
                                <th data-field="course.name">@lang('Course')</th>
                                <th data-field="complexity">@lang('Complexity')</th>
                                <th data-sortable="true" data-field="cost">@lang('Cost')</th>
                                <th data-field="bonus">@lang('Bonus')</th>
                                <th data-formatter="statusFormatter" data-field="user.status">@lang('Status')</th>
                            </tr>
                            </thead>
                        </table>
                        <span class="float-right mt-3">Количество заданий: <span class="count-rows"></span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    function rowStyle(row) {

        let classes = [];

        if (!row.is_available) {
            classes.push('cursor-link unavailable_lesson')
        } else if (row.user) {
            classes.push('cursor-link bought')
        } else {
            classes.push('cursor-link')
        }

        return {
            classes: classes
        }
    }

    function statusFormatter(value) {
        if (!value)
            return '-'

        return trans.get('__JSON__.' + value);
    }
</script>

<style>
    .unavailable_lesson {
        background-color: #f6f3f3;
    }

    .hidden{
        display:none;
        visibility:hidden;
    }

    .cursor-link {
        cursor: pointer;
    }
</style>

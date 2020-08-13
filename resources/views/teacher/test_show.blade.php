@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('libraries/dropzone/dropzone.css')}}">
@endsection

@section('js')
    <script src="{{asset('js/question_list.js')}}" defer></script>
    <script src="{{asset('libraries/dropzone/dropzone.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-header">@lang('Tests')</div>

                    <div class="card-body">
                            <div class="sort_fields row">
                                <div class="col-lg-3 col-sm-6 mt-2">
                                    <select class="custom-select searchable" id="direction_id">
                                        @foreach($directions as $direction)
                                            <option value="{{$direction->id}}">{{$direction->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-sm-6 mt-2">
                                    <select class="custom-select searchable" id="course_id">
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4 mt-2">
                                    <select class="custom-select searchable" id="status">
                                        <option value="verified">Проверенные</option>
                                        <option selected value="not_verified">Не проверенные</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4 mt-2">
                                    <select class="custom-select searchable" id="date">
                                        <option selected value="oldest">Старые (по дате)</option>
                                        <option value="latest">Свежие (по дате)</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control searchable" id="search" placeholder="Search">
                                    </div>
                                </div>
                            </div>
                            <div class="answers row"></div>
                        @include('teacher.modals.question')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2 h5">
                        <span>@lang('Create course')</span>
                    </div>
                    <div class="card-body">
                        <form action="{{route('course.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$course->id ?? ''}}">

                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$course->name ?? ''}}" placeholder="@lang('Enter course name')">
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <input type="text" class="form-control" id="description" name="description" value="{{$course->description ?? ''}}" placeholder="@lang('Enter description')">
                            </div>

                            <div class="form-group">
                                <label for="description">@lang('Direction')</label>
                                <select name="direction_id" id="direction_id" class="form-control select2-enable input-lg">
                                    @foreach($directions as $direction)
                                        <option value="{{$direction->id}}">{{$direction->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <a href="{{route('direction.edit', $direction)}}"><button type="button" class="btn btn-secondary  float-left">@lang('Back')</button></a>
                            <button type="submit" class="btn btn-primary  float-right">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

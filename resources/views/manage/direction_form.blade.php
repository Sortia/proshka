@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2 h5">
                        <span>@lang('Direction')</span>
                    </div>
                    <div class="card-body">
                        <form action="{{route('manage.direction.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$direction->id ?? ''}}">
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$direction->name ?? ''}}" placeholder="@lang('Enter direction name')">
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <input type="text" class="form-control" id="description" name="description"  value="{{$direction->description ?? ''}}" placeholder="@lang('Enter description')">
                            </div>
                            <a href="{{route('manage.direction.index')}}"><button type="submit" class="btn btn-secondary float-left">@lang('Back')</button></a>
                            <button type="submit" class="btn btn-primary float-right">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

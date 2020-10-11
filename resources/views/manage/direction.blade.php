@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2 h5">
                        <span>@lang('Directions')</span>
                        <span><a href="{{route('manage.direction.create')}}" class="btn btn-sm btn-success float-right">@lang('Create')</a></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">@lang('#')</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Description')</th>
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($directions as $direction)
                                <tr>
                                    <th scope="row">{{$direction->order}}</th>
                                    <td>{{$direction->name}}</td>
                                    <td>{{$direction->description}}</td>
                                    <td>
                                        <a href="{{route('manage.direction.edit', $direction)}}">
                                        <button class="btn btn-primary btn-sm">@lang('Show')</button></a>
                                        <form class="d-inline" method="post" action="{{route('manage.direction.destroy', ['direction' => $direction->id])}}">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm">@lang('Delete')</button>
                                        </form>
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
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2 h5">
                        <span>@lang('Directions')</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Description')</th>
                                <th scope="col">@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($directions as $direction)
                                <tr>
                                    <td>{{$direction->name}}</td>
                                    <td>{{$direction->description}}</td>
                                    <td>
                                        <a href="{{route('direction.show', $direction)}}">
                                            <button class="btn btn-primary btn-sm">@lang('Show')</button>
                                        </a>
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

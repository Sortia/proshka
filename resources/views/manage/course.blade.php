@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-2 h5">
                        <span>@lang('Courses')</span>
                        <span><a href="{{route('manage.course.create')}}"
                                 class="btn btn-sm btn-success float-right">@lang('Create')</a></span>
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
                            @foreach($courses as $course)
                                <tr>
                                    <th scope="row">{{$course->id}}</th>
                                    <td>{{$course->name}}</td>
                                    <td>{{$course->description}}</td>
                                    <td>
                                        <a href="{{route('manage.course.edit', $course)}}"><button class="btn btn-sm btn-primary">@lang('Show')</button></a>
                                        <form class="d-inline" method="post" action="{{route('manage.course.destroy', ['course' => $course->id])}}">
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

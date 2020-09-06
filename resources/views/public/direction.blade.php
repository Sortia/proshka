@extends('layouts.app')

@section('content')
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row page-header no-gutters"><h3 class="page-title">@lang('Directions')</h3></div>
                <div class="card">
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($directions as $direction)
                                <a href="{{route('direction.show', $direction)}}" class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-sm-2">{{$direction->name}}</div>
                                        <div class="col-sm-10">{{$direction->description}}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

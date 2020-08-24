@extends('layouts.app')

@section('js')
    <script src="{{asset('libraries/maskedinput/maskedinput.min.js')}}" defer></script>
    <script src="{{asset('js/registration.js')}}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-xl-8">
                <div class="card">
                    <div class="card-header">{{ __('auth.register') }}</div>

                    <div class="card-body">
                        <registration></registration>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if($errors->hasBag())
    <div class="container">
        <div class="alert alert-danger col-lg-12" role="alert">
            @foreach($errors->getBag('default')->all() as $error)
                {{$error}}<br>
            @endforeach
        </div>
    </div>
@endif

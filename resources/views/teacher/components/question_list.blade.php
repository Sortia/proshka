@foreach($lessonUserList as $lessonUser)
    <div class="card card-body col-lg-12 my-2 mx-3" id="lesson_user_{{$lessonUser->id}}">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">@lang('Direction')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="col-form-label" disabled
                       value="{{$lessonUser->lesson->course->direction->name}}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">@lang('Course')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="col-form-label" disabled
                       value="{{$lessonUser->lesson->course->name}}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">@lang('Task')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="col-form-label" disabled
                       value="{{$lessonUser->lesson->name}}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">@lang('Student')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="col-form-label" disabled
                       value="{{$lessonUser->user->fullName()}}">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-sm btn-primary float-right show_answer" data-lesson_user_id="{{$lessonUser->id}}" data-toggle="modal"
                        data-target="#checkAnswer">@lang('Show')</button>
            </div>
        </div>
    </div>
@endforeach
<div class="col-lg-12 mt-2">
    <nav class="float-right">
        {{ $lessonUserList->links() }}
    </nav>
</div>

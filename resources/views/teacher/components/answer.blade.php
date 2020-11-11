@foreach($questionUserList as $questionUser)
    <fieldset id="question_user_fieldset_{{$questionUser->id}}" @unless(in_array($questionUser->status, ['complete', 'wrong'])) disabled @endunless>

    <div class="question_user_card" data-question_user_id="{{$questionUser->id}}" id="question_user_{{$questionUser->id}}">
        <div class="form-group">
            <label>@lang('Question'):</label>
            <div class="question">{{$questionUser->question->question}}</div>
        </div>
        <hr>
        <div class="form-group">
            <label>@lang('Hint to the answer'):</label>
            <div class="question">{{$questionUser->question->hint}}</div>
        </div>
        <hr>
        <div class="files mt-3"></div>
        <div class="form-group">
            <label>@lang('Answer'):</label>
            <div class="answer">

                @switch($questionUser->question->type)
                    @case('select')
                    @foreach($questionUser->question->answers as $answer)
                        <div class="form-row align-items-center answer">
                            <div class="col">
                                <input disabled type="text" class="form-control mb-2 answer_text
                                @if(in_array($answer->id, $questionUser->answer_id))
                                    @if($answer->is_right) is-valid @else is-invalid @endif
                                @endif"
                                       value="{{$answer->text}}">
                            </div>
                        </div>
                    @endforeach
                    @break
                    @case('select_many')
                    @foreach($questionUser->question->answers as $answer)
                        <div class="form-row align-items-center answer">
                            <div class="col">
                                <input disabled type="text" class="form-control mb-2 answer_text
                                @if(in_array($answer->id, $questionUser->answer_id))
                                    @if($answer->is_right) is-valid @else is-invalid @endif
                                @endif"
                                    value="{{$answer->text}}">
                            </div>
                        </div>
                    @endforeach
                    @break

                    @case('text')
                    <div class="answer">{{$questionUser->text}}</div>
                    @break
                @endswitch

                <div class="files">
                    @foreach($questionUser->studentFiles as $file)
                        <a href="{{route('file.show', $file)}}">{{$file->name}}</a><br>
                    @endforeach
                </div>

            </div>
        </div>
        <hr>
        <div class="row">
            <div class="teacherFiles col-lg-12">
                <label>@lang('Comment'):</label><br>
                @foreach($questionUser->teacherFiles as $file)
                    <a href="{{route('file.show', $file)}}">{{$file->name}}</a><br>
                @endforeach
            </div>
            @if($questionUser->status === 'complete')
                <div class="col-lg-12">
                    <div class="dropzone"></div>
                </div>
            @endif
            <div class="col-lg-12 mt-3">
            <textarea
                placeholder="Укажите причину отправки задания на доработку, отзыва задания ил похвалите ученика за прекрасно выполненное задание"
                class="form-control comment" rows="3">{{$questionUser->comment}}</textarea>
            </div>
        </div>
{{--        <div class="row mt-2">--}}
{{--            <div class="col-lg-3">--}}
{{--                <button class="btn btn-block btn-dark float-right rework_question"--}}
{{--                        data-question_user_id="{{$questionUser->id}}"--}}
{{--                        data-status="rework">@lang('Send for rework')</button>--}}
{{--            </div>--}}

{{--            <div class="col-lg-6"></div>--}}
{{--            <div class="col-lg-3">--}}
{{--                <button class="btn btn-block btn-success float-left accept_question"--}}
{{--                        data-question_user_id="{{$questionUser->id}}"--}}
{{--                        data-status="right">@lang('Accept')</button>--}}
{{--            </div>--}}
{{--        </div>--}}
        <hr>
    </div>
    </fieldset>
@endforeach





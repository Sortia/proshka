@foreach($questionUserList as $questionUser)
    <fieldset @unless($questionUser->status === 'complete') disabled @endunless>

    <div id="question_user_{{$questionUser->id}}">
        <div class="form-group">
            <label>@lang('Question')</label>
            <div class="question">{{$questionUser->question->question}}</div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">@lang('Status')</label>
            <div class="col-sm-9">
                <input type="text" class="form-control status" disabled
                <input type="text" class="form-control status" disabled
                       value="{{__(Str::ucfirst($questionUser->status))}}">
            </div>
        </div>

        <div class="files mt-3"></div>
        <div class="form-group">
            <label>@lang('Answer')</label>
            <div class="answer">

                @switch($questionUser->question->type)
                    @case('select')
                    @foreach($questionUser->question->answers as $answer)
                        <div class="form-row align-items-center answer">
                            <div class="col-auto">
                                <div class="form-check mb-2">
                                    <input style="pointer-events: none"
                                           @if($answer->id === $questionUser->answer_id) checked
                                           @endif class="form-check-input answer_right"
                                           type="radio"
                                           name="card_radio_{{$questionUser->question_id}}">
                                    <label class="form-check-label"></label>
                                </div>
                            </div>
                            <div class="col">
                                <input disabled type="text" class="form-control mb-2 answer_text
                    @if($answer->id === $questionUser->answer_id and !$answer->is_right) is-invalid @endif
                                @if($answer->is_right) is-valid @endif"
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
        <div class="row">
            <div class="col-lg-12 mt-3">
            <textarea
                placeholder="Укажите причину отправки задания на доработку, отзыва задания ил похвалите ученика за прекрасно выполненное задание"
                class="form-control comment" rows="3">{{$questionUser->comment}}</textarea>
            </div>
            <div class="teacherFiles col-lg-12 mt-3">
                @foreach($questionUser->teacherFiles as $file)
                    <a href="{{route('file.show', $file)}}">{{$file->name}}</a><br>
                @endforeach
            </div>
            @if($questionUser->status === 'complete')
            <div class="col-lg-12 mt-3">
                <div class="dropzone"></div>
            </div>
            @endif
        </div>
        <div class="row mt-2">
            <div class="col-lg-3">
                <button class="btn btn-block btn-dark float-right rework_question"
                        data-question_user_id="{{$questionUser->id}}"
                        data-status="rework">@lang('Send for rework')</button>
            </div>

            <div class="col-lg-6"></div>
            <div class="col-lg-3">
                <button class="btn btn-block btn-success float-left accept_question"
                        data-question_user_id="{{$questionUser->id}}"
                        data-status="right">@lang('Accept task')</button>
            </div>
        </div>
        <hr>
    </div>
    </fieldset>

@endforeach





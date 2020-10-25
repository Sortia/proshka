@foreach($questionUserList as $questionUser)
    <fieldset id="question_user_fieldset_{{$questionUser->id}}" @unless(in_array($questionUser->status, ['complete', 'wrong'])) disabled @endunless>

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
                            <div class="col-auto">
                                <span class="sort mr-4">
                            <input type="hidden" class="order_number" value="{{$question->order_number}}" data-question_id="{{$question->id}}">
                            <button type="button" class="btn btn-sm btn-outline-primary sort_up">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary sort_down">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                </svg>
                            </button>
                        </span>
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
            @if(in_array($questionUser->status, ['complete', 'wrong']))
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
                        data-status="right">@lang('Accept')</button>
            </div>
        </div>
        <hr>
    </div>
    </fieldset>

@endforeach





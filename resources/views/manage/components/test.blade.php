@foreach($lesson->test->questions ?? [] as $question)
    <div class="card answer-card card_question_id_{{$question->id}}" data-index="{{$question->id}}">
        <summary data-toggle="collapse" data-target="#answer_card_question_id_{{$question->id}}" aria-expanded="true">
            <div class="card-header">
                <h5 class="mb-0">
                    <span class="header-label">
                        {{\Illuminate\Support\Str::limit($question->question, 20, '...') ?: __('Task')}}
                    </span>
                    <span class="float-right">
                        <button class="btn btn-sm btn-outline-danger delete_question">Delete</button>
                    </span>
                </h5>
            </div>
        </summary>

        <div id="answer_card_question_id_{{$question->id}}" class="collapse pb-3" data-parent="#accordion">
            <div class="card-body">
                <div class="answer-card-content">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">@lang('Question text')</label>
                        <textarea class="form-control question" rows="3">{{$question->question}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>@lang('Answer type')</label>
                        <select class="form-control answer_type" name="type">
                            @foreach(\App\Constants\AnswerTypes::getList() as $id => $name)
                                <option @if($question->type === $id) selected @endif value="{{$id}}">{{__($name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="answer-cover" @if($question->type != \App\Constants\AnswerTypes::SELECT) style="display: none" @endif>
                        <hr>
                        <div class="template">
                            <div class="form-row align-items-center">
                                <div class="col mb-2">
                                    <button type="button"
                                            class="btn btn-outline-success add_answer float-right btn-sm">@lang('Add answer option')</button>
                                </div>
                            </div>
                        </div>
                        <div class="answers">
                            @foreach($question->answers as $answer)
                                <div class="form-row align-items-center answer">
                                    <div class="col-auto">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input answer_right" type="radio" @if($answer->is_right) checked @endif name="card_radio_answer_id_{{$question->id}}">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2 answer_text" data-answer_id="{{$answer->id}}" value="{{$answer->text}}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    <div class="files">
                        <div class="dropzone dropzone-files"></div>
                    </div>
                    <hr>
                    <div class="form-check mt-2">
                        <div class="float-left">
                            <input class="form-check-input attach_file_checkbox" type="checkbox" @if($question->accept_file) checked @endif>
                            <label class="form-check-label">
                                @lang('Ability to attach a file')
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

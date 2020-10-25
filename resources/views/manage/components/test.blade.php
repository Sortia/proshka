@if($lesson->test)
@foreach($lesson->test->questions->sortBy('order_number') ?? [] as $question)
    <div class="card answer-card card_question_id_{{$question->id}}" data-index="{{$question->id}}">
        <summary data-toggle="collapse" data-target="#answer_card_question_id_{{$question->id}}" aria-expanded="true">
            <div class="card-header">
                <h5 class="mb-0">
                    <span class="header-label">
                        {{\Illuminate\Support\Str::limit($question->question, 20, '...') ?: __('Task')}}
                    </span>
                    <span class="float-right">
                        <span class="sort mr-4">
                            <input type="hidden" class="order_number" value="{{$question->order_number}}" data-question_id="{{$question->id}}">
                            <button type="button" class="btn btn-sm btn-outline-primary sort_question_up">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                </svg>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary sort_question_down">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                </svg>
                            </button>
                        </span>
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
                            @if($question->type === \App\Constants\AnswerTypes::SELECT)
                            @foreach($question->answers->sortBy('order_number') as $answer)
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
                                    <div class="col-auto" style="height: 42px">
                                        <span class="sort">
                                            <input type="hidden" class="order_number" value="{{$question->order_number}}" data-question_id="{{$question->id}}">
                                            <button style="height: 35px" type="button" class="btn btn-sm btn-outline-primary sort_answer_up">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                                </svg>
                                            </button>
                                            <button style="height: 35px" type="button" class="btn btn-sm btn-outline-primary sort_answer_down">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="answer-cover-many" @if($question->type != \App\Constants\AnswerTypes::SELECT_MANY) style="display: none" @endif>
                        <hr>
                        <div class="template">
                            <div class="form-row align-items-center">
                                <div class="col mb-2">
                                    <button type="button"
                                            class="btn btn-outline-success add_answer_many float-right btn-sm">@lang('Add answer option')</button>
                                </div>
                            </div>
                        </div>
                        <div class="answers-many">
                            @if($question->type === \App\Constants\AnswerTypes::SELECT_MANY)
                            @foreach($question->answers->sortBy('order_number') as $answer)
                                <div class="form-row align-items-center answer">
                                    <div class="col-auto">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input answer_right" type="checkbox" @if($answer->is_right) checked @endif>
                                            <label class="form-check-label"></label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control mb-2 answer_text" data-answer_id="{{$answer->id}}" value="{{$answer->text}}">
                                    </div>
                                    <div class="col-auto" style="height: 42px">
                                        <span class="sort">
                                            <input type="hidden" class="order_number" value="{{$question->order_number}}" data-question_id="{{$question->id}}">
                                            <button style="height: 35px" type="button" class="btn btn-sm btn-outline-primary sort_answer_up">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                  <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                                </svg>
                                            </button>
                                            <button style="height: 35px" type="button" class="btn btn-sm btn-outline-primary sort_answer_down">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                  <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                            @endif
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
@endif

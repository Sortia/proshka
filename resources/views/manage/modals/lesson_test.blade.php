<div class="modal fade" id="testModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testModalLabel">@lang('Test')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" enctype="multipart/form-data" method="post">

                    <div class="test">
                        <div class="card card-body answer-card card_0 mb-3" data-index="0">
                            <div class="answer-card-content">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">@lang('Question text')</label>
                                    <textarea class="form-control question" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">@lang('Hint to the answer')</label>
                                    <textarea class="form-control hint" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Answer type')</label>
                                    <select class="form-control answer_type" name="type">
                                        @foreach(\App\Constants\AnswerTypes::getList() as $id => $name)
                                            <option value="{{$id}}">{{__($name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="answer-cover">
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

                                    </div>
                                </div>
                                <div class="answer-cover-many">
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

                                    </div>
                                </div>
                                <hr>
                                <div class="files">
                                    <div class="dropzone dropzone_question"></div>
                                </div>

                                <hr>
                                <div class="form-check mt-2">
                                    <div class="float-left">
                                        <input class="form-check-input attach_file_checkbox" type="checkbox">
                                        <label class="form-check-label">
                                            @lang('Ability to attach a file')
                                        </label>
                                    </div>
                                    <div class="float-right mb-1">
                                        <button type="button"
                                                class="btn btn-sm btn-success add_question">@lang('Add question')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="accordion"></div>
                        <div id="preview"></div>

                        <div class="modal-footer mt-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                            <button id="save_test" type="button" class="btn btn-primary">@lang('Save')</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

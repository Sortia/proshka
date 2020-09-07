<div class="modal fade" id="checkAnswer" tabindex="-1" role="dialog"
     aria-hidden="true">
    <input type="hidden" id="question_user_id">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <input type="hidden" id="course_id" name="course_id">
            <input type="hidden" id="id" name="id">
            <div class="modal-header p-2">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Task')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">@lang('Direction')</label>
                    <div class="col-sm-9">
                        <input type="text" id="direction_id" class="form-control" disabled
                               value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">@lang('Course')</label>
                    <div class="col-sm-9">
                        <input type="text" id="course_id" class="form-control" disabled
                               value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">@lang('Task')</label>
                    <div class="col-sm-9">
                        <input type="text" id="lesson_id" class="form-control" disabled
                               value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">@lang('Status')</label>
                    <div class="col-sm-9">
                        <input type="text" id="status" class="form-control" disabled
                               value="">
                    </div>
                </div>
                <hr>

                <div id="question_list"></div>

                <fieldset id="lesson_control_buttons">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Дополнительные баллы (от 0 до 10)</div>
                                </div>
                                <input type="number" class="form-control" id="additional_points" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-3">
                            <button class="btn btn-block btn-danger float-right wrong_lesson"
                                    data-status="rework">@lang('Revoke the job')</button>
                        </div>

                        <div class="col-lg-6"></div>
                        <div class="col-lg-3">
                            <button class="btn btn-block btn-success float-left right_lesson"
                                    data-status="right">@lang('Принять задание')</button>
                        </div>
                    </div>
                </fieldset>


            </div>
            <div class="modal-footer p-2">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

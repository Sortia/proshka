<div class="modal fade" id="checkAnswer" tabindex="-1" role="dialog"
     aria-hidden="true">
    <input type="hidden" id="question_user_id">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <input type="hidden" id="course_id" name="course_id">
            <input type="hidden" id="id" name="id">
            <div class="modal-header p-2">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Lesson')</h5>
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
                    <label class="col-sm-3 col-form-label">@lang('Lesson')</label>
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
                <div class="form-group">
                    <label>@lang('Question')</label>
                    <div id="question"></div>
                </div>
                <div class="files mt-3"></div>
                <div class="form-group">
                    <label>@lang('Answer')</label>
                    <div id="answer"></div>
                </div>

                <div class="row">
                    <div class="col-lg-4 mt-2">
                        <button class="btn btn-success btn-block" id="accept_question" data-status="right">@lang('Accept task')</button>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <button class="btn btn-dark btn-block" id="rework_question" data-status="rework">@lang('Send for rework')</button>
                    </div>
                    <div class="col-lg-4 mt-2">
                        <button class="btn btn-danger btn-block" id="wrong_question" data-status="wrong">@lang('Revoke the job')</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 mt-3">
                        <textarea placeholder="Укажите причину отправки задания на доработку, отзыва задания ил похвалите ученика за прекрасно выполненное задание" id="comment" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="teacherFiles col-lg-12 mt-3"></div>
                    <div class="col-lg-12 mt-3">
                        <div class="dropzone"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-2">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

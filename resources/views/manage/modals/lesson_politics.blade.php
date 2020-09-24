<div class="modal fade" id="politicsModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Politics')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">Задания:</div>
                </div>
                <div class="offset-1">
                    <div id="policy_lesson_list" class="row my-3 ml-3"></div>
                </div>
                <p>Доступны при:</p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@lang('Direction')</span>
                            </div>
                            <select id="policy_constraint_direction_id"
                                    class="form-control input-lg">
                                <option value="">@lang('Select direction')</option>
                                @foreach($directions as $direction)
                                    <option value="{{$direction->id}}">{{$direction->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@lang('Direction')</span>
                            </div>
                            <select name="course_id" id="policy_constraint_course_id"
                                    class="form-control input-lg direction-select"></select>
                        </div>
                    </div>
                </div>
                <div class="offset-1">
                    <div id="policy_constraint_lesson_list" class="row my-3 ml-3"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button id="save_policy" type="button" class="btn btn-primary">@lang('Save')</button>
                </div>
            </div>
        </div>
    </div>
</div>

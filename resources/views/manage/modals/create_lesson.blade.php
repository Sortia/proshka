<div class="modal fade" id="createLessonModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="save_lesson" action="{{route('manage.lesson.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="course_id" name="course_id">
                <input type="hidden" id="id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Task')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for="name">@lang('Name')</label>
                                <input max="255" required type="text" class="form-control" id="name" name="name"
                                       placeholder="@lang('Enter name')">
                            </div>
                            <div class="col-lg-4">
                                <label for="cost">@lang('Direction')</label>
                                <select name="direction_id" id="form_direction_id"
                                        class="form-control input-lg">
                                    <option value="">@lang('Select direction')</option>
                                    @foreach($directions as $direction)
                                        <option value="{{$direction->id}}">{{$direction->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="cost">@lang('Course')</label>
                                <select name="course_id" id="form_course_id" required
                                        class="form-control input-lg">
                                    <option value="">@lang('Select course')</option>
                                </select>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <label for="description">@lang('Description')</label>
                                <input max="255" required type="text" class="form-control" id="description" name="description"
                                       placeholder="@lang('Enter description')">
                            </div>
                            <div class="col-lg-4">
                                <label for="description">@lang('Description for parents')</label>
                                <input max="255" required type="text" class="form-control" id="parents_description" name="parents_description"
                                       placeholder="@lang('Enter description for parents')">
                            </div>
                            <div class="col-lg-4">
                                <label for="cost">@lang('Status')</label>
                                <select name="status_id" id="status_id" required
                                        class="form-control input-lg">
                                    @foreach($statuses as $status)
                                        <option value="{{$status->id}}">@lang($status->name)</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <label for="cost">@lang('Cost')</label>
                                <input min="0" required type="number" class="form-control" id="cost" name="cost"
                                       placeholder="@lang('Enter cost')">
                            </div>
                            <div class="col-lg-4">
                                <label for="bonus">@lang('Bonus')</label>
                                <input min="0" required type="number" class="form-control" id="bonus" name="bonus"
                                       placeholder="@lang('Enter bonus')">
                            </div>
                            <div class="col-lg-4">
                                <label for="fine">@lang('Fine')</label>
                                <input min="0" required type="number" class="form-control" id="fine" name="fine"
                                       placeholder="@lang('Enter fine')">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <label for="available_at">@lang('Available at')</label>
                                <input required type="number" class="form-control" id="available_at"
                                       name="available_at"
                                       min="0"
                                       placeholder="@lang('Enter available at')">
                            </div>
                            <div class="col-lg-4">
                                <label for="time">@lang('Recommended time (in minutes)')</label>
                                <input type="text" class="form-control" id="time" name="time"
                                       placeholder="@lang('Enter time')">
                            </div>
                            <div class="col-lg-4">
                                <label for="complexity">@lang('Complexity')</label>
                                <input required type="number" class="form-control" id="complexity"
                                       name="complexity"
                                       min="0"
                                       max="10"
                                       placeholder="@lang('Enter complexity')">
                            </div>
{{--                            <div class="col-lg-4">--}}
{{--                                <label for="order_number">@lang('Order number')</label>--}}
{{--                                <input required type="number" class="form-control" id="order_number"--}}
{{--                                       name="order_number"--}}
{{--                                       min="0"--}}
{{--                                       placeholder="@lang('Enter order number')">--}}
{{--                            </div>--}}
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <label for="text" class="m-0 mt-2">@lang('Theory')</label>
                                <hr class="mt-1">
                                <div class="editor-overlay">
                                    <div id="editor"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-block col-lg-12 mb-3">
                    <span class="float-left mb-3">
                         <button id="edit_test" type="button" class="btn btn-outline-danger edit-test" data-toggle="modal"
                                 data-target="#testModal">@lang('Add/Edit tests')</button>
                    </span>
                    <span class="float-right mb-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                        <button class="btn btn-primary">@lang('Save')</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

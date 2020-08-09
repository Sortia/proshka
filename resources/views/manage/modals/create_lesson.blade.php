<div class="modal fade" id="createLessonModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="save_lesson" action="{{route('manage.lesson.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="course_id" name="course_id">
                <input type="hidden" id="id" name="id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('Lesson')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="name">@lang('Name')</label>
                                <input required type="text" class="form-control" id="name" name="name"
                                       placeholder="@lang('Enter name')">
                            </div>
                            <div class="col-lg-6">
                                <label for="description">@lang('Description')</label>
                                <input required type="text" class="form-control" id="description" name="description"
                                       placeholder="@lang('Enter description')">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <label for="complexity">@lang('Complexity')</label>
                                <input required type="number" class="form-control" id="complexity"
                                       name="complexity"
                                       placeholder="@lang('Enter complexity')">
                            </div>
                            <div class="col-lg-4">
                                <label for="cost">@lang('Cost')</label>
                                <input required type="number" class="form-control" id="cost" name="cost"
                                       placeholder="@lang('Enter cost')">
                            </div>
                            <div class="col-lg-4">
                                <label for="bonus">@lang('Bonus')</label>
                                <input required type="number" class="form-control" id="bonus" name="bonus"
                                       placeholder="@lang('Enter bonus')">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <label for="available_at">@lang('Available at')</label>
                                <input required type="number" class="form-control" id="available_at"
                                       name="available_at"
                                       placeholder="@lang('Enter available at')">
                            </div>
                            <div class="col-lg-4">
                                <label for="time">@lang('Time')</label>
                                <input required type="number" class="form-control" id="time" name="time"
                                       placeholder="@lang('Enter time')">
                            </div>
                            <div class="col-lg-4">
                                <label for="order_number">@lang('Order number')</label>
                                <input required type="number" class="form-control" id="order_number"
                                       name="order_number"
                                       placeholder="@lang('Enter order number')">
                            </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                    <button class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
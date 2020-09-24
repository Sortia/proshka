<div class="modal fade" id="filesModal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Files')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="lesson-files" class="my-3">
                    <div class="list-group">

                    </div>
                </div>
                <div class="files">
                    <form method="post" action="" enctype="multipart/form-data" id="myform">
                        <div class="custom-file">
                            <input type="file" id="upload_file" class="custom-file-input lesson-file" name="file">
                            <label class="custom-file-label" for="customFile">@lang('Choose file')</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

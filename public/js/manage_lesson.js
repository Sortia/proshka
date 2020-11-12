$(() => {
    window.dpzLessonMultipleFiles = initFiler('#dropzone_lesson');

    let policy_lessons = [];
    let current_row = 0;

    fillCourses(getCourses(null))

    $('#time').mask('00:00', {clearIfNotMatch: true});

    $('#create_lesson').on('click', () => {
        $('#course_id').val($("#search_course_id option:selected").val())
        $('#edit_test').attr('disabled', true)
    });

    $('.edit-lesson').on('click', function () {
        $.ajax({
            method: "GET",
            url: `/manage/lesson/${$(this).parents('tr').data('lesson_id')}`,
            success: (response) => {
                dpzLessonMultipleFiles.removeAllFiles( true );

                current_row = response.id;

                $('#id').val(response.id);
                // $('#order_number').val(response.order_number);
                $('#name').val(response.name);
                $('#complexity').val(response.complexity);
                $('#cost').val(response.cost);
                $('#bonus').val(response.bonus);
                $('#text').val(response.text);
                $('#description').val(response.description);
                $('#parents_description').val(response.parents_description);
                $('#available_at').val(response.available_at);
                $('#time').val(time_by_minutes(response.time));
                $('#fine').val(response.fine);
                $('#status_id').val(response.status_id);
                window.editor.clipboard.dangerouslyPasteHTML(response.task);

                $('#create_lesson').click();
                $('#course_id').val(response.course_id);
                $('#edit_test').attr('disabled', false)
                $('#form_direction_id').val(response.course.direction_id)

                fillCourses(getCourses(response.course.direction_id))

                $('#form_course_id').val(response.course_id)

                $.each(response.files, function (i, file) {
                    let mockFile = {name: file.name, size: 0, id: file.id, lesson_id: response.id}

                    dpzLessonMultipleFiles.files.push(mockFile);
                    dpzLessonMultipleFiles.emit('addedfile', mockFile)
                    dpzLessonMultipleFiles.emit('thumbnail', mockFile, `/file/${file.id}`)
                    dpzLessonMultipleFiles.emit('complete', mockFile)

                    $('a.dz-remove:last').before(`<a class="dz-remove" href="/file/${file.id}" data-dz-remove="">Скачать файл</a>`)
                })
            },
            error: (response) => show_error(response),
        });
    });

    $('.set-politics').on('click', function () {
        $.ajax({
            method: "POST",
            url: `/manage/policy/show/${$(this).parents('tr').data('lesson_id')}`,
            error: (response) => show_error(response),
            success: (response) => {
                policy_lessons = [];

                $('#policy_constraint_direction_id').empty();
                $('#policy_constraint_course_id').empty();
                $('#policy_lesson_list').empty();
                $('#policy_constraint_lesson_list').empty();

                $('#policy_constraint_direction_id').append(`<option>Выберите направление</option>`);
                $('#policy_constraint_course_id').append(`<option>Выберите курс</option>`);

                $.each(response.directions, function (i, item) {
                    $('#policy_constraint_direction_id').append(`<option value="${item.id}" ${item.id === response.constraintCourse.direction_id ? 'selected' : ''}>${item.name}</option>`);
                });

                $.each(response.courses, function (i, item) {
                    $('#policy_constraint_course_id').append(`<option value="${item.id}" ${item.id === response.constraintCourse.id ? 'selected' : ''}>${item.name}</option>`);
                });

                $.each(response.lesson.course.lessons, function (i, item) {
                    let id = randomInteger(1, 10000);

                    if (response.lessons.includes(item.id))
                        policy_lessons.push(item.id);

                    $('#policy_lesson_list').append(`
                        <div class="col-lg-3">
                            <div class="form-check">
                                <input id="checkbox_${id}" ${response.lessons.includes(item.id) ? 'checked' : ''} type="checkbox" class="form-check-input lesson-checkbox" data-lesson_id="${item.id}">
                                <label class="form-check-label" for="checkbox_${id}">${item.name}</label>
                            </div>
                        </div>
                    `);
                });

                $.each(response.constraintCourse.lessons, function (i, item) {
                    let id = randomInteger(1, 10000);

                    $('#policy_constraint_lesson_list').append(`
                        <div class="col-lg-3">
                            <div class="form-check">
                                <input id="checkbox_${id}" ${response.constraints.includes(item.id) ? 'checked' : ''} type="checkbox" class="form-check-input lesson-constraint-checkbox" data-lesson_id="${item.id}">
                                <label class="form-check-label" for="checkbox_${id}">${item.name}</label>
                            </div>
                        </div>
                    `);
                });

            }
        });
    });

    $('#createLessonModal').on('hidden.bs.modal', function () {
        $('#createLessonModal input, #createLessonModal textarea, #createLessonModal select').val('');
        $('.ql-editor').html('')
        dpzLessonMultipleFiles.removeAllFiles( true );
    });

    $('.add_task').on('click', function () {
        let lesson_id = $(this).parents('tr').data('lesson_id');

        $.ajax({
            method: "GET",
            url: "/manage/task",
            data: {
                lesson_id: lesson_id,
            },
            success: (response) => {
                window.editor.clipboard.dangerouslyPasteHTML(response);
            },
            error: (response) => show_error(response),
        });


        $('#task_lesson_id').val(lesson_id);
    })

    $('#createLessonTaskModal').on('hidden.bs.modal', function () {
        $('#task_lesson_id').val('');
    });

    $('#form_direction_id').on('change', function () {
        $('#form_course_id').empty()
        fillCourses(getCourses(this.value))
    })

    // $('#save_task').on('click', () => {
    //     $.ajax({
    //         method: "POST",
    //         url: "/manage/task",
    //         data: {
    //             task: $('.ql-editor').html(),
    //             lesson_id: $('#task_lesson_id').val(),
    //         },
    //         success: () => location.reload(),
    //         error: (response) => show_error(response),
    //     });
    // });

    $('#policy_constraint_direction_id').on('change', function () {
        $.ajax({
            method: "GET",
            url: "/course/list",
            data: {
                direction_id: $("#policy_constraint_direction_id option:selected").val()
            },
            error: (response) => show_error(response),
            success: (response) => {
                $('#policy_constraint_course_id').empty();

                $.each(response, function (i, item) {
                    $('#policy_constraint_course_id').append($('<option>', {
                        value: item.id,
                        text: item.name
                    }));
                });

                $('#policy_constraint_course_id').trigger('change');
            }
        });
    });

    $('#search_direction_id').on('change', function () {
        search($("#search_direction_id option:selected").val(), '');
    });

    $('#search_course_id').on('change', function () {
        search($("#search_direction_id option:selected").val(), $("#search_course_id option:selected").val());
    });

    function search(direction_id, course_id) {
        let url = '/manage/lesson?'

        if (direction_id !== '') {
            url += `direction_id=${direction_id}`;
        }

        if (course_id !== '') {
            url += `&course_id=${course_id}`;
        }

        location.href = url;
    }

    $('#policy_constraint_course_id').on('change', () => {
        $.ajax({
            method: "GET",
            url: "/lesson/list",
            data: {
                course_id: $("#policy_constraint_course_id option:selected").val()
            },
            error: (response) => show_error(response),
            success: (response) => {
                $('#policy_constraint_lesson_list').empty();

                $.each(response, function (i, item) {
                    let id = randomInteger(1, 10000);

                    $('#policy_constraint_lesson_list').append(`
                        <div class="col-lg-3">
                            <div class="form-check">
                                <input id="checkbox_${id}" type="checkbox" class="form-check-input lesson-constraint-checkbox" data-lesson_id="${item.id}">
                                <label class="form-check-label" for="checkbox_${id}">${item.name}</label>
                            </div>
                        </div>
                    `);
                });
                console.log(response);
            }
        });
    });

    $('#save_policy').on('click', () => {
        let lessons = [];
        let constraints = [];

        $(".lesson-checkbox:checked").each(function (i, item) {
            lessons.push($(item).data('lesson_id'))
        });

        $(".lesson-constraint-checkbox:checked").each(function (i, item) {
            constraints.push($(item).data('lesson_id'))
        });

        $.ajax({
            method: "POST",
            url: "/manage/policy",
            data: {
                lessons: lessons,
                constraints: constraints,
                prevent_lessons: policy_lessons,
            },
            error: (response) => show_error(response),
            success: () => {
                location.reload();
            }
        });
    });

    $('.delete-lesson').on('click', function () {
        console.log($(this).parents('tr').data('lesson_id'));
        $.ajax({
            method: "DELETE",
            url: `/manage/lesson/${$(this).parents('tr').data('lesson_id')}`,
            error: (response) => show_error(response),
            success: () => {
                location.reload();
            }
        });
    });

    $('body').on('click', '.delete-file', function () {
        $.ajax({
            url: `/file/${$(this).data('file_id')}`,
            type: 'delete',
            contentType: false,
            processData: false,
            error: (response) => show_error(response),
            success: () => {
                $(this).parents('.list-group-item').remove();
            },
        });
    });

    $('#save_lesson').on('submit', function (event) {
        event.preventDefault();

        let fd = new FormData();

        let data = {
            id: $('#id').val(),
            course_id: $('#form_course_id').val(),
            status_id: $('#status_id').val(),
            // order_number: $('#order_number').val(),
            name: $('#name').val(),
            complexity: $('#complexity').val(),
            cost: $('#cost').val(),
            bonus: $('#bonus').val(),
            description: $('#description').val(),
            parents_description: $('#parents_description').val(),
            available_at: $('#available_at').val(),
            time: get_minutes_by_time($('#time').val()),
            fine: $('#fine').val(),
            task: $('.ql-editor').html(),
        };

        data.inline_files = [];

        let files = Dropzone.forElement($('#dropzone_lesson')[0]).files;

        for (let i = 0; i < files.length; i++) {
            if (files[i] instanceof File) {
                fd.append(`files[]`, files[i]);
            } else {
                data.inline_files.push(files[i]);
            }
        }

        fd.append('data', JSON.stringify(data));

        $.ajax({
            url: `/manage/lesson`,
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            error: (response) => show_error(response),
            success: function () {
                location.reload();
            },
        });
    });

    function add_file(file) {
        $('#lesson-files .list-group').append(`
            <div class="list-group-item">
                <div class="row">
                    <div class="col-lg-10"><a href="/file/${file.id}">${file.name}</a></a></div>
                    <div class="col-lg-2"><button class="btn btn-outline-danger btn-sm float-right delete-file" data-file_id="${file.id}">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </button></div>
                </div>
            </div>`
        );
    }

    function getCourses(directionId) {
        let result = [];
        $.ajax({
            url: `/course/list`,
            method: 'get',
            async: false,
            data: {
                direction_id: directionId,
            },
            error: (response) => show_error(response),
            success: (response) => {
                result = response
            },
        });

        return result
    }

    function fillCourses(courses) {
        $('#form_course_id').empty().append(new Option('Выберите курс', ''))

        $.each(courses, function (key, value) {
            $('#form_course_id').append(new Option(value.name, value.id))
        });
    }
});

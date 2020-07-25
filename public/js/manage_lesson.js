$(() => {

    let policy_lessons = [];


    $('#create_lesson').on('click', () => {
        $('#course_id').val($("#search_course_id option:selected").val())
    });

    $('.edit-lesson').on('click', function () {
        let row = $(this).parents('tr');

        $('#id').val(row.data('lesson_id'));
        $('#order_number').val(row.children('.row-order_number').text());
        $('#name').val(row.children('.row-name').text());
        $('#complexity').val(row.children('.row-complexity').text());
        $('#cost').val(row.children('.row-cost').text());
        $('#bonus').val(row.children('.row-bonus').text());
        $('#text').val(row.children('.row-text').text());
        $('#description').val(row.children('.row-description').text());
        $('#available_at').val(row.children('.row-available_at').text());
        $('#time').val(row.children('.row-time').text());

        $('#create_lesson').click();
    });

    $('.set-politics').on('click', function () {
        $.ajax({
            method: "POST",
            url: `/manage/policy/show/${$(this).parents('tr').data('lesson_id')}`,
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
        $('#createLessonModal input, #createLessonModal textarea').val('');
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
            }
        });


        $('#task_lesson_id').val(lesson_id);
    })

    $('#createLessonTaskModal').on('hidden.bs.modal', function () {
        $('#task_lesson_id').val('');
    });

    $('#save_task').on('click', () => {
        $.ajax({
            method: "POST",
            url: "/manage/task",
            data: {
                task: $('.ql-editor').html(),
                lesson_id: $('#task_lesson_id').val(),
            },
            success: () => location.reload()
        });
    });

    $('#policy_constraint_direction_id').on('change', function () {
        $.ajax({
            method: "GET",
            url: "/course/list",
            data: {
                direction_id: $("#policy_constraint_direction_id option:selected").val()
            },
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
        $.ajax({
            method: "GET",
            url: "/course/list",
            data: {
                direction_id: $("#search_direction_id option:selected").val()
            },
            success: (response) => {
                $('#search_course_id').empty().append(`<option>Выберите курс</option>`);

                $.each(response, function (i, item) {
                    $('#search_course_id').append($('<option>', {
                        value: item.id,
                        text: item.name
                    }));
                });
            }
        });
    });

    $('#search_course_id').on('change', function () {
        location.href = `/manage/lesson?direction_id=${$("#search_direction_id option:selected").val()}&course_id=${$("#search_course_id option:selected").val()}`;
    });

    $('#policy_constraint_course_id').on('change', () => {
        $.ajax({
            method: "GET",
            url: "/lesson/list",
            data: {
                course_id: $("#policy_constraint_course_id option:selected").val()
            },
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
            success: () => {
                location.reload();
            }
        });
    });

});

$(() => {

    loadCourses();

    $('#direction_id').on('change', () => loadCourses());

    $('.searchable').on('change', () => filterAnswers());

    $('.searchable').on('keyup', () => filterAnswers());

    /**
     *
     */
    $('.wrong_lesson').on('click', function (e) {
        $.ajax({
            method: "POST",
            url: `/lesson_user/${$(this).data('lesson_user_id')}/wrong`,
            error: (response) => show_error(response),
            success: (response) => {
                swal_success();
                $('#checkAnswer').modal('hide')
                $(`#lesson_user_${$(this).data('lesson_user_id')}`).remove();
            }
        });
    });

    /**
     *
     */
    $('.right_lesson').on('click', function (e) {
        let additional_points = $('#additional_points');

        if (additional_points.val() < 0 || additional_points.val() > 10) {
            additional_points.addClass('is-invalid');
            return;
        } else {
            additional_points.removeClass('is-invalid');
        }

        $.ajax({
            method: "POST",
            data: {
                additional_points: additional_points.val(),
            },
            url: `/lesson_user/${$(this).data('lesson_user_id')}/right`,

            success: (response) => {
                swal_success();
                $('#checkAnswer').modal('hide')
                $(`#lesson_user_${$(this).data('lesson_user_id')}`).remove();
            },
            error: (response) => show_error(response),
        });
    });

    /**
     * Проставление статуса выполненному заданию
     */
    $('body').on('click', '.accept_question, .rework_question', function () {
        let fd = new FormData();
        let question_user_id = $(this).data('question_user_id');

        let files = Dropzone.forElement($(`#question_user_${question_user_id} .dropzone`)[0]).files;

        for (let i = 0; i < files.length; i++) {
            fd.append(`files[]`, files[i]);
        }

        fd.append('question_user_id', question_user_id);
        fd.append('comment', $(`#question_user_${question_user_id} .comment`).val());
        // fd.append('additional_points', $('#additional_points').val());

        $.ajax({
            method: "POST",
            url: `/question_user/${question_user_id}/${$(this).data('status')}`,
            data: fd,
            contentType: false,
            processData: false,
            error: (response) => show_error(response),
            success: (response) => {
                swal_success();
                // $(`#question_user_${question_user_id}`).remove()
                $(`#question_user_fieldset_${question_user_id}`).attr('disabled', true);
            }
        });
    });

    /**
     * Переход по пагинации
     */
    $('body').on('click', '.page-link', function (event) {
        event.preventDefault();

        filterAnswers($(this).attr('href').split('page=')[1]);
    });

    /**
     * Открытие модалки
     */
    $('body').on('click', '.show_answer', function () {
       let lesson_user_id = $(this).data('lesson_user_id');

        $.ajax({
            method: "GET",
            url: `/lesson_user/${lesson_user_id}/`,
            error: (response) => show_error(response),
            success: (response) => {
                console.log(response);
                $('#checkAnswer #direction_id').val(response.lessonUser.lesson.course.direction.name)
                $('#checkAnswer #course_id').val(response.lessonUser.lesson.course.name)
                $('#checkAnswer #lesson_id').val(response.lessonUser.lesson.name)
                $('#checkAnswer #status').val(trans.get('__JSON__.' + response.lessonUser.status))
                $('#checkAnswer .right_lesson').data('lesson_user_id', response.lessonUser.id)
                $('#checkAnswer .wrong_lesson').data('lesson_user_id', response.lessonUser.id)
                $('#checkAnswer #additional_points').val(response.lessonUser.additional_point)

                $('#question_list').empty().append(response.html);

                $('.dropzone').each(function (i, item) {
                    initFiler(item);
                });

                if (response.lessonUser.status !== 'complete') {
                    $('#lesson_control_buttons').attr('disabled', true)
                }
            }
        });
    });

    /**
     * Заполнение списка курсов
     */
    function loadCourses() {
        $.ajax({
            method: "GET",
            url: "/course/list",
            data: {
                direction_id: $("#direction_id option:selected").val()
            },
            error: (response) => show_error(response),
            success: (response) => {
                $('#course_id').empty();

                $.each(response, function (i, item) {
                    $('#course_id').append($('<option>', {
                        value: item.id,
                        text: item.name
                    }));
                });

                filterAnswers();
            }
        });
    }

    function filterAnswers(page = 1) {
        $.ajax({
            method: "GET",
            url: "/answer/list/filter",
            data: {
                direction_id: $('#direction_id').val(),
                course_id: $('#course_id').val(),
                status: $('#status').val(),
                date_sort: $('#date').val(),
                search: $('#search').val(),
                page: page
            },
            error: (response) => show_error(response),
            success: (response) => {
                console.log(response);
                $('.answers').empty().append(response.html);
            }
        });
    }
});

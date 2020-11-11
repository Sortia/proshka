$(() => {

    loadCourses();

    $('#direction_id').on('change', () => loadCourses());

    $('.searchable').on('change', () => filterAnswers());

    $('.searchable').on('keyup', () => filterAnswers());

    /**
     *
     */
    $('.wrong_lesson').on('click', function (e) {
        let fd = new FormData();

        fd = addQuestionsData(fd)

        sendAjaxSave(fd, 'wrong', $(this).data('lesson_user_id'))
    });

    /**
     * Чтобы в поле нельзя было ввести больше 10 и меньше 0
     */
    $('#additional_points').on('input', function (event) {
        if ($(this).val() > 10) {
            $(this).val(10);
        }

        if ($(this).val() < 0) {
            $(this).val(0);
        }
    });

    /**
     *
     */
    $('.right_lesson').on('click', function (e) {
        let fd = new FormData();

        let additional_points = $('#additional_points');

        if (additional_points.val() < 0 || additional_points.val() > 10) {
            additional_points.addClass('is-invalid');
            return;
        } else {
            additional_points.removeClass('is-invalid');
        }

        fd = addAdditionalPointsData(fd)
        fd = addQuestionsData(fd)

        sendAjaxSave(fd, 'right', $(this).data('lesson_user_id'))
    });

    /**
     *
     */
    $('.rework_lesson').on('click', function (e) {
        let fd = new FormData();

        fd = addQuestionsData(fd)

        sendAjaxSave(fd, 'rework', $(this).data('lesson_user_id'))
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
                $('#checkAnswer #direction_id').val(response.lessonUser.lesson.course.direction.name)
                $('#checkAnswer #course_id').val(response.lessonUser.lesson.course.name)
                $('#checkAnswer #lesson_id').val(response.lessonUser.lesson.name)
                $('#checkAnswer #status').val(trans.get('__JSON__.' + response.lessonUser.status))
                $('#checkAnswer .right_lesson').data('lesson_user_id', response.lessonUser.id)
                $('#checkAnswer .wrong_lesson').data('lesson_user_id', response.lessonUser.id)
                $('#checkAnswer .rework_lesson').data('lesson_user_id', response.lessonUser.id)
                $('#checkAnswer #additional_points').val(response.lessonUser.additional_point)
                $('#checkAnswer .lesson_comment').val(response.lessonUser.comment)

                $('#question_list').empty().append(response.html);

                $('.dropzone').each(function (i, item) {
                    initFiler(item);
                });

                if (response.lessonUser.status !== 'complete') {
                    $('#lesson_control_buttons, #checkAnswer .comment').attr('disabled', true)
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

    function addAdditionalPointsData(fd) {
        let additional_points = $('#additional_points');

        fd.append('additional_points', additional_points.val() || 0);
        fd.append('comment', $('.lesson_comment').val());

        return fd;
    }

    function addQuestionsData(fd) {
        let questions = []

        $('.question_user_card').each(function () {
            let id = $(this).data('question_user_id')

            questions.push({
                comment: $(this).find('.comment').val(),
                id: id,
            })

            let files = Dropzone.forElement($(this).find('.dropzone')[0]).files;

            for (let i = 0; i < files.length; i++) {
                if (files[i] instanceof File) {
                    fd.append(`files_${id}[]`, files[i]);
                } else {
                    data.inline_files.push(files[i]);
                }
            }
        });

        fd.append('questions', JSON.stringify(questions));

        return fd;
    }

    function sendAjaxSave(fd, type, id) {
        $.ajax({
            method: "POST",
            data: fd,
            contentType: false,
            processData: false,
            url: `/lesson_user/${id}/${type}`,

            success: () => {
                swal_success();
                $('#checkAnswer').modal('hide')
                $(`#lesson_user_${id}`).remove();
            },
            error: (response) => show_error(response),
        });
    }
});

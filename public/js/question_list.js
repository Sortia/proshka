$(() => {

    loadCourses();
    initFiler($('.dropzone')[0])


    $('#direction_id').on('change', () => loadCourses());

    $('.searchable').on('change', () => filterAnswers());

    $('.searchable').on('keyup', () => filterAnswers());

    /**
     * Удаление файлов из dropzone при закрытии модалки
     */
    $('#checkAnswer').on('hidden.bs.modal', function (e) {
        Dropzone.forElement($('#checkAnswer .dropzone')[0]).removeAllFiles(true);
    })

    /**
     * Проставление статуса выполненному заданию
     */
    $('#accept_question, #rework_question, #wrong_question').on('click', function () {
        let fd = new FormData();
        let question_user_id = $('#question_user_id').val();
        let files = Dropzone.forElement($('#checkAnswer .dropzone')[0]).files;

        for (let i = 0; i < files.length; i++) {
            fd.append(`files[]`, files[i]);
        }

        fd.append('question_user_id', question_user_id);
        fd.append('comment', $('#comment').val());

        $.ajax({
            method: "POST",
            url: `/question_user/${question_user_id}/${$(this).data('status')}`,
            data: fd,
            contentType: false,
            processData: false,
            error: (response) => show_error(response),
            success: (response) => {
                $('#checkAnswer').modal('hide')
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
       let question_user_id = $(this).data('question_user_id');

        $.ajax({
            method: "GET",
            url: `/question_user/${question_user_id}/`,
            error: (response) => show_error(response),
            success: (response) => {
                console.log(response);
                $('#checkAnswer #direction_id').val(response.questionUser.question.test.lesson.course.direction.name)
                $('#checkAnswer #course_id').val(response.questionUser.question.test.lesson.course.name)
                $('#checkAnswer #lesson_id').val(response.questionUser.question.test.lesson.name)
                $('#checkAnswer #question').html(response.questionUser.question.question)
                $('#checkAnswer #question_user_id').val(response.questionUser.id)
                $('#checkAnswer #status').val(__(response.questionUser.status))
                $('#checkAnswer #comment').val(response.questionUser.comment)

                $('#answer').empty().append(response.html);

                $.each(response.questionUser.teacher_files, function (i, file) {
                    $('.teacherFiles').append(`<a href="/file/${file.id}">${file.name}</a><br>`)
                });
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

$(() => {
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
});

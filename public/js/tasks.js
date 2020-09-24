$(() => {
    refreshTableData();

    $('#direction_id, #my_courses, input[name=task_type]').on('change', function () {
        refreshTableData({
            direction_id: $('#direction_id').val(),
            my_courses: $('#my_courses').is(':checked'),
            task_type: $("input[name='task_type']:checked").val(),
        });
    });

    function refreshTableData(params = {}) {
        $.ajax({
            method: "get",
            url: `/tasks/show`,
            data: params,
            error: (response) => {
                show_error(response)
            },
            success: (response) => {
                $('#table').bootstrapTable("destroy").bootstrapTable({data: response})
                $('.count-rows').text(response.length);
            }
        });
    }

    $('body').on('click', 'tr:not(:first)', function () {
        let tr = $(this);
        let lesson_id = tr.children('.id').html();

        if (tr.hasClass('unavailable_lesson')) {
            return swal_error('Это задание еще недоступно!', 1500);
        }

        if (tr.hasClass('bought')) {
            location.href = `/lesson/${lesson_id}/show`
        } else {
            Swal.fire({
                title: 'Ты уверен, что будешь выполнять задание "' + tr.children('.name').html() + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Да!',
                cancelButtonText: 'Нет',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        method: "POST",
                        url: `/lesson/${lesson_id}/buy`,
                        error: (response) => {
                            if (response.status === 403) {
                                swal_error('Нельзя взять более одного задания на выполнение!', 2000);
                            } else {
                                show_error(response)
                            }
                        },
                        success: () => {
                            swal_success().then(() => {
                                location.href = `/lesson/${lesson_id}/show`
                            });
                        }
                    });
                }
            })
        }
    });

});

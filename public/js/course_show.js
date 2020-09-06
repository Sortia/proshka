$(() => {
    $('.buy-course-link').on('click', function (event) {
        event.preventDefault();

        const lesson_id = $(this).data('lesson_id');

        Swal.fire({
            title: 'Ты уверен, что будешь выполнять задание "' + $(this).data('lesson_name') + '"?',
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
    });
});

$(() => {
    $('#refuse_task').on('click', () => {
        Swal.fire({
            title: 'Ты уверен, что хочешь отказаться от выполнения задания?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Да!',
            cancelButtonText: 'Нет',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    method: "POST",
                    url: `refuse`,
                    success: (response) => {
                        swal_success().then(() => {
                            location.href = `/course/${response.lesson.course_id}/show`
                        });
                    },
                    error: (response) => show_error(response),
                });
            }
        });
    });
});

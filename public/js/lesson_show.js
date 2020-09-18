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
                            location.href = `/tasks`
                        });
                    },
                    error: (response) => show_error(response),
                });
            }
        });
    });

    $('#complete_task').on('click', function () {
        $.ajax({
            method: "POST",
            url: `complete`,
            success: (response) => {
                swal_success().then(() => {
                    location.href = `/tasks`
                });
            },
            error: (response) => show_error(response),
        });
    });
});

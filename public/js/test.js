$(() => {

    $('.dropzone').each((i, elem) => {
        console.log($(elem).data('disable'));
        if ($(elem).data('disable') === true) {
            initFiler(elem, false);
        } else {
            initFiler(elem);
        }

    })

    $('#save_answer').on('click', function () {
        let item = $('.carousel .active .test-item');
        let answer_type = item.find('.answer_type').val();
        let question_id = item.find('.question_id').val();
        let question_user_id = item.find('.question_user_id').val();

        // если вопрос не активен - ответ не отправляется на сервер
        // не активен он если ученик на него уже ответил (исключение - учитель отправил задание на доработку)
        if (!item.find('.is_active').val()) {
            moveCarousel();

            return;
        }

        let fd = new FormData();

        fd.append('question_id', question_id);
        fd.append('question_user_id', question_user_id);

        switch (answer_type) {
            case "select":
                fd.append('answer_id', item.find('.answer_right:checked').data('answer_id'))
                break;
            case "text":
                fd.append('text', item.find('.question_answer_text').val())
                break;
        }

        if (item.has('.dropzone').length) {
            // add files
            let files = Dropzone.forElement(item.find('.dropzone')[0]).files;

            for (let i = 0; i < files.length; i++) {
                fd.append(`files[]`, files[i]);
            }
        }


        $.ajax({
            method: "POST",
            url: "/question_user/store",
            data: fd,
            contentType: false,
            processData: false,
            error: (response) => show_error(response),
            success: (response) => {
                switch (response.status) {
                    case 'complete':
                        return swal_success('Тест принят', 2000).then(() => location.href = '/tasks');
                    case 'right':
                        return swal_success('Тест сдан', 2000).then(() => location.href = '/tasks');
                    default: moveCarousel();
                }
            }
        });

        console.log(answer_type, question_id);

    });

    function moveCarousel() {
        if ($('.carousel .active .test-item').hasClass('final')) {
            $('#save_answer').parent().remove();
        }

        $('#carouselExampleControls').carousel('next');
    }

});

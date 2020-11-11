$(() => {
    let index = 0;
    let current_row;

    window.dpzMultipleFiles = initFiler('.dropzone_question');

    $(document).on('click', '.sort_question_up, .sort_question_down', function(e) {
        e.stopPropagation();
    });

    $('#testModal').on('show.bs.modal', function (e) {
        $('.answer_type').trigger('change');
    });

    $('.edit-test').on('click', function () {

        if (!$('#id').val()) {
            return;
        }

        $.ajax({
            method: "GET",
            url: `/manage/test/${$('#id').val()}`,
            success: (response) => {
                console.log(response);
                current_row = response.lesson.id;
                $('#accordion').empty().append(response.html);


                $.each(response.lesson.test.questions, function (i, question) {
                    let dpzMultipleFiles = initFiler($(`.card_question_id_${question.id} .dropzone-files`)[0]);

                    $.each(question.files, function (i, file) {
                        let mockFile = {name: file.name, size: 0, id: file.id, question_id: question.id}

                        dpzMultipleFiles.files.push(mockFile);
                        dpzMultipleFiles.emit('addedfile', mockFile)
                        dpzMultipleFiles.emit('thumbnail', mockFile, `/file/${file.id}`)
                        dpzMultipleFiles.emit('complete', mockFile)
                    })

                });


            },
            error: (response) => show_error(response),
        });
    });

    $('#save_test').on('click', function () {
        let data = {};
        let fd = new FormData();

        data.questions = [];
        data.inline_files = [];
        data.lesson_id = current_row;

        $('.answer-card:not(.card_0)').each((i, question) => {
            let answers = [];

            $(question).find('.answer').each((i, answer) => {
                answers.push({
                    id: $(answer).find('.answer_text').data('answer_id') || null,
                    text: $(answer).find('.answer_text').val(),
                    is_right: $(answer).find('.answer_right').prop('checked'),
                });
            });

            data.questions.push({
                index: $(question).data('index'),
                question: $(question).find('.question').val(),
                hint: $(question).find('.hint').val(),
                type: $(question).find('.answer_type').val(),
                accept_file: $(question).find('.attach_file_checkbox').prop('checked'),
                answers: answers,
            });
            let files = Dropzone.forElement($(question).find('.dropzone_question')[0]).files;

            for (let i = 0; i < files.length; i++) {
                if (files[i] instanceof File) {
                    fd.append(`files_${$(question).data('index')}[]`, files[i]);
                } else {
                    data.inline_files.push(files[i]);
                }
            }
        });

        fd.append('data', JSON.stringify(data));

        $.ajax({
            method: "POST",
            url: "/manage/test",
            data: fd,
            contentType: false,
            processData: false,
            error: (response) => show_error(response),
            success: () => $('#testModal').modal('hide')
        });

    });

    $('body').on('change', '.answer_type', function () {
        let type = $(this).children("option:selected").val();
        let card = get_card(this);

        switch (type) {
            case 'select':
                process_select_show(card);
                break;
            case 'text':
                process_text_show(card);
                break;
            case 'none':
                process_none_show(card);
                break;
            case 'select_many':
                process_select_many_show(card);
                break;
        }
    })

    $('body').on('click', '.add_answer', function () {
        add_answer(get_card(this));
    })

    $('body').on('click', '.add_answer_many', function () {
        add_answer_many(get_card(this));
    })

    $('body').on('click', '.add_question', function () {
        let form_card = get_card(this).children('.answer-card-content');
        let card = form_card.clone();

        move_card(form_card);
        reset_card(card);

        $('.card_0').append(card);

        card.find('.files').empty().append('<div class="dropzone dropzone_question"></div>');
        initFiler($('.dropzone_question')[0]);
    });

    $('body').on('click', '.delete_question', function (event) {
        event.preventDefault();
        get_card(this).remove();
    });

    $('body').on('click', '.sort_question_up', function (event) {
        let cur = $(this).parents('.answer-card');
        let sib = cur.prev();

        sib.before(cur)
    });

    $('body').on('click', '.sort_question_down', function (event) {
        let cur = $(this).parents('.answer-card');
        let sib = cur.next();

        sib.after(cur)
    });

    $('body').on('click', '.sort_answer_up', function (event) {
        let cur = $(this).parents('.answer');
        let sib = cur.prev();

        sib.before(cur)
    });

    $('body').on('click', '.sort_answer_down', function (event) {
        let cur = $(this).parents('.answer');
        let sib = cur.next();

        sib.after(cur)
    });

    function process_select_show(card) {
        console.log(3);
        $(card).find('.answer-cover').show();
        $(card).find('.answer-cover-many').hide();
        $(card).find('.answers-many').empty();
    }

    function process_text_show(card) {
        console.log(1);
        $(card).find('.answer-cover').hide();
        $(card).find('.answers').empty();
        $(card).find('.answer-cover-many').hide();
        $(card).find('.answers-many').empty();
    }

    function process_none_show(card) {
        console.log(2);
        $(card).find('.answer-cover').hide();
        $(card).find('.answers').empty();
        $(card).find('.answer-cover-many').hide();
        $(card).find('.answers-many').empty();
    }

    function process_select_many_show(card) {
        console.log(4);
        $(card).find('.answer-cover').hide();
        $(card).find('.answers').empty();
        $(card).find('.answer-cover-many').show();
    }

    function get_card($this) {
        return $($this).parents('.answer-card');
    }

    function add_answer(card) {
        let element = $(card).find('.answers')

        element.append(`
            <div class="form-row align-items-center answer">
                <div class="col-auto">
                    <div class="form-check mb-2">
                        <input title="Укажите правильный вариант ответа при необходимости" class="form-check-input answer_right large-radio" type="radio" name="card_radio_${card.data('index')}">
                        <label class="form-check-label"></label>
                    </div>
                </div>
                <div class="col">
                    <input type="text" class="form-control mb-2 answer_text">
                </div>
                <div class="col-auto" style="height: 42px">
                    <span class="sort">
                        <input type="hidden" class="order_number" value="{{$question->order_number}}" data-question_id="{{$question->id}}">
                        <button style="height: 35px" type="button" class="btn btn-sm btn-outline-primary sort_answer_up">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                            </svg>
                        </button>
                        <button style="height: 35px" type="button" class="btn btn-sm btn-outline-primary sort_answer_down">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                            </svg>
                        </button>
                    </span>
                </div>
            </div>
        `);

        if (element.find('.answer').length === 1) {
            add_help_label(element);
        }
    }

    function add_answer_many(card) {
        let element = $(card).find('.answers-many');

        element.append(`
            <div class="form-row align-items-center answer">
                <div class="col-auto">
                    <div class="form-check mb-2">
                        <input title="Укажите правильный вариант ответа при необходимости" class="form-check-input answer_right large-checkbox" type="checkbox" name="card_radio_${card.data('index')}">
                        <label class="form-check-label"></label>
                    </div>
                </div>
                <div class="col">
                    <input type="text" class="form-control mb-2 answer_text">
                </div>
                <div class="col-auto" style="height: 42px">
                    <span class="sort">
                        <input type="hidden" class="order_number" value="{{$question->order_number}}" data-question_id="{{$question->id}}">
                        <button style="height: 35px" type="button" class="btn btn-sm btn-outline-primary sort_answer_up">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                            </svg>
                        </button>
                        <button style="height: 35px" type="button" class="btn btn-sm btn-outline-primary sort_answer_down">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                            </svg>
                        </button>
                    </span>
                </div>
            </div>
        `);

        if (element.find('.answer').length === 1) {
            add_help_label(element);
        }
    }

    function add_help_label(element) {
        element.after('<small>Добавление варианта ответа</small>')
    }

    function move_card(form_card) {
        let card_index = --index;
        let card_class = 'card_' + card_index;
        let text = form_card.find('.question').val();

        $('#accordion').append(`
            <div class="card answer-card ${card_class}" data-index="${card_index}">
                <summary data-toggle="collapse" data-target="#answer_card_${card_index}" aria-expanded="true">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <span class="header-label">${text.substr(0, 20) || 'Title'}</span>
                            <span class="float-right">
                            <span class="sort mr-4">
                                <input type="hidden" class="order_number" value="{{$question->order_number}}" data-question_id="{{$question->id}}">
                                <button type="button" class="btn btn-sm btn-outline-primary sort_question_up">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                                    </svg>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary sort_question_down">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                    </svg>
                                </button>
                            </span>
                                <button class="btn btn-sm btn-outline-danger delete_question">Delete</button>
                            </span
                        ></h5>
                    </div>
                </summary>

                <div id="answer_card_${card_index}" class="collapse pb-3" data-parent="#accordion">
                    <div class="card-body"></div>
                </div>
            </div>
       `);

        form_card.appendTo(`.${card_class} .card-body`);

        form_card.find('.answer_right').each((i, elem) => {
            $(elem).attr('name', `card_radio_${card_index}`);
        });

        $(`.${card_class}`).find('.add_question').remove();
    }

    function reset_card(card) {
        card.find('.question').val('');
        card.find('.hint').val('');
        card.find('.attach_file_checkbox').prop('checked', false);
        card.find('.answers').empty();
        card.find('.answer_type').val('select').trigger('change');
    }

});

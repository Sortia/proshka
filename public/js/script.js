$(() => {
    $('body').on("change", '.change-file-input', function () {
        let filename = $(this).val().match(/[^\\/]*$/)[0];

        $(this).siblings('.custom-file-label').text(filename);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.randomInteger = function (min, max) {
        // получить случайное число от (min-0.5) до (max+0.5)
        let rand = min - 0.5 + Math.random() * (max - min + 1);
        return Math.round(rand);
    }

    window.clearFileInputField = function (Id) {
        document.getElementById(Id).innerHTML = document.getElementById(Id).innerHTML;
    }

    window.show_error = function (response) {
        console.log(response);
        swal_error();
    }

    window.initFiler = function (selector, clickable = true) {
        return new Dropzone(selector, {
            url: "/file/post",
            clickable: clickable,
            addRemoveLinks: true,
            autoProcessQueue: false,
            parallelUploads: 10 // Number of files process at a time (default 2)
        });
    }

    window.swal_success = function (text = 'Успешно!', timer = 900) {
        return Swal.fire({title: text, icon: 'success', timer: timer})
    }

    window.swal_error = function (text = 'Что-то пошло не так...', timer = 900) {
        Swal.fire({title: text, icon: 'error', timer: timer})
    }
});

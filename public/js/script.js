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
        alert(response.statusText);
    }

});


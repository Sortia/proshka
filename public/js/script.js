$(() => {
    $('#file').on("change", function(){
        let filename = $(this).val().match(/[^\\/]*$/)[0];

        $('#file-label').text(filename);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    window.randomInteger = function(min, max) {
        // получить случайное число от (min-0.5) до (max+0.5)
        let rand = min - 0.5 + Math.random() * (max - min + 1);
        return Math.round(rand);
    }

});


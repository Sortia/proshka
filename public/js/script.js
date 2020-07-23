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

});


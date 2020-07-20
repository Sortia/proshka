$(() => {
    $('#file').on("change", function(){
        let filename = $(this).val().match(/[^\\/]*$/)[0];

        $('#file-label').text(filename);
    });
});

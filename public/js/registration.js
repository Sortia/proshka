$(() => {
    $('#phone').mask('+7(999) 999-99-99');

    $('#role_id').on('change', function () {
        $('.representative').toggle();
    });

    $('#adult_checkbox').on('change', function () {
        $('.representative-fields').toggle();
        $('#representative_email').val('');
    });
});

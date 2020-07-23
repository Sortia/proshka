$(() => {
    new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [['bold', 'italic'], ['link', 'image', 'video']],
        }
    });
});

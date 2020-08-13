$(() => {
    let book = {
        complete: 'Выполнено',
        right: 'Верно',
        wrong: 'Неверно',
        rework: 'На доработке',
    }

    window.__ = function (key) {
        return book[key];
    }
})

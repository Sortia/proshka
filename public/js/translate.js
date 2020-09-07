$(() => {
    let book = {
        complete: 'Выполнено',
        active: 'Активно',
        right: 'Верно',
        wrong: 'Неверно',
        rework: 'На доработке',
    }

    window.__ = function (key) {
        return book[key];
    }
})

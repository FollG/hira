(() => {
    MicroModal.init({
        disableScroll: true, // [6]
        awaitOpenAnimation: false, // [8]
        awaitCloseAnimation: false, // [9]
    });

    $(document).on('click', '#add-task-comment', (e) => {
        let task_id = $(e.target).attr('data-id');
        MicroModal.show('modal-1');
    })
    $(document).on('click', '.modal__btn.modal__btn-primary', (e) => {
        let comment = $('#comment').val();
        let task_id = $('#add-task-comment').attr('data-id');

        fetch('tasks/post/sendcomment', {
            method: "POST",
            headers: {
                "Content-Type":"json/application;utf-8"
            },
            body: JSON.stringify({
                comment,
                task_id
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.ok === 1) {
                    $.notify(`Комментарий успешно отправлен`, 'success', {});
                    MicroModal.close('modal-1');
                    location.href=location.href;
                } else {
                    $.notify(`Ошибка`, 'error', {})
                    MicroModal.close('modal-1');
                }
            })
    })

    $(document).on('click', '#check-on-user', (e) => {
        let task_id = $(e.target).attr('data-id');
        MicroModal.show('modal-2');
    })
    $(document).on('click', '.modal__btn.modal__btn-primary2', (e) => {
        let user_id = $('#user').find(':selected').attr('user-id');

        let task_id = $('#check-on-user').attr('data-id');

        fetch('tasks/post/checkonuser', {
            method: "POST",
            headers: {
                "Content-Type":"json/application;utf-8"
            },
            body: JSON.stringify({
                user_id,
                task_id
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.ok === 1) {
                    $.notify(`Задача успешно назначена`, 'success', {});
                    MicroModal.close('modal-2');
                    location.href=location.href;
                } else {
                    $.notify(`Ошибка`, 'error', {})
                    MicroModal.close('modal-2');
                }
            })
    })

    $(document).on('click', '#change-surgency', (e) => {
        MicroModal.show('modal-3');
    })
    $(document).on('click', '.modal__btn.modal__btn-primary3', (e) => {
        let urgency_id = $('#surgency').find(':selected').attr('urgency-name');
        let task_id = $('#check-on-user').attr('data-id');

        fetch('tasks/post/changeUrgency', {
            method: "POST",
            headers: {
                "Content-Type":"json/application;utf-8"
            },
            body: JSON.stringify({
                urgency_id,
                task_id
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.ok === 1) {
                    $.notify(`Задача успешно назначена`, 'success', {});
                    MicroModal.close('modal-3');
                    location.href=location.href;
                } else {
                    $.notify(`Ошибка`, 'error', {})
                    MicroModal.close('modal-3');
                }
            })
    })

    $(document).on('click', '#change-status', (e) => {
        MicroModal.show('modal-4');
    })
    $(document).on('click', '.modal__btn.modal__btn-primary4', (e) => {
        let status_id = $('#status').find(':selected').attr('status-id');
        let task_id = $('#check-on-user').attr('data-id');

        fetch('tasks/post/changeStatus', {
            method: "POST",
            headers: {
                "Content-Type":"json/application;utf-8"
            },
            body: JSON.stringify({
                status_id,
                task_id
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.ok === 1) {
                    $.notify(`Задача успешно обновлена`, 'success', {});
                    MicroModal.close('modal-4');
                    location.href=location.href;
                } else {
                    $.notify(`Ошибка`, 'error', {})
                    MicroModal.close('modal-4');
                }
            })
    })

    $(document).on('click', '#set-timetracker', (e) => {
        MicroModal.show('modal-5');
    })
    $(document).on('click', '.modal__btn.modal__btn-primary5', (e) => {
        let time = $('#time').val();
        let task_id = $('#set-timetracker').attr('data-id');

        fetch('tasks/post/setTimeTracker', {
            method: "POST",
            headers: {
                "Content-Type":"json/application;utf-8"
            },
            body: JSON.stringify({
                time,
                task_id
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.ok === 1) {
                    $.notify(`Задача успешно обновлена`, 'success', {});
                    MicroModal.close('modal-5');
                    location.href=location.href;
                } else {
                    $.notify(`Ошибка`, 'error', {})
                    MicroModal.close('modal-5');
                }
            })
    })
})()
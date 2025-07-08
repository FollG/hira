(() => {
    MicroModal.init({
        disableScroll: true, // [6]
        awaitOpenAnimation: false, // [8]
        awaitCloseAnimation: false, // [9]
    });

    $(document).on('click', '#add-project-button', (e) => {
        let task_id = $(e.target).attr('data-id');
        MicroModal.show('modal-project');
    })
    $(document).on('click', '.modal__btn.modal__btn-primary-project', (e) => {
        let name = $('#project-name').val();

        fetch('settings/post/setproject', {
            method: "POST",
            headers: {
                "Content-Type":"json/application;utf-8"
            },
            body: JSON.stringify({
                name
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.ok === 1) {
                    $.notify(`Комментарий успешно отправлен`, 'success', {});
                    MicroModal.close('modal-project');
                } else {
                    $.notify(`Ошибка`, 'error', {})
                    MicroModal.close('modal-project');
                }
            })
    })

    $(document).on('click', '#add-task-button', (e) => {
        let task_id = $(e.target).attr('data-id');
        MicroModal.show('modal-task');
    })
    $(document).on('click', '.modal__btn.modal__btn-primary-task', (e) => {
        let name = $('#project-name').val();

        fetch('settings/post/settask', {
            method: "POST",
            headers: {
                "Content-Type":"json/application;utf-8"
            },
            body: JSON.stringify({
                name
            })
        })
            .then(response => response.json())
            .then(response => {
                if (response.ok === 1) {
                    $.notify(`Комментарий успешно отправлен`, 'success', {});
                    MicroModal.close('modal-project');
                } else {
                    $.notify(`Ошибка`, 'error', {})
                    MicroModal.close('modal-project');
                }
            })
    })
})();
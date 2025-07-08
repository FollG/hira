(()=> {
    $(document).on('click', '.project-name', (e) => {
        let project_id = $(e.target).attr('data-id')
        window.location.href = "/project?project="+project_id;
    });

    $(document).on('click', '.user-name', (e) => {
        let user_id = $(e.target).attr('data-id');
        window.location.href = "/users?user="+user_id;
    })

    $(document).on('click', '.task-name', (e) => {
        let task_id = $(e.target).attr('data-id');
        window.location.href = "/task?task="+task_id;
    })

    $('.content-window').html($('.content-wrapper'));
})();
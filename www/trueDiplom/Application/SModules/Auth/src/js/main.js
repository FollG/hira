(() => {

    $(document).keypress((e) => {
        if(e.which === 13) {
            $('#auth-button').click();
        }
    })

    $('#auth-button').on('click', (e) => {

        let login = $('#login').val();
        let password = $('#password').val();

        if(!login) {
            $.notify(`Поле логина не может быть пустым.`, 'error', {})
            return;
        }
        if(!password) {
            $.notify(`Поле пароля не может быть пустым.`, 'error', {})
            return;
        }

        fetch('auth/post/auth', {
            method: 'POST',
            headers: {
                'Content-Type':'application/json;utf-8',
            },
            body: JSON.stringify({
                login,
                password,
            })
        })
            .then(response => response.json())
            .then(response => {
                if(response.ok === 1 && response.content.data) {
                    $.notify(`Добро пожаловать!`, 'success', {})
                    window.location.replace("/home");
                } else {
                    $.notify(`Произошла ошибка, проверьте логин и пароль и попробуйте еще раз.`, 'error', {})
                }
            })
    })

    $('.see-password-btn').on('click', () => {
        if('password' === $('#password').attr('type')){
            $('#password').prop('type', 'text');
        }else{
            $('#password').prop('type', 'password');
        }
    })
})();

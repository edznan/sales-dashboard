$(document).ready(function() {

    if(localStorage.getItem('username').length > 0){
        $('#username').val(localStorage.getItem('username'));
    }
    if(localStorage.getItem('password').length > 0){
        $('#password').val(localStorage.getItem('password'));
    }
    if(localStorage.getItem('remember_me') == 'checked'){
        $('#remember-me-checkbox').attr('checked', 'checked');
        console.log('checked');
    } else {
        if($('#remember-me-checkbox').attr('checked') == 'checked'){
            console.log('checkbox checked')
        } else {
            console.log('checkbox not checked');
        }
    }

    $("#login-btn").click(function() {
        var username = '';
        var password = '';
        var remember_me = false;
        var success_msg = 'Logged in successfully.';
        var error_msg = 'Login failed.';

        if($('#username').val()) {
            username = $('#username').val();
        } else {
            console.log('no username');
        }

        if($('#password').val()) {
            password = $('#password').val();
        } else {
            console.log('no password');
        }

        if($('#remember-me-checkbox').is(':checked')) {
            remember_me = 'checked';
        } 

        if(remember_me ==  'checked'){
            localStorage.setItem('remember_me', 'checked');
            localStorage.setItem('username', username);
            localStorage.setItem('password', password);
        } else {
            localStorage.setItem('remember_me', 'unchecked');
            localStorage.setItem('username', '');
            localStorage.setItem('password', '');
        }

        if(username.length != 0 && password.length != 0) {
            $.ajax({
                url: 'login.php',
                method: 'POST',
                data: {
                    username: username,
                    password: password
                },
                success: (response) => {
                    if(response != 'success'){
                        $('#response').css({'background-color': '#ff0000', 'color': '#fff'});
                        $('#response').html(error_msg);
                    } else {
                        $('#response').css({'background-color': '#56baed', 'color': '#fff'});
                        $('#response').html(success_msg);
                        window.location = 'index.php';
                    }
                },
                dataType: 'text'
            })
        }
    });
});
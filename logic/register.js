$(document).ready(function() {

    $("#register-btn").click(function() {
        var firstName = '';
        var lastName = '';
        var username = '';
        var email = '';
        var password = '';
        var success_msg = 'Registered successfully.';
        var error_msg = 'Registration failed.';

        if($('#firstName').val()) {
            firstName = $('#firstName').val();
        } else {
            console.log('no first name');
        }

        if($('#lastName').val()) {
            lastName = $('#lastName').val();
        } else {
            console.log('no last name');
        }

        if($('#email').val()) {
            email = $('#email').val();
        } else {
            console.log('no email');
        }

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

        if(firstName.length != 0 && lastName.length != 0 && email.length != 0 && username.length != 0 && password.length != 0) {
            $.ajax({
                url: 'register.php',
                method: 'POST',
                data: {
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    username: username,
                    password: password
                },
                success: (response) => {
                    var res = response.substring(0, 7);
                    if(res != 'success'){
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
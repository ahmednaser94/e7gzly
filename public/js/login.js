
/* ==================================== 
    User Login
=======================================*/
$(`#login_form`).on(`submit`, function (ev) {
    ev.preventDefault();

    var email = $(`#login_email`).val().trim();
    var password = $(`#login_password`).val().trim();
    var remember = $(`#remember-me:checked`).val();

    $.ajax(`../api.php?section=users&do=user_login`, {
        method: `POST`,
        data: {
            'email': email,
            'password': password,
            'remember': remember,
        },
        success: function (data, textStatus, jqXHR) {
            login = JSON.parse(data);
            var msg = '';

            if (login == 'email')
                msg = "Email is Incorrect!";
            else if (login == 'password'){
                msg = "Password is Incorrect!";
                $('#forget_pass_link').removeClass('d-none');
                
            }
            //   if email and password are correct check for status
            else {
                // check for the user status before going on
                if (login == 'pending') {
                    msg = "Your account is still pending, please wait until your company's approval";
                    setTimeout(() => {
                        location.href = "logout.php"
                    }, 4000);
                    $('#msg-modal-body').html(msg);
                    $('#msg-alert').modal('toggle');
                    return false;
                }
                else if (login == 'rejected') {
                    msg = 'your account is rejected!';
                    setTimeout(() => {
                        location.href = "logout.php"
                    }, 3500);
                    $('#msg-modal-body').html(msg);
                    $('#msg-alert').modal('toggle');
                    return false;
                }
                else {
                    msg = "Login Successful!";
                    localStorage.setItem("user_type", login.user_type_id);
                }
            }
            // show the message 
            $('#msg-modal-body').html(msg);
            $('#msg-alert').modal('toggle');

            // in case of successful login
            if (msg == "Login Successful!") {
                $('#modal-login').modal('toggle');
                setTimeout(() => {
                    if (login.user_type_id > `1` && login.user_type_id < `5`)
                        location.href = "/org/index.php"
                    else if (login.user_type_id == `5`)
                        location.href = "/admin/index.php"
                    else
                        location.href = "index.php"
                }, 1500);
            }
        },
        error: function (jqXhr, textStatus, errorThrown) {
            console.log("Error: ", errorThrown);
        }
    })

});
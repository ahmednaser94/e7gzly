var feedMsg = {
    "emptyMail": "Please Enter an Email!",
    "enterMail": "Please Enter a Valid Email!",
    "mailExists": "Email already exists!",
    "nameShort": "Name is too short",
    "emptyPhone": "Please Enter a Phone!",
    "enterPhone": "Please Enter a Valid Phone Number!",
    "PhoneExists": "Phone already exists!",
    "emptyID": "Please Enter an ID!",
    "IDexists": "ID already exists!",
    "longName": "Name is too long ust be more than 10 and less than 40 characters",
    "shortName": "Name is short short must be more than 10 and less than 40 characters",
    "shortPass": "Password less than 5 characters",
    "invalidPass": "Password Does not meet requirements!!",
    "notMatching": "Password not matching!!",
    "matchPass": "Password Match!",
    "longAddress": "Address is too short must be more than 15 and less than 100 characters",
    "shortAddress": "Address is short long must be more than 15 and less than 100 characters",
    "mailAvail": "Email is available!",
    "phoneAvail": "Phone is available!",
    "IDAvail": "ID is available!",
};

var msgClass = { "valid": "valid-feedback", "invalid": "invalid-feedback" };

// show a message for the user under input
function ValidAlert(a, b, c) {
    $(a).removeClass().addClass(b);
    $(a).html(c).show();
    return true;
}


// check the link of the page of contains specific path
function checkPage(page) {
    return (window.location.pathname.includes(page)) ? true : false;
}

/* ==================================== 
    Update - Delete - Add  (About us)
=======================================*/
if (checkPage("about_us.php")) {

    // get the value of clicked button(add - update - delete)
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    $(`#about_us_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);
        var aboutUS = document.querySelector('.about_us_edit').value;

        $.ajax(`../../api.php?section=about_us&do=Update_about_us`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'details': aboutUS
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $(`.form-btn`).prop('disabled', false);
                // setTimeout(() => {
                //     location.href = "../../admin/about_us.php"
                // }, 2000);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`.form-btn`).prop('disabled', false);
    }

    );
}

/* ==================================== 
    Update - Delete - Add  (contacts)
=======================================*/
if (checkPage("contacts.php")) {

    // get the value of clicked button(add - update - delete)
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    $(`#about_us_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);
        var phone = $('#phone').val();
        var email = $('#email').val();
        var fb = $('#fb').val();
        var twitter = $('#twitter').val();
        var instagram = $('#instagram').val();
        var youtube = $('#youtube').val();
        var linkedin = $('#linkedin').val();

        $.ajax(`../../api.php?section=contacts&do=contacts_update`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'phone': phone,
                'email': email,
                'fb': fb,
                'twitter': twitter,
                'instagram': instagram,
                'youtube': youtube,
                'linkedin': linkedin
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $(`.form-btn`).prop('disabled', false);
                // setTimeout(() => {
                //     location.href = "../../admin/contacts.php"
                // }, 2000);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`.form-btn`).prop('disabled', false);
    }

    );
}


/* ==================================== 
    Update - Delete - Add  (Category)
=======================================*/
if (checkPage("category_update.php") || checkPage("category_add.php")) {

    // get the value of clicked button(add - update - delete)
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    $(`#category_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);

        var categID = $(`#cat_id option:selected`).val();
        var catName = $('#cat_name').val();

        $.ajax(`../../api.php?section=categories&do=category_update`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'cat_id': categID,
                'name': catName
            },
            success: function (data, textStatus, jqXHR) {
                console.log("Output: data", data)
                reply = JSON.parse(data);
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $(`.form-btn`).prop('disabled', false);
                setTimeout(() => {
                    location.href = "../../admin/categories.php"
                }, 2000);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`.form-btn`).prop('disabled', false);
    }

    );
}




/* ==================================== 
    Update - Delete - Add  (Organization)
=======================================*/
if (checkPage("org_update.php") || checkPage("org_add.php")) {

    // get the value of clicked button(add - update - delete)
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    $(`#org-form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);

        var orgID = $(`#org_id option:selected`).val();
        var categID = $(`#cat_id option:selected`).val();
        var Name = $('#_name').val();
        var license = $('#license').val();
        var url = $('#url').val();
        var phone = $('#org_phone').val();

        $.ajax(`../../api.php?section=organization&do=org_update`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'cat_id': categID,
                'org_id': orgID,
                'name': Name,
                'license': license,
                'phone': phone,
                'url': url
            },
            success: function (data, textStatus, jqXHR) {
                console.log("Output: data", data)
                reply = JSON.parse(data);
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $(`.form-btn`).prop('disabled', false);
                if (reply.includes('license')) {
                    return false
                }
                else {
                    setTimeout(() => {
                        location.href = "../../admin/orgs.php"
                    }, 2000);

                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`.form-btn`).prop('disabled', false);
    }

    );
}

/* ==================================== 
    Update - Delete - Add  (Organization)
=======================================*/
if (checkPage("org_user_update.php") || checkPage("org_user_add.php")) {

    // get the value of clicked button(add - update - delete)
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    // to prevent form submission if there are exists in DB
    var isMail = false;
    var isPhone = false;



    $(`#email`).blur(function () {
        // get the values to check for
        $(`#email`).prop('disabled', true);

        var email = $("#email").val().trim();
        if (email === '' || email.length < 9) {
            ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['emptyMail']);
            $(`#email`).prop('disabled', false);
            return false;
        }
        else if (email.length > 8) {
            const mailRegex = /^([a-zA-Z0-9]+\.?\_?[a-zA-Z0-9]+)+@{1}[a-zA-Z0-9\.]+/;
            if (!(mailRegex.test(email))) {
                ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['enterMail']);
                $(`#email`).prop('disabled', false);
                return false;
            }
        }
        $.ajax(`../../api.php?section=users&do=check_email`, {
            method: `POST`,
            data: {
                'email': email
            },
            success: function (data, textStatus, jqXHR) {
                checkMail = JSON.parse(data);
                if (checkMail !== "exists") {
                    ValidAlert('#mail_feedback', msgClass['valid'], feedMsg['mailAvail']);
                    var isMail = false;
                }
                else {
                    ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['mailExists']);
                    var isMail = true;
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })
        $(`#email`).prop('disabled', false);
    })

    // check if phone already exists 
    $("#phone").blur(function () {
        var phoneInput = $(`#phone`);
        phoneInput.prop('disabled', true);
        var phone = $("#phone").val().trim();

        if (phone === '') {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['emptyPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        else if (phone.length > 0 && (phone.length < 8 || phone.length > 11)) {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['enterPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        else {
            $.ajax(`../../api.php?section=users&do=check_phone`, {
                method: `POST`,
                data: {
                    'phone': phone
                },
                success: function (data, textStatus, jqXHR) {
                    checkPhone = JSON.parse(data);
                    if (checkPhone !== "exists") {
                        ValidAlert('#phone_feedback', msgClass['valid'], feedMsg['phoneAvail']);
                        isPhone = false;
                    }
                    else {
                        ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['PhoneExists']);
                        isPhone = true;
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log("Error: ", errorThrown);
                }
            })
            phoneInput.prop('disabled', false);
        }
    })


    // Validate Password
    $(`input[name=password]`).on('blur', function () {
        var pass = $(`input[name=password]`).val();
        const passRegex = /^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$/;
        if (pass.length > 0 && pass.length < 5) {
            ValidAlert('#pass_alert', msgClass['invalid'], feedMsg['shortPass']);
            return false;
        }
        else if (pass.length > 4 && (!passRegex.test(pass))) {
            ValidAlert('#pass_alert', msgClass['invalid'], feedMsg['invalidPass']);
            return false;
        }
        else
            $(`#pass_alert`).hide();
    })

    // validate password confirmation
    $(`input[name=confirmation]`).on('blur', function () {
        var confirm = $(`input[name=confirmation]`).val();
        if (confirm.length > 4 && $(`input[name=password]`).val() !== confirm) {
            ValidAlert('#confirm_alert', msgClass['invalid'], feedMsg['notMatching']);
            return false;
        }
        else
            $(`#confirm_alert`).hide();
    })

    $(`#org_user_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);

        $(`#register`).prop('disabled', true);
        if (isMail == true || isPhone == true) {
            // alert('Please check all fields again!');
            $('#msg-modal-body').html(`Please check all fields again!`);
            $('#msg-alert').modal('toggle');
            $(`.form-btn`).prop('disabled', false);
            return false;
        }

        var userID = $(`#user_id option:selected`).val();
        var orgID = $(`#org option:selected`).val();
        var Name = $('#_name').val();
        var phone = $('#phone').val();
        var address = $('#address').val();

        // in case of adding user
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax(`../../api.php?section=users&do=Update_org_user`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'user_id': userID,
                'org_id': orgID,
                'name': Name,
                'phone': phone,
                'address': address,
                'email': email,
                'password': password
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $(`.form-btn`).prop('disabled', false);

                if (reply.includes('successfully')) {
                    setTimeout(() => {
                        location.href = "org_users.php"
                    }, 2000);
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`.form-btn`).prop('disabled', false);
    }

    );
}


/* ==================================== 
    update user password
=======================================*/
if (checkPage("pass_update.php")) {
    $(`#pass_form`).on(`submit`, function (ev) {
        ev.preventDefault();

        var Oldpass = $(`input[name=old_password]`).val();
        var Newpass = $(`input[name=password]`).val();

        $.ajax(`../../api.php?section=users&do=password_update`, {
            method: `POST`,
            data: {
                'old_password': Oldpass,
                'new_password': Newpass,
            },
            success: function (data, textStatus, jqXHR) {
                userReg = JSON.parse(data);
                $('#msg-modal-body').html(userReg);
                $('#msg-alert').modal('toggle');

            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })

    });
}


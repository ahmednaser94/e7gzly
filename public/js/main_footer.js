var feedMsg = {
    "good": "Looks Good!",
    "emptyMail": "Please Enter an Email!",
    "enterMail": "Please Enter a Valid Email!",
    "mailExists": "Email already exists!",
    "nameShort": "Name is too short",
    "emptyPhone": "Please Enter a Phone!",
    "enterPhone": "Please Enter a Valid Phone Number!",
    "PhoneExists": "Phone already exists!",
    "emptyID": "Please Enter an ID!",
    "IDexists": "ID already exists!",
    "longName": "Name is too long must be between 10 and and 40 characters",
    "shortName": "Name is too short must be between 10 and and 40 characters",
    "shortPass": "Password less than 5 characters",
    "invalidPass": "Password Does not meet requirements!!",
    "notMatching": "Password not matching!!",
    "matchPass": "Password Match!",
    "longAddress": "Address is too long must be between 15 and and 100 characters",
    "shortAddress": "Address is too short must be between 15 and and 100 characters",
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


/* ====================================== 
    Booking Ticket
====================================== */
if (checkPage("book.php")) {

    $('#book_btn').prop('disabled', true);

    const servInfo = $('#service_info');

    servInfo.css({ "visibility": "hidden" });
    const category = $("#category");
    const organization = $("#organization");
    const branch = $("#branch");
    const service = $("#service");

    organization.prop('disabled', true);
    branch.prop('disabled', true);
    service.prop('disabled', true);

    category.change(function () {
        var catID = category.val();
        branch.prop('disabled', true);
        service.prop('disabled', true);

        $.ajax(`../api.php?section=organization&do=get_cat_organizations`, {
            method: `POST`,
            data: {
                'cat_id': catID
            },
            success: function (data, textStatus, jqXHR) {

                if (data == 'false') {
                    organization.html('');
                    organization.html('<option value="">There are no Organizations yet!</option>');
                }
                else {
                    orgs = JSON.parse(data);
                    organization.html('');
                    organization.html('<option disabled selected value="">choose Organization</option>');
                    orgs.forEach(function (item) {
                        organization.append(`<option value='${item.id}'>${item.name}</option>`);
                    })
                    organization.prop('disabled', false);
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })
    });

    // get branches inside an organization
    organization.change(function () {
        var org = organization.val();
        service.prop('disabled', true);

        $.ajax(`../api.php?section=branches&do=get_branches_post`, {
            method: `POST`,
            data: {
                'organization': org
            },
            success: function (data, textStatus, jqXHR) {
                br = $('#branch');
                if (data == 'false') {
                    br.html('');
                    br.html('<option value="">There are no Branches yet!</option>');
                }
                else {
                    branches = JSON.parse(data);
                    br.html('');
                    br.html('<option disabled selected value="">choose Branch</option>');
                    branches.forEach(function (branch) {
                        br.append(`<option value='${branch.br_id}'>${branch.name}</option>`);
                    })
                    branch.prop('disabled', false);
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })
    });

    // get services inside a branch
    branch.change(function () {
        var orgID = organization.val().trim();
        var branchID = branch.val().trim();
        service.prop('disabled', true);
        $.ajax(`../api.php?section=branch_services&do=get_branch_services_post`, {
            method: `POST`,
            data: {
                'org_id': orgID,
                'branch_id': branchID
            },
            success: function (data, textStatus, jqXHR) {
                if (data == 'false') {
                    service.html('');
                    service.html('<option value="">There are no Services yet!</option>');
                }
                else {
                    services = JSON.parse(data);
                    service.html('');
                    service.html('<option disabled selected value="">choose Service</option>');
                    services.forEach(function (item) {
                        service.append(`<option value='${item.id}'>${item.name}</option>`);
                    })
                    service.prop('disabled', false);
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })
    });


    // get details about a service
    service.change(function () {
        var orgID = organization.val().trim();
        var branchID = branch.val().trim();
        var brServiceID = service.val().trim();
        $('#book_btn').prop('disabled', false);

        $.ajax(`../api.php?section=branch_services&do=get_br_serv_status`, {
            method: `POST`,
            data: {
                'org_id': orgID,
                'branch_id': branchID,
                'br_service_id': brServiceID
            },
            success: function (data, textStatus, jqXHR) {
                if (data == 'false') {
                    $('#waiting_customers').html('No Waiting Customers!');
                    $('#ETA').html('0 Min');
                }
                else {
                    infos = JSON.parse(data);
                    $('#waiting_customers').html(infos.waiting);
                    if (infos.estimated > 60)
                        $('#ETA').html(`${Math.floor(infos.estimated / 60)} Hours &  ${infos.estimated % 60} Min`);
                    else
                        $('#ETA').html(`${infos.estimated} Min`);
                }
                servInfo.css({ "visibility": "visible" });

            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })
    });

    //  Add , Update or Delete Employee Data
    $(`#book_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`#book_btn`).prop('disabled', true);

        orgID = organization.val().trim();
        BranchID = branch.val().trim();
        ServiceID = service.val().trim();

        $.ajax(`../api.php?section=tickets&do=add_ticket`, {
            method: `POST`,
            data: {
                'org_id': orgID,
                'branch_id': BranchID,
                'br_service_id': ServiceID
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $('#book_btn').prop('disabled', false);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
                $('#book_btn').prop('disabled', false);
            }
        })
    })

}


/* ==================================== 
    update user password
=======================================*/

if (checkPage("reset_pass.php") || checkPage("pass_recovery_code.php")) {

    if (checkPage("reset_pass.php")) {
        setTimeout(() => {
            $('#delete_account').on('click', function (e) {
                var ticketID = $(this).val();

                var ok = confirm(`are you sure to Delete Your Account ?!`);
                if (!ok) {
                    e.preventDefault();
                }
                else {

                    $.ajax(`../api.php?section=users&do=delete_account`, {
                        method: `POST`,
                        success: function (data, textStatus, jqXHR) {
                            reply = JSON.parse(data);
                            $('#msg-modal-body').html(reply);
                            $('#msg-alert').modal('toggle');
                            setTimeout(() => {
                                location.href = "logout.php"
                            }, 2000);
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    })
                }
            });

        }, 300);
    }

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


    $(`#pass_form`).on(`submit`, function (ev) {
        ev.preventDefault();
        $('#reset_pass').prop('disabled', true);

        var Oldpass = $(`input[name=old_password]`).val();
        var Newpass = $(`input[name=password]`).val();

        $.ajax(`../api.php?section=users&do=password_update`, {
            method: `POST`,
            data: {
                'old_password': Oldpass,
                'new_password': Newpass,
            },
            success: function (data, textStatus, jqXHR) {
                userReg = JSON.parse(data);
                $('#msg-modal-body').html(userReg);
                $('#msg-alert').modal('toggle');
                $('#reset_pass').prop('disabled', false);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
                $('#reset_pass').prop('disabled', false);
            }
        })

    });

}


/* ==================================== 
    Update Profile
=======================================*/
if (checkPage("profile")) {

    $("#phone").blur(function () {
        var phoneInput = $(`#phone`);
        phoneInput.prop('disabled', true);
        var phone = $("#phone").val().trim();

        if (phone === '') {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['emptyPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        else if (phone.length > 0 && (phone.length < 4 || phone.length > 12)) {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['enterPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        phoneInput.prop('disabled', false);

    })


    //  Add , Update or Delete Employee Data
    $(`#profile-form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);


        var name = $('#_name').val().trim();
        var address = $('#address').val().trim();
        var phone = $('#phone').val().trim();


        $.ajax(`../../api.php?section=users&do=user_update`, {
            method: `POST`,
            data: {
                '_name': name,
                'phone': phone,
                'address': address
            },
            success: function (data, textStatus, jqXHR) {
                console.log("Output: data", data)
                if (data.includes('phone')) {
                    $('#msg-modal-body').html("Phone Already Exists");
                    $('#msg-alert').modal('toggle');
                    $(`.btn`).prop('disabled', false);
                    return false;
                }
                reply = JSON.parse(data);
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $(`.btn`).prop('disabled', false);
                setTimeout(() => {
                    location.href = "profile.php"
                }, 2000);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
    })
}

/* ==================================== 
    Delete a ticket
=======================================*/
if (checkPage("my_tickets")) {
    setTimeout(() => {
        $('.ticket_delete').on('click', function (e) {
            var ticketID = $(this).val();

            var ok = confirm(`are you sure to Delete this Ticket ?!`);
            if (!ok) {
                e.preventDefault();
            }
            else {
                $.ajax(`../api.php?section=tickets&do=delete_ticket`, {
                    method: `POST`,
                    data: {
                        'ticket_id': ticketID
                    },
                    success: function (data, textStatus, jqXHR) {
                        reply = JSON.parse(data);
                        $('#msg-modal-body').html(reply);
                        $('#msg-alert').modal('toggle');
                        setTimeout(() => {
                            location.href = "my_tickets.php"
                        }, 2000);
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                })
            }
        });

    }, 300);


}

if (checkPage("pass_recovery.php")) {

    $('#phone_cont').hide();

    $(`input[type=radio][name=type]`).change(function () {
        if ($(this).val() == "email") {
            $('#phone_cont').hide();
        }
        else if ($(this).val() == "phone") {
            $('#phone_cont').show();
        }
    })


    var isPhone = false;

    // check if phone already exists 
    $("#phone").blur(function () {
        var phoneInput = $(`#phone`);
        phoneInput.prop('disabled', true);
        var phone = $("#phone").val().trim();

        if (phone === '') {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['emptyPhone']);
            phoneInput.prop('disabled', false);
            $("#phone").removeClass('is-valid').addClass('is-invalid');
            return false;
        }
        else if (phone.length > 0 && (phone.length < 8 || phone.length > 11)) {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['enterPhone']);
            phoneInput.prop('disabled', false);
            $("#phone").removeClass('is-valid').addClass('is-invalid');
            return false;
        }
        else {
            $.ajax(`../api.php?section=users&do=check_recovery_phone`, {
                method: `POST`,
                data: {
                    'phone': phone
                },
                success: function (data, textStatus, jqXHR) {
                    checkPhone = JSON.parse(data);
                    if (checkPhone == "wrong phone") {
                        ValidAlert('#phone_feedback', msgClass['invalid'], 'Phone is not correct');
                        $(`#pass_form_btn`).prop('disabled', true);
                        $("#phone").removeClass('is-valid').addClass('is-invalid');
                        return false;
                    }
                    else {
                        ValidAlert('#phone_feedback', msgClass['valid'], 'Phone is correct');
                        $("#phone").removeClass('is-invalid').addClass('is-valid');
                        $(`#pass_form_btn`).prop('disabled', false);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log("Error: ", errorThrown);
                }
            })
            phoneInput.prop('disabled', false);
        }
    })



    // validate form and register a user
    $(`#forget_pass_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);


        var type = $(`input[type=radio][name=type]:checked`).val();

        if (type == "phone") {
            if (isPhone == true || phone == '') {
                $('#msg-modal-body').html(`Please check phone again!`);
                $('#msg-alert').modal('toggle');
                $(`.form-btn`).prop('disabled', false);
                return false;
            }
        }
        $.ajax(`../api.php?section=pass_recovery&do=send_code`, {
            method: `POST`,
            data: {
                'type': type
            },
            success: function (data, textStatus, jqXHR) {
                console.log("Output: data", data)
                if (data == 'false' || data.includes('Exceptions')) {
                    if (data == 'false')
                        $('#msg-modal-body').html('Please Check your credentials again!');
                    else
                        $('#msg-modal-body').html('sending failed, choose different method!');

                    $('#msg-alert').modal('toggle');
                    $(`.form-btn`).prop('disabled', false);
                    return false;
                }
                else {
                    reply = JSON.parse(data)
                    if (reply.includes('sent')) {
                        if (type == "email")
                            $('#msg-modal-body').html('Message sent Successfully, please check your email');
                        else
                            $('#msg-modal-body').html('Message sent Successfully, please check your Phone');

                        $('#msg-alert').modal('toggle');
                        setTimeout(() => {
                            $(`.form-btn`).prop('disabled', false);
                        }, 3000);
                        setTimeout(() => {
                            location.href = "pass_recovery_code.php"
                        }, 4000);
                    }
                    else if (reply.includes('sending failed') || !(reply.includes('sent'))) {
                        $('#msg-modal-body').html('Sending Failed, please choose another method');
                        $('#msg-alert').modal('toggle');
                        $(`.form-btn`).prop('disabled', false);
                    }
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
                $(`.form-btn`).prop('disabled', false);
            }
        })
    });
}

if (checkPage("pass_recovery_code.php")) {

    $('#pass_reset_form').hide();

    // validate form and register a user
    $(`#recovery_code_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`#code_btn`).prop('disabled', true);

        var code = $('#recovery_code').val();

        $.ajax(`../api.php?section=pass_recovery&do=confirm_code`, {
            method: `POST`,
            data: {
                'code': code
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                if (reply == 'false') {
                    $('#msg-modal-body').html('Wrong Code!');
                    $('#msg-alert').modal('toggle');
                    $(`#code_btn`).prop('disabled', false);
                    return false;
                }
                else if (reply == 'true') {
                    $('#msg-modal-body').html('Code is correct, please choose a password');
                    $('#code_div').hide();
                    $('#msg-alert').modal('toggle');
                    $('#pass_code_hidden').html(code);
                    setTimeout(() => {
                        $('#msg-alert').modal('toggle');
                    }, 3500);
                    $('#pass_reset_form').show();
                    $('#recovery_code').prop('disabled', true);
                    $(`#code_btn`).prop('disabled', true);
                }
                else {
                    $(`#code_btn`).prop('disabled', false);
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
                $(`#code_btn`).prop('disabled', false);
            }
        })
    })


    $(`#pass_reset_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`#pass_btn`).prop('disabled', true);

        var code2 = $('#pass_code_hidden').html();
        var password = $('#password').val();

        $.ajax(`../api.php?section=pass_recovery&do=reset_pass`, {
            method: `POST`,
            data: {
                'code2': code2,
                'new_password': password
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                if (reply == 'code changed') {
                    $('#msg-modal-body').html('please refresh the page and enter a correct code again!');
                    $(`#pass_btn`).prop('disabled', false);
                    return false;
                }
                else if (reply.includes('successfully')) {
                    $('#msg-modal-body').html(reply);
                    setTimeout(() => {
                        location.href = "index.php"
                    }, 2000);
                    $(`#pass_btn`).prop('disabled', false);
                }
                $('#msg-alert').modal('toggle');
                $(`#pass_btn`).prop('disabled', false);


            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
                $(`#pass_btn`).prop('disabled', false);
            }
        })
    })



}
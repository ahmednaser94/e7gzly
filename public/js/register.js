var feedMsg = {
    "branchManagerExists": "This branch already has a manager, contact your organization!",
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


// hide employee section if the user is customer
if ($('#organization').val())
    $(`.comp`).show();
else
    $(`.comp`).hide();


// $('#register').prop('disabled', true);

// change employee section display
$(`input[type=radio][name=user_type]`).change(function () {
    if (this.value == 1) {
        $('.comp').hide();
    } else if (this.value == 2 || this.value == 3) {
        $('.comp').show();
        $("#branch").prop('disabled', true);
        $("#comp_id").prop('disabled', true);
        $('#branch_feedback').hide();
        $.ajax(`../api.php?section=organization&do=get_all_organizations`, {
            method: `POST`,
            data: {

            },
            success: function (data, textStatus, jqXHR) {
                organization = $('#organization');
                organization.html('');
                if (data == 'false') {
                    org.html('<option disabled value="">There are no Organizations!!</option>');
                }
                else {
                    orgs = JSON.parse(data);
                    organization.html('<option disabled selected value="">choose Organization </option>');
                    orgs.forEach(function (org) {
                        organization.append(`<option value='${org.id}'>${org.name}</option>`);
                    })
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })
    }
});

// to prevent form submission if there are exists in DB
var isMail = false;
var isPhone = false;
var isID = false;
var isBM = false;

// disable branch and comp ID 
$("#branch").prop('disabled', true);
$("#comp_id").prop('disabled', true);

// get the branches of a chosen organization
$("#organization").change(function () {
    var org = $("#organization").val();

    $('#branch').removeClass('is-invalid', 'is-valid');
    $('#branch_feedback').hide();

    $.ajax(`../api.php?section=branches&do=get_branches_post`, {
        method: `POST`,
        data: {
            'organization': org
        },
        success: function (data, textStatus, jqXHR) {
            br = $('#branch');
            if (data == 'false') {
                br.html('');
                br.html('<option disabled selected value="">There are no Branches yet!</option>');
                $("#organization").removeClass('is-valid').addClass('is-invalid');
            }
            else {
                branches = JSON.parse(data);
                $("#organization").removeClass('is-invalid').addClass('is-valid');
                br.html('');
                br.html('<option disabled selected value="">choose Branch</option>');
                branches.forEach(function (branch) {
                    br.append(`<option value='${branch.br_id}'>${branch.name}</option>`);
                })
                $("#branch").prop('disabled', false);
            }
        },
        error: function (jqXhr, textStatus, errorThrown) {
            console.log("Error: ", errorThrown);
        }
    })
});

$("#branch").change(function () {

    $("#comp_id").prop('disabled', true);
    var userType = $(`input[name=user_type]:checked`).val().trim();
    if (userType == 3) {
        var organization = $(`#organization`).val();
        var branch = $(`#branch`).val();

        $.ajax(`../api.php?section=users&do=check_branch_manager`, {
            method: `POST`,
            data: {
                'org_id': organization,
                'branch_id': branch
            },
            success: function (data, textStatus, jqXHR) {
                if (data == 'false') {
                    isBM = false;
                    $('#branch').removeClass('is-invalid').addClass('is-valid');
                    $('#branch_feedback').hide();
                    $("#comp_id").prop('disabled', false);
                }
                else {
                    checkBranchManager = JSON.parse(data);
                    ValidAlert('#branch_feedback', msgClass['invalid'], checkBranchManager);
                    $('#branch').removeClass('is-valid').addClass('is-invalid');
                    isBM = true;
                    return false;
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })
    }
    else {
        $("#comp_id").prop('disabled', false);
    }


});

// check if email already exists
$(document).ready(function () {

    $(`#email`).blur(function () {
        // get the values to check for
        $(`#email`).prop('disabled', true);

        var email = $("#email").val().trim();
        if (email === '' || email.length < 9) {
            ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['emptyMail']);
            $(`#email`).prop('disabled', false);
            $('#email').removeClass('is-valid').addClass('is-invalid');
            return false;
        }
        // else if (email.length > 8) {
        //     const mailRegex = /^([a-zA-Z0-9]+\.?\_?[a-zA-Z0-9]+)+@{1}[a-zA-Z0-9\.]+/;
        //     if (!(mailRegex.test(email))) {
        //         ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['enterMail']);
        //         $(`#email`).prop('disabled', false);
        //         $('#email').removeClass('is-valid').addClass('is-invalid');
        //         return false;
        //     }
        // }
        $.ajax(`../api.php?section=users&do=check_email`, {
            method: `POST`,
            data: {
                'email': email
            },
            success: function (data, textStatus, jqXHR) {
                checkMail = JSON.parse(data);
                if (checkMail !== "exists") {
                    ValidAlert('#mail_feedback', msgClass['valid'], feedMsg['mailAvail']);
                    isMail = false;
                    $('#email').removeClass('is-invalid').addClass('is-valid');
                }
                else {
                    ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['mailExists']);
                    isMail = true;
                    $('#email').removeClass('is-valid').addClass('is-invalid');
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
            $('#phone').removeClass('is-valid').addClass('is-invalid');
            return false;
        }
        else if (phone.length > 0 && (phone.length < 8 || phone.length > 11)) {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['enterPhone']);
            phoneInput.prop('disabled', false);
            $('#phone').removeClass('is-valid').addClass('is-invalid');
            return false;
        }
        else {
            $.ajax(`../api.php?section=users&do=check_phone`, {
                method: `POST`,
                data: {
                    'phone': phone
                },
                success: function (data, textStatus, jqXHR) {
                    checkPhone = JSON.parse(data);
                    if (checkPhone !== "exists") {
                        ValidAlert('#phone_feedback', msgClass['valid'], feedMsg['phoneAvail']);
                        isPhone = false;
                        $('#phone').removeClass('is-invalid').addClass('is-valid');
                    }
                    else {
                        ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['PhoneExists']);
                        isPhone = true;
                        $('#phone').removeClass('is-valid').addClass('is-invalid');
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log("Error: ", errorThrown);
                }
            })
            phoneInput.prop('disabled', false);
        }
    })


    // check if Employee ID already exists 
    $("#comp_id").blur(function () {
        var orgID = $('#organization').val().trim();
        var compID = $("#comp_id").val().trim();
        if (compID === '') {
            ValidAlert('#comp_id_alert', msgClass['invalid'], feedMsg['emptyID']);
            $('#comp_id').removeClass('is-valid').addClass('is-invalid');
        }
        else {
            $.ajax(`../api.php?section=users&do=check_comp_id`, {
                method: `POST`,
                data: {
                    'org_id': orgID,
                    'comp_id': compID
                },
                success: function (data, textStatus, jqXHR) {
                    checkID = JSON.parse(data);
                    if (checkID !== "exists") {
                        ValidAlert('#comp_id_alert', msgClass['valid'], feedMsg['IDAvail']);
                        $('#comp_id').removeClass('is-invalid').addClass('is-valid');
                        isID = false;
                    }
                    else {
                        ValidAlert('#comp_id_alert', msgClass['invalid'], feedMsg['IDexists']);
                        $('#comp_id').removeClass('is-valid').addClass('is-invalid');
                        isID = true;
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log("Error: ", errorThrown);
                }
            })
        }
    })
});

//  VALIDATION
// Name Validation
$(`input[name=_name]`).on('blur', function () {
    var name = $(`input[name=_name]`).val().trim();
    if (name.length > 40) {
        ValidAlert('#name_feedback', msgClass['invalid'], feedMsg['longName']);
        $(`input[name=_name]`).removeClass('is-valid').addClass('is-invalid');
        return false;
    }
    else if (name.length > 0 && name.length < 10) {
        ValidAlert('#name_feedback', msgClass['invalid'], feedMsg['shortName']);
        $(`input[name=_name]`).removeClass('is-valid').addClass('is-invalid');
        return false;
    }
    else {
        $(`#name_feedback`).hide();
        $(`input[name=_name]`).removeClass('is-invalid').addClass('is-valid');
    }
})

// Validate Password
$(`input[name=password]`).on('blur', function () {
    var pass = $(`input[name=password]`).val();
    const passRegex = /^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$/;
    if (pass.length > 0 && pass.length < 5) {
        ValidAlert('#pass_alert', msgClass['invalid'], feedMsg['shortPass']);
        $(`input[name=password]`).removeClass('is-valid').addClass('is-invalid');
        return false;
    }
    else if (pass.length > 4 && (!passRegex.test(pass))) {
        ValidAlert('#pass_alert', msgClass['invalid'], feedMsg['invalidPass']);
        $(`input[name=password]`).removeClass('is-valid').addClass('is-invalid');
        return false;
    }
    else {
        $(`#pass_alert`).hide();
        $(`input[name=password]`).removeClass('is-invalid').addClass('is-valid');
    }
})

// validate password confirmation
$(`input[name=confirmation]`).on('blur', function () {
    var confirm = $(`input[name=confirmation]`).val();
    if (confirm.length > 4) {
        if ($(`input[name=password]`).val() !== confirm) {
            ValidAlert('#confirm_alert', msgClass['invalid'], feedMsg['notMatching']);
            $(`input[name=confirmation]`).removeClass('is-valid').addClass('is-invalid');
            return false;
        }
        else {
            ValidAlert('#confirm_alert', msgClass['valid'], "Password Match!");
            $(`input[name=confirmation]`).removeClass('is-invalid').addClass('is-valid');
        }
    }
})

// Address Validation
$(`input[name=address]`).on('blur', function () {
    var address = $(`input[name=address]`).val().trim();
    if (address.length > 100) {
        ValidAlert('#address_feedback', msgClass['invalid'], feedMsg['longAddress']);
        $(`input[name=address]`).removeClass('is-valid').addClass('is-invalid');
        return false;
    }
    if (address.length < 15) {
        ValidAlert('#address_feedback', msgClass['invalid'], feedMsg['shortAddress']);
        $(`input[name=address]`).removeClass('is-valid').addClass('is-invalid');
        return false;
    }
    else {
        $(`#address_feedback`).hide();
        $(`input[name=address]`).removeClass('is-invalid').addClass('is-valid');
    }

})

// validate form and register a user
$(`#reg_form`).on(`submit`, function (ev) {
    ev.preventDefault();

    $(`#register`).prop('disabled', true);
    if (isMail == true || isPhone == true || isID == true || isBM == true) {
        // alert('Please check all fields again!');
        $('#msg-modal-body').html(`Please check all fields again!`);
        $('#msg-alert').modal('toggle');
        $(`#register`).prop('disabled', false);
        return false;
    }

    var userType = $(`input[name=user_type]:checked`).val().trim();
    var name = $(`input[name=_name]`).val().trim();
    var email = $("#email").val().trim();
    var pass = $(`input[name=password]`).val();
    var address = $(`input[name=address]`).val().trim();
    var phone = $("#phone").val().trim();
    var organization = $(`#organization`).val();
    var branch = $(`#branch`).val();
    var compID = $(`input[name=comp_id]`).val();


    $.ajax(`../api.php?section=users&do=reg`, {
        method: `POST`,
        data: {
            'user_type': userType,
            '_name': name,
            'email': email,
            'phone': phone,
            'password': pass,
            'address': address,
            'organization': organization,
            'branch': branch,
            'comp_id': compID
        },
        success: function (data, textStatus, jqXHR) {

            userReg = JSON.parse(data);

            // show the message 
            $('#msg-modal-body').html(userReg);
            $('#msg-alert').modal('toggle');
            $(`#register`).prop('disabled', false);
            if (userReg.includes('successfully')) {
                setTimeout(() => {
                    location.href = "/index.php"
                }, 4000);
            }

        },
        error: function (jqXhr, textStatus, errorThrown) {
            console.log("Error: ", errorThrown);
        }
    })

});


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


//  VALIDATION
// Name Validation
$(`input[name=_name]`).on('blur', function () {
    var name = $(`input[name=_name]`).val().trim();
    if (name.length > 30) {
        ValidAlert('#name_alert', msgClass['invalid'], feedMsg['longName']);
        return false;
    }
    else if (name.length > 0 && name.length < 10) {
        ValidAlert('#name_alert', msgClass['invalid'], feedMsg['shortName']);
        return false;
    }
    else
        $(`#name_alert`).hide();
})

// Address Validation
$(`input[name=address]`).on('blur', function () {
    var address = $(`input[name=address]`).val().trim();
    if (address.length > 100) {
        ValidAlert('#address_feedback', msgClass['invalid'], feedMsg['longAddress']);
        return false;
    }
    if (address.length < 15) {
        ValidAlert('#address_feedback', msgClass['invalid'], feedMsg['shortAddress']);
        return false;
    }
    else
        $(`#address_feedback`).hide();

})



// Validate Password
$(`input[name=password]`).on('blur', function () {
    var pass = $(`input[name=password]`).val();
    const passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,20}$/;
    if (pass.length > 0 && pass.length < 5) {
        console.log("tooo short");
        // ValidAlert('#pass_alert', msgClass['invalid'], feedMsg['shortPass']);
        return false;
    }
    else if (pass.length > 4 && (!passRegex.test(pass))) {
        console.log("invalid");
        // ValidAlert('#pass_alert', msgClass['invalid'], feedMsg['invalidPass']);
        return false;
    }
    // else
    //     $(`#pass_alert`).hide();
})

// validate password confirmation
$(`input[name=confirmation]`).on('blur', function () {
    var confirm = $(`input[name=confirmation]`).val();
    if (confirm.length > 4 && $(`input[name=password]`).val() !== confirm) {
        console.log("no match");
        // ValidAlert('#confirm_alert', msgClass['invalid'], feedMsg['notMatching']);
        return false;
    }
    // else
    //     $(`#confirm_alert`).hide();
})

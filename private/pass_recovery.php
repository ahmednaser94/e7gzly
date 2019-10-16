<?php
session_start();
ob_start();

require __DIR__ . '/vendor/autoload.php';

use Twilio\Rest\Client;


use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/vendor/autoload.php';
require_once "..\private\class\User.php";

$u = new User();

switch ($_GET['do']) {
    case 'send_code': {


            $name =  $_SESSION['recovery_name'];
            $phone = $_SESSION['recovery_phone'];
            $email =  $_SESSION['recovery_email'];

            $code = rand(11111, 99999);

            $_SESSION['code'] = $code;


            if ($_POST['type'] == "email") {

                $mail = new PHPMailer;

                $mail->IsSMTP();
                // $mail->SMTPDebug = 4;
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;
                $mail->IsHTML(true);

                $mail->Username = "webdevtest25@gmail.com";
                $mail->Password = "Ahmed@naser1";

                $mail->setFrom('webdevtest25@gmail.com', 'E7GZLY');
                $mail->addAddress($email, $name);

                $mail->Subject = 'Password Recovery Code from E7GZLY';
                $mail->Body = '  <h2>Dear ' . $name . ' <br>this is your password recovery code: ' . $code . ' <br>Thanks <br> E7GZLY </h2>';

                if (!$mail->send()) {
                    $data =  "sending failed";
                } else {

                    $data =  "sent";
                }
            } else if ($_POST['type'] == "phone") {

                // Your Account SID and Auth Token from twilio.com/console
                $account_sid = 'AC320b843b6acfa154f5bafdf38ad09add';
                $auth_token = 'a6710d696e89ae777939177a9c28f1c2';
                // In production, these should be environment variables. E.g.:

                // A Twilio number you own with SMS capabilities
                $twilio_number = "+19802553977";

                $client = new Client($account_sid, $auth_token);
                $client->messages->create(
                    '+2' . $phone . '',
                    array(
                        'from' => $twilio_number,
                        'body' => 'Dear ' . $name . '! This is your recovery code: ' . $code . '',
                        "statusCallback" => "http://postb.in/1234abcd"
                    )
                );

                $data = 'sent';
            }
        }
        break;

    case 'confirm_code': {
            $form_code = trim($_POST['code']);
            if ($_SESSION['code'] == $form_code)
                return $data = 'true';
            else
                return $data = 'false';
        }
        break;

    case 'reset_pass': {
            if ($_SESSION['code'] == trim($_POST['code2'])) {
                $u->setUserID($_SESSION['recovery_user_id']);
                $u->setNewPassword($_POST['new_password']);
                $data = $u->RecoveryPass();
                unset($_SESSION['code']);
                unset($_SESSION['recovery_name']);
                unset($_SESSION['recovery_email']);
                unset($_SESSION['recovery_phone']);
                unset($_SESSION['recovery_user_id']);
                unset($_SESSION['phone_digits']);
            } else {
                return $data = 'code changed';
            }
        }
        break;

    default:
        $data = 'choose Action';
        break;
}

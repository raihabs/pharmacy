<?php
include '../config/connect.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../usersignin/PHPMailer/Exception.php';
require '../usersignin/PHPMailer/PHPMailer.php';
require  '../usersignin/PHPMailer/SMTP.php';

// echo "dfd";
var_dump(isset($_POST['check-email']));
if (isset($_POST['check-email'])) {
    $email =  mysqli_real_escape_string($conn, $_POST['email']);
    if ($email == '') {
        $_SESSION['forgot_pass'] = "Field are required.";
        $_SESSION['forgot_icon'] = "error";
        header('location: ../usersignin/reset-page.php');
        exit();
    } else {
        // echo $email;
        $check_email = "SELECT * FROM user WHERE email = '" . $email . "'";
        $run_sql = mysqli_query($conn, $check_email);
        if (mysqli_num_rows($run_sql) > 0) {
            $info = mysqli_fetch_assoc($run_sql);
            $name = $info['firstname'] . " " . $info['lastname'];
            $username = $info['username'];
            $code = rand(999999, 111111);

            date_default_timezone_set('Asia/Manila');
            $time = new DateTime();

            $current_time = $time->format('H:i:s');

            $time->modify('+8 minutes');

            $new_time = $time->format('H:i:s');

            $insert_code = "UPDATE user SET code = '" . $code . "', time = '" . $new_time . "' WHERE email='" . $email . "'";
            $run_query =  mysqli_query($conn, $insert_code);
            if ($run_query) {
                $query = "SELECT code FROM user WHERE email = '" . $email . "'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $email_code = $row['code'];

                $mail = new PHPMailer;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = "rh.mis0524@gmail.com";
                $mail->Password = "dgpq kscg ljap wvyi";
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom("rh.mis0524@gmail.com", ' BrindoxCare');
                $mail->addReplyTo('donotreply@gmail.com', 'DONOTREPLY');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $code = rand(999999, 111111);
                $detect_device = $_SERVER['HTTP_USER_AGENT'];


                $year = date("Y");

                $email_logo = '<img height="110" src="../assets/images/default_images/brindox.png" title="brindox_care" alt="brindox care">';
                $email_footer = '© ' . $year . ' ' . "Brindox";
                $email_name = strtok($name, " ");
                $code = $email_code;
                $email_device = $detect_device;
                $email_username = $username;

                $email_template = '../usersignin/template_mail/reset_password.html';
                $message = file_get_contents($email_template);
                $message = str_replace('%email_logo%', $email_logo, $message);
                $message = str_replace('%email_footer%', $email_footer, $message);
                $message = str_replace('%email_name%', $email_name, $message);
                $message = str_replace('%email_username%', $email_username, $message);
                $message = str_replace('%email_code%', $code, $message);
                $message = str_replace('%email_device%', $email_device, $message);
                $mail->Subject = 'Password Reset Code';
                $mail->MsgHTML($message);
                if ($mail->send()) {
                    // $info = "We've sent a password reset code to your email address - $email";
                    // $_SESSION['info'] = $info;
                    // $_SESSION['email'] = $email;
                    // $_SESSION['msg_status'] = array("msg" => "Success", "icon" => "success");
                    $info = "We've sent a new password reset code to your email address.";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    $_SESSION['verify_icon'] = "success";

                    header('location: ../usersignin/verification-code.php');
                    exit();
                } else {
                    $_SESSION['forgot_pass'] = "Failed while sending password reset code" . $email;
                    $_SESSION['forgot_icon'] = "error";
                    header('location: ../usersignin/reset-page.php');
                    exit();
                }
            } else {
                $_SESSION['forgot_pass'] = "Something went wrong";
                $_SESSION['forgot_icon'] = "error";
                header('location: ../usersignin/reset-page.php');
                exit();
            }
        } else {
            $_SESSION['forgot_pass'] = "Email address does not exist";
            $_SESSION['forgot_icon'] = "error";
            header('location: ../usersignin/reset-page.php');
            exit();
        }
    }
}


if (isset($_POST['check-code'])) {
    $email =  mysqli_real_escape_string($conn, $_POST['email']);
    $code =  mysqli_real_escape_string($conn, $_POST['code']);
    if ($code == '') {
        $_SESSION['verify_status'] = "Field are required.";
        $_SESSION['verify_icon'] = "error";
        header('location: ../usersignin/verification-code.php');
        exit();
    } else {
        if (empty($code)) {
            $_SESSION['verify_status'] = "Please enter the password reset code.";
            $_SESSION['verify_icon'] = "warning";
            header('location: ../usersignin/verification-code.php');
            exit();
        } else if (!(is_numeric($code))) {
            $_SESSION['verify_status'] = "Invalid input. Numbers only.";
            $_SESSION['verify_icon'] = "warning";
            header('location: ../usersignin/verification-code.php');
            exit();
        } else {
            if (strlen($code) > 6) {
                $_SESSION['verify_status'] = "Please enter the password reset code exact size!";
                $_SESSION['verify_icon'] = "warning";
                header('location: ../usersignin/verification-code.php');
                exit();
            } else {
                $check_code = "SELECT email, code FROM user WHERE email = '" . $email . "' AND code = '" . $code . "'";
                $run_sql = mysqli_query($conn, $check_code);
                if (mysqli_num_rows($run_sql) > 0) {
                    $_SESSION['email'] = $email;
                    $_SESSION['code'] = $code;
                    header('location: ../usersignin/resetpassword.php');
                    exit();
                } else {
                    $check_code1 = "SELECT * FROM `user` WHERE `email` = '" . $email . "'";
                    $run_sql1 = mysqli_query($conn, $check_code1);

                    $info = mysqli_fetch_assoc($run_sql1);
                    $initial_time = $info['time'];

                    date_default_timezone_set('Asia/Manila');
                    // Get current time
                    $time = new DateTime();
                    $limit_time = $time->format('H:i:s');


                    if ($limit_time > $initial_time) {
                        $_SESSION['verify_status'] = "Your password reset code has expired";
                        $_SESSION['verify_icon'] = "warning";
                        header('location: ../usersignin/verification-code.php');
                        exit();
                    } else {
                        $_SESSION['verify_status'] = "You\'ve entered an invalid code!";
                        $_SESSION['verify_icon'] = "warning";
                        header('location: ../usersignin/verification-code.php');
                        exit();
                    }
                }
            }
        }
    }
}

$resend_code = 0;
if (isset($_POST['resend-code'])) {
    $email = $_POST['email'];
    // $resend_code = $_SESSION['resend_code_' . md5($email)]  >= 1 ? $_SESSION['resend_code_' . md5($email)]++ : $_SESSION['resend_code_' . md5($email)] = 1;

    if ($email < 10) {
        $_SESSION['verify_status'] = "Unable to resend new code. Please Contact System Admin.";
        $_SESSION['verify_icon'] = "error";
        header('location: ../usersignin/verification-code.php');
        exit();
    } else {
        $check_email = "SELECT * FROM user WHERE email='$email'";
        $run_sql = mysqli_query($conn, $check_email);
        $info = mysqli_fetch_assoc($run_sql);
        $name = $info['firstname'] . " " . $info['lastname'];
        $username = $info['username'];
        $code = rand(999999, 111111);


        date_default_timezone_set('Asia/Manila');
        $time = new DateTime();

        $current_time = $time->format('H:i:s');

        $time->modify('+8 minutes');

        $new_time = $time->format('H:i:s');

        $insert_code = "UPDATE user SET code = '" . $code . "', time = '" . $new_time . "'  WHERE email='$email'";
        $run_query =  mysqli_query($conn, $insert_code);

        if ($run_query) {
            $query = "SELECT code FROM user WHERE email = '" . $email . "'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $email_code = $row['code'];

            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = "rh.mis0524@gmail.com";
            $mail->Password = "dgpq kscg ljap wvyi";
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom("rh.mis0524@gmail.com", 'BrindoxCare');
            $mail->addReplyTo('donotreply@gmail.com', 'DONOTREPLY');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $code = rand(999999, 111111);
            $detect_device = $_SERVER['HTTP_USER_AGENT'];


            $year = date("Y");

            $email_logo = '<img height="110" src="../assets/images/default_images/brindox.png" title="brindox_care" alt="brindox care">';
            $email_footer = '© ' . $year . ' ' . "Brindox";
            $email_name = strtok($name, " ");
            $code = $email_code;
            $email_device = $detect_device;
            $email_username = $username;

            $email_template =  '../usersignin/template_mail/reset_password.html';
            $message = file_get_contents($email_template);
            $message = str_replace('%email_logo%', $email_logo, $message);
            $message = str_replace('%email_footer%', $email_footer, $message);
            $message = str_replace('%email_name%', $email_name, $message);
            $message = str_replace('%email_username%', $email_username, $message);
            $message = str_replace('%email_code%', $code, $message);
            $message = str_replace('%email_device%', $email_device, $message);
            $mail->Subject = 'New Password Reset Code';
            $mail->MsgHTML($message);
            if ($mail->send()) {
                $info = "We've sent a new password reset code to your email address.";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['verify_status'] = "Sent Successfully";
                $_SESSION['verify_icon'] = "success";
                header('location: ../usersignin/verification-code.php');
                exit();
            } else {
                $_SESSION['verify_status'] = "Failed while sending new password reset code";
                $_SESSION['verify_icon'] = "error";
                header('location: ../usersignin/verification-code.php');
                exit();
            }
        } else {
            $_SESSION['verify_status'] = "Something went wrong";
            $_SESSION['verify_icon'] = "error";
            header('location: ../usersignin/verification-code.php');
            exit();
        }
    }
}
if (isset($_POST['reset-pass'])) {
    $email = $_POST['email'];
    $newpass = $_POST['newpass'];
    $verifypass = $_POST['verifypass'];
    $newpass = mysqli_real_escape_string($conn, $_POST['newpass']);
    $verifypass = mysqli_real_escape_string($conn, $_POST['verifypass']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);


    if ($newpass == "" || $verifypass == "") {
        $_SESSION['reset_status'] = "Fields are Required.";
        $_SESSION['reset_icon'] = "error";
        header('location: /pharmacy/usersignin/resetpassword.php');
        exit();
    } else if ($newpass != $verifypass) {
        $_SESSION['reset_status'] = "The input password did not match";
        $_SESSION['reset_icon'] = "error";
        header('location: /pharmacy/usersignin/resetpassword.php');
        exit();
    } else if (strlen($newpass) < 8  || !preg_match('/[A-Z]/', $newpass) || !preg_match('/[a-z]/', $newpass) || !preg_match('/[0-9]/', $newpass)) {
        $_SESSION['reset_status'] = "Invalid User New Password! Check if the new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit";
        $_SESSION['reset_icon'] = "error";
        header('location: /pharmacy/usersignin/resetpassword.php');
        exit();
    } else if (strlen($verifypass) < 8  || !preg_match('/[A-Z]/', $verifypass) || !preg_match('/[a-z]/', $verifypass) || !preg_match('/[0-9]/', $verifypass)) {
        $_SESSION['reset_status'] = "Invalid User Confirm New Password! Check if the new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit";
        $_SESSION['reset_icon'] = "error";
        header('location: /pharmacy/usersignin/resetpassword.php');
        exit();
    } else {
        $password = md5($newpass);
        $changesql = "SELECT * FROM user WHERE email='$email'";
        $changequery = mysqli_query($conn, $changesql);
        if (mysqli_num_rows($changequery) > 0) {
            $info = mysqli_fetch_assoc($changequery);
            $name = $info['firstname'] . " " . $info['lastname'];
            $username = $info['username'];
            $updatesql = "UPDATE user SET password='$password',session_attempt=1 WHERE email='$email'";
            $updatequery = mysqli_query($conn, $updatesql);
            if ($updatequery) {
                $query = "SELECT code FROM user WHERE email = '" . $email . "'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $email_code = $row['code'];

                $mail = new PHPMailer;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = "rh.mis0524@gmail.com";
                $mail->Password = "dgpq kscg ljap wvyi";
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom("rh.mis0524@gmail.com", 'BrindoxCare');
                $mail->addReplyTo('donotreply@gmail.com', 'DONOTREPLY');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $code = rand(999999, 111111);
                $detect_device = $_SERVER['HTTP_USER_AGENT'];


                $year = date("Y");

                $email_logo = '<img height="110" src="../assets/images/default_images/brindox.png" title="brindox_care" alt="brindox care">';
                $email_footer = '© ' . $year . ' ' . "Brindox";
                $email_name = strtok($name, " ");
                $code = $email_code;
                $email_device = $detect_device;
                $email_username = $username;

                $email_template = '../usersignin/template_mail/reset_account.html';
                $message = file_get_contents($email_template);
                $message = str_replace('%email_logo%', $email_logo, $message);
                $message = str_replace('%email_footer%', $email_footer, $message);
                $message = str_replace('%email_name%', $email_name, $message);
                $message = str_replace('%email_username%', $email_username, $message);
                $message = str_replace('%email_password%', $email_password, $message);

                $mail->Subject = 'Password Reset';
                $mail->MsgHTML($message);
                if ($mail->send()) {
                    $_SESSION['email'] = $email;
                    // echo "<script>Swal.fire({
                    //     title: 'Good job!',
                    //     text: 'You clicked the button!',
                    //     icon: 'success'
                    //   });</script>";
                    $_SESSION['success-change'] = "You have successfully updated your password. You may now log in with your new password.";
                    $notice = "We've sent also your username and new password to your email address - $email";
                    $_SESSION['notice-info'] = $notice;
                    header('location: ../usersignin/signin.php');
                    exit();
                } else {
                    $_SESSION['email'] = $email;
                    $_SESSION['success-change'] = "You have successfully updated your password. You may now log in with your new password.";
                    $_SESSION['notice-info'] = "Sorry, we're unable to send your username and new password to your e-mail address.";
                    header('location: ../usersignin/signin.php');
                    exit();
                }
            } else {
                $_SESSION['reset_status'] = "Updating password failed";
                $_SESSION['reset_icon'] = "error";
                header('location: ../usersignin/reset-password.php');
                exit();
            }
        }
    }
}

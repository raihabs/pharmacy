<?php
include '../config/connect.php';
session_start();

if (isset($_POST['update_user_password'])) {

    $user_id = $_POST['id'];
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $newpassword1 = mysqli_real_escape_string($conn, $_POST['newpassword1']);
    $newpassword2 = mysqli_real_escape_string($conn, $_POST['newpassword2']);


    $user_sql = mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = '$user_id'");
    $row = mysqli_fetch_array($user_sql);
    $pass = $row['password'];


    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d H:i:s");

    if ($password == "" || $newpassword1 == "" || $newpassword2 == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.',
        ];
        echo json_encode($res);
        return;
    } else {

        if (md5($password) != $pass) {
            $res = [
                'status' => 400,
                'msg' => 'Invalid Current Password Please Try Again.',
            ];
            echo json_encode($res);
            return;
        } else if ($newpassword1 != $newpassword2) {
            $res = [
                'status' => 400,
                'msg' => 'New Password Are Not Match.',
            ];
            echo json_encode($res);
            return;
        } else {
            if ($password == $newpassword1 || $password == $newpassword2) {
                $res = [
                    'status' => 400,
                    'msg' => 'Use Other New Password That Not Match Your Current Password.',
                ];
                echo json_encode($res);
                return;
            } else if (strlen($newpassword1) < 8  || !preg_match('/[A-Z]/', $newpassword1) || !preg_match('/[a-z]/', $newpassword1) || !preg_match('/[0-9]/', $newpassword1)) {
                $res = [
                    'status' => 400,
                    'msg' => 'Invalid User Password! Check if the new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit',
                ];
                echo json_encode($res);
                return;
            } else {

                $query = " UPDATE `user` 
            SET `password` = '" . md5($newpassword1) . "',
            `date_updated_at` = '" . $date_updated_at . "' 
            WHERE `user_id` = '" . $user_id . "'  ";
                $query_run = mysqli_query($conn, $query);
                if ($query_run) {
                    $res = [
                        'status' => 200,
                        'msg' => 'Password Updated Successfully!',
                    ];
                    echo json_encode($res);
                    return;
                }
            }
        }
    }
}



// Update own user information
if (isset($_POST['update_user_information'])) {

    $upd_id = $_POST['id'];

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone1 = mysqli_real_escape_string($conn, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($conn, $_POST['phone2']);
    $phone =  $phone1 . $phone2;

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);

    $query_user_info = "SELECT * FROM `user` 
    WHERE  `firstname` = '" . $firstname . "'  AND `lastname` = '" . $lastname . "' AND `email` = '" . $email . "' AND `phone` = '" . $phone . "' AND `address` = '" . $address . "' AND `birthday` = '" . $birthday . "' ";
    $result = mysqli_query($conn, $query_user_info);

    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d H:i:s");

    
    function validatePhilippinePhoneNumber($phone)
    {
        // Define the regex pattern to match +63 followed by 10 digits
        $phone_pattern = "/^(\+63)\d{10}$/";

        // Check if the phone number matches the pattern
        if (preg_match($phone_pattern, $phone)) {
            return true; // Valid Philippine phone number
        }
    }

    function validateBirthday($birthday)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
            // Parse the date into components
            $dateComponents = explode('-', $birthday);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateBirthdayYear($birthday)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {

            $birth_year = date('Y', strtotime($birthday));
            $current_year = date('Y');
            $legal_year = $current_year - 18;
            $invalid_year = $current_year - 60;

            if ($birth_year >= $current_year || $birth_year > $legal_year || $birth_year <= $invalid_year) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    $sql_upd_email = "SELECT `email` FROM `user` WHERE `email` = '" . $email . "' ";
    $res_upd_email = mysqli_query($conn, $sql_upd_email);



    if ($firstname == "" || $lastname == "" || $email == "" || $phone2 == "" || $address == "" || $birthday == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.',
        ];
        echo json_encode($res);
        return;
    } else  if (mysqli_num_rows($result) > 0) {
        $res = [
            'status' => 400,
            'msg' => 'There has no changes in your data field.',
        ];
        echo json_encode($res);
        return;
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid email address please type a valid email!',
        ];
        echo json_encode($res);
        return;
    } else if (!is_string($phone)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid phone number format.',
        ];
        echo json_encode($res);
        return;
    } else if (!validatePhilippinePhoneNumber($phone)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid phone number length',
        ];
        echo json_encode($res);
        return;
    }  else if (!validateBirthday($birthday)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid birthday format or date.',
        ];
        echo json_encode($res);
        return;
    }  else if (validateBirthdayYear($birthday)) {
        $res = [
            'status' => 400,
            'msg' => 'Exceed of legal age required.',
        ];
        echo json_encode($res);
        return;
    } else {
        $query_new_info = " UPDATE `user` 
        SET `firstname` = '" . $firstname . "',
        `lastname` = '" . $lastname . "',
        `email` = '" . $email . "',
        `phone` = '" . $phone . "', 
        `address` = '" . $address . "', 
        `birthday` = '" . $birthday . "',
        `date_updated_at` = '" . $date_updated_at . "' 
        WHERE `user_id` = '" . $upd_id . "'  ";
        $query_run_info = mysqli_query($conn, $query_new_info);
        if ($query_run_info) {
            $res = [
                'status' => 200,
                'msg' => 'Your Information Updated Successfully!',
            ];
            echo json_encode($res);
            return;
        }
    }
}


if (isset($_FILES["image"]["name"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];

    $imageName = $_FILES["image"]["name"];
    $imageSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];
    // Image validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));

    if (!in_array($imageExtension, $validImageExtension)) { ?>

        <script>
            Swal.fire({
                    icon: 'warning',
                    title: 'Something Went Wrong.',
                    text: 'Invalid Extensions, Use: JPG, JPEG, PNG, SVG',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/user_profile_settings.php';
                });
        </script>

    <?php } elseif ($imageSize > 1200000) { ?>

        <script>
            Swal.fire({
                    icon: 'warning',
                    title: 'Something Went Wrong.',
                    text: 'Please Dont Use High Image Size',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/user_profile_settings.php';
                });
        </script>

    <?php } else {

        // unlink($user["image"]);
        if (isset($_SESSION["user_id_admin"])) {
            $id = $_SESSION["user_id_admin"];
        } else if (isset($_SESSION["user_id_cashier"])) {
            $id = $_SESSION["user_id_cashier"];
        } else {
            $id = $_SESSION["user_id_inventory_clerk"];
        }
        $sessionId = $id;
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = $sessionId"));

        unlink('../assets/images/user_images/' . $user["image"]);

        $newImageName = $name . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name

        $newImageName = $newImageName . '.' . $imageExtension;
        $query = "UPDATE user  SET `image` = '$newImageName' WHERE `user_id` = $id ";

        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, '../assets/images/user_images/' . $newImageName);

    ?>

        <script>
            Swal.fire({
                    icon: 'success',
                    title: 'SUCCESS',
                    text: 'Successfully Change Profile',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/user_profile_settings.php';
                });
        </script>

<?php  }
}
?>














<?php
if (isset($_POST['del_id1'])) {

    $del_id1 = $_POST['del_id1'];
    $query_archive = " UPDATE `user` 
    SET `status` = 'INACTIVE' 
    WHERE `user_id` = '" . $del_id1 . "'  ";
    $archive_data = mysqli_query($conn, $query_archive);

    if ($archive_data) {
        $res = [
            'status' => 200,
            'msg' => 'The User status has been Updated.'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 400,
            'msg' => 'There\'s has Error Occured.',
        ];
        echo json_encode($res);
        return;
    }
}


if (isset($_POST['del_id2'])) {

    $del_id2 = $_POST['del_id2'];
    $query_active = " UPDATE `user` 
    SET `status` = 'ACTIVE' 
    WHERE `user_id` = '" . $del_id2 . "'  ";
    $active_data = mysqli_query($conn, $query_active);

    if ($active_data) {
        $res = [
            'status' => 200,
            'msg' => 'The User status has been Updated.'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 400,
            'msg' => 'There\'s has Error Occured.',
        ];
        echo json_encode($res);
        return;
    }
}
?>









<?php
// Add User Account
if (isset($_POST['valid_account'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone1 = mysqli_real_escape_string($conn, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($conn, $_POST['phone2']);
    $phone =  $phone1 . $phone2;

    // Regex pattern for Philippine phone numbers
    $phone_pattern = "/^(\+63)\d{10}$/"; // Philippine phone number only

    function validatePhilippinePhoneNumber($phone)
    {
        // Define the regex pattern to match +63 followed by 9 digits
        $phone_pattern = "/^(\+63)\d{10}$/";

        // Check if the phone number matches the pattern
        if (preg_match($phone_pattern, $phone)) {
            return true; // Valid Philippine phone number
        }
    }

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql_username = "SELECT `username` FROM `user` WHERE `username` = '" . $username . "' ";
    $res_username = mysqli_query($conn, $sql_username);

    $sql_email = "SELECT `email` FROM `user` WHERE `email` = '" . $email . "' ";
    $res_email = mysqli_query($conn, $sql_email);

    $password = mysqli_real_escape_string($conn, $_POST['password']);

    function validateBirthday($birthday)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
            // Parse the date into components
            $dateComponents = explode('-', $birthday);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateBirthdayYear($birthday)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {

            $birth_year = date('Y', strtotime($birthday));
            $current_year = date('Y');
            $legal_year = $current_year - 18;
            $invalid_year = $current_year - 60;

            if ($birth_year >= $current_year || $birth_year > $legal_year || $birth_year <= $invalid_year) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }
    date_default_timezone_set('Asia/Manila');
    $date_created_at = date("Y-m-d H:i:s");

    if ($username == "" || $firstname == "" || $lastname == "" || $email == "" || $phone2 == "" || $address == "" || $birthday == "" || $password == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.',
        ];
        echo json_encode($res);
        return;
    } else if ($role == "Choose Role") {
        $res = [
            'status' => 400,
            'msg' => 'Choose right user role.',
        ];
        echo json_encode($res);
        return;
    } else if (strlen($password) < 8  || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid User Password! Check if the new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit',
        ];
        echo json_encode($res);
        return;
    } else {
        if (mysqli_num_rows($res_username) > 0) {
            $res = [
                'status' => 400,
                'msg' => 'The ' . $username . ' username is already exist.',
            ];
            echo json_encode($res);
            return;
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $res = [
                'status' => 400,
                'msg' => 'Invalid email address please type a valid email!',
            ];
            echo json_encode($res);
            return;
        } else if (mysqli_num_rows($res_email) > 0) {
            $res = [
                'status' => 400,
                'msg' => 'The ' . $email . ' email is already exist.',
            ];
            echo json_encode($res);
            return;
        } else if (!preg_match($phone_pattern, $phone) ) {
            $res = [
                'status' => 400,
                'msg' => 'Invalid phone number format.',
            ];
            echo json_encode($res);
            return;
        } else if (!validateBirthday($birthday)) {
            $res = [
                'status' => 400,
                'msg' => 'Invalid birthday format or date.',
            ];
            echo json_encode($res);
            return;
        } else if (validateBirthdayYear($birthday)) {
            $res = [
                'status' => 400,
                'msg' => 'Exceed of legal age required.',
            ];
            echo json_encode($res);
            return;
        } else {
            $hash_password = md5($password);

            $query_add_user = "INSERT INTO `user` (`username`,`firstname`, `lastname`,`email`,`phone`,`address`,`birthday`,`password`,`role`,`session_attempt`,`status`,`date_created_at`) VALUE ('$username','$firstname','$lastname','$email','$phone','$address','$birthday','$hash_password','$role', 1,'ACTIVE','$date_created_at')";
            $query_add_user_run = mysqli_query($conn, $query_add_user);

            if ($query_add_user_run) {
                $res = [
                    'status' => 200,
                    'msg' => 'Account Added Successfully! ',
                ];
                echo json_encode($res);
                return;
                $url = '../admin/account.php';
                header('Location: ' . $url);
            }
        }
    }
}


// Update User Account

if (isset($_POST['update_account'])) {

    $user_id = $_POST['user_id'];

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone1 = mysqli_real_escape_string($conn, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($conn, $_POST['phone2']);

    $phone =  $phone1 . $phone2;

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = $user_id"));

    $query_update_user = "SELECT * FROM `user` 
    WHERE `username` = '" . $user['username'] . "' AND `username` = '" . $username . "'
    AND `firstname` = '" . $user['firstname'] . "' AND `firstname` = '" . $firstname . "' 
    AND `lastname` = '" . $user['lastname'] . "' AND `lastname` = '" . $lastname . "' 
    AND `email` = '" . $user['email'] . "' AND `email` = '" . $email . "' 
    AND `phone` = '" . $user['phone'] . "' AND `phone` = '" . $phone . "' 
    AND `address` = '" . $user['address'] . "' AND `address` = '" . $address . "' 
    AND `birthday` = '" . $user['birthday'] . "' AND `birthday` = '" . $birthday . "' 
    AND `role` = '" . $user['role'] . "' AND `role` = '" . $role . "'
    ";
    $result_update_user = mysqli_query($conn, $query_update_user);


    $sql_update_username = "SELECT * FROM `user` WHERE `username` != '" . $user['username'] . "' AND `username` = '" . $username . "'";
    $res_update_username = mysqli_query($conn, $sql_update_username);

    $sql_update_email = "SELECT `email` FROM `user` WHERE `email` != '" . $user['email'] . "' AND `email` = '" . $email . "' ";
    $res_update_email = mysqli_query($conn, $sql_update_email);

    function validateBirthdayFormat($birthday)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
            // Parse the date into components
            $dateComponents = explode('-', $birthday);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateBirthdayYear($birthday)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {

            $birth_year = date('Y', strtotime($birthday));
            $current_year = date('Y');
            $legal_year = $current_year - 18;
            $invalid_year = $current_year - 60;

            if ($birth_year >= $current_year || $birth_year > $legal_year || $birth_year <= $invalid_year) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }
    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d H:i:s");


    if (mysqli_num_rows($result_update_user) > 0) {
        $res = [
            'status' => 400,
            'msg' => 'There\'s no changes in data field.',
        ];
        echo json_encode($res);
        return;
    } else if ($username == "" || $firstname == "" || $lastname == "" || $email == "" || $phone2 == "" || $address == "" || $birthday == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.',
        ];
        echo json_encode($res);
        return;
    } else {


        $new_phone = substr_replace($phone, "", 0, 1);

        // Regex pattern for Philippine phone numbers
        // $phone_pattern = "/^(\+639)\d{9}$/"; 
        // Philippine phone number only

        function validatePhilippinePhoneNumber($phone)
        {
            // Define the regex pattern to match +639 followed by 9 digits
            $phone_pattern = "/^(\+63)\d{10}$/";

            // Check if the phone number matches the pattern
            if (preg_match($phone_pattern, $phone)) {
                return true; // Valid Philippine phone number
            }
        }


        if (mysqli_num_rows($res_update_username) > 0) {
            $res = [
                'status' => 400,
                'msg' => 'Username ' . $username . ' is already exist.',
            ];
            echo json_encode($res);
            return;
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $res = [
                'status' => 400,
                'msg' => 'Invalid email address please type a valid email!',
            ];
            echo json_encode($res);
            return;
        } else if (mysqli_num_rows($res_update_email) > 0) {
            $res = [
                'status' => 400,
                'msg' => 'Email ' . $email . ' is already exist.',
            ];
            echo json_encode($res);
            return;
        } else if (!is_string($phone)) {
            $res = [
                'status' => 400,
                'msg' => 'Invalid phone number format.',
            ];
            echo json_encode($res);
            return;
        } else if (!validatePhilippinePhoneNumber($phone)) {
            $res = [
                'status' => 400,
                'msg' => 'Invalid phone number length',
            ];
            echo json_encode($res);
            return;
        } else if (!validateBirthdayFormat($birthday)) {
            $res = [
                'status' => 400,
                'msg' => 'Invalid birthday format.',
            ];
            echo json_encode($res);
            return;
        } else if (validateBirthdayYear($birthday)) {
            $res = [
                'status' => 400,
                'msg' => 'Exceed of legal age required.',
            ];
            echo json_encode($res);
            return;
        } else {

            $query_upd_user = "UPDATE `user` 
        SET `username` = '" . $username . "',
        `firstname` = '" . $firstname . "',
        `lastname` = '" . $lastname . "',
        `email` = '" . $email . "',
        `phone` = '" . $phone . "', 
        `address` = '" . $address . "', 
        `birthday` = '" . $birthday . "', 
        `role` = '" . $role . "', 
        `date_updated_at` = '" . $date_updated_at . "' 
        WHERE `user_id` = '" . $user_id . "'  ";
            $query_run_upd_user = mysqli_query($conn, $query_upd_user);
            if ($query_run_upd_user) {
                $res = [
                    'status' => 200,
                    'msg' => 'Account Updated Successfully!',
                ];
                echo json_encode($res);
                return;
            }
        }
    }
}



// Update User Password

if (isset($_POST['user_Password'])) {

    // unlink($user["image"]);
    if (isset($_SESSION["user_id_admin"])) {
        $log_user_id = $_SESSION["user_id_admin"];
    } else if (isset($_SESSION["user_id_cashier"])) {
        $log_user_id = $_SESSION["user_id_cashier"];
    } else {
        $log_user_id = $_SESSION["user_id_inventory_clerk"];
    }
    // $log_user_id = $_SESSION["user_id_admin"];



    $admin_password = mysqli_real_escape_string($conn, $_POST['admin_password']);
    $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);

    $query_admin = "SELECT * FROM `user` WHERE `user_id` = $log_user_id AND `password` != '" . md5($admin_password) . "' ORDER BY `user_id` ASC";
    $admin_result = mysqli_query($conn, $query_admin);

    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d H:i:s");


    if ($admin_password == "" || $user_password == "") {
        $res = [
            'status' => 400,
            'msg' => 'Please fill the required field!',
        ];
        echo json_encode($res);
        return;
    } else if (mysqli_num_rows($admin_result) > 0) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid admin password. Please try again.',
        ];
        echo json_encode($res);
        return;
    } else if (strlen($user_password) < 8  || !preg_match('/[A-Z]/', $user_password) || !preg_match('/[a-z]/', $user_password) || !preg_match('/[0-9]/', $user_password)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid User Password! Check if the new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit',
        ];
        echo json_encode($res);
        return;
    } else {

        $user_password = md5($user_password);

        $user_id = $_POST['u_id'];

        $user_query = "UPDATE `user` 
        SET `password` = '" . $user_password . "',
        `date_updated_at` = '" . $date_updated_at . "' 
        WHERE `user_id` = '" . $user_id . "'  ";

        $user_query_run = mysqli_query($conn, $user_query);
        if ($user_query_run) {
            $res = [
                'status' => 200,
                'msg' => 'User Password Updated Successfully!',
            ];
            echo json_encode($res);
            return;
        }
    }
}




?>
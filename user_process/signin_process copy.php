<?php
include '../config/connect.php';
session_start();

// $response = array(
// 	'success' => "500",
// 	'message' => 'Unknown Error',
// 	'title' => '',
// 	'session' => "0"
// );

if (isset($_POST['login_form'])) {

	$username =  mysqli_real_escape_string($conn, $_POST['username']);
	$password =  mysqli_real_escape_string($conn, $_POST['password']);

	if ($username == "" || $password == "") {

		$_SESSION['signin_title'] = "Field are required." . $username;
		$_SESSION['signin_icon'] = "error";
		header('location: ../usersignin/signin.php');
		// $res = [
		// 	'success' => 500,
		// 	'title' => "Please try again!",
		// 	'message' => "Fields are Required."
		// ];

		// echo json_encode($res);
		// return;
	} else {

		$checkUser = "SELECT * FROM `user` WHERE `username` = '" . $username . "' OR  `email` = '" . $username . "'  ";
		$checkUser_run = mysqli_query($conn, $checkUser);

		// check if the username exists
		if (mysqli_num_rows($checkUser_run) > 0) {

			// check password
			$checkPassword = "SELECT * FROM `user` WHERE ( `username` = '" . $username . "' OR  `email` = '" . $username . "')  AND `password` = '" . md5($password) . "'";
			$checkPasswordrun = mysqli_query($conn, $checkPassword);

			$row = mysqli_fetch_assoc($checkPasswordrun);

			// If username exists, check if the password matches
			if (mysqli_num_rows($checkPasswordrun) > 0) {


				date_default_timezone_set('Asia/Manila');
				$currentDateTime = date("Y-m-d H:i:s");

				$_SESSION['name'] = $row['firstname'] . " " . $row['lastname'];
				if ($row['role'] == 'Admin' && $row['session_attempt'] <= 4) {

					$_SESSION["user_id_admin"] = $row['user_id'];
					$_SESSION['name'];

					$session_attempt_query = "UPDATE `user` 
				SET `_attempt` = 1
				WHERE `user_id` = " . $row['user_id'] . "  ";
					$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

					$login_query = "INSERT INTO `loginhistory` (`username`, `datetime`) 
				VALUE ('" . $row['username'] . "', '$currentDateTime')";
					$login_run = mysqli_query($conn, $login_query);

					$_SESSION['login_success'] = true; // Set this flag for progress bar
					$_SESSION['signin_title'] = "Login Successful.";
					$_SESSION['signin_icon'] = "success"; // Change to 'success' for successful login
					header('location: ../admin/admin.php');
					exit();

					// $response['success'] = "100";
					// $response['title'] = 'Welcome!';
					// $response['message'] = 'Admin Login Succesfully!';
				} else if ($row['role'] == 'Cashier' && $row['session_attempt'] <= 4) {
					$_SESSION["user_id_cashier"] = $row['user_id'];
					$_SESSION['name'];

					$session_attempt_query = "UPDATE `user` 
				SET `session_attempt` = 1
				WHERE `user_id` = " . $row['user_id'] . "  ";
					$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

					$login_query = "INSERT INTO `loginhistory` (`username`, `datetime`) 
				VALUE ('" . $row['username'] . "', '$currentDateTime')";
					$login_run = mysqli_query($conn, $login_query);


					$_SESSION['login_success'] = true; // Set this flag for progress bar
					$_SESSION['signin_title'] = "Login Successful.";
					$_SESSION['signin_icon'] = "success"; // Change to 'success' for successful login
					header('location: ../cashier/home.php');
					exit();

					// $response['success'] = "200";
					// $response['title'] = 'Welcome!';
					// $response['message'] = 'Admin Login Succesfully!';
				} else if ($row['role'] == 'Inventory Clerk' && $row['session_attempt'] <= 4) {
					$_SESSION["user_id_inventory_clerk"] = $row['user_id'];
					$_SESSION['name'];

					$session_attempt_query = "UPDATE `user` 
				SET `session_attempt` = 1
				WHERE `user_id` = " . $row['user_id'] . "  ";
					$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

					$login_query = "INSERT INTO `loginhistory` (`username`, `datetime`) 
				VALUE ('" . $row['username'] . "', '$currentDateTime')";
					$login_run = mysqli_query($conn, $login_query);

					$_SESSION['signin_title'] = "Inventory Clerk Login Succesfully.";
					$_SESSION['signin_icon'] = "error";
					header('location: ../inventory_clerk/inventory.php');
					exit();

					// $response['success'] = "300";
					// $response['title'] = 'Welcome!';
					// $response['message'] = 'Admin Login Succesfully!';
				} else {
					$checkUser = "SELECT * FROM `user` WHERE `username` = '" . $username . "' OR  `email` = '" . $username . "' ";
					$checkUserun = mysqli_query($conn, $checkUser);

					$check = mysqli_fetch_assoc($checkUserun);



					if ($check['session_attempt'] >= 5) {
						$_SESSION['signin_title'] = "Attempt limit exceeded! Reset your Password.";
						$_SESSION['signin_icon'] = "error";
						$_SESSION['session_attempt'] = "Login Attempts: 5";
						header('location: ../usersignin/signin.php');
						header('location: ../usersignin/reset-page.php');
						// $response['success'] = "700";
						// $response['title'] = 'Attempt limit exceeded!';
						// $response['message'] = "Reset your Password. or Contact your Admin.";
					} else {

						// Increment attempts
						$session_attempt_query = "UPDATE `user` 
				SET `session_attempt` = " . $check['session_attempt'] + 1 . "
				WHERE `user_id` = " . $check['user_id'] . "  ";
						$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

						$_SESSION['signin_title'] = "Invalid Username or Password. You only have " . 5 - $check['session_attempt'] . " Attempt";
						$_SESSION['signin_icon'] = "error";
						$_SESSION['session_attempt'] = "Login Attempts: " . $check['session_attempt'];
						header('location: ../usersignin/signin.php');
						exit();
						// $response['success'] = "500";
						// $response['title'] = 'SOMETHING WENT WRONG!';
						// $response['message'] = "Invalid Username or Password";
						// $response['session'] = "Login Attempts: " . $check['session_attempt'];
					}
				}
			} else {
				$checkUser = "SELECT * FROM `user` WHERE `username` = '" . $username . "' OR  `email` = '" . $username . "' ";
				$checkUserun = mysqli_query($conn, $checkUser);

				$check = mysqli_fetch_assoc($checkUserun);



				if ($check['session_attempt'] >= 5) {
					$_SESSION['signin_title'] = "Attempt limit exceeded! Reset your Password.";
					$_SESSION['signin_icon'] = "error";
					$_SESSION['session_attempt'] = "Login Attempts: 5";

					// Output JavaScript to redirect after a delay  
					header('Location: ../usersignin/reset-page.php');
					// Optionally, you can show a message before redirecting
					exit;
					// $response['success'] = "700";
					// $response['title'] = 'Attempt limit exceeded!';
					// $response['message'] = "Reset your Password. or Contact your Admin.";
				} else {

					// Increment attempts
					$session_attempt_query = "UPDATE `user` 
				SET `session_attempt` = " . $check['session_attempt'] + 1 . "
				WHERE `user_id` = " . $check['user_id'] . "  ";
					$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

					$_SESSION['signin_title'] = "Invalid Username or Password. You only have " . 5 - $check['session_attempt'] . " Attempt";
					$_SESSION['signin_icon'] = "error";
					$_SESSION['session_attempt'] = "Login Attempts: " . $check['session_attempt'];

					header('location: ../usersignin/signin.php');

					// $response['success'] = "500";
					// $response['title'] = 'SOMETHING WENT WRONG!';
					// $response['message'] = "Invalid Username or Password";
					// $response['session'] = "Login Attempts: " . $check['session_attempt'];
				}
			}
		} else {
			$_SESSION['signin_title'] = "User doesn't exist. Please try again.";
			$_SESSION['signin_icon'] = "error";
			header('location: ../usersignin/signin.php');
			exit();

			// $response['success'] = "600";
			// $response['title'] = 'SOMETHING WENT WRONG!';
			// $response['message'] = "User doesn't exist. Please try again.";
		}
	}
}
// echo json_encode($response);

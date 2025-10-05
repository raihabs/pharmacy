<?php
error_reporting(0);
session_start();



unset($_SESSION['checkUser']);
unset($_SESSION['send_email']);
unset($_SESSION['resend_email']);
unset($_SESSION['resend_code']);
if (isset($_SESSION['checkUser']) || isset($_SESSION['send_email']) || isset($_SESSION['verify_email']) || isset($_SESSION['verify_code']) || isset($_SESSION['resend_email']) || isset($_SESSION['resend_code'])) {
    header("Location: ../usersignin/signin.php");
    session_destroy();
} else
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css" />

    <link rel="shortcut icon" type="../assets/images/default_images/brindox.png" href="../assets/images/default_images/brindox.png">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <link rel="stylesheet" href="signin.css">

    <title>Reset Page</title>

    <style>
        /* Container for the progress bar */
        .progress-div {
            display: none;
            /* Hidden by default, shown when needed */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            /* Adjust width as necessary */
            background-color: rgba(115, 132, 165, 0.678);
            /* Light background color */
            border: 1px solid #ccc;
            /* Border with a light gray color */
            border-radius: 5px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            padding: 20px;
            /* Padding inside the box */
            text-align: center;
            z-index: 1000;
            /* Make sure it's above other elements */
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Message text above the progress bar */
        #progress_msg {
            color: #fff;
            font-weight: 500;
            font-family: 'Poppins-Regular', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;

            margin-bottom: 10px;
            /* Space between message and progress bar */
            font-size: 16px;
        }

        /* Container for the progress bar itself */
        .progress-container {
            width: 50%;
            background-color: #e0e0e0;
            /* Light gray background for the bar */
            border-radius: 5px;
            overflow: hidden;
            /* Ensures the progress bar stays within the rounded corners */
        }

        /* The progress bar */
        .progress-bar {
            height: 20px;
            /* Height of the progress bar */
            width: 0%;
            /* Start at 0% width, will be animated */
            background-color: #052d5a;
            /* Green color */
            border-radius: 5px;
            transition: width 1s ease-in-out;
            /* Smooth transition for width changes */
        }

        @keyframes progress {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
    </style>

</head>

<body>
    <div class="progress-div" id="progressDiv" style="display: none;">

        <p id="progress_msg"></p>
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
    </div>

    <div class="login-wrap">

        <!-- Message Box -->
        <div class="message-box" id="messageBox" style="display: none; align-items:right; justify-content: right; right:0; margin: 20px 45px;">
            <div class="close-btn" id="closeBtn">
                <button type="button" class="close mr-1" style="border:0;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="border:0; font-size: 22px;">&times;</span>
                </button>
            </div>
            <p id="error_msg"></p>
            <div class="loading-bar-container">
                <div class="loading-bar" id="loadingBar"></div>
            </div>
        </div>
        <span class="login100-form-logo">
            <img src="../assets/images/default_images/brindox.png" class="brindox" alt="" width="100%" height="90">
        </span>

        <div class="login-card">

            <!-- Login Form -->
            <form id="send_email_form" class="login100-form validate-form">
                
                <span class="login100-form-title">
                    FORGOT PASSWORD
                </span>


                <div class="form">
                    <i id="email" class="mdi mdi-email menu-icon"></i>
                    <input type="text" id="username" name="email" class="username" placeholder="Email Address">
                    <div id="container">
                        <h5><a class="txt1"></a></h5>
                    </div>
                    <button type="submit" id="signinBtn" style="align-items: center;">Continue</button>

                    <div id="container">
                        <h5><a class="txt2" href="/pharmacy/usersignin/signin.php">Back to Login</a></h5>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- <script src="../assets/js/signin.js"></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- modal -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <!-- sweetalert2 message -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>


    <script>
        // Function to show the custom message box
        function showMessageBox(title, message, icon) {
            // Update the message box content
            $('#error_msg').html(`<div class="alert alert-danger" role="alert" style="font-size: 16px;"><strong>${title}</strong><br>${message}</div>`);

            // Optionally, set different styles based on the icon
            if (icon === 'success') {
                $('#messageBox').css('border-color', 'green');
            } else if (icon === 'warning') {
                $('#messageBox').css('border-color', 'orange');
            } else if (icon === 'error') {
                $('#messageBox').css('border-color', 'red');
            }

            // Show the message box
            $('#messageBox').show();

            // Hide the message box after 4 seconds (adjust as needed)
            setTimeout(function() {
                $('#messageBox').fadeOut();
            }, 10000);
        }

        // Function to show the progress bar
        function showProgressBar(message) {
            $('#progressDiv').show();
            // Update the message box content
            $('#progress_msg').html(`<strong>${message}</strong>`);
            // Optionally, you can add animation to the progress bar here
            $('#progressDiv .progress-bar').css('width', '100%');

            // Hide the progress bar after the redirect
            setTimeout(function() {
                $('#progressDiv').fadeOut();
            }, 8000);
        }

        // Close message box on clicking the close button
        $('#closeBtn').on('click', function() {
            $('#messageBox').fadeOut();
        });
        $(document).ready(function() {

            $('#send_email_form').on('submit', function(e) {

                e.preventDefault();

                const username = $('#username').val();
                const send_email_form = $('#send_email_form').val();

                $.ajax({
                    url: '../user_process/resetpassword_process.php',
                    type: 'POST',
                    data: {
                        username: username,
                        send_email_form: send_email_form
                    },
                    success: function(response) {
                        var res = jQuery.parseJSON(response);

                        if (res.success == 100) {
                            $('#messageBox').hide();

                            showProgressBar(res.message);
                            setTimeout(function() {
                                location.href = '/pharmacy/usersignin/verification-code.php';
                            }, 5000);
                        } else if (res.success == 500) {
                            showMessageBox(res.title, res.message, 'warning');
                            setTimeout(function() {
                                location.href = '/pharmacy/usersignin/reset-page.php';
                            }, 8000);
                        } else if (res.success == 600) {
                            showMessageBox(res.title, res.message, 'warning');
                            setTimeout(function() {
                                location.href = '/pharmacy/usersignin/reset-page.php';
                            }, 8000);
                        } else {

                            showMessageBox(res.title, res.message, 'warning');
                            setTimeout(function() {
                                location.href = '/pharmacy/usersignin/reset-page.php';
                            }, 5000);
                        }
                    },
                    error: function(error) {
                        showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
                        console.log('error', error);
                    }
                })
            });
        });
    </script>
</body>

</html>
<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session
$id = $_SESSION["user_id_admin"];

$sessionId = $id;

$valid_user = "SELECT * FROM `user` WHERE `user_id` = '" . $sessionId . "' && `role` != 'Admin'";
$check_user = mysqli_query($conn, $valid_user);

if (!isset($sessionId) || mysqli_num_rows($check_user) < 0) {
  header("Location: ../usersignin/signin.php");
  session_destroy();
} else
  $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = $sessionId"));

include "../include/user_meta_tag.php";
include "../include/user_top.php";
?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

<title>User Account</title>
<style>
  /* Alternative for input container */
  /* use this instead if custom */
  .group-item {
    display: flex;
    flex-direction: column;
    /* overflow-x: scroll !important; */
    overflow-x: scroll !important;
    overflow-y: scroll !important;
  }

  /* Alternative for input group */
  /* use this instead if custom */
  .input-item {
    display: flex;
    flex-wrap: nowrap;
    align-items: center;
  }

  .input-item input,
  .input-item select {
    flex: 1;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin: 5px;
  }

  .input-item button {
    margin-left: 10px;
    padding: 10px 10px;
    font-size: 16px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 120px;
  }

  .input-item #add-btn {
    margin-left: 10px;
    padding: 10px 10px;
    font-size: 16px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 120px;
  }

  .input-item button:hover {
    background-color: #45a049;
  }

  .input-item button.remove-btn {
    background-color: #f44336;
  }

  .input-item button.remove-btn:hover {
    background-color: #e53935;
  }


  /* styles.css */

  .button-container {
    margin-bottom: 20px;
  }

  .btn {
    padding: 5px 20px;
    margin-right: 35px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .add_user {
    color: #fff !important;
  }

  .btn.active-button {
    background-color: #007bff;
    color: white;
  }

  .btn:not(.active-button) {
    background-color: #fff;
    color: #007bff;
    border: 2px solid rgba(85, 107, 47, 0.7);
  }
</style>
</head>

<body>

  <!-- <?php include "../include/user_loader.php"; ?> -->

  <div class="container-scroller">
    <?php include "../include/admin_sidebar.php"; ?>

    <div class="container-fluid page-body-wrapper">
      <div id="theme-settings" class="settings-panel">
        <i class="settings-close mdi mdi-close"></i>
        <!-- <p class="settings-heading">SIDEBAR SKINS</p> -->
        <div class="sidebar-bg-options selected" id="sidebar-default-theme">
          <div class="img-ss rounded-circle bg-light border mr-3"></div>
        </div>
        <div class="sidebar-bg-options" id="sidebar-dark-theme">
          <div class="img-ss rounded-circle bg-dark border mr-3"></div>
        </div>
        <!-- <p class="settings-heading mt-2">HEADER SKINS</p> -->
        <div class="color-tiles mx-0 px-4">
          <div class="tiles light"></div>
          <div class="tiles dark"></div>
        </div>
      </div>


      <?php include "../include/admin_header.php"; ?>


      <div class="main-panel">
        <div class="content-wrapper pb-0">

          <div class="page-header">
            <h3 class="page-title">User Account</h3>
            <?php include "../include/user_breadcrumb.php"; ?>
            <div class="page-header flex-wrap">
              <div class="d-flex">
                <div class="button-container mt-3">
                  <button id="activeButton" class="btn active-button">Active</button>
                  <button id="archiveButton" class="btn ml-3">Archive</button>
                </div>
              </div>
              </h3>
              <div class="d-flex">
                <a href="../admin/account.php">
                  <button type="button" class="btn btn-sm bg-white btn-icon-text " style="background-color: #fff; color: #007bff;  border: 2px solid rgba(85, 107, 47, 0.7);">
                    <i class="mdi mdi-refresh btn-icon-prepend"></i>Refresh
                  </button>
                </a>
                <!-- <a href="../user_process/account_export.php">
                  <button type="button" class="btn btn-sm bg-white btn-icon-text  ml-3" style="background-color: #fff; color: #007bff; border: 2px solid rgba(85, 107, 47, 0.7);"  >
                    <i class="mdi mdi-export btn-icon-prepend"></i>Export
                  </button>
                </a> -->


                <button type="button" class="btn btn-sm bg-white btn-icon-text ml-3" onclick="printUserTable()">
                  <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <iframe id="userPrintIframe" src="../getdata/account_data_query.php" style="display:none;"></iframe>

                <button type="button" class="btn btn-sm btn-info  ml-3 add_user" data-toggle="modal" style="background-color: #007bff; color: #fff;" data-target="#addUserAccount">
                  Add User
                </button>
              </div>
            </div>
            <div id="contentContainer" class="mt-4">
              <!-- Active content by default -->
              <div class="row" id="activeContent">
                <div class="col-lg-12 stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Active Accounts</h4>
                      <p class="card-description">List of active accounts.</p>
                      <div class="table-responsive">
                        <!-- Including PHP file for active accounts -->
                        <?php include "../admin/account_data_active.php"; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Archive content, initially hidden -->
              <div class="row" id="archiveContent" style="display: none;">
                <div class="col-lg-12 stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Archived Accounts</h4>
                      <p class="card-description">List of archived accounts.</p>
                      <div class="table-responsive">
                        <!-- Including PHP file for archived accounts -->
                        <?php include "../admin/account_data_archive.php"; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>


        <?php include "../include/user_footer.php"; ?>
      </div>

      <!-- Add Modal -->
      <div class="modal fade" id="addUserAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header text-light" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
              <h5 class="modal-title text-uppercase font-weight-bold ml-3" id="exampleModalLabel" style="color: #fff;">Add Account</h5>
              <button type="button" class="close mr-1" style="padding-top: 22px;" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="addAccount">
              <div class="modal-body ml-5 mr-5 mt-4">

                <div class="mb-4  ">
                  <label for="content">User Name <span style="color:red; font-size: 18px;">*</span></label>

                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" id="username" name="username" placeholder="User Name" class="form-control  form-control-lg" />
                    </div>
                  </div>
                </div>

                <div class="mb-4">

                  <label for="content" style="margin: 0 15.8rem 0 0;">First Name <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content" style="margin: 0 11.0rem 0 0;">Last Name <span style="color:red; font-size: 18px;">*</span></label>

                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" id="firstname" name="firstname" placeholder="First Name" class="form-control  form-control-lg" />
                    </div>
                    <div class="col-md-4">
                      <input type="text" id="lastname" name="lastname" placeholder="Last Name" class="form-control form-control-lg" />
                    </div>
                  </div>
                </div>


                <div class="mb-4">

                  <label for="content" style="margin: 0 18.1rem 0 0;">Email <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content" style="margin: 0 17.9rem 0 0;">Phone <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content">Address <span style="color:red; font-size: 18px;">*</span></label>

                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" id="email" name="email" placeholder="Email" class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-1">
                      <input type="text" id="phone1" name="phone1" placeholder="+63" value="+63" class="form-control form-control-lg" readonly />
                    </div>
                    <div class="col-md-3">
                      <input type="text" id="phone2" name="phone2" placeholder="123.." class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-4">
                      <input type="text" id="address" name="address" placeholder="Address" class="form-control form-control-lg" />
                    </div>
                  </div>
                </div>

                <div class="mb-4">

                  <label for="content" style="margin: 0 16.8rem 0 0;">Birthday <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content" style="margin: 0 18.5rem 0 0;">Role <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content">Password <span style="color:red; font-size: 18px;">*</span></label>

                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" id="birthday" name="birthday" placeholder="YYYY-MM-DD" class="form-control" />
                    </div>
                    <div class="col-md-4">
                      <select id="role" name="role" class="custom-select">
                        <option value="Choose Role">Choose Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Cashier">Cashier</option>
                        <option value="Employee">Employee</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <input type="text" id="password" name="password" placeholder="Password" class="form-control form-control-lg" />
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                <button class="btn btn-primary">Add</button>

              </div>
            </form>
          </div>
        </div>
      </div>



      <!-- Update Modal -->
      <div class="modal fade" id="updateUserAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header text-light" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
              <h5 class="modal-title text-uppercase font-weight-bold ml-3" id="exampleModalLabel" style="color: #fff;">Update Account</h5>
              <button type="button" class="close mr-1" style="padding-top: 22px;" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="updAccount">
              <div class="modal-body ml-5 mr-5 mt-4">

                <div class="mb-5">
                  <label for="content">User Name <span style="color:red; font-size: 18px;">*</span></label>
                  <input type="hidden" name="user_id" id="upduser_id">

                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" name="username" id="updusername" placeholder="User Name" class="form-control form-control-lg" />
                    </div>
                  </div>
                </div>

                <div class="mb-5">

                  <label for="content" style="margin: 0 15.8rem 0 0;">First Name <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content" style="margin: 0 11.0rem 0 0;">Last Name <span style="color:red; font-size: 18px;">*</span></label>

                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" name="firstname" id="updfirstname" placeholder="First Name" class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-4">
                      <input type="text" name="lastname" id="updlastname" placeholder="Last Name" class="form-control form-control-lg" />
                    </div>
                  </div>
                </div>


                <div class="mb-4">

                  <label for="content" style="margin: 0 18.1rem 0 0;">Email <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content" style="margin: 0 17.9rem 0 0;">Phone <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content">Address <span style="color:red; font-size: 18px;">*</span></label>

                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" name="email" id="updemail" placeholder="Email" class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-1">
                      <input type="text" name="phone1" id="updphone1" placeholder="+63" value="+63" class="form-control form-control-lg" readonly />
                    </div>
                    <div class="col-md-3">
                      <input type="text" name="phone2" id="updphone2" placeholder="123.." class="form-control form-control-lg" />
                    </div>
                    <div class="col-md-4">
                      <input type="text" name="address" id="updaddress" placeholder="Address" class="form-control form-control-lg" />
                    </div>
                  </div>
                </div>

                <div class="mb-3">

                  <label for="content" style="margin: 0 18.1rem 0 0;">Birthday <span style="color:red; font-size: 18px;">*</span></label>
                  <label for="content" style="margin: 0 17.9rem 0 0;">Role <span style="color:red; font-size: 18px;">*</span></label>

                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" name="birthday" id="updbirthday" placeholder="YYYY-MM-DD" class="form-control" />
                    </div>
                    <div class="col-md-4">
                      <select name="role" id="updrole" class="custom-select">
                        <option value="Admin">Admin</option>
                        <option value="Cashier">Cashier</option>
                        <option value="Employee">Employee</option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-info">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>


      <!-- Change Password Modal -->
      <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header text-light" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
              <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">Update User Password</h5>
              <button type="button" class="close mr-1" style="padding-top: 22px;" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="userPassword">
              <div class="modal-body ml-5 mr-5 mt-4">



                <div class="mb-4">
                  <label for="content">Admin Password <span style="color:red; font-size: 18px;">*</span></label>
                  <div class="row" style="padding: 2%;">
                    <div class="col-md-6">
                      <input type="text" name="admin_password"  id="admin_password" placeholder="Enter Admin Password" class="form-control  form-control-lg" />
                    </div>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="content">User Password <span style="color:red; font-size: 18px;">*</span></label>
                  <input type="hidden" name="u_id" id="u_id">

                  <div class="row" style="padding: 2%;">
                    <div class="col-md-6">
                      <input type="text" name="user_password" id="user_password" placeholder="Enter New User Password" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-info">Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>



    </div>
    <!-- container-scroller -->

    <?php include '../include/user_bottom.php'; ?>
    <?php include '../user_process/user_process.php'; ?>


</body>

</html>

<script>
  // Add User Modal


  // Function to validate empty fields and apply red border
  function validateFieldsUsers() {
    // Get the form fields
    const username = document.getElementById('username');
    const firstname = document.getElementById('firstname');
    const lastname = document.getElementById('lastname');
    const email = document.getElementById('email');
    const phone1 = document.getElementById('phone1');
    const phone2 = document.getElementById('phone2');
    const address = document.getElementById('address');
    const birthday = document.getElementById('birthday');
    const role = document.getElementById('role');
    const password = document.getElementById('password');

    // Apply red border to fields if they are empty or invalid
    if (username.value.trim() === '') {
      username.style.border = '2px solid red';
    } else {
      username.style.border = 'none'; // Remove border if input is not empty
    }

    if (firstname.value.trim() === '') {
      firstname.style.border = '2px solid red';
    } else {
      firstname.style.border = 'none'; // Remove border if input is not empty
    }

    if (lastname.value.trim() === '') {
      lastname.style.border = '2px solid red';
    } else {
      lastname.style.border = 'none'; // Remove border if input is not empty
    }

    if (email.value.trim() === '') {
      email.style.border = '2px solid red';
    } else {
      email.style.border = 'none'; // Remove border if input is not empty
    }

    if (phone2.value.trim() === '') {
      phone2.style.border = '2px solid red';
    } else {
      phone2.style.border = 'none'; // Remove border if input is not empty
    }

    if (address.value.trim() === '') {
      address.style.border = '2px solid red';
    } else {
      address.style.border = 'none'; // Remove border if input is not empty
    }

    if (birthday.value.trim() === '') {
      birthday.style.border = '2px solid red';
    } else {
      birthday.style.border = 'none'; // Remove border if input is not empty
    }


    if (role.value === 'Choose Role') {
      role.style.border = '2px solid red';
    } else {
      role.style.border = 'none'; // Remove border if category is selected
    }

    if (password.value.trim() === '') {
      password.style.border = '2px solid red';
    } else {
      password.style.border = 'none'; // Remove border if input is not empty
    }
  }

  // Combine phone1 and phone2 values
  const phone = phone1.value + phone2.value; // Concatenate phone numbers

  // Function to validate phone pattern
  function validatePhilippinePhoneNumber(phone) {
    // Define the regex pattern to match +639 followed by 9 digits
    const phonePattern = /^(\+63)\d{10}$/;

    // Check if the phone number matches the pattern
    if (phonePattern.test(phone)) {
      return true; // Valid Philippine phone number
    } else {
      return false; // Invalid phone number
    }
  }

  // Function to validate the date format (YYYY-MM-DD)
  // Function to validate the date format (YYYY-MM-DD)
  function validateBirthday(birthday) {
    // Check if the input matches the YYYY-MM-DD format
    const regex = /^\d{4}-\d{2}-\d{2}$/;
    if (regex.test(birthday)) {
      // Split the date into components
      const dateComponents = birthday.split('-');

      // Check if the date is valid using the Date object
      const year = parseInt(dateComponents[0], 10);
      const month = parseInt(dateComponents[1], 10) - 1; // Month is zero-indexed
      const day = parseInt(dateComponents[2], 10);

      // Create a Date object and check if it's a valid date
      const date = new Date(year, month, day);
      if (date.getFullYear() === year && date.getMonth() === month && date.getDate() === day) {
        return true; // Valid date
      }
    }
    return false; // Invalid date format or invalid date
  }

  // Function to validate if the birthday is within a valid range (18 to 60 years old)
  function validateBirthdayYear(birthday) {
    // Check if the input matches the YYYY-MM-DD format
    const regex = /^\d{4}-\d{2}-\d{2}$/;
    if (regex.test(birthday)) {
      const birthDate = new Date(birthday);
      const currentDate = new Date();

      const birthYear = birthDate.getFullYear();
      const currentYear = currentDate.getFullYear();

      // Calculate the legal and invalid years
      const legalYear = currentYear - 18;
      const invalidYear = currentYear - 60;

      // Check if the birth year is within the valid range
      if (birthYear >= currentYear || birthYear > legalYear || birthYear <= invalidYear) {
        return false; // Invalid birth year (too young or too old)
      }
      return true; // Valid age (between 18 and 60)
    }
    return false; // Invalid date format
  }

  // Example usage:
  if (validateBirthday(birthday)) {
    console.log('Valid Birthday');
  } else {
    console.log('Invalid Birthday');
  }

  if (validateBirthdayYear(birthday)) {
    console.log('Valid Age (18-60)');
  } else {
    console.log('Invalid Age (Must be between 18-60)');
  }





  // Automatically validate on page load
  document.addEventListener('DOMContentLoaded', function() {
    validateFieldsUsers(); // Validate the fields when the page loads
  });

  // Optionally, add event listeners to check the fields as the user types
  const inputsUsers = document.querySelectorAll('input, select');
  inputsUsers.forEach(function(inputUsers) {
    inputUsers.addEventListener('input', function() {
      validateFieldsUsers(); // Revalidate fields on user input
    });
  });

  $(document).ready(function() {
    // new form update
    $(document).on('submit', '#addAccount', function(e) {
      e.preventDefault(); // Prevent form submission

      // Clear previous red borders before validating
      var inputsUsers = document.querySelectorAll('input, select');
      inputsUsers.forEach(function(inputUsers) {
        inputUsers.style.border = ''; // Reset all borders
      });

      // Re-validate the fields before submitting
      validateFieldsUsers(); // Re-validate fields to ensure red borders are applied to empty ones

      // Check if role is selected properly
      const roleField = document.getElementById('role');
      if (roleField.value === 'Choose Role') {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Role',
          text: 'Please choose a different role.',
          timer: 3000
        });
        categoroleFieldryField.style.border = '2px solid red'; // Apply red border to role field
        return; // Stop further processing if role is invalid
      }

      // If any field is invalid, show a general error message and stop execution
      const fieldsToCheckUsers = [
        'username', 'firstname', 'lastname', 'email', 'phone1',
        'phone2', 'address', 'birthday', 'role', 'password'
      ];

      let isValidUsers = true;
      fieldsToCheckUsers.forEach(function(fieldNameUsers) {
        var fieldUsers = document.getElementById(fieldNameUsers);
        if (!fieldUsers.value.trim() || (fieldNameUsers === 'category' && fieldUsers.value === 'Select Category Option')) {
          isValidUsers = false;
          fieldUsers.style.border = '2px solid red'; // Apply red border to invalid fields
        }
      });

      // If validation fails, stop form submission and show an error message
      if (!isValidUsers) {
        Swal.fire({
          icon: 'error',
          title: 'Missing Fields',
          text: 'Please fill in all the required fields.',
          timer: 3000
        });
        return; // Stop execution if validation fails
      }

      // Validate expiration date format
      const phones1 = document.getElementById('phone1');
      const phones2 = document.getElementById('phone2');
      const phones = phones1.value + phones2.value;
      if (!validatePhilippinePhoneNumber(phones)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Phone Number',
          text: 'Please enter a valid phone number format +63XXXXXXXXXX' . phones,
          timer: 3000
        });
        document.getElementById('phone2').style.border = '2px solid red';
      }
      const birthdayadd = document.getElementById('birthday').value;

      // Validate if expiration date is within the last 5 years
      if (!validateBirthday(birthdayadd)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Birthday Date',
          text: 'Please enter a birthday date in the format YYYY-MM-DD.',
          timer: 3000
        });
        document.getElementById('birthday').style.border = '2px solid red';
        return;
      }

      // Validate if expiration date is within the last 5 years
      if (!validateBirthdayYear(birthdayadd)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Birthday Date',
          text: 'Please enter required birthday date.',
          timer: 3000
        });
        document.getElementById('birthday').style.border = '2px solid red';
        return;
      }


      // If validation passes, show SweetAlert to confirm submission
      Swal.fire({
        title: 'Do you want to save the user?',
        confirmButtonText: 'Save',
        denyButtonText: `Cancel`,
      }).then((result) => {
        if (result.isConfirmed) {
          // Create FormData for AJAX request
          var formData = new FormData(this);
          formData.append("valid_account", true);

          $.ajax({
            type: "POST",
            url: "../user_process/user_process.php", // action
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = jQuery.parseJSON(response);
              if (res.status == 400) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 3000
                })
              } else if (res.status == 500) {
                Swal.fire({
                  icon: 'warning',
                  title: 'Something Went Wrong.',
                  text: res.msg,
                  timer: 3000
                })
              } else if (res.status == 200) {
                Swal.fire({
                  icon: 'success',
                  title: 'SUCCESS',
                  text: res.msg,
                  timer: 2000
                }).then(function() {
                  location.reload();
                });
              }
            }
          });
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info').then(function() {
            location.reload(); // Reload the page if the user cancels
          });
        }
      });
    })
  });


$(document).ready(function() {
  // Update Row - Fetch product data
  $(document).on('click', '.account_edit', function() {
    var user_edit_id = $(this).val();

    $.ajax({
      type: "GET",
      url: "../getdata/user_data.php?user_edit_id=" + user_edit_id,
      success: function(response) {
        var res = jQuery.parseJSON(response);
        if (res.status == 200) {
          $('#upduser_id').val(res.data.user_id);
          $('#updusername').val(res.data.username);
          $('#updfirstname').val(res.data.firstname);
          $('#updlastname').val(res.data.lastname);
          $('#updemail').val(res.data.email);
          $('#updphone2').val(res.data.phone);
          $('#updaddress').val(res.data.address);
          $('#updbirthday').val(res.data.birthday);
          $('#updrole').val(res.data.role);
        }
      }
    });
  });

  // Function to validate empty fields and apply red border
  function validateFieldsUpdUsers() {
    // Get the form fields
    const fields = [
      'updusername', 'updfirstname', 'updlastname', 'updemail', 'updphone1',
      'updphone2', 'updaddress', 'updbirthday', 'updrole', 'updpassword'
    ];

    fields.forEach(function(field) {
      const element = document.getElementById(field);
      if (element) {
        if (element.value.trim() === '' || (field === 'updrole' && element.value === 'Choose Role')) {
          element.style.border = '2px solid red';
        } else {
          element.style.border = 'none'; // Remove border if valid
        }
      }
    });
  }

  // Automatically validate on page load
  document.addEventListener('DOMContentLoaded', function() {
    validateFieldsUpdUsers(); // Validate the fields when the page loads
  });

  // Optionally, add event listeners to check the fields as the user types
  const inputsupdUsers = document.querySelectorAll('input, select');
  inputsupdUsers.forEach(function(inputupdUsers) {
    inputupdUsers.addEventListener('input', function() {
      validateFieldsUpdUsers(); // Revalidate fields on user input
    });
  });

  // New form update (Submit the form)
  $(document).on('submit', '#updAccount', function(e) {
    e.preventDefault(); // Prevent form submission

    // Clear previous red borders before validating
    var inputsupdUsers = document.querySelectorAll('input, select');
    inputsupdUsers.forEach(function(inputupdUsers) {
      inputupdUsers.style.border = ''; // Reset all borders
    });

    // Re-validate the fields before submitting
    validateFieldsUpdUsers(); // Re-validate fields to ensure red borders are applied to empty ones

    // Check if role is selected properly
    const roleFieldupd = document.getElementById('updrole');
    if (roleFieldupd.value === 'Choose Role') {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Role',
        text: 'Please choose a valid role.',
        timer: 3000
      });
      roleFieldupd.style.border = '2px solid red'; // Apply red border to role field
      return; // Stop further processing if role is invalid
    }

    // If any field is invalid, show a general error message and stop execution
    const fieldsToCheckupdUsers = [
      'updusername', 'updfirstname', 'updlastname', 'updemail', 'updphone1',
      'updphone2', 'updaddress', 'updbirthday', 'updrole', 'updpassword'
    ];

    let isValidupdUsers = true;
    fieldsToCheckupdUsers.forEach(function(fieldNameUsers) {
      var fieldupdUsers = document.getElementById(fieldNameUsers);
      if (!fieldupdUsers.value.trim() || (fieldNameUsers === 'updrole' && fieldupdUsers.value === 'Choose Role')) {
        isValidupdUsers = false;
        fieldupdUsers.style.border = '2px solid red'; // Apply red border to invalid fields
      }
    });

    // If validation fails, stop form submission and show an error message
    if (!isValidupdUsers) {
      Swal.fire({
        icon: 'error',
        title: 'Missing Fields',
        text: 'Please fill in all the required fields.',
        timer: 3000
      });
      return; // Stop execution if validation fails
    }

    // Validate phone number format
    const updphone1 = document.getElementById('updphone1').value;
    const updphone2 = document.getElementById('updphone2').value;
    const fullPhone = updphone1 + updphone2;
    if (!validatePhilippinePhoneNumber(fullPhone)) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Phone Number',
        text: 'Please enter a valid phone number format (+63XXXXXXXXXX)',
        timer: 3000
      });
      document.getElementById('updphone2').style.border = '2px solid red';
      return; // Stop execution if phone number is invalid
    }

    // Validate birthday format and range
    const updbirthdayadd = document.getElementById('updbirthday').value;
    if (!validateBirthday(updbirthdayadd)) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Birthday Date',
        text: 'Please enter a valid birthday date in the format YYYY-MM-DD.',
        timer: 3000
      });
      document.getElementById('updbirthday').style.border = '2px solid red';
      return;
    }

    // Validate if the birthday is within the required age range (18 to 60)
    if (!validateBirthdayYear(updbirthdayadd)) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Birthday Date',
        text: 'Age must be between 18 and 60 years old.',
        timer: 3000
      });
      document.getElementById('updbirthday').style.border = '2px solid red';
      return;
    }

    // If validation passes, show SweetAlert to confirm submission
    Swal.fire({
      title: 'Do you want to save the user?',
      confirmButtonText: 'Save',
      denyButtonText: `Cancel`,
    }).then((result) => {
      if (result.isConfirmed) {
        // Create FormData for AJAX request
        var formData = new FormData(this);
        formData.append("valid_account", true);

        $.ajax({
          type: "POST",
          url: "../user_process/user_process.php", // action
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 400) {
              Swal.fire({
                icon: 'warning',
                title: 'Something Went Wrong.',
                text: res.msg,
                timer: 3000
              });
            } else if (res.status == 500) {
              Swal.fire({
                icon: 'warning',
                title: 'Server Error.',
                text: res.msg,
                timer: 3000
              });
            } else if (res.status == 200) {
              Swal.fire({
                icon: 'success',
                title: 'SUCCESS',
                text: res.msg,
                timer: 2000
              }).then(function() {
                location.reload(); // Reload the page after success
              });
            }
          }
        });
      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info').then(function() {
          location.reload(); // Reload the page if the user cancels
        });
      }
    });
  });
});










// Function to validate empty fields and apply red border
function validateFieldsUpdPass() {
    // Get the form fields
    const fieldspass = [
      'admin_password', 'u_id', 'user_password'
    ];

    fieldspass.forEach(function(fieldpass) {
      const elementpass = document.getElementById(fieldpass);
      if (elementpass) {
        if (elementpass.value.trim() === '' || (fieldpass === 'updrole' && elementpass.value === 'Choose Role')) {
          elementpass.style.border = '2px solid red';
        } else {
          elementpass.style.border = 'none'; // Remove border if valid
        }
      }
    });
  }

  // Automatically validate on page load
  document.addEventListener('DOMContentLoaded', function() {
    validateFieldsUpdPass(); // Validate the fields when the page loads
  });

  // Optionally, add event listeners to check the fields as the user types
  const inputsupdPass = document.querySelectorAll('input');
  inputsupdPass.forEach(function(inputupdPass) {
    inputupdPass.addEventListener('input', function() {
      validateFieldsUpdPass(); // Revalidate fields on user input
    });
  });

  // New form update (Submit the form)
  $(document).on('submit', '#userPassword', function(e) {
    e.preventDefault(); // Prevent form submission

    // Clear previous red borders before validating
    var inputsupdPass = document.querySelectorAll('input');
    inputsupdPass.forEach(function(inputupdPass) {
      inputupdPass.style.border = ''; // Reset all borders
    });

    // Re-validate the fields before submitting
    validateFieldsUpdPass(); // Re-validate fields to ensure red borders are applied to empty ones



    // If any field is invalid, show a general error message and stop execution
    const fieldsToCheckupdUsers = [
      'admin_password', 'u_id', 'user_password'
    ];

    let isValidupdUsers = true;
    fieldsToCheckupdUsers.forEach(function(fieldNameUsers) {
      var fieldupdUsers = document.getElementById(fieldNameUsers);
      if (!fieldupdUsers.value.trim()) {
        isValidupdUsers = false;
        fieldupdUsers.style.border = '2px solid red'; // Apply red border to invalid fields
      }
    });

    // If validation fails, stop form submission and show an error message
    if (!isValidupdUsers) {
      Swal.fire({
        icon: 'error',
        title: 'Missing Fields',
        text: 'Please fill in all the required fields.',
        timer: 3000
      });
      return; // Stop execution if validation fails
    }

    // Validate phone number format
    const updphone1 = document.getElementById('updphone1').value;
    const updphone2 = document.getElementById('updphone2').value;
    const fullPhone = updphone1 + updphone2;
    if (!validatePhilippinePhoneNumber(fullPhone)) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Phone Number',
        text: 'Please enter a valid phone number format (+63XXXXXXXXXX)',
        timer: 3000
      });
      document.getElementById('updphone2').style.border = '2px solid red';
      return; // Stop execution if phone number is invalid
    }

    // Validate birthday format and range
    const updbirthdayadd = document.getElementById('updbirthday').value;
    if (!validateBirthday(updbirthdayadd)) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Birthday Date',
        text: 'Please enter a valid birthday date in the format YYYY-MM-DD.',
        timer: 3000
      });
      document.getElementById('updbirthday').style.border = '2px solid red';
      return;
    }

    // Validate if the birthday is within the required age range (18 to 60)
    if (!validateBirthdayYear(updbirthdayadd)) {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Birthday Date',
        text: 'Age must be between 18 and 60 years old.',
        timer: 3000
      });
      document.getElementById('updbirthday').style.border = '2px solid red';
      return;
    }

    // If validation passes, show SweetAlert to confirm submission
    Swal.fire({
      title: 'Do you want to Update this User Password?',
        showCancelButton: true,
        confirmButtonText: 'Update',
    }).then((result) => {
      if (result.isConfirmed) {
        // Create FormData for AJAX request
        var formData = new FormData(this);
        formData.append("user_Password", true);

        $.ajax({
          type: "POST",
          url: "../user_process/user_process.php", // action
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 400) {
              Swal.fire({
                icon: 'warning',
                title: 'Something Went Wrong.',
                text: res.msg,
                timer: 3000
              });
            } else if (res.status == 500) {
              Swal.fire({
                icon: 'warning',
                title: 'Server Error.',
                text: res.msg,
                timer: 3000
              });
            } else if (res.status == 200) {
              Swal.fire({
                icon: 'success',
                title: 'SUCCESS',
                text: res.msg,
                timer: 2000
              }).then(function() {
                location.reload(); // Reload the page after success
              });
            }
          }
        });
      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info').then(function() {
          location.reload(); // Reload the page if the user cancels
        });
      }
    });
  });




</script>
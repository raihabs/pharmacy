<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session
if (isset($_SESSION["user_id_admin"])) {
  $id = $_SESSION["user_id_admin"];
  $sessionId = $id;

  $valid_user = "SELECT * FROM `user` WHERE `user_id` = '" . $sessionId . "' && `role` != 'Admin'";
  $check_user = mysqli_query($conn, $valid_user);
} else if (isset($_SESSION["user_id_cashier"])) {
  $id = $_SESSION["user_id_cashier"];
  $sessionId = $id;

  $valid_user = "SELECT * FROM `user` WHERE `user_id` = '" . $sessionId . "' && `role` != 'Cashier'";
  $check_user = mysqli_query($conn, $valid_user);
} else {
  $id = $_SESSION["user_id_inventory_clerk"];
  $sessionId = $id;

  $valid_user = "SELECT * FROM `user` WHERE `user_id` = '" . $sessionId . "' && `role` != 'Inventory Clerk'";
  $check_user = mysqli_query($conn, $valid_user);
}


if (!isset($sessionId) || mysqli_num_rows($check_user) < 0) {
  header("Location: ../usersignin/signin.php");
  session_destroy();
} else

  $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = $sessionId"));

include "../include/user_meta_tag.php";
include "../include/user_top.php";
?>

<title>Profile Settings</title>

</head>

<body>
  <?php include "../include/user_loader.php"; ?>

  <div class="container-scroller">
    <?php    // unlink($user["image"]);
    if (isset($_SESSION["user_id_admin"])) {
      include "../include/admin_sidebar.php";
    } else if (isset($_SESSION["user_id_cashier"])) {
      include "../include/cashier_sidebar.php";
    } else {
      include "../include/inventory_clerk_sidebar.php";
    }
    ?>
    <?php  ?>

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

      <?php include "../include/user_profile_settings_main_panel.php"; ?>

    </div>
    <!-- container-scroller -->

    <?php include '../include/user_bottom.php'; ?>
    <?php include '../user_process/user_process.php'; ?>
    <?php include '../user_process/signature_process.php'; ?>

    <script type="text/javascript">
      document.getElementById("image").onchange = function() {
        document.getElementById("form").submit();
      };
    </script>
</body>

</html>
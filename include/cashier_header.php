<!-- header -->
<nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
  <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
    <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="../admin/admin.php"><img src="../assets/images/default_images/brindox.png" alt="logo" style="height: 40px; width: 40px;" /></a>
    <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
      <i class="mdi mdi-menu"></i>
    </button>
    <ul class="navbar-nav">
      <a class="nav-link" href="../inventory_clerk/physical_inventory.php">
        <h1 style="color: #fff; letter-spacing: 5px; text-transform: uppercase; font-size:large; display: flex; justify-content:center; margin-top: 16px;">Brindox Care Pharmacy</h1>
      </a>
    </ul>
    <ul class="navbar-nav navbar-nav-left ml-lg-auto">
    
      <?php
      include '../config/connect.php';

      error_reporting(0);
      session_start();
      // unlink($user["image"]);
      if (isset($_SESSION["user_id_admin"])) {
        $id = $_SESSION["user_id_admin"];
      } else if (isset($_SESSION["user_id_cashier"])) {
        $id = $_SESSION["user_id_cashier"];
      } else {
        $id = $_SESSION["user_id_inventory_clerk"];
      }

      $show_profile = "SELECT * FROM `user` WHERE `user_id` = '" . $id . "'";
      $result_profile = mysqli_query($conn, $show_profile);
      $profile = mysqli_fetch_array($result_profile);
      ?>


      <li class="nav-item nav-profile dropdown border-0">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
          <!-- <img class="nav-profile-img mr-2" alt="" src="../assets/images1/faces/face1.jpg" /> -->
          <?php if (is_array($profile)) { ?>
            <?php if (empty($profile['image'])) { ?>
              <img class="nav-profile-img mr-2" alt="" src="../assets/images/default_images/profile.jpg" />
            <?php } else { ?>
              <img class="nav-profile-img mr-2" src="../assets/images/user_images/<?php echo $profile['image']; ?>" width=45 height=45 title="profile" style="object-fit: cover;">
          <?php }
          }
          ?>
          <span class="profile-name"><?php echo $profile['firstname'] . " " . $profile['lastname']; ?></span>
        </a>
        <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="../admin/user_profile_settings.php">
            <i class="mdi mdi-account-settings mr-2 text-success"></i> Profile Settings </a>
          <a class="dropdown-item" href="../usersignin/logout.php">
            <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
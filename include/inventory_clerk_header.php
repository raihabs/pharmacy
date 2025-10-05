<!-- header -->
<nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
  <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
    <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="../inventory_clerk/physical_inventory.php"><img src="../assets/images/default_images/brindox.png" alt="logo" style="height: 40px; width: 40px;" /></a>
    <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
      <i class="mdi mdi-menu"></i>
    </button>
    <ul class="navbar-nav">
      <a class="nav-link" href="../inventory_clerk/physical_inventory.php">
        <h1 style="color: #fff; letter-spacing: 5px; text-transform: uppercase; font-size:large; display: flex; justify-content:center; margin-top: 16px;">Brindox Care Pharmacy</h1>
      </a>
    </ul>
    <ul class="navbar-nav navbar-nav-left ml-lg-auto">
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          <?php
          $archive_count_list_query = "SELECT COUNT(*), p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.notification, p.expiration_date, p.date_created_at, 
          a.ar_id as ar_id, a.item_code as item_code, a.quantity, a.expiration_date, a.remarks, a.created_by, a.updated_by, a.date_created_at, a.date_updated_at
          FROM product p LEFT JOIN archive a ON p.pr_id = a.pr_id WHERE (a.quantity <= 30 OR a.remarks != 'ACTIVE') AND a.date_updated_at IS NOT NULL  ORDER BY a.date_created_at DESC, a.date_updated_at DESC
          LIMIT 70";

          $archive_count_list_result = mysqli_query($conn, $archive_count_list_query);
          $count = mysqli_fetch_array($archive_count_list_result);
          $notification__query = "SELECT COUNT(*), pr_id as pr_id FROM `notification` WHERE  `created_by` = '" . $_SESSION["user_id_inventory_clerk"] . "'";
          $notification__result = mysqli_query($conn, $notification__query);

          $notif = mysqli_fetch_array($notification__result);
          ?>
          <span class="count count-varient1"><?php echo $count['COUNT(*)'] - $notif['COUNT(*)'] ?></span>
          <!-- count of archives -->
        </a>


        <div class="dropdown-menu navbar-dropdown1 navbar-dropdown-large preview-list" aria-labelledby="messageDropdown" style="overflow-y: auto; white-space: nowrap; height: 660px;">
          <h6 class="p-3 mb-0">Notification</h6>
          <?php
          include '../config/connect.php';

          $archive_list_query = "SELECT  p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.notification, p.expiration_date, p.date_created_at, 
    a.ar_id as ar_id, a.item_code as item_code, a.quantity, a.expiration_date, a.remarks, a.created_by, a.updated_by, a.date_created_at, a.date_updated_at
    FROM product p LEFT JOIN archive a ON p.pr_id = a.pr_id WHERE (a.quantity <= 30 OR a.remarks != 'ACTIVE') AND a.date_updated_at IS NOT NULL ORDER BY  a.date_created_at DESC, a.date_updated_at DESC
LIMIT 70";
          $archive_list_result = mysqli_query($conn, $archive_list_query);

          if (mysqli_num_rows($archive_list_result) > 0) {
            while ($row = mysqli_fetch_array($archive_list_result)) {


              $today = new DateTime();
              $thirty_days_later = new DateTime('+30 days');
              $date_to_check = new DateTime($row['expiration_date']);

              $quantity = $row['quantity'];
              $user_creator_list_query = "SELECT * FROM `user` WHERE `user_id` = '" . $row["created_by"] . "' ORDER BY `user_id` DESC";
              $user_creator_list_result = mysqli_query($conn, $user_creator_list_query);
              $user_creator = mysqli_fetch_array($user_creator_list_result);


              // Determine remarks based on quantity and expiration date
              $today = new DateTime();
              $thirty_days_later = new DateTime('+30 days');
              $date_to_check = new DateTime($row['expiration_date']);

          ?>
              <?php

              if (isset($_SESSION["user_id_admin"])) {
              ?>


                <a class="dropdown-item preview-item" onclick="updateNotification(<?php echo $row['pr_id']; ?>)" href="../admin/archive.php" style="text-decoration: none;">

                <?php } else if (isset($_SESSION["user_id_inventory_clerk"])) { ?>
                  <a class="dropdown-item preview-item" onclick="updateNotification(<?php echo $row['pr_id']; ?>)" href="../inventory_clerk/inventory.php" style="text-decoration: none;">
                  <?php } ?>


                  <div class="preview-item-content flex-grow">
                    <?php
                    $notification_list_query = "SELECT * FROM `notification` WHERE `pr_id` = '" . $row["pr_id"] . "'  AND `created_by` = '" . $_SESSION["user_id_inventory_clerk"] . "'";
                    $notification_list_result = mysqli_query($conn, $notification_list_query);

                    $notification = mysqli_fetch_assoc($notification_list_result);

                    if (mysqli_num_rows($notification_list_result) == 0) { ?>
                      <button class="btn btn-primary mr-5 notif-button"style="margin-bottom: 50px; left:0; align-items: top; background: #3c506e; opacity: 25%; height: 120px; width: 180px; border: none; width: 400px; position: absolute;"></button>
                    <?php
                    } else
                    ?>
                    <?php if ($quantity == 0 && $date_to_check > $thirty_days_later) { ?>
                      <span class="badge badge-pill mb-2 mt-2 " style="background: #B30E1A; color:fff !important;  font-size: 14px; letter-spacing: 2px;"><?php echo "CRITICAL LEVEL 1" ?></span>
                      <p class="text-justify text-sm-left text-md-left  ">Please check <span style="font-size: 14px; color: #B30E1A; font-weight: 900;"><?php echo $row['remarks'] ?> ITEM </span> <span style="font-size: 14px; color: #273746; font-weight: 900;">(<?php echo $row['item_code'] ?>).</span></p>
                    <?php } else if ($quantity <= 30 && $date_to_check > $thirty_days_later) { ?>
                      <span class="badge badge-pill badge-warning mb-2 mt-2" style="background: #B3A70E; color:fff !important;font-size: 14px; letter-spacing: 2px;"><?php echo "CRITICAL LEVEL 2" ?></span>
                      <p class="text-justify text-sm-left text-md-left  ">Please check <span style="font-size: 14px; color: #5dade2; font-weight: 900;"><?php echo $row['remarks'] ?> ITEM </span> <span style="font-size: 14px; color: #273746; font-weight: 900;">(<?php echo $row['item_code'] ?>).</span></p>
                    <?php } else if ($quantity > 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today || $quantity <= 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today) { ?>
                      <span class="badge badge-pill badge-warning mb-2 mt-2" style="background: #B3A70E; color:fff !important;font-size: 14px; letter-spacing: 2px;"><?php echo "CRITICAL LEVEL 2" ?></span>
                      <p class="text-justify text-sm-left text-md-left  "><span style="background: #B30E1A; color:fff !important;font-size: 14px; color: #5dade2; text-decoration: underline; font-weight: 900;">Please check <span style="font-size: 14px; color: #5dade2; font-weight: 900;"><?php echo $row['remarks'] ?> ITEM </span> <span style="font-size: 14px; color: #273746; font-weight: 900;">(<?php echo $row['item_code'] ?>).</span></p>
                    <?php } else if ($quantity > 30 && $date_to_check <= $today || $quantity <= 30 && $date_to_check <= $today) { ?>
                      <span class="badge badge-pill mb-2 mt-2 " style="background: #B30E1A; color:fff !important;font-size: 14px; letter-spacing: 2px;"><?php echo "CRITICAL LEVEL 1 " ?></span>
                      <p class="text-justify text-sm-left text-md-left  ">Please check <span style="font-size: 14px; color: #B30E1A; font-weight: 900;"><?php echo $row['remarks'] ?> ITEM </span> <span style="font-size: 14px; color: #273746; font-weight: 900;">(<?php echo $row['item_code'] ?>).</span></p>
                    <?php } else { ?>
                      <span class="badge badge-pill badge-success mb-2 mt-2" style="background: #0EB334; color:fff !important;font-size: 14px; letter-spacing: 2px;"> CRITICAL LEVEL 3</span>
                      <p class="text-justify text-sm-left text-md-left">User: <span style="font-size: 14px; color: #5dade2; text-decoration: underline; font-weight: 900;"><?php echo $user_creator["firstname"] . " " . $user_creator["lastname"] ?></span> created <span style="font-size: 14px; color: #5dade2; font-weight: 900;"><?php echo $row['remarks'] ?> ITEM </span><span style="font-size: 14px; color: #273746; font-weight: 900;">(<?php echo $row['item_code'] ?>).</span> </p>
                    <?php } ?>

                  </div>
                  <?php

                  // Create a DateTime object from the SQL datetime string
                  $dateTime = new DateTime($row['date_updated_at'] ? $row['date_created_at'] : $row['date_created_at']);

                  // Set the timezone to 'Asia/Manila'
                  $dateTime->setTimezone(new DateTimeZone('Asia/Manila'));

                  // Format the DateTime object to 'Y-m-d h:i A' format
                  $timeFormatted = $dateTime->format('Y-m-d h:i A');

                  ?>
                  <p class=" text-muted align-self-start mt-2 " style="font-size: 12px;"> <?php echo $timeFormatted ?> </p>
                  </a>
                <?php
              }
            }

            if (isset($_SESSION["user_id_admin"])) { ?>
                <a href="../admin/archive.php">
                  <h6 class="p-3 mb-0">See all activity</h6>
                </a>
              <?php } else if (isset($_SESSION["user_id_inventory_clerk"])) { ?>
                <a href="../inventory_clerk/inventory.php">
                  <h6 class="p-3 mb-0">See all activity</h6>
                </a>
              <?php } ?>

        </div>
      </li>

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
          <a class="dropdown-item" href="../inventory_clerk/user_profile_settings.php">
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

<script>
function updateNotification(productId) {
    // Send a POST request to update_notification.php
    fetch('../user_process/update_notification.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${productId}` // Data sent to the server
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // alert('Notification updated successfully!');
            // Optionally, refresh the notifications list or update the UI
        } else {
            // alert(`Error: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // alert('An error occurred while updating the notification.');
    });
}
</script>
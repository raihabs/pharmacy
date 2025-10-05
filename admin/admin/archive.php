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
</style>
</head>

<body>

  <?php include "../include/user_loader.php"; ?>

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
            <h3 class="page-title">Archive Table</h3>
            <?php include "../include/user_breadcrumb.php"; ?>
            <div class="page-header flex-wrap">
              <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span>
              </h3>
              <div class="d-flex">
                <a href="../admin/archive.php">
                  <button type="button" class="btn btn-sm bg-white btn-icon-text border">
                    <i class="mdi mdi-refresh btn-icon-prepend"></i>Refresh
                  </button>
                </a>
                <a href="../user_process/archive_export.php">
                  <button type="button" class="btn btn-sm bg-white btn-icon-text border ml-3">
                    <i class="mdi mdi-export btn-icon-prepend"></i>Export
                  </button>
                </a>
                <button type="button" class="btn btn-sm bg-white btn-icon-text ml-3" onclick="printUserTable()">
                  <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <iframe id="userPrintIframe" src="../getdata/archive_data_query.php" style="display:none;"></iframe>

              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <p class="card-description"> </p>
                    <div class="table-responsive">
                      <?php include "../admin/archive_data.php"; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>


          <?php include "../include/user_footer.php"; ?>
        </div>



        <!-- Update Modal -->
        <div class="modal fade" id="updateUserArchive" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header text-light" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
                <h5 class="modal-title text-uppercase font-weight-bold ml-3" id="exampleModalLabel" style="color: #fff;">Update Inventory</h5>
                <button type="button" class="close mr-1" style="padding-top: 22px;" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="updArchive">
                <div class="modal-body ml-5 mr-5 mt-4">
                  <input type="hidden" name="pr_id" id="pr_id">
                  <input type="hidden" name="remarks" id="remarks">

                  <input type="hidden" name="user_id" value="<?= $sessionId ?>">
                  <div class="mb-5">
                    <label for="content">Item Code</label>

                    <div class="row">
                      <div class="col-md-4">
                        <input type="text" name="item_code" id="item_code" placeholder="Item Code" class="form-control  form-control-lg" readonly />
                      </div>
                    </div>
                  </div>



                  <div class="mb-4">
                    <label for="content" style="margin: 0 17.5rem 0 0;">Quantity</label>
                    <label for="content">Expiration Date</label>
                    <div class="row">
                      <div class="col-md-4">
                        <input type="text" name="quantity" id="quantity" placeholder="Quantity" class="form-control form-control-lg" />
                      </div>
                      <div class="col-md-4">
                        <input type="date" name="expiration_date" id="expiration_date" placeholder="Expiration Date" class="form-control form-control-lg" />
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
    </div>

    <?php include '../include/user_bottom.php'; ?>
    <?php include '../user_process/user_process.php'; ?>




</body>

</html>
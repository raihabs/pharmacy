<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session
SESSION["user_id_inventory_clerk"];

$sessionId = $id;

$valid_user = "SELECT * FROM `user` WHERE `user_id` = '" . $sessionId . "' && `role` != 'Inventory Clerk'";
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



  .card-container {
    max-width: 1400px;
    /* Adjust the max-width as per your requirement */
    margin: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    /* Adjust card width and spacing */
    gap: 20px;
    /* Adjust gap between cards */
  }

  @media (max-width: 767px) {
    .card-container {
      display: grid;
      margin: 10px;
    }

  }

  .card-items {
    box-shadow: 0 0 10px rgba(2, 1, 2, 0.8);
    padding: 10px;
  }

  .card-img {
    width: 100%;
    height: 200px;
    /* Fixed height */
    object-fit: cover;
    /* Ensures the image covers the area and maintains aspect ratio */
    padding: 5px;
  }

  .product-name {
    font-weight: bold;
    color: #024ab8;

    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    /* Number of lines to show */
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 3em;
    /* Adjust the height as per line height */
    line-height: 1.5em;
    /* Adjust the line height */
  }

  .item-code {
    font-weight: bold;
    color: #000;
    text-align: right;
  }

  .description {
    margin-top: 10px;
    font-size: 12px;
    line-height: 1.6;

    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    /* Number of lines to show */
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 3em;
    /* Adjust the height as per line height */
    line-height: 1.5em;
    /* Adjust the line height */
  }

  .price-quantity {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    font-size: 16px;
  }

  .quantity {
    width: 30px;
  }

  .btn-bottom {
    width: 100%;
    padding: 10px 0;
    background-color: #024ab8;
    color: white;
    text-align: center;
    border: none;
    border-radius: 0;
    cursor: pointer;
  }
</style>
</head>

<body>

  <?php include "../include/user_loader.php"; ?>

  <div class="container-scroller">
    <?php include "../include/inventory_clerk_sidebar.php"; ?>

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


      <?php include "../include/inventory_clerk_header.php"; ?>


      <div class="main-panel">
        <div class="content-wrapper pb-0">

          <div class="page-header">
            <h3 class="page-title">Inventory Table</h3>
            <?php include "../include/user_breadcrumb.php"; ?>
            <div class="page-header flex-wrap">
              <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span>
              </h3>
              <div class="d-flex">
                <a href="../inventory_clerk/sales.php">
                  <button type="button" class="btn btn-sm bg-white btn-icon-text border">
                    <i class="mdi mdi-refresh btn-icon-prepend"></i>Refresh
                  </button>
                </a>
                <!-- <a href="../user_process/sales_export.php">
                  <button type="button" class="btn btn-sm bg-white btn-icon-text border ml-3">
                    <i class="mdi mdi-export btn-icon-prepend"></i>Export
                  </button>
                </a> -->
                <button type="button" class="btn btn-sm bg-white btn-icon-text ml-3" onclick="printUserTable()">
                  <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <iframe id="userPrintIframe" src="../getdata/sales_data_query.php" style="display:none;"></iframe>

              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <p class="card-description"> </p>
                    <div class="table-responsive">
                      <?php include "../inventory_clerk/sales_data.php"; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-6 stretch-card">
              </div>

              <?php
              $total_query = "SELECT SUM(total) as total_sale FROM sale WHERE status = 'RELEASED' ";
              $total_result = mysqli_query($conn, $total_query);
              $total = mysqli_fetch_array($total_result);
              ?>

              <div class="col-lg-6 stretch-card">
                <div class="card">
                  <div class="card-body">

                    <p class="card-description">
                    <h4 class="card-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      TOTAL SALE: &nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $total['total_sale'] ?></b></h4>
                    </p>

                  </div>
                </div>
              </div>
            </div>

          </div>


          <?php include "../include/user_footer.php"; ?>
        </div>





      </div>
      <!-- container-scroller -->

      <?php include '../include/user_bottom.php'; ?>
      <?php include '../user_process/user_process.php'; ?>


      <script>
        // Add User Modal
        $(document).on('submit', '#updSales', function(e) {
          e.preventDefault();
          var formData = new FormData(this);
          formData.append("update_sales", true);
          {
            Swal.fire({
              title: 'Do you want to update product details?',
              showCancelButton: true,
              confirmButtonText: 'Update',
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $.ajax({
                  type: "POST",
                  url: "../user_process/product_process.php", //action
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
                })
              } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info').then(function() {
                  location.reload();
                });
              }
            })
          }
        });
      </script>


</body>

</html>
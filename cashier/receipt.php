<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session
$id = $_SESSION["user_id_cashier"];

$sessionId = $id;

$valid_user = "SELECT * FROM `user` WHERE `user_id` = '" . $sessionId . "' && `role` != 'Cashier'";

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

  .dropbtn {
    background-color: #3498DB;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
  }

  .dropbtn:hover,
  .dropbtn:focus {
    background-color: #2980B9;
  }

  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown a:hover {
    background-color: #ddd;
  }

  .show {
    display: block;
  }
</style>
</head>

<body>

  <?php include "../include/user_loader.php"; ?>

  <div class="container-scroller">
    <?php include "../include/cashier_sidebar.php"; ?>

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


      <?php include "../include/cashier_header.php"; ?>


      <div class="main-panel">
        <div class="content-wrapper pb-0">

          <div class="page-header">
            <h3 class="page-title">Receipt Table</h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../admin/admin.php">Receipt</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Brinbox Care Pharmacy </li>
              </ol>
            </nav>
          </div>

          <div class="banner-header" style="width: 100%; background: #052d5a; margin: 10px;">
            <h1 style="text-align: center; font-bold: bold; color: #fff; text-transform: uppercase;" id="change_status">Exchange</h1>
          </div>
          <div class="page-header flex-wrap">


            <select id="sort" name="sort" class="btn btn-sm bg-white btn-icon-text border">
              <option value="RETURN">Return</option>
              <option value="EXCHANGE">Exchange</option>
            </select>

            <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span></h3>

            <div class="d-flex">
              <button type="button" class="btn btn-sm bg-white btn-icon-text ml-3" onclick="printUserTable()">
                <i class="mdi mdi-print btn-icon-prepend"></i>Print
              </button>

              
                <!-- Hidden iframe that loads user_print.php -->
                <iframe id="userPrintIframe" src="../getdata/receipt_data_query.php" style="display:none;"></iframe>

            </div>
          </div>

          <div class="row">
            <div class="col-lg-12 stretch-card">
              <div style="width: 100%;">
                <div class="card" style="padding: 16px;">
                  <form id="addReceipt">
                    <div style="display: flex; justify-content: space-between;">
                      <div class="m-5 mt-5">
                        <div class="row">
                          <div class="col-md-4" style="display: flex; flex-direction: column;">
                            <label for="">Receipt Number</label>
                            <input type="text" name="receipt_no" class="form-control form-control-lg">
                          </div>
                          <div class="col-md-4" style="display: flex; flex-direction: column;">
                            <label for="">Item Code</label>
                            <input type="text" name="item_code" class="form-control form-control-lg">
                          </div>
                          <div class="col-md-4" style="display: flex; flex-direction: column;">
                            <label for="">Description</label>
                            <input type="text" name="description" class="form-control form-control-lg">
                          </div>
                        </div>
                      </div>
                      <div class="m-5 mt-5">
                        <div class="row">
                          <div class="col-md-4" style="display: flex; flex-direction: column;">
                            <label for="">Quantity</label>
                            <input type="text" name="quantity" class="form-control form-control-lg">
                          </div>
                          <div class="col-md-4" style="display: flex; flex-direction: column;">
                            <label for="">Total Amount</label>
                            <input type="text" name="total_amount" class="form-control form-control-lg">
                          </div>

                          <div id="status" class="col-md-4" style="display: flex; flex-direction: column;">
                            <label for="">Total Amount</label>
                            <select id="status" name="status" class="form-control form-control-lg">
                              <option value="Select type of Return">Select type of Return</option>
                              <option value="Defective">Defective</option>
                              <option value="Near Expiration">Near Expiration</option>
                            </select>
                            <input type="hidden" id="type" name="type" value="EXCHANGE" class="form-control">

                          </div>
                        </div>
                      </div>
                    </div>
                    <div style="width: 100%; display: flex; justify-content: end;">
                      <button style="width: 150px; border: none; background: #343a40; color: #fff; padding: 8px 16px; margin-top: 16px;">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-lg-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"></h4>
                  <p class="card-description"> </p>
                  <div class="table-responsive">
                    <?php include "../cashier/receipt_data.php"; ?>
                  </div>
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
 document.getElementById("sort").addEventListener("change", function() {
    const selectedValue = this.value;
    document.getElementById("change_status").textContent = selectedValue;
    document.getElementById("type").value = selectedValue;

    // Check if the selected value is 'EXCHANGE' and hide the #status div
    if (selectedValue === 'EXCHANGE') {
        document.getElementById("status").style.display = 'none';  // Hide the #status div
    } else {
        document.getElementById("status").style.display = 'block'; // Show the #status div
    }
});

// Dropdown functionality
$(document).ready(function() {
    // Toggle dropdown visibility
    $(".dropbtn").click(function() {
        $("#myDropdown").toggleClass("show");
    });

    // Close the dropdown if the user clicks outside of it
    $(window).click(function(event) {
        if (!$(event.target).hasClass("dropbtn")) {
            $(".dropdown-content").each(function() {
                if ($(this).hasClass("show")) {
                    $(this).removeClass("show");
                }
            });
        }
    });
});


      // Add User Modal
      $(document).on('submit', '#addReceipt', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("add_receipt", true);
        {
          Swal.fire({
            title: 'Do you want to add receipt details?',
            showCancelButton: true,
            confirmButtonText: 'Add',
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
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


  .box-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
  }

  .box {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px;
    border-radius: 5px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    background-color: white;
    display: flex;
    flex-direction: row;
    /* Changes layout direction to vertical */
    align-items: stretch;
    /* Align items to stretch to the container's width */
    display: flex;
    align-items: center;
    justify-content: space-between;

    position: relative;
    flex: 1 1 300px;
    max-width: 100%;
    box-sizing: border-box;
  }

  .box input {
    background-color: #d0eaff;
    border: 1px solid #007bff;
    border-radius: 4px;
    padding: 10px;
    margin: 5px 0;
    /* Adds vertical spacing between inputs */
    text-align: center;
    color: #007bff;
    flex: 1;
    box-sizing: border-box;
  }

  .box input.quantity {
    background-color: #b3d7ff;
  }

  .remove-button {
    background-color: #ff4d4d;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 11px;
    cursor: pointer;
    margin: 10px;
    /* Adds spacing above the button */
    box-sizing: border-box;
  }

  .remove-button:hover {
    background-color: #e60000;
  }

  .input-button1 {
    background: #ff4d4d;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 11px;
    cursor: pointer;
    margin: 10px;
    width: 100px;
    text-align: center;
    /* Adds spacing above the button */
    box-sizing: border-box;
  }

  .input-button1:hover {
    background: #b3d7ff;
  }


  #submitButton {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
    margin-top: 20px;
    font-size: 16px;
  }

  #submitButton:hover {
    background-color: #0056b3;
  }

  #submitButton,
  #resetButton {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    float: right;
    cursor: pointer;
    margin-top: 20px;
    font-size: 16px;
    margin-right: 10px;
  }

  #submitButton:hover,
  #resetButton:hover {
    background-color: #0056b3;
  }

  /* Media Query for responsive design */
  @media (max-width: 1098px) {
    .box-container {
      flex-direction: column;
      align-items: center;
      max-width: 100%;
    }

    .box {
      border: 1px solid #ccc;
      padding: 30px;
      border-radius: 5px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      background-color: white;
      display: flex;
      flex-direction: column;
      /* Changes layout direction to vertical */
      align-items: stretch;
      /* Align items to stretch to the container's width */
      position: relative;
      flex: 1 1 300px;
      max-width: 100%;
      margin: 5px 0;
      box-sizing: border-box;
    }

    #submitButton,
    #resetButton {
      width: 100%;
      margin-right: 0;
    }
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
            <h3 class="page-title">Inventory Table</h3>
            <?php include "../include/user_breadcrumb.php"; ?>
            <div class="page-header flex-wrap">
              <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span>
              </h3>
              <div class="d-flex">
                <a href="../admin/inventory.php">
                  <button type="button" class="btn btn-sm bg-white btn-icon-text border">
                    <i class="mdi mdi-refresh btn-icon-prepend"></i>Refresh
                  </button>
                </a>
                <a href="../user_process/inventory_export.php">
                  <button type="button" class="btn btn-sm bg-white btn-icon-text border ml-3">
                    <i class="mdi mdi-export btn-icon-prepend"></i>Export
                  </button>
                </a>
              </div>
            </div>

            <div class="row">
              <div class="col-lg-12 stretch-card">
                <div class="card" style="padding:25px;">
                  <div class="card-body" style="padding:25px; background-color: #fff;  border: 2px dashed #007bff;">
                    <h4 class="card-title" style="font-size:28px; text-align: center;  margin-top: 20px; letter-spacing: 12px;">Scan Product</h4>

                    <form id="addInventory" method="post">
                      <div class="box">
                        <input type="text" placeholder="Item Code" readonly>
                        <input type="text" placeholder="Selling Price" readonly>
                        <input type="text" placeholder="Quantity" readonly>
                        <input type="text" placeholder="Expiration Date" readonly>
                        <div class="input-button1">Remove</div>
                      </div>
                      <div id="itemBoxContainer" class="box-container">

                      </div>
                      <button type="submit" id="submitButton">Submit</button>
                      <button type="button" id="resetButton">Reset</button>
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
                      <?php include "../admin/inventory_data.php"; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>


          <?php include "../include/user_footer.php"; ?>
        </div>


        <!-- Update Modal -->
        <div class="modal fade" id="updateUserInventory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header text-light" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
                <h5 class="modal-title text-uppercase font-weight-bold ml-3" id="exampleModalLabel" style="color: #fff;">Update Inventory</h5>
                <button type="button" class="close mr-1" style="padding-top: 22px;" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="updInventory">
                <div class="modal-body ml-5 mr-5 mt-4">
                  <input type="hidden" name="pr_id" id="pr_id">
                  <input type="hidden" name="remarks" id="remarks">

                  <input type="hidden" name="user_id" value="<?= $sessionId ?>">
                  <div class="mb-5">
                    <label for="content">Product Information</label>

                    <div class="row">
                      <div class="col-md-4">
                        <input type="text" name="item_code" id="item_code" placeholder="Item Code" class="form-control  form-control-lg" readonly />
                      </div>
                    </div>
                  </div>



                  <div class="mb-4">
                    <label for="content">Stock Information</label>
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

      <?php include '../include/user_bottom.php'; ?>
      <?php include '../user_process/user_process.php'; ?>

      <script>
        let barcode = '';

        document.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {

            if (barcode.length > 0) {
              fetchItemData(barcode);
              barcode = ''; // Clear the barcode after processing
            }
          } else {
            barcode += e.key; // Concatenate the key press to the barcode string
          }
        });

        function fetchItemData(barcode) {
          const xhr = new XMLHttpRequest();
          xhr.open('GET', '../getdata/inventory_get_data.php?item_codes=' + encodeURIComponent(barcode), true);
          xhr.onload = function() {
            if (xhr.status === 200) {
              const item = JSON.parse(xhr.responseText);
              if (item) {
                addItemToBox(item);
          console.log(addItemToBox(item));

                saveItemsToLocalStorage();
              }
            }
          };
          xhr.send();
        }

        function addItemToBox(item) {
          let existingBox = document.getElementById('item-' + item.item_code);

          if (existingBox) {
            let quantityField = existingBox.querySelector('.quantity');
            let currentQuantity = parseInt(quantityField.value) || 0;
            quantityField.value = currentQuantity + 1;
          } else {
            let box = document.createElement('div');
            box.className = 'box';
            box.id = 'item-' + item.item_code;
            box.innerHTML = `
                    <input type="hidden" name="pr_id[]" value="${item.pr_id}" placeholder="ID" readonly>
                    <input type="text" name="item_code[]" value="${item.item_code}" placeholder="Item Code" readonly>
                    <input type="text" name="sell_price[]" value="${item.sell_price}" placeholder="Selling Price" readonly>
                    <input type="text" name="quantity[]" class="quantity" value="1" placeholder="Quantity">
                    <input type="text" name="expiration_date[]" value="${item.expiration_date}" placeholder="Expiration Date" readonly>
                    <input type="hidden" name="user_id[]" value="<?php echo $sessionId ?>" placeholder="Created By" readonly>
                    <input type="hidden" name="created_by[]" value="${item.created_by}" placeholder="Created By" readonly>
                    <input type="hidden" name="date_created_at[]" value="${item.date_created_at}" placeholder="Date Created at" readonly>
                    <button class="remove-button" onclick="removeItem('${item.item_code}')">Remove</button>
                `;
            document.getElementById('itemBoxContainer').appendChild(box);
          }
        }

        function removeItem(itemCode) {
          let box = document.getElementById('item-' + itemCode);
          if (box) {
            box.remove();
            saveItemsToLocalStorage();
          }
        }

        function saveItemsToLocalStorage() {
          const boxs = document.querySelectorAll('.box');
          const items = Array.from(boxs).map(box => {
            const inputs = box.querySelectorAll('input');
            return {
              pr_id: inputs[0].value,
              item_code: inputs[1].value,
              sell_price: inputs[2].value,
              quantity: inputs[3].value,
              expiration_date: inputs[4].value,
              user_id: inputs[5].value,
              created_by: inputs[6].value,
              date_created_at: inputs[7].value
            };
          });
          localStorage.setItem('items', JSON.stringify(items));
        }

        function loadItemsFromLocalStorage() {
          const items = JSON.parse(localStorage.getItem('items')) || [];
          items.forEach(item => addItemToBox(item));
        }

        // Load items from local storage on page load
        loadItemsFromLocalStorage();

        $(document).ready(function() {
          $(document).on('submit', '#addInventory', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            Swal.fire({
              title: 'Do you want to Add Product?',
              showCancelButton: true,
              confirmButtonText: 'Add',
            }).then((result) => {

              if (result.isConfirmed) {
                $.ajax({
                  type: "POST",
                  url: "../user_process/add_inventory_process.php",
                  data: formData,
                  success: function(response) {
                    var res = JSON.parse(response);
              console.log(response);

                    if (res.status == 400) {
                      Swal.fire({
                        icon: 'warning',
                        title: 'Something Went Wrong.',
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
                        // Remove all cards after successful submission
                        document.getElementById('itemBoxContainer').innerHTML = '';
                        localStorage.removeItem('items');
                        location.reload();
                      });
                    }
                  }
                });
              } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info').then(function() {
                  location.reload();
                });
              }
            });
          });

          $('#resetButton').click(function() {
            Swal.fire({
              title: 'Are you sure you want to reset?',
              showCancelButton: true,
              confirmButtonText: 'Reset',
            }).then((result) => {
              if (result.isConfirmed) {
                // Remove all box and clear local storage
                document.getElementById('itemBoxContainer').innerHTML = '';
                localStorage.removeItem('items');
              }
            });
          });
        });
      </script>
</body>

</html>
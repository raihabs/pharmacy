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
    max-width: 2800px;
    /* Adjust the max-width as per your requirement */
    margin: 20px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    /* Adjust card width and spacing */
    gap: 10px;
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
    height: 420px;
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
    max-height: 4em;
    /* Adjust the height as per line height */
    line-height: 1.5em;
    /* Adjust the line height */
    top: 185px;
  }

  .item-code {
    font-weight: bold;
    color: #000;
    text-align: right;
    margin-top: 280px;
  }

  .description {
    margin: 19px 1px !important;
    font-size: 12px;
    line-height: 1.9;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 4.5em;
    line-height: 1.7em;
    position: absolute;
    top: 285px;
    left: 0;
    float: left;
    width: 100%;
    text-align: left;
    padding: 16px;
  }

  .price-quantity {
    position: relative;
    display: flex;
    justify-content: space-between;
    margin-top: 100px;
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




  .form-container {
    width: 100%;
    padding: 10px;
    margin: 20px 0;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    background-color: #f8f9fa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .form-title {
    text-align: center;
    margin: 50px auto;
    padding: 10px;
    font-weight: bold;
    background-color: #024ab8;
    color: #fff;
    height: 60px;
  }


  .form-container .input-row {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 15px;
    width: 100%;
  }

  .input-row input {
    flex: 1;
  }

  .btn-remove {
    color: white;
    background-color: #dc3545;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
  }

  .btn-remove:hover {
    background-color: #c82333;
  }

  .total-sum {
    display: flex;
    justify-content: right;
    align-items: center;
    margin-top: 20px;
  }

  :root {
    --color-background: #000119;
    --stroke-width: calc(1em / 16);
    --font-size: 1.4rem;
    --font-weight: 700;
    --letter-spacing: calc(1em / 8);
  }

  .total-sum {
    display: flex;
    justify-content: center;
    align-items: center;
    color: var(--color-background);
    font-size: var(--font-size);

  }

  .form-title-sum {
    margin-right: 10px;
    font-weight: bold;
    background-clip: text;


    color: #024ab8;
    font-size: var(--font-size);
    font-weight: var(--font-weight);
    letter-spacing: var(--letter-spacing);
    padding: calc(--stroke-width / 2);
    -webkit-text-stroke-color: transparent;
    -webkit-text-stroke-width: var(--stroke-width);
  }

  #totalSum {
    width: 140px;
    border: 0;
    color: var(--color-background);
    font-size: 1.2rem;
    padding: 10px;
    font-weight: bold;
    margin: 18px;
    background: transparent;
  }

  #insertButton {
    width: 20%;
    height: 45px;
    margin-bottom: 10px;
    color: white;
    border: none;
    border-radius: 5%;
    align-items: center;
  }


  .form-buttons {
    display: flex;
    justify-content: left;
    gap: 10px;
    margin-top: 20px;
  }

  /* .card-button {
    width: 100%;
    height: 50px;
    margin-top: 10px;
    color: white;
    border: none;
    border-radius: 5%;
    align-items: center;
  } */

  .card-proceed {
    width: 50%;
    height: 50px;
    margin: 30px 25%;
    color: white;
    border: none;
    border-radius: 5%;
    align-items: left;
  }

  .card-button {
    left: 0;
    top: -16px;
    width: 100%;
    height: 420px;
    margin-top: 10px;
    color: white;
    position: absolute;
    float: top;
    align-items: center;
    border-radius: 1% 1% 38% 1%;
    background: linear-gradient(to bottom, rgba(230, 229, 242, 0.4) 30%, rgba(69, 153, 205, 0.3));


  }

  <?php
  $product_list_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.sell_price, p.manufacturing_date, p.image,
COALESCE(i.in_id, 0) AS in_id, COALESCE(i.quantity, 0) AS quantity,
COALESCE(i.expiration_date, '0000-00-00') AS expiration_date, 
CASE
    WHEN COALESCE(i.quantity, 0) = 0 THEN 'NEW'
    WHEN COALESCE(i.quantity, 0) >= 30 THEN 'LESS QUANTITY'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date < DATE_SUB(i.expiration_date, INTERVAL 30 DAY) THEN 'EXPIRE SOON'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date > CURDATE() THEN 'EXPIRED'
    ELSE 'ACTIVE'
END AS remarks
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.quantity > 30 AND i.remarks = 'ACTIVE' ORDER BY p.pr_id ASC";
  $product_list_result = mysqli_query($conn, $product_list_query);

  if (mysqli_num_rows($product_list_result) > 0) {
    while ($product = mysqli_fetch_array($product_list_result)) {
  ?><?php echo "#colorButton" . $product['pr_id'] . ".blue{" ?><?php echo "border: solid 5px #4599cd; }" ?><?php
                                                                                                          }
                                                                                                        }
                                                                                                            ?>
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

      <?php include "../include/home_main_panel.php"; ?>


    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?php include '../include/user_bottom.php'; ?>

  <?php include '../user_process/product_process.php'; ?>













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

    function fetchItemData(b) {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', '../getdata/inventory_get_data.php?barcode=' + encodeURIComponent(barcode), true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          const barcode = JSON.parse(xhr.responseText);
          if (cardNumber) {
            createRow(cardNumber);
            saveItemsToLocalStorage();
          }
        }
      };
      xhr.send();
    }

    
    let totalSum = 0;

    function updateFields(cardNumber) {
      const price = parseFloat(document.getElementById(`price_${cardNumber}`).value);
      const quantity = parseInt(document.getElementById(`quantity_${cardNumber}`).value);
      const total = price * quantity;

      const inputs = document.querySelectorAll(`.row .col-lg-12 #container .input-row[data-card="${cardNumber}"] input[name="price[]"]`);
      inputs.forEach(input => {
        input.value = price;
      });

      const quantityInputs = document.querySelectorAll(`.row .col-lg-12 #container .input-row[data-card="${cardNumber}"] input[name="quantity[]"]`);
      quantityInputs.forEach(input => {
        input.value = quantity;
      });

      const totalInputs = document.querySelectorAll(`.row .col-lg-12 #container .input-row[data-card="${cardNumber}"] input[name="total[]"]`);
      totalInputs.forEach(input => {
        input.value = total.toFixed(2);
      });

      updateTotalSum();
    }

    function createRow(cardNumber) {
      const container = document.getElementById('container');
      const existingRow = container.querySelector(`.input-row[data-card="${cardNumber}"]`);

      if (existingRow) {
        // Row already exists for this card, update existing row instead of creating new one
        const price = parseFloat(document.getElementById(`price_${cardNumber}`).value);
        const quantity = parseInt(document.getElementById(`quantity_${cardNumber}`).value);
        const total = price * quantity;

        const priceInputs = existingRow.querySelectorAll('input[name="price[]"]');
        priceInputs.forEach(input => {
          input.value = price;
        });

        const quantityInputs = existingRow.querySelectorAll('input[name="quantity[]"]');
        quantityInputs.forEach(input => {
          input.value = quantity;
        });

        const totalInput = existingRow.querySelector('input[name="total[]"]');
        totalInput.value = total.toFixed(2);

        updateTotalSum();
      } else {
        // Create new row
        const pr_id = document.getElementById(`pr_id_${cardNumber}`).value;
        const item_code = document.getElementById(`item_code_${cardNumber}`).value;
        const price = parseFloat(document.getElementById(`price_${cardNumber}`).value);
        const quantity = parseInt(document.getElementById(`quantity_${cardNumber}`).value);
        const total = price * quantity;

        const row = document.createElement('div');
        row.classList.add('input-row');
        row.setAttribute('data-card', cardNumber);

        const inputs = [{
            name: 'pr_id[]',
            value: pr_id,
            type: 'hidden'
          },
          {
            name: 'item_code[]',
            value: item_code
          },
          {
            name: 'price[]',
            value: price
          },
          {
            name: 'quantity[]',
            value: quantity
          },
          {
            name: 'total[]',
            value: total.toFixed(2)
          }
        ];

        inputs.forEach(inputData => {
          const input = document.createElement('input');
          input.type = inputData.type || 'text';
          input.name = inputData.name;
          input.value = inputData.value;
          input.setAttribute('readonly', true);
          input.classList.add('form-control');
          row.appendChild(input);
        });


        <?php
        $select_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.sell_price, p.manufacturing_date, p.image,
COALESCE(i.in_id, 0) AS in_id, COALESCE(i.quantity, 0) AS quantity,
COALESCE(i.expiration_date, '0000-00-00') AS expiration_date, 
CASE
    WHEN COALESCE(i.quantity, 0) = 0 THEN 'NEW'
    WHEN COALESCE(i.quantity, 0) >= 30 THEN 'LESS QUANTITY'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date < DATE_SUB(i.expiration_date, INTERVAL 30 DAY) THEN 'EXPIRE SOON'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date > CURDATE() THEN 'EXPIRED'
    ELSE 'ACTIVE'
END AS remarks
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.quantity > 30 AND i.remarks = 'ACTIVE' ORDER BY p.pr_id DESC LIMIT 1";
        $select_result = mysqli_query($conn, $select_query);
        $select = mysqli_fetch_array($select_result); ?>
        const removeButton = document.createElement('button');
        removeButton.textContent = 'Remove';
        removeButton.type = 'button';
        removeButton.classList.add('btn', 'btn-remove');
        // removeButton.id = 'remove_" . $selectToRemove['pr_id'] . "';
        removeButton.addEventListener('click', function() {
          container.removeChild(row);
          updateTotalSum();

          const button<?php echo $select['pr_id'] ?> = document.getElementById('colorButton<?php echo $select['pr_id'] ?>');

          <?php
          $product_list_query1 = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.sell_price, p.manufacturing_date, p.image,
COALESCE(i.in_id, 0) AS in_id, COALESCE(i.quantity, 0) AS quantity,
COALESCE(i.expiration_date, '0000-00-00') AS expiration_date, 
CASE
    WHEN COALESCE(i.quantity, 0) = 0 THEN 'NEW'
    WHEN COALESCE(i.quantity, 0) >= 30 THEN 'LESS QUANTITY'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date < DATE_SUB(i.expiration_date, INTERVAL 30 DAY) THEN 'EXPIRE SOON'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date > CURDATE() THEN 'EXPIRED'
    ELSE 'ACTIVE'
END AS remarks
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE p.pr_id != " . $select['pr_id'] . " AND i.quantity > 30 AND i.remarks = 'ACTIVE' ORDER BY p.pr_id DESC";
          $product_list_result1 = mysqli_query($conn, $product_list_query1);

          if (mysqli_num_rows($product_list_result1) > 0) {
            while ($selectToRemove = mysqli_fetch_array($product_list_result1)) {
          ?>
              <?php echo "
          const button" . $selectToRemove['pr_id'] . " = document.getElementById('colorButton" . $selectToRemove['pr_id'] . "');
          
          " ?>
          <?php
            }
          }
          ?>


          if (button<?php echo $select['pr_id'] ?>.classList.contains('blue')) {
            button<?php echo $select['pr_id'] ?>.classList.remove('blue');
          }
          <?php
          $product_list_query2 = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.sell_price, p.manufacturing_date, p.image,
COALESCE(i.in_id, 0) AS in_id, COALESCE(i.quantity, 0) AS quantity,
COALESCE(i.expiration_date, '0000-00-00') AS expiration_date, 
CASE
    WHEN COALESCE(i.quantity, 0) = 0 THEN 'NEW'
    WHEN COALESCE(i.quantity, 0) >= 30 THEN 'LESS QUANTITY'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date < DATE_SUB(i.expiration_date, INTERVAL 30 DAY) THEN 'EXPIRE SOON'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date > CURDATE() THEN 'EXPIRED'
    ELSE 'ACTIVE'
END AS remarks
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE p.pr_id != " . $select['pr_id'] . " AND i.quantity > 30 AND i.remarks = 'ACTIVE' ORDER BY p.pr_id DESC";
          $product_list_result2 = mysqli_query($conn, $product_list_query2);

          if (mysqli_num_rows($product_list_result2) > 0) {
            while ($selectToRemoveifelse = mysqli_fetch_array($product_list_result2)) {
          ?>
              <?php echo "else if(button" . $selectToRemoveifelse['pr_id'] . ".classList.contains('blue')) {
            button" . $selectToRemoveifelse['pr_id'] . ".classList.remove('blue');
          }" ?>
          <?php
            }
          }
          ?>

        });

        row.appendChild(removeButton);

        container.appendChild(row);

        updateTotalSum();

      }
    }

    function updateTotalSum() {
      const rows = document.querySelectorAll('.row .col-lg-12 #container .input-row');
      let sum = 0;
      rows.forEach(row => {
        const totalInput = row.querySelector('input[name="total[]"]');
        if (totalInput) {
          sum += parseFloat(totalInput.value);
        }
      });
      totalSum = sum;
      document.getElementById('totalSum').value = totalSum.toFixed(2);
    }

    function resetForm() {
      document.getElementById('addSale').reset();
      document.getElementById('container').innerHTML = '';
      document.getElementById('totalSum').value = '0.00';
      totalSum = 0;





      <?php
      $product_list_query3 = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.sell_price, p.manufacturing_date, p.image,
COALESCE(i.in_id, 0) AS in_id, COALESCE(i.quantity, 0) AS quantity,
COALESCE(i.expiration_date, '0000-00-00') AS expiration_date, 
CASE
    WHEN COALESCE(i.quantity, 0) = 0 THEN 'NEW'
    WHEN COALESCE(i.quantity, 0) >= 30 THEN 'LESS QUANTITY'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date < DATE_SUB(i.expiration_date, INTERVAL 30 DAY) THEN 'EXPIRE SOON'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date > CURDATE() THEN 'EXPIRED'
    ELSE 'ACTIVE'
END AS remarks
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.quantity > 30 AND i.remarks = 'ACTIVE' ORDER BY p.pr_id DESC";
      $product_list_result3 = mysqli_query($conn, $product_list_query3);

      if (mysqli_num_rows($product_list_result3) > 0) {
        while ($selectToReset = mysqli_fetch_array($product_list_result3)) {
      ?>
          <?php echo "
          const button" . $selectToReset['pr_id'] . " = document.getElementById('colorButton" . $selectToReset['pr_id'] . "');
          
          " ?>
        <?php
        }
      }

      $product_list_query4 = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.sell_price, p.manufacturing_date, p.image,
COALESCE(i.in_id, 0) AS in_id, COALESCE(i.quantity, 0) AS quantity,
COALESCE(i.expiration_date, '0000-00-00') AS expiration_date, 
CASE
    WHEN COALESCE(i.quantity, 0) = 0 THEN 'NEW'
    WHEN COALESCE(i.quantity, 0) >= 30 THEN 'LESS QUANTITY'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date < DATE_SUB(i.expiration_date, INTERVAL 30 DAY) THEN 'EXPIRE SOON'
    WHEN i.expiration_date IS NOT NULL AND i.expiration_date > CURDATE() THEN 'EXPIRED'
    ELSE 'ACTIVE'
END AS remarks
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.quantity > 30 AND i.remarks = 'ACTIVE' ORDER BY p.pr_id DESC";
      $product_list_result4 = mysqli_query($conn, $product_list_query4);

      if (mysqli_num_rows($product_list_result4) > 0) {
        while ($selectToResetifelse = mysqli_fetch_array($product_list_result4)) {
        ?>
          <?php echo "
            if(button" . $selectToResetifelse['pr_id'] . ".classList.contains('blue')) {
            button" . $selectToResetifelse['pr_id'] . ".classList.remove('blue');
            }" ?>
      <?php
        }
      }
      ?>


    }
  </script>


  <script>
    // Add User Modal
    $(document).on('submit', '#addSale', function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      formData.append("add_sale", true);
      {
        Swal.fire({
          title: 'Do you want to add product details?',
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'Add',
          denyButtonText: `Don't Add`,
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
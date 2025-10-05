<?php
include '../config/connect.php';

// error_reporting(0);
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

<title>Home</title>
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
    justify-content: center;
    margin: 15px 35px;
    width: 95%;
  }

  .input-row input {
    flex: 1;
    width: 14px;
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


  #resetButton {
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
    margin: 50px 25%;
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

  /* Hidden input */
  #item-code-input {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  <?php
  $product_list_query = "SELECT  p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at DESC, i.date_updated_at DESC";
  $product_list_result = mysqli_query($conn, $product_list_query);

  if (mysqli_num_rows($product_list_result) > 0) {
    while ($product = mysqli_fetch_array($product_list_result)) {
  ?><?php echo "#form" . $product['pr_id'] . ".blue{" ?><?php echo "border: solid 5px #024ab8; }" ?><?php
                                                                                                  }
                                                                                                }
                                                                                                    ?>
</style>
</head>

<body>
  <div id="global-loader" style="display: none;">
    <div class="whirly-loader"> </div>
  </div>

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

  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('container');
      const totalSpan = document.getElementById('total');
      const totalDiscount = document.getElementById('total_discount');

      const fullNameInput = document.getElementById('full_name');
      const idNoInput = document.getElementById('id_no');
      const addressInput = document.getElementById('address');
      const discountType = document.getElementById('discount');

      const resetButton = document.getElementById('resetButton');
      const itemCodeInput = document.getElementById('item-code-input');
      let total = 0;

      // Focus the hidden input when the page loads
      itemCodeInput.focus();

      // Function to check if the essential fields are filled
      function areFieldsFilled() {
        return fullNameInput.value && idNoInput.value && addressInput.value && discountType.value !== 'Choose Type of discount';
      }

      // Function to update the total
      function updateTotal() {
        total = Array.from(container.getElementsByClassName('box')).reduce((sum, box) => {
          const quantityInput = box.querySelector('.form-control.quantity-input');
          const sellPrice = parseFloat(quantityInput.dataset.sellprice);
          const quantity = parseInt(quantityInput.value);
          const rowTotal = quantity * sellPrice;
          return sum + rowTotal;
        }, 0);

        totalSpan.textContent = total.toFixed(2);
      }

      // Function to update the discount total
      function updateDiscount() {
        let discountTotal = 0;

        // Only apply discount if fields are filled and a valid discount type is selected
        if (areFieldsFilled()) {
          // Apply 7% discount if all fields are filled and valid
          discountTotal = Array.from(container.getElementsByClassName('box')).reduce((sum, box) => {
            const quantityInput = box.querySelector('.form-control.quantity-input');
            const sellPrice = parseFloat(quantityInput.dataset.sellprice);
            const quantity = parseInt(quantityInput.value);
            const rowTotal = (quantity * sellPrice) * 0.80; // Apply the 7% discount
            return sum + rowTotal;
          }, 0);
        }

        // Update the total discount text
        totalDiscount.textContent = discountTotal.toFixed(2);
      }

      // Event listeners for real-time input changes
      fullNameInput.addEventListener('input', () => {
        updateDiscount(); // Trigger the discount update on input change
        updateTotal(); // Update the total as well
      });

      idNoInput.addEventListener('input', () => {
        updateDiscount(); // Trigger the discount update on input change
        updateTotal(); // Update the total as well
      });

      addressInput.addEventListener('input', () => {
        updateDiscount(); // Trigger the discount update on input change
        updateTotal(); // Update the total as well
      });

      discountType.addEventListener('change', () => {
        updateDiscount(); // Trigger the discount update when discount is selected
        updateTotal(); // Update the total as well
      });

      // Reset button functionality
      resetButton.addEventListener('click', () => {
        // Reset input fields and totals
        fullNameInput.value = '';
        idNoInput.value = '';
        addressInput.value = '';
        discountType.value = 'Choose Type of discount';

        // Reset the totals
        updateTotal();
        updateDiscount();
      });

      // Example: Trigger updateTotal and updateDiscount on input changes in the box (quantity, sellPrice)
      container.addEventListener('input', () => {
        updateTotal();
        updateDiscount();
      });

      // Function to handle barcode scanning
      itemCodeInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
          const item_code = itemCodeInput.value;
          handleBarcodeScan(item_code);
          itemCodeInput.value = ''; // Clear the input after scanning
        }
      });

      // Function to handle barcode scanning or product card clicking
      function handleBarcodeScan(item_code) {
        const productElement = document.querySelector(`.form[data-itemcode='${item_code}']`);
        if (productElement) {
          const pr_id = productElement.getAttribute('data-prid');
          const sell_price = parseFloat(productElement.getAttribute('data-sellprice'));
          const existingRow = container.querySelector(`.row[data-prid='${pr_id}']`);

          if (existingRow) {
            const quantityInput = existingRow.querySelector('.form-control.quantity-input');
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updateRowTotal(existingRow);

            const targetInput = document.getElementById(`iquantity${pr_id}`);
            targetInput.value = quantityInput.value;


            <?php
            $quantity_list_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.pi_quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at DESC, i.date_updated_at DESC";
            $quantity_list_result = mysqli_query($conn, $quantity_list_query);

            if (mysqli_num_rows($quantity_list_result) > 0) {
              while ($first_quantity = mysqli_fetch_array($quantity_list_result)) {

            ?>

                const iquantity<?php echo $first_quantity['pr_id'] ?> = parseInt(document.getElementById('iquantity<?php echo $first_quantity['pr_id'] ?>').value) || 0;
                const prquantity<?php echo $first_quantity['pr_id'] ?> = parseInt(document.getElementById('prquantity<?php echo $first_quantity['pr_id'] ?>').value) || 0;
                const newquantity<?php echo $first_quantity['pr_id'] ?> = prquantity<?php echo $first_quantity['pr_id'] ?> - iquantity<?php echo $first_quantity['pr_id'] ?>;
                document.getElementById('newquantity<?php echo $first_quantity['pr_id'] ?>').value = newquantity<?php echo $first_quantity['pr_id'] ?>;


            <?php
              }
            }

            ?>

            <?php
            $newquantity_list_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.pi_quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at DESC, i.date_updated_at DESC";
            $newquantity_list_result = mysqli_query($conn, $newquantity_list_query);

            if (mysqli_num_rows($newquantity_list_result) > 0) {
              while ($first_newquantity = mysqli_fetch_array($newquantity_list_result)) {
            ?>

                const newQuantityElement<?php echo $first_newquantity['pr_id']; ?> = document.getElementById(`newquantity<?php echo $first_newquantity['pr_id']; ?>`);
                const inQuantityElement<?php echo $first_newquantity['pr_id']; ?> = document.getElementById(`inquantity<?php echo $first_newquantity['pr_id']; ?>`);

                const changeValueButton<?php echo $first_newquantity['pr_id']; ?> = document.getElementById('changeValueButton<?php echo $first_newquantity['pr_id']; ?>');
                changeValueButton<?php echo $first_newquantity['pr_id']; ?>.addEventListener('click', () => {
                  // Change the value of newQuantityElement to 19
                  if (newQuantityElement<?php echo $first_newquantity['pr_id']; ?>.value <= 0) {
                    inQuantityElement<?php echo $first_newquantity['pr_id']; ?>.style.borderColor = 'red'; // Handle non-numeric input
                  } else {
                    inQuantityElement<?php echo $first_newquantity['pr_id']; ?>.style.borderColor = 'blue'; // Handle non-numeric input
                  }

                  // console.log(`New quantity set to: ${newQuantityElement<?php echo $first_newquantity['pr_id']; ?>.value}`); // Log the new value
                });

            <?php
              }
            }
            ?>

          } else {
            updateTotal();
            updateDiscount();

            const box = document.createElement('div');

            const targetInput = document.getElementById(`iquantity${pr_id}`);
            targetInput.value = 1;


            <?php
            $quantity_list_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.pi_quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at DESC, i.date_updated_at DESC";
            $quantity_list_result = mysqli_query($conn, $quantity_list_query);

            if (mysqli_num_rows($quantity_list_result) > 0) {
              while ($first_quantity = mysqli_fetch_array($quantity_list_result)) {

            ?>

                const iquantity<?php echo $first_quantity['pr_id'] ?> = parseInt(document.getElementById('iquantity<?php echo $first_quantity['pr_id'] ?>').value) || 0;
                const prquantity<?php echo $first_quantity['pr_id'] ?> = parseInt(document.getElementById('prquantity<?php echo $first_quantity['pr_id'] ?>').value) || 0;
                const newquantity<?php echo $first_quantity['pr_id'] ?> = prquantity<?php echo $first_quantity['pr_id'] ?> - iquantity<?php echo $first_quantity['pr_id'] ?>;
                document.getElementById('newquantity<?php echo $first_quantity['pr_id'] ?>').value = newquantity<?php echo $first_quantity['pr_id'] ?>;


            <?php
              }
            }

            ?>



            <?php
            $newquantity_list_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.pi_quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at DESC, i.date_updated_at DESC";
            $newquantity_list_result = mysqli_query($conn, $newquantity_list_query);

            if (mysqli_num_rows($newquantity_list_result) > 0) {
              while ($first_newquantity = mysqli_fetch_array($newquantity_list_result)) {
            ?>
                const iQuantityElement<?php echo $first_newquantity['pr_id']; ?> = document.getElementById(`iquantity<?php echo $first_newquantity['pr_id']; ?>`);
                const prQuantityElement<?php echo $first_newquantity['pr_id']; ?> = document.getElementById(`prquantity<?php echo $first_newquantity['pr_id']; ?>`);


                const newQuantityElement<?php echo $first_newquantity['pr_id']; ?> = document.getElementById(`newquantity<?php echo $first_newquantity['pr_id']; ?>`);
                const inQuantityElement<?php echo $first_newquantity['pr_id']; ?> = document.getElementById(`inquantity<?php echo $first_newquantity['pr_id']; ?>`);

                const changeValueButton<?php echo $first_newquantity['pr_id']; ?> = document.getElementById('changeValueButton<?php echo $first_newquantity['pr_id']; ?>');
                changeValueButton<?php echo $first_newquantity['pr_id']; ?>.addEventListener('click', () => {
                  // Change the value of newQuantityElement to 19
                  if (iQuantityElement<?php echo $first_newquantity['pr_id']; ?>.value > prQuantityElement<?php echo $first_newquantity['pr_id']; ?>.value || newQuantityElement<?php echo $first_newquantity['pr_id']; ?>.value <= 0) {
                    inQuantityElement<?php echo $first_newquantity['pr_id']; ?>.style.borderColor = 'red'; // Handle non-numeric input
                  } else {
                    inQuantityElement<?php echo $first_newquantity['pr_id']; ?>.style.borderColor = 'blue'; // Handle non-numeric input
                  }

                  console.log(`New quantity set to: ${first_newquantity<?php echo $first_newquantity['pr_id']; ?>.value}`); // Log the new value
                });

            <?php
              }
            }
            ?>
            box.className = 'input-row box row';
            box.dataset.prid = pr_id;
            box.style.borderColor = 'blue';

            document.querySelectorAll('.row').forEach(form => form.style.borderColor = 'blue');

            // Create and append the elements one by one
            const hiddenPrId = document.createElement('input');
            hiddenPrId.type = 'hidden';
            hiddenPrId.className = 'form-control';
            hiddenPrId.name = 'pr_id[]';
            hiddenPrId.value = `${pr_id}`;
            hiddenPrId.readOnly = true;
            box.appendChild(hiddenPrId);

            const itemCodeInput = document.createElement('input');
            itemCodeInput.type = 'text';
            itemCodeInput.className = 'form-control';
            itemCodeInput.name = 'item_code[]';
            itemCodeInput.value = `${item_code}`;
            itemCodeInput.readOnly = true;
            box.appendChild(itemCodeInput);

            const sellPriceInput = document.createElement('input');
            sellPriceInput.type = 'text';
            sellPriceInput.className = 'form-control';
            sellPriceInput.name = 'sell_price[]';
            sellPriceInput.value = `${sell_price}`;
            sellPriceInput.readOnly = true;
            box.appendChild(sellPriceInput);

            const quantityInput = document.createElement('input');
            quantityInput.type = 'text';
            quantityInput.id = `inquantity${pr_id}`;
            quantityInput.className = 'form-control quantity-input';
            quantityInput.name = 'quantity[]';
            quantityInput.value = 1;
            quantityInput.dataset.sellprice = `${sell_price}`;
            quantityInput.style.borderColor = 'blue';


            // Append enterstockInput to the desired container
            document.body.appendChild(quantityInput); // Change this to your specific contain

            // Add change event to sync the input
            quantityInput.addEventListener('input', () => {
              syncInput(pr_id);
            });
            box.appendChild(quantityInput);


            const enterstockInput = document.createElement('input');

            const newquantityInput = document.getElementById(`newquantity${pr_id}`);
            enterstockInput.type = 'hidden';
            enterstockInput.id = `enterstock${pr_id}`;
            enterstockInput.className = 'form-control quantity-input';
            enterstockInput.name = 'enterstock[]';

            enterstockInput.value = newquantityInput.value;

            // Append enterstockInput to the desired container
            document.body.appendChild(enterstockInput); // Change this to your specific contain

            // Check if enterstockInput value is negative
            if (parseFloat(enterstockInput.value) <= 0) {
              // Set the border of quantityInput to red if the value is negative
              quantityInput.style.borderColor = 'red';
            } else {
              // Reset the border color if the value is not negative
              quantityInput.style.borderColor = 'blue';
            }
            // Add change event to sync the input
            enterstockInput.addEventListener('input', () => {
              syncInput(pr_id);

            });

            box.appendChild(enterstockInput);

            const totalInput = document.createElement('input');
            totalInput.type = 'text';
            totalInput.className = 'form-control row-total';
            totalInput.name = 'total[]';
            totalInput.value = `${sell_price.toFixed(2)}`;
            totalInput.readOnly = true;
            box.appendChild(totalInput);

            const hiddenUserId = document.createElement('input');
            hiddenUserId.type = 'hidden';
            hiddenUserId.className = 'form-control';
            hiddenUserId.name = 'user_id[]';
            hiddenUserId.value = "<?php echo $sessionId; ?>"; // Ensure this value is set properly
            hiddenUserId.readOnly = true;
            box.appendChild(hiddenUserId);
            box.appendChild(enterstockInput);
            
// Create the input fields once
let fullnameInput = document.createElement('input');
fullnameInput.type = 'hidden';
fullnameInput.className = 'form-control row-total';
fullnameInput.name = 'full_name[]';
fullnameInput.readOnly = true;
box.appendChild(fullnameInput);

let idNoInput = document.createElement('input');
idNoInput.type = 'hidden';
idNoInput.className = 'form-control';
idNoInput.name = 'id_no[]';
idNoInput.readOnly = true;
box.appendChild(idNoInput);

let addressInput = document.createElement('input');
addressInput.type = 'hidden';
addressInput.className = 'form-control row-total';
addressInput.name = 'address[]';
addressInput.readOnly = true;
box.appendChild(addressInput);

let discountInput = document.createElement('input');
discountInput.type = 'hidden';
discountInput.className = 'form-control row-total';
discountInput.name = 'discount[]';
discountInput.readOnly = true;
box.appendChild(discountInput);

// Event listener for full_name input field
document.getElementById('full_name').addEventListener('input', function() {
    const yfull_name = document.getElementById('full_name').value;

    // Update the value of the fullname input
    fullnameInput.value = yfull_name;
});

// Event listener for id_no input field
document.getElementById('id_no').addEventListener('input', function() {
    const yid_no = document.getElementById('id_no').value;

    // Update the value of the idNo input
    idNoInput.value = yid_no;
});

// Event listener for address input field
document.getElementById('address').addEventListener('input', function() {
    const yaddress = document.getElementById('address').value;

    // Update the value of the address input
    addressInput.value = yaddress;
});

// Event listener for discount select field
document.getElementById('discount').addEventListener('input', function() {
    const ydiscount = document.getElementById('discount').value;

    // Update the value of the discount input
    discountInput.value = ydiscount;
});


            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-remove remove-btn';
            removeButton.textContent = 'Remove';
            removeButton.id = `removeButton${pr_id}`;
            document.body.appendChild(removeButton); // Change this to your specific contain

            // Add event listener to the remove button
            removeButton.addEventListener('click', () => {
              box.remove();

              newquantityInput.value = 0;
              updateTotal(); // Update the total after removal
              updateDiscount();
            });

            box.appendChild(removeButton);


            // Finally, append the box to the desired parent container
            container.appendChild(box);

            // The syncInput function
            function syncInput(pr_id) {
              const inquantityValue = document.getElementById(`inquantity38`).value;

              const targetInput = document.getElementById(`iquantity38`);
              targetInput.value = 1;

              if (targetInput) {
                targetInput.value = inquantityValue;
              }
            }

            box.querySelector('.remove-btn').addEventListener('click', () => {
              box.remove();
              updateTotal();
              updateDiscount();


              <?php
              $select_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at ASC, i.date_updated_at ASC LIMIT 1";
              $select_result = mysqli_query($conn, $select_query);
              $select = mysqli_fetch_array($select_result); ?>


              const button<?php echo $select['pr_id'] ?> = document.getElementById('form<?php echo $select['pr_id'] ?>');


              <?php
              $product_list_query1 = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.in_id != '" . $select['in_id'] . "' AND i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at ASC, i.date_updated_at ASC";
              $product_list_result1 = mysqli_query($conn, $product_list_query1);

              if (mysqli_num_rows($product_list_result1) > 0) {
                while ($selectToRemove = mysqli_fetch_array($product_list_result1)) {
              ?>
                  <?php echo "
          const button" . $selectToRemove['pr_id'] . " = document.getElementById('form" . $selectToRemove['pr_id'] . "');
          
          " ?>
              <?php
                }
              }
              ?>


              if (button<?php echo $select['pr_id'] ?>.classList.contains('blue')) {
                button<?php echo $select['pr_id'] ?>.classList.remove('blue');
              }
              <?php
              $product_list_query2 = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at ASC, i.date_updated_at ASC";
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





            updateTotal();
            updateDiscount();

            <?php
            $removeButton_list_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at DESC, i.date_updated_at DESC";
            $removeButton_list_result = mysqli_query($conn, $removeButton_list_query);

            if (mysqli_num_rows($removeButton_list_result) > 0) {
              while ($first_removeButton = mysqli_fetch_array($removeButton_list_result)) {
            ?>
                const proquantity<?php echo $first_removeButton['pr_id']; ?> = document.getElementById(`prquantity<?php echo $first_removeButton['pr_id']; ?>`);

                const removeButton<?php echo $first_removeButton['pr_id']; ?> = document.getElementById('removeButton<?php echo $first_removeButton['pr_id']; ?>');

                removeButton<?php echo $first_removeButton['pr_id']; ?>.addEventListener('click', () => {
                  const proQuantity<?php echo $first_removeButton['pr_id'] ?> = proquantity<?php echo $first_removeButton['pr_id'] ?>.value;
                  document.getElementById('newquantity<?php echo $first_removeButton['pr_id'] ?>').value = proQuantity<?php echo $first_removeButton['pr_id'] ?>;
                });

            <?php
              }
            }
            ?>

            container.appendChild(box);
          }

        }
      }

      // Function to update the total for a specific row
      function updateRowTotal(box) {
        const quantityInput = box.querySelector('.form-control.quantity-input');
        const sellPrice = parseFloat(quantityInput.dataset.sellprice);
        const quantity = parseInt(quantityInput.value);
        const rowTotal = quantity * sellPrice;
        box.querySelector('.row-total').textContent = `${rowTotal.toFixed(2)}`;
        updateTotal();
        updateDiscount();
      }

      // Event listener for product card clicks
      document.querySelectorAll('.form').forEach(form => {
        form.addEventListener('click', () => {
          const item_code = form.getAttribute('data-itemcode');
          handleBarcodeScan(item_code); // Simulate barcode scan on click
        });
      });

      // Event listener for reset button
      resetButton.addEventListener('click', () => {
        container.innerHTML = '';
        totalSpan.textContent = '0.00';


        <?php
        $product_list_query3 = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at ASC, i.date_updated_at ASC";
        $product_list_result3 = mysqli_query($conn, $product_list_query3);

        if (mysqli_num_rows($product_list_result3) > 0) {
          while ($selectToReset = mysqli_fetch_array($product_list_result3)) {
        ?>
            <?php echo "
          const button" . $selectToReset['pr_id'] . " = document.getElementById('form" . $selectToReset['pr_id'] . "');
          
          " ?>
          <?php
          }
        }

        $product_list_query4 = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.remarks = 'ACTIVE' OR i.remarks != 'ACTIVE' ORDER BY i.date_created_at ASC, i.date_updated_at ASC";
        $product_list_result4 = mysqli_query($conn, $product_list_query4);

        if (mysqli_num_rows($product_list_result4) > 0) {
          while ($selectToResetifelse = mysqli_fetch_array($product_list_result4)) {
          ?>

            if (button<?php echo $selectToResetifelse['pr_id'] ?>.classList.contains('blue')) {
              button<?php echo $selectToResetifelse['pr_id'] ?>.classList.remove('blue');
            }
        <?php
          }
        }
        ?>

      });
    });
  </script>







  <script>
    $(document).ready(function() {
      // Check if the page is being refreshed
      if (performance.navigation.type === performance.navigation.TYPE_RELOAD) {
        // Show the progress div when the page is refreshed
        $('#global-loader').show();
      } else {
        // Hide global-loader if it's a new page load (not a refresh)
        $('#global-loader').hide();
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {

      // Function to check if a field is empty
      function validateField(input) {
        if (input.val().trim() === "") {
          input.css('border', '2px solid red'); // Apply red border
          return false;
        } else {
          input.css('border', ''); // Remove red border
          return true;
        }
      }

      // Function to validate the select input
      function validateSelect(select) {
        if (select.val() === 'Choose Type of discount') {
          select.css('border', '2px solid red'); // Apply red border
          return false;
        } else {
          select.css('border', ''); // Remove red border
          return true;
        }
      }

      // Form submit event listener
      $(document).on('submit', '#addSale', function(e) {
        e.preventDefault();

        var formIsValid = true;

        // Validate required fields (inputs and select)
        var fullNameValid = validateField($('#full_name'));
        var idNoValid = validateField($('#id_no'));
        var addressValid = validateField($('#address'));
        var discountValid = validateSelect($('#discount'));

        // Check if quantity is valid for each input
        var quantityValid = true;
        $('input[name="quantity[]"]').each(function() {
          if ($(this).val().trim() === "" || parseInt($(this).val()) <= 0) {
            $(this).css('border', '2px solid red'); // Apply red border if invalid
            quantityValid = false;
          } else {
            $(this).css('border', ''); // Remove red border if valid
          }
        });

        // If any field is invalid, stop form submission
        if (!quantityValid) {
          formIsValid = false;
          Swal.fire({
            icon: 'warning',
            title: 'Please fill in all required fields',
            text: 'Make sure all inputs and the discount type are selected, and quantity is greater than 0.',
            timer: 3000,
          });
          return; // Prevent form submission if fields are not valid
        }

        // If the form is valid, proceed with formData check

        // Check full name, id number, address, and discount fields
        var fullName = $('#full_name').val().trim();
        var idNo = $('#id_no').val().trim();
        var address = $('#address').val().trim();
        var discount = $('#discount').val();


        var formData = new FormData(this);
          formData.append("add_sale", true);

        // If the form is valid, append the data and proceed
        if (!formIsValid && (fullName !== "" || idNo !== "" || address !== "" || discount !== 'Choose Type of discount') 
        || formIsValid && (fullName !== "" && idNo === "" && address === "" && discount === 'Choose Type of discount')
        || formIsValid && (fullName === "" && idNo !== "" && address === "" && discount === 'Choose Type of discount')
        || formIsValid && (fullName === "" && idNo === "" && address !== "" && discount === 'Choose Type of discount')
        || formIsValid && (fullName === "" && idNo === "" && address === "" && discount !== 'Choose Type of discount')
        || formIsValid && (fullName !== "" && idNo !== "" && address === "" && discount === 'Choose Type of discount')
        || formIsValid && (fullName !== "" && idNo !== "" && address !== "" && discount === 'Choose Type of discount')
        || formIsValid && (fullName !== "" && idNo === "" && address !== "" && discount === 'Choose Type of discount')
        || formIsValid && (fullName !== "" && idNo === "" && address !== "" && discount !== 'Choose Type of discount')
        || formIsValid && (fullName !== "" && idNo !== "" && address === "" && discount !== 'Choose Type of discount')
        || formIsValid && (fullName === "" && idNo !== "" && address !== "" && discount !== 'Choose Type of discount')
        || formIsValid && (fullName === "" && idNo !== "" && address !== "" && discount !== 'Choose Type of discount')
        || formIsValid && (fullName === "" && idNo !== "" && address === "" && discount !== 'Choose Type of discount')
        ) {
          Swal.fire({
            icon: 'warning',
            title: 'Please fill in all required fields',
            text: 'Ensure that quantity, name, ID number, address, and discount type are selected.',
            timer: 3000,
          });
        } else {

          // Proceed with the form submission if everything is valid
          Swal.fire({
            title: 'Do you want to add product details?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Add',
            denyButtonText: `Don't Add`,
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: "POST",
                url: "../user_process/product_process.php", // action
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                  console.log(response);
                  var res = jQuery.parseJSON(response);
                  if (res.status == 400) {
                    Swal.fire({
                      icon: 'warning',
                      title: 'Something Went Wrong.',
                      text: res.msg,
                      timer: 3000,
                    });
                  } else if (res.status == 500) {
                    Swal.fire({
                      icon: 'warning',
                      title: 'Something Went Wrong.',
                      text: res.msg,
                      timer: 3000,
                    });
                  } else if (res.status == 200) {
                    Swal.fire({
                      icon: 'success',
                      title: 'SUCCESS',
                      text: res.msg,
                      timer: 2000,
                    }).then(function() {
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
        }
      });
    });
  </script>


</body>

</html>
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

<title>Product Table</title>
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

      <?php include "../include/product_main_panel.php"; ?>


    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <?php include '../include/user_bottom.php'; ?>

  <?php include '../user_process/product_process.php'; ?>

</body>

</html>


<script>
  // ALL FUNCTION

  // Function to validate empty fields and apply red border
  function validateFields() {
    // Get the form fields
    const item_code = document.getElementById('item_code');
    const brand = document.getElementById('brand');
    const description = document.getElementById('description');
    const batch_no = document.getElementById('batch_no');
    const lot_no = document.getElementById('lot_no');
    const category = document.getElementById('category');
    const quantity = document.getElementById('quantity');
    const material_cost = document.getElementById('material_cost');
    const sell_price = document.getElementById('sell_price');
    const manufacturing_date = document.getElementById('manufacturing_date');
    const expiration_date = document.getElementById('expiration_date');

    // Apply red border to fields if they are empty or invalid
    if (item_code.value.trim() === '') {
      item_code.style.border = '2px solid red';
    } else {
      item_code.style.border = 'none'; // Remove border if input is not empty
    }

    if (brand.value.trim() === '') {
      brand.style.border = '2px solid red';
    } else {
      brand.style.border = 'none'; // Remove border if input is not empty
    }

    if (description.value.trim() === '') {
      description.style.border = '2px solid red';
    } else {
      description.style.border = 'none'; // Remove border if input is not empty
    }


    if (batch_no.value.trim() === '') {
      batch_no.style.border = '2px solid red';
    } else {
      batch_no.style.border = 'none'; // Remove border if input is not empty
    }

    if (lot_no.value.trim() === '') {
      lot_no.style.border = '2px solid red';
    } else {
      lot_no.style.border = 'none'; // Remove border if input is not empty
    }

    if (category.value === 'Select Category Option') {
      category.style.border = '2px solid red';
    } else {
      category.style.border = 'none'; // Remove border if category is selected
    }

    if (quantity.value.trim() === '') {
      quantity.style.border = '2px solid red';
    } else {
      quantity.style.border = 'none'; // Remove border if input is not empty
    }

    if (material_cost.value.trim() === '') {
      material_cost.style.border = '2px solid red';
    } else {
      material_cost.style.border = 'none'; // Remove border if input is not empty
    }

    if (sell_price.value.trim() === '') {
      sell_price.style.border = '2px solid red';
    } else {
      sell_price.style.border = 'none'; // Remove border if input is not empty
    }

    if (manufacturing_date.value.trim() === '') {
      manufacturing_date.style.border = '2px solid red';
    } else {
      manufacturing_date.style.border = 'none'; // Remove border if input is not empty
    }

    if (expiration_date.value.trim() === '') {
      expiration_date.style.border = '2px solid red';
    } else {
      expiration_date.style.border = 'none'; // Remove border if input is not empty
    }
  }



  // Function to validate expiration date format (YYYY-MM-DD)
  function validateExpirationDate(expiration_date) {
    // Check if the input matches the YYYY-MM-DD format
    const datePattern = /^\d{4}-\d{2}-\d{2}$/;
    if (datePattern.test(expiration_date)) {
      // Parse the date into components (YYYY-MM-DD)
      const dateComponents = expiration_date.split('-');

      // Check if the date is valid using the built-in Date object
      const date = new Date(expiration_date);
      if (date.getFullYear() === parseInt(dateComponents[0]) &&
        (date.getMonth() + 1) === parseInt(dateComponents[1]) &&
        date.getDate() === parseInt(dateComponents[2])) {
        return true; // Valid date
      }
    }
    return false; // Invalid date format or invalid date
  }

  // Function to validate if expiration date is within 5 years from now
  function validateExpirationDateYear(expiration_date) {
    // Check if the input matches the YYYY-MM-DD format first
    if (!validateExpirationDate(expiration_date)) {
      return false; // If the date format is invalid, return false
    }

    // Parse the expiration date to compare
    const dateToCheck = new Date(expiration_date);

    // Get today's date and calculate the date 5 years from today
    const today = new Date();
    const fiveYearsApart = new Date();
    fiveYearsApart.setFullYear(today.getFullYear() + 5); // 5 years ahead
    const fiveYearsAgo = new Date();
    fiveYearsAgo.setFullYear(today.getFullYear() - 5); // 5 years ago

    // Check if the expiration date is within the last 5 years range
    if (dateToCheck >= today && dateToCheck <= fiveYearsApart) {
      return true; // Valid date
    }

    return false; // Date is outside the valid range
  }

  // Function to validate manufacturing date format (YYYY-MM-DD)
  function validateManufactureDate(manufacturing_date) {
    // Check if the input matches the YYYY-MM-DD format
    const datePattern = /^\d{4}-\d{2}-\d{2}$/;
    if (datePattern.test(manufacturing_date)) {
      // Parse the date into components (YYYY-MM-DD)
      const dateComponents = manufacturing_date.split('-');

      // Check if the date is valid using the built-in Date object
      const date = new Date(manufacturing_date);
      if (date.getFullYear() === parseInt(dateComponents[0]) &&
        (date.getMonth() + 1) === parseInt(dateComponents[1]) &&
        date.getDate() === parseInt(dateComponents[2])) {
        return true; // Valid date
      }
    }
    return false; // Invalid date format or invalid date
  }

  // Function to validate if manufacturing date is within the last 5 years
  function validateManufactureDateYear(manufacturing_date) {
    // Check if the input matches the YYYY-MM-DD format first
    if (!validateManufactureDate(manufacturing_date)) {
      return false; // If the date format is invalid, return false
    }

    // Get today's date and calculate the date 3 years ago
    const today = new Date();
    const threeYearsAgo = new Date();
    threeYearsAgo.setFullYear(today.getFullYear() - 5); // 3 years ago

    // Parse the manufacturing date to compare
    const dateToCheck = new Date(manufacturing_date);

    // Check if the manufacturing date is within the last 5 years range (from 5 years ago to today)
    if (dateToCheck >= threeYearsAgo && dateToCheck <= today) {
      return true; // Valid date
    }

    return false; // Date is outside the valid range
  }

  function validateQuantityInput($quantity) {
    // Check if quantity is numeric and greater than 0
    if ($quantity <= 0) {
      return false; // Invalid input, return false
    }
    return true; // Valid input, return true
  }

  function validateMaterialInput($material_cost) {
    // Check if material cost is numeric and greater than 0
    if ($material_cost <= 0) {
      return false; // Invalid input, return false
    }
    return true; // Valid input, return true
  }

  function validatePriceInput($sell_price) {
    // Check if sell price is numeric and greater than 0
    if ($sell_price <= 0) {
      return false; // Invalid input, return false
    }
    return true; // Valid input, return true
  }


  // Automatically validate on page load
  document.addEventListener('DOMContentLoaded', function() {
    validateFields(); // Validate the fields when the page loads
  });

  // Optionally, add event listeners to check the fields as the user types
  const inputs = document.querySelectorAll('input, select');
  inputs.forEach(function(input) {
    input.addEventListener('input', function() {
      validateFields(); // Revalidate fields on user input
    });
  });

  $(document).ready(function() {
    // new form update
    $(document).on('submit', '#addProduct', function(e) {
      e.preventDefault();
      e.preventDefault(); // Prevent form submission

      // Clear previous red borders before validating
      var inputs = document.querySelectorAll('input, select');
      inputs.forEach(function(input) {
        input.style.border = ''; // Reset all borders
      });

      // Re-validate the fields before submitting
      validateFields(); // Re-validate fields to ensure red borders are applied to empty ones

      // Check if category is selected properly
      const categoryField = document.getElementById('category');
      if (categoryField.value === 'Select Category Option') {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Category',
          text: 'Please choose a different category.',
          timer: 3000
        });
        categoryField.style.border = '2px solid red'; // Apply red border to category field
        return; // Stop further processing if category is invalid
      }

      // If any field is invalid, show a general error message and stop execution
      const fieldsToCheck = [
        'item_code', 'brand', 'description', 'batch_no', 'lot_no', 'category', 'quantity',
        'material_cost', 'sell_price', 'manufacturing_date', 'expiration_date'
      ];

      let isValid = true;
      fieldsToCheck.forEach(function(fieldName) {
        var field = document.getElementById(fieldName);
        if (!field.value.trim() || (fieldName === 'category' && field.value === 'Select Category Option')) {
          isValid = false;
          field.style.border = '2px solid red'; // Apply red border to invalid fields
        }
      });

      // If validation fails, stop form submission and show an error message
      if (!isValid) {
        Swal.fire({
          icon: 'error',
          title: 'Missing Fields',
          text: 'Please fill in all the required fields.',
          timer: 3000
        });
        return; // Stop execution if validation fails
      }


      // Validate expiration date format
      const expirationDate = document.getElementById('expiration_date').value;
      if (!validateExpirationDate(expirationDate)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Expiration Date',
          text: 'Please enter a valid expiration date in the format YYYY-MM-DD.',
          timer: 3000
        });
        document.getElementById('expiration_date').style.border = '2px solid red';
        return;
      }


      // Get the input fields
      const materialCost = document.getElementById('material_cost');
      const sellPrice = document.getElementById('sell_price');

      // Validate the values
      if (parseFloat(materialCost.value) > parseFloat(sellPrice.value)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Values',
          text: 'Manufacturing date value cannot be greater than the sell price.',
          timer: 3000
        });

        // Highlight the fields with errors
        materialCost.style.border = '2px solid red';
        sellPrice.style.border = '2px solid red';
        return;
      } else {
        // Reset border styles if valid
        materialCost.style.border = '';
        sellPrice.style.border = '';
      }

      // Validate if expiration date is within the last 5 years
      if (!validateExpirationDateYear(expirationDate)) {
        Swal.fire({
          icon: 'error',
          title: 'Expiration Date Out of Range',
          text: 'Expiration date must be within 5 years from today.',
          timer: 3000
        });
        document.getElementById('expiration_date').style.border = '2px solid red';
        return;
      }

      // Validate if expiration date is within the last 5 years
      if (validateManufactureDateYear(manufacturing_date)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Manufacture Date',
          text: 'Please enter a valid manufacture date in the format YYYY-MM-DD.',
          timer: 3000
        });
        document.getElementById('manufacturing_date').style.border = '2px solid red';
        return;
      }
      // Assuming quantity, material_cost, and sell_price are coming from input fields
      let quantity = document.getElementById('quantity').value;
      let material_cost = document.getElementById('material_cost').value;
      let sell_price = document.getElementById('sell_price').value;


      if (!validateQuantityInput(quantity)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Quantity',
          text: 'Input Quantity must be a positive numeric value.',
          timer: 3000
        });
        document.getElementById('quantity').style.border = '2px solid red';
        return; // Stop further execution
      }

      if (!validateMaterialInput(material_cost)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Material Cost',
          text: 'Input Material Cost must be a positive numeric value.',
          timer: 3000
        });
        document.getElementById('material_cost').style.border = '2px solid red';
        return; // Stop further execution
      }

      if (!validatePriceInput(sell_price)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Sell Price',
          text: 'Input Sell Price must be a positive numeric value.',
          timer: 3000
        });
        document.getElementById('sell_price').style.border = '2px solid red';
        return; // Stop further execution
      }

      // Continue with other processing if validation passes...


      // If validation passes, show SweetAlert to confirm submission
      Swal.fire({
        title: 'Do you want to save the Product?',
        showCancelButton: true,
        confirmButtonText: 'Save',
      }).then((result) => {
        if (result.isConfirmed) {
          // Create FormData for AJAX request
          var formData = new FormData(this);
          formData.append("valid_product", true);

          $.ajax({
            type: "POST",
            url: "../user_process/product_process.php", // action
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              var res = jQuery.parseJSON(response);
              if (res.status == 400 || res.status == 500) {
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
    })
  });




  $(document).ready(function() {
    // Update Row - Fetch product data
    $(document).on('click', '.product_edit', function() {
      var product_edit_id = $(this).val();

      $.ajax({
        type: "GET",
        url: "../getdata/product_data.php?product_edit_id=" + product_edit_id,
        success: function(response) {
          var res = jQuery.parseJSON(response);
          if (res.status == 200) {
            $('#updpr_id').val(res.data.pr_id);
            $('#upditem_code').val(res.data.item_code);
            $('#upddescription').val(res.data.description);
            $('#updbatch_no').val(res.data.batch_no);
            $('#updlot_no').val(res.data.lot_no);
            $('#updbrand').val(res.data.brand);
            $('#rcategory').val(res.data.category);
            $('#updmaterial_cost').val(res.data.material_cost);
            $('#updsell_price').val(res.data.sell_price);
            $('#updmanufacturing_date').val(res.data.manufacturing_date);
            $('#updquantity').val(res.data.p_quantity);
            $('#updexpiration_date').val(res.data.expiration_date);
          }
        }
      });
    });







    function validateFields() {
      // Get the form fields
      const upditem_code = document.getElementById('upditem_code');
      const updbrand = document.getElementById('updbrand');
      const upddescription = document.getElementById('upddescription');
      const updbatch_no = document.getElementById('updbatch_no');
      const updlot_no = document.getElementById('updlot_no');
      const updcategory = document.getElementById('rcategory');
      const updquantity = document.getElementById('updquantity');
      const updmaterial_cost = document.getElementById('updmaterial_cost');
      const updsell_price = document.getElementById('updsell_price');
      const updmanufacturing_date = document.getElementById('updmanufacturing_date');
      const updexpiration_date = document.getElementById('updexpiration_date');

      // Apply red border to fields if they are empty or invalid
      if (upditem_code.value.trim() === '') {
        upditem_code.style.border = '2px solid red';
      } else {
        upditem_code.style.border = 'none'; // Remove border if input is not empty
      }

      if (updbrand.value.trim() === '') {
        updbrand.style.border = '2px solid red';
      } else {
        updbrand.style.border = 'none'; // Remove border if input is not empty
      }

      if (upddescription.value.trim() === '') {
        upddescription.style.border = '2px solid red';
      } else {
        upddescription.style.border = 'none'; // Remove border if input is not empty
      }

      if (updcategory.value === 'Select Category Option') {
        updcategory.style.border = '2px solid red';
      } else {
        updcategory.style.border = 'none'; // Remove border if category is selected
      }


      if (updbatch_no.value.trim() === '') {
        updbatch_no.style.border = '2px solid red';
      } else {
        updbatch_no.style.border = 'none'; // Remove border if input is not empty
      }

      if (updlot_no.value.trim() === '') {
        updlot_no.style.border = '2px solid red';
      } else {
        updlot_no.style.border = 'none'; // Remove border if input is not empty
      }

      if (updquantity.value.trim() === '') {
        updquantity.style.border = '2px solid red';
      } else {
        updquantity.style.border = 'none'; // Remove border if input is not empty
      }

      if (updmaterial_cost.value.trim() === '') {
        updmaterial_cost.style.border = '2px solid red';
      } else {
        updmaterial_cost.style.border = 'none'; // Remove border if input is not empty
      }

      if (updsell_price.value.trim() === '') {
        updsell_price.style.border = '2px solid red';
      } else {
        updsell_price.style.border = 'none'; // Remove border if input is not empty
      }

      if (updmanufacturing_date.value.trim() === '') {
        updmanufacturing_date.style.border = '2px solid red';
      } else {
        updmanufacturing_date.style.border = 'none'; // Remove border if input is not empty
      }

      if (updexpiration_date.value.trim() === '') {
        updexpiration_date.style.border = '2px solid red';
      } else {
        updexpiration_date.style.border = 'none'; // Remove border if input is not empty
      }


    }



    // Function to validate fields on form
    function validateUpdFields() {
      const fields = [
        'updpr_id', 'upditem_code', 'updbrand', 'upddescription', 'updbatch_no', 'updlot_no', 'rcategory', 'updquantity', 'updmaterial_cost',
        'updsell_price', 'updmanufacturing_date', 'updexpiration_date'
      ];

      fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field.value.trim() !== '') {
          field.style.border = 'none'; // No border if not empty
        } else {
          field.style.border = '2px solid red'; // Red border if empty
        }
      });

      // Validate category selection
      const categoryField = document.getElementById('rcategory');
      if (categoryField.value === 'Select Category Option') {
        categoryField.style.border = '2px solid red';
      }
    }

    // Automatically validate on page load
    document.addEventListener('DOMContentLoaded', function() {
      validateUpdFields(); // Validate fields when the page loads
    });

    // Add event listeners for live input validation
    const inputs_updProducts = document.querySelectorAll('input, select');
    inputs_updProducts.forEach(function(inputs_updProduct) {
      inputs_updProduct.addEventListener('input', function() {
        validateUpdFields(); // Revalidate fields on user input
      });
    });

    // Handle form submission
    $(document).on('submit', '#updProduct', function(e) {
      e.preventDefault(); // Prevent form submission

      // Clear previous red borders before validating
      var inputs_updProducts = document.querySelectorAll('input, select');
      inputs_updProducts.forEach(function(inputs_updProduct) {
        inputs_updProduct.style.border = ''; // Reset all borders
      });

      // Re-validate fields before submitting
      validateUpdFields(); // Ensure all fields are validated

      // Validate category selection
      const categoryField = document.getElementById('rcategory');
      if (categoryField.value === 'Select Category Option') {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Category',
          text: 'Please choose a valid category.',
          timer: 3000
        });
        categoryField.style.border = '2px solid red'; // Red border if category is invalid
        return; // Stop further processing
      }


      // Get the input fields
      const updmaterialCost = document.getElementById('updmaterial_cost');
      const updsellPrice = document.getElementById('updsell_price');

      // Validate the values
      if (parseFloat(updmaterialCost.value) > parseFloat(updsellPrice.value)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Values',
          text: 'Material cost value cannot be greater than the sell price.',
          timer: 3000
        });

        // Highlight the fields with errors
        updmaterialCost.style.border = '2px solid red';
        updsellPrice.style.border = '2px solid red';
        return;
      } else {
        // Reset border styles if valid
        updmaterialCost.style.border = '';
        updsellPrice.style.border = '';
      }


      // Validate expiration date format
      const updexpiration_date = document.getElementById('updexpiration_date').value;
      if (!validateExpirationDate(updexpiration_date)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Expiration Date',
          text: 'Please enter a valid expiration date in the format YYYY-MM-DD.',
          timer: 3000
        });
        document.getElementById('updexpiration_date').style.border = '2px solid red';
        return;
      }

      // Validate if expiration date is within the last 5 years range
      if (!validateExpirationDateYear(updexpiration_date)) {
        Swal.fire({
          icon: 'error',
          title: 'Expiration Date Out of Range',
          text: 'Expiration date must be within 5 years from today.',
          timer: 3000
        });
        document.getElementById('updexpiration_date').style.border = '2px solid red';
        return;
      }

      // Validate manufacturing date if it is within the last 3 years from today
      if (validateManufactureDateYear(updmanufacturing_date)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Manufacture Date',
          text: 'Please enter a valid manufacture date in the format YYYY-MM-DD.',
          timer: 3000
        });
        document.getElementById('updmanufacturing_date').style.border = '2px solid red';
        return;
      }

      // Assuming quantity, material_cost, and sell_price are coming from input fields
      let updquantity = document.getElementById('updquantity').value;
      let updmaterial_cost = document.getElementById('updmaterial_cost').value;
      let updsell_price = document.getElementById('updsell_price').value;

      if (!validateQuantityInput(updquantity)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Quantity',
          text: 'Please enter a valid non-zero or positive quantity.',
          timer: 3000
        });
        document.getElementById('updquantity').style.border = '2px solid red';
        return; // Stop further execution
      }

      if (!validateMaterialInput(updmaterial_cost)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Material Cost',
          text: 'Please enter a valid non-zero or positive cost.',
          timer: 3000
        });
        document.getElementById('updmaterial_cost').style.border = '2px solid red';
        return; // Stop further execution
      }

      if (!validatePriceInput(updsell_price)) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Sell Price',
          text: 'Please enter a valid non-zero or positive price.',
          timer: 3000
        });
        document.getElementById('updsell_price').style.border = '2px solid red';
        return; // Stop further execution
      }







      // If validation passes, show confirmation dialog
      Swal.fire({
        title: 'Do you want to update the product?',
        showCancelButton: true,
        confirmButtonText: 'Update',
      }).then((result) => {
        if (result.isConfirmed) {
          // Create FormData for AJAX request
          var formData = new FormData(this);
          formData.append("update_product", true);

          // Perform the AJAX request
          $.ajax({
            type: "POST",
            url: "../user_process/product_process.php", // action
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
              } else if (res.status == 200) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: res.msg,
                  timer: 2000
                }).then(function() {
                  location.reload(); // Reload the page after success
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an issue updating the product. Please try again.',
                timer: 3000
              });
            }
          });
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info').then(function() {
            location.reload(); // Reload if user cancels
          });
        }
      });
    });
  });
</script>
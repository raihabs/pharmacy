<?php
include '../config/connect.php';

error_reporting(0);
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        .form {
            border: 2px solid black;
            padding: 10px;
            margin: 10px;
            cursor: pointer;
        }

        .form:hover {
            border-color: blue;
        }

        .container {
            margin-top: 20px;
        }

        .row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-control {
            margin-right: 10px;
            width: 50px;
            text-align: center;
        }

        .remove-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: darkred;
        }

        .total-container {
            margin-top: 20px;
            text-align: right;
        }

        #resetButton {
            background-color: gray;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        #resetButton:hover {
            background-color: darkgray;
        }

        /* Hidden input */
        #item-code-input {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
    </style>
</head>

<body>
    <!-- Product Cards -->
    <div id="product-cards">
        <!-- Example Product Cards -->
        <div class="form" id="form1" data-itemcode="8995201800479" data-prid="1" data-sellprice="100" data-quantity="10">
            Product ID: 1<br>
            Sell Price: $100<br>
            Quantity: 10
        </div>
        <div class="form" id="form2" data-itemcode="002" data-prid="2" data-sellprice="200" data-quantity="5">
            Product ID: 2<br>
            Sell Price: $200<br>
            Quantity: 5
        </div>
        <div class="form" id="form3" data-itemcode="003" data-prid="3" data-sellprice="300" data-quantity="8">
            Product ID: 3<br>
            Sell Price: $300<br>
            Quantity: 8
        </div>
    </div>

    <!-- Hidden Input for Barcode Scanner -->
    <input type="text" id="item-code-input" />

    <!-- Container for Dynamic Inputs -->
    <div id="container" class="container"></div>

    <!-- Total and Reset Button -->
    <div class="total-container">
        <span id="total">0.00</span>
        <button id="resetButton">Reset</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('container');
            const totalSpan = document.getElementById('total');
            const resetButton = document.getElementById('resetButton');
            const itemCodeInput = document.getElementById('item-code-input');
            let total = 0;

            // Focus the hidden input when the page loads
            itemCodeInput.focus();

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
                    const existingRow = container.querySelector(`.box[data-prid='${pr_id}']`);

                    if (existingRow) {
                        const quantityInput = existingRow.querySelector('.form-control.quantity-input');
                        quantityInput.value = parseInt(quantityInput.value) + 1;
                        updateRowTotal(existingRow);
                    } else {
                        const box = document.createElement('div');

                        box.className = 'input-row box';
                        box.dataset.prid = pr_id;
                        box.style.borderColor = 'blue';
                        document.querySelectorAll('.box').forEach(form => form.style.borderColor = 'blue');

                        box.innerHTML = `
                            <input type="text" class='form-control' name="pr_id[]" value="${pr_id}" readonly />
                            <input type="text" class='form-control' name="item_code[]" value="${item_code}" readonly />
                            <input type="text" class='form-control' name="sell_price[]" value="${sell_price}" readonly />
                            <input type='text' class='form-control quantity-input' name="quantity[]" value='1' data-sellprice='${sell_price}'>
                            <input type='text' class='form-control row-total' name="total[]" value='${sell_price.toFixed(2)}' readonly>
                            <button class='remove-btn'>Remove</button>
                        `;
                        box.querySelector('.remove-btn').addEventListener('click', () => {
                            box.remove();
                            updateTotal();

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


                            const button<?php echo $select['pr_id'] ?> = document.getElementById('form<?php echo $select['pr_id'] ?>');


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
                        container.appendChild(box);
                    }

                    updateTotal();
                } else {
                    alert('Item not found!');
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
          const button" . $selectToReset['pr_id'] . " = document.getElementById('form" . $selectToReset['pr_id'] . "');
          
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

            });
        });
    </script>
</body>

</html>
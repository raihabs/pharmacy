<?php
$servername = "localhost:4306";
$username = "root"; // change this to your database username
$password = ""; // change this to your database password
$dbname = "main"; // change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$pr_ids = $_POST['pr_id'];
$item_codes = $_POST['item_code'];
$sell_prices = $_POST['sell_price'];
$quantities = $_POST['quantity'];
$expiration_dates = $_POST['expiration_date'];



// Prepare SQL statements
$fetch_product_sql = "SELECT p_quantity FROM product WHERE item_code = ?";
$fetch_inventory_sql = "SELECT quantity FROM inventory WHERE item_code = ?";
$insert_update_sql = "INSERT INTO inventory (pr_id, item_code, sell_price, quantity, expiration_date, remarks) 
                      VALUES (?, ?, ?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE
                      sell_price=VALUES(sell_price), 
                      quantity=quantity + VALUES(quantity),
                      expiration_date=VALUES(expiration_date)";
$insert_archive_sql = "INSERT INTO archive (pr_id, item_code, sell_price, quantity, expiration_date, remarks) 
                      VALUES (?, ?, ?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE
                      sell_price=VALUES(sell_price), 
                      quantity=quantity + VALUES(quantity),
                      expiration_date=VALUES(expiration_date),
                      remarks=VALUES(remarks)";
$update_inventory_sql = "UPDATE inventory 
               SET sell_price = ?, quantity = ?, expiration_date = ?, remarks = ? 
               WHERE item_code = ?";

$update_product_sql = "UPDATE product
                        SET sell_price = ?, p_quantity = ?, expiration_date = ? 
                        WHERE item_code = ?";
// Prepare the statements
$fetch_product_stmt = $conn->prepare($fetch_product_sql);
$fetch_inventory_stmt = $conn->prepare($fetch_inventory_sql);
$insert_update_stmt = $conn->prepare($insert_update_sql);
$update_inventory_stmt = $conn->prepare($update_inventory_sql);
$update_product_stmt = $conn->prepare($update_product_sql);
$insert_archive_stmt = $conn->prepare($insert_archive_sql);

if (!$fetch_product_stmt || !$fetch_inventory_stmt || !$insert_update_stmt ||  !$insert_archive_stmt || !$update_inventory_stmt || !$update_product_stmt) {
    echo json_encode(array('status' => 400, 'msg' => 'Error preparing statement: ' . $conn->error));
    $conn->close();
    exit();
}

// Process each item
for ($i = 0; $i < count($item_codes); $i++) {
    $pr_id = $conn->real_escape_string($pr_ids[$i]);
    $item_code = $conn->real_escape_string($item_codes[$i]);
    $sell_price = $conn->real_escape_string($sell_prices[$i]);
    $quantity = $conn->real_escape_string($quantities[$i]);
    $expiration_date = $conn->real_escape_string($expiration_dates[$i]);

    // Fetch existing quantity from the product table
    $fetch_product_stmt->bind_param("s", $item_code);
    $fetch_product_stmt->execute();
    $fetch_product_stmt->store_result();
    $fetch_product_stmt->bind_result($existing_quantity);
    $fetch_product_stmt->fetch();

    // Fetch existing quantity from the inventory table
    $fetch_inventory_stmt->bind_param("s", $item_code);
    $fetch_inventory_stmt->execute();
    $fetch_inventory_stmt->store_result();
    $fetch_inventory_stmt->bind_result($inventory_quantity);
    $fetch_inventory_stmt->fetch();

    // Calculate the new quantity
    $new_quantity = ($inventory_quantity !== null ? $inventory_quantity : 0) + $quantity;

    // Determine remarks based on quantity and expiration date
    $today = new DateTime();
    $thirty_days_later = new DateTime('+30 days');
    $date_to_check = new DateTime($expiration_date);

    if ($new_quantity > 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today) {
        $remarks = 'EXPIRE SOON';
    } elseif ($new_quantity <= 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today) {
        $remarks = 'LOW QUANTITY';
    } elseif ($date_to_check <= $today) {
        $remarks = 'EXPIRED';
    } else {
        $remarks = 'ACTIVE';
    }

    if ($fetch_inventory_stmt->num_rows >  0) {
        // Update inventory if the item exists
        $update_inventory_stmt->bind_param("dissi", $sell_price, $new_quantity, $expiration_date, $remarks, $item_code);
        $update_product_stmt->bind_param("diss", $sell_price, $new_quantity, $expiration_date, $item_code);
        $insert_archive_stmt->bind_param("ssdiss", $pr_id, $item_code, $sell_price, $new_quantity, $expiration_date, $remarks);
        if (!$update_inventory_stmt->execute() || !$update_product_stmt->execute() || !$insert_archive_stmt->execute()) {
            echo json_encode(array('status' => 400, 'msg' => 'Error executing update statement: ' . $update_inventory_stmt . ' and ' . $update_inventory_stmt . ' and ' . $insert_archive_stmt->error));
            $update_inventory_stmt->close();
            $update_product_stmt->close();
            $insert_archive_stmt->close();
            $conn->close();
            exit();
        }
    } else {
        // Insert or update the inventory table
        $insert_inventory_stmt->bind_param("ssdiss", $pr_id, $item_code, $sell_price, $new_quantity, $expiration_date, $remarks);
        $update_product_stmt->bind_param("diss", $sell_price, $new_quantity, $expiration_date, $item_code);
        $insert_archive_stmt->bind_param("ssdiss", $pr_id, $item_code, $sell_price, $new_quantity, $expiration_date, $remarks);
        if (!$insert_update_stmt->execute() || !$update_product_stmt->execute() || !$insert_archive_stmt->execute()) {
            echo json_encode(array('status' => 400, 'msg' => 'Error executing insert/update statement: ' . $insert_update_stmt . ' and ' . $update_inventory_stmt . ' and ' . $insert_archive_stmt->error));
            $insert_update_stmt->close();
            $update_product_stmt->close();
            $insert_archive_stmt->close();
            $conn->close();
            exit();
        }
    }
}

// Close the statements and the connection
$fetch_product_stmt->close();
$fetch_inventory_stmt->close();
$insert_update_stmt->close();
$update_inventory_stmt->close();
$update_product_stmt->close();
$insert_archive_stmt->close();

$conn->close();

echo json_encode(array('status' => 200, 'msg' => 'Inventory updated successfully'));

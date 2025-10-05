<?php
$servername = "localhost:4306";
$username = "root"; // change this to your database username  :4306
$password = ""; // change this to your database password
$dbname = "main"; // change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// error_reporting(0);
session_start();


// Get POST data
$pr_ids = $_POST['pr_id'];
$item_codes = $_POST['item_code'];
$sell_prices = $_POST['sell_price'];
$quantities = $_POST['quantity'];
$pi_quantities = $_POST['pi_quantity'];
$expiration_dates = $_POST['expiration_date'];
$user_ids = $_POST['user_id'];
$created_bys = $_POST['created_by'];
$date_created_ats = $_POST['date_created_at'];


if (isset($_SESSION["user_id_admin"])) {
    $id = $_SESSION["user_id_admin"];
}else {
    $id = $_SESSION["user_id_inventory_clerk"];
}

$updated_insert_by = $id;

// Prepare SQL statements
$fetch_product_sql = "SELECT p_quantity FROM product WHERE item_code = ?";
// $fetch_inventory_sql = "SELECT * FROM inventory WHERE ((item_code = ? AND remarks = 'ACTIVE') OR (item_code = ? AND remarks = 'LOW QUANTITY')  OR (item_code = ? AND remarks = 'EXPIRED SOON') OR (item_code = ? AND remarks = 'NO QUANTITY') OR (item_code = ? AND remarks = 'EXPIRED')) GROUP BY item_code ORDER BY item_code ASC ";
// $fetch_archive_sql = "SELECT * FROM archive WHERE ((item_code = ? AND remarks = 'ACTIVE') OR (item_code = ? AND remarks = 'LOW QUANTITY')  OR (item_code = ? AND remarks = 'EXPIRED SOON') OR (item_code = ? AND remarks = 'NO QUANTITY') OR (item_code = ? AND remarks = 'EXPIRED')) GROUP BY item_code ORDER BY item_code ASC ";
$fetch_inventory_sql = "SELECT quantity FROM inventory WHERE (item_code = ? AND remarks IN ('ACTIVE', 'LOW QUANTITY', 'EXPIRED SOON', 'NO QUANTITY', 'EXPIRED')) GROUP BY item_code ORDER BY item_code ASC";
$fetch_inventory2_sql = "SELECT pi_quantity FROM inventory WHERE (item_code = ? AND remarks IN ('ACTIVE', 'LOW QUANTITY', 'EXPIRED SOON', 'NO QUANTITY', 'EXPIRED')) GROUP BY item_code ORDER BY item_code ASC";
$fetch_archive_sql = "SELECT quantity FROM archive WHERE (item_code = ? AND remarks IN ('ACTIVE', 'LOW QUANTITY', 'EXPIRED SOON', 'NO QUANTITY', 'EXPIRED')) GROUP BY item_code ORDER BY item_code ASC";

$insert_inventory_sql = "INSERT INTO inventory (pr_id, item_code, sell_price, quantity, pi_quantity, expiration_date, remarks, created_by,  updated_by, date_created_at, date_updated_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE
                            sell_price=VALUES(sell_price), 
                            quantity=quantity + VALUES(quantity),
                            quantity= VALUES(quantity),
                            expiration_date=VALUES(expiration_date),
                            created_by=VALUES(created_by),
                            updated_by=VALUES(updated_by),  
                            date_created_at=VALUES(date_created_at),
                            date_updated_at=VALUES(date_updated_at)";

$insert_archive_sql = "INSERT INTO archive (pr_id, item_code, sell_price, quantity, expiration_date, remarks, created_by, updated_by, date_created_at, date_updated_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE
                            sell_price=VALUES(sell_price), 
                            quantity=quantity + VALUES(quantity),
                            expiration_date=VALUES(expiration_date),
                            remarks=VALUES(remarks),
                            created_by=VALUES(created_by),
                            updated_by=VALUES(updated_by),
                            date_created_at=VALUES(date_created_at),
                            date_updated_at=VALUES(date_updated_at)";

$update_archive_sql = "UPDATE archive 
SET sell_price = ?, quantity = ?,   expiration_date = ?, remarks = ?, created_by = ?, updated_by = ?, date_created_at = ? , date_updated_at = ?  
WHERE item_code = ? AND (remarks = 'ACTIVE' OR remarks = 'LOW QUANTITY' OR remarks = 'EXPIRED SOON' OR remarks = 'NO QUANTITY'  OR remarks = 'EXPIRED') ";

$update_inventory_sql = "UPDATE inventory 
SET sell_price = ?, quantity = ?, pi_quantity = ?, expiration_date = ?, remarks = ?, created_by = ?, updated_by = ?, date_created_at = ?, date_updated_at = ?   
WHERE item_code = ? AND (remarks = 'ACTIVE' OR remarks = 'LOW QUANTITY' OR remarks = 'EXPIRED SOON' OR remarks = 'NO QUANTITY'  OR remarks = 'EXPIRED') ";

$update_product_sql = "UPDATE product
                                SET sell_price = ?, p_quantity = ?, expiration_date = ?
                                WHERE item_code = ?";

// Prepare the statements
$fetch_product_stmt = $conn->prepare($fetch_product_sql);
$fetch_inventory_stmt = $conn->prepare($fetch_inventory_sql);
$fetch_inventory2_stmt = $conn->prepare($fetch_inventory2_sql);
$fetch_archive_stmt = $conn->prepare($fetch_archive_sql);

$insert_inventory_stmt = $conn->prepare($insert_inventory_sql);
$update_inventory_stmt = $conn->prepare($update_inventory_sql);
$update_product_stmt = $conn->prepare($update_product_sql);
$insert_archive_stmt = $conn->prepare($insert_archive_sql);
$update_archive_stmt = $conn->prepare($update_archive_sql);

if (!$fetch_product_stmt || !$fetch_inventory_stmt || !$fetch_archive_stmt || !$insert_inventory_stmt ||  !$insert_archive_stmt ||   !$update_archive_stmt || !$update_inventory_stmt || !$update_product_stmt) {
    echo json_encode(array('status' => 400, 'msg' => 'Error preparing statement: ' . $conn->error));
    $conn->close();
    exit();
}


$updated__by = 0;
$date_insert_updated_at = '0000-00-00 00:00:00';

// Process each item
for ($i = 0; $i < count($item_codes); $i++) {
    $pr_id = $conn->real_escape_string($pr_ids[$i]);
    $item_code = $conn->real_escape_string($item_codes[$i]);
    $sell_price = $conn->real_escape_string($sell_prices[$i]);
    $quantity = $conn->real_escape_string($quantities[$i]);
    $pi_quantity = $conn->real_escape_string($pi_quantities[$i]);
    $expiration_date = $conn->real_escape_string($expiration_dates[$i]);
    $user_id = $conn->real_escape_string($user_ids[$i]);
    $created_by = $conn->real_escape_string($created_bys[$i]);
    $date_created_at = $conn->real_escape_string($date_created_ats[$i]);


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

    
    // Fetch existing quantity from the inventory table
    $fetch_inventory2_stmt->bind_param("s", $item_code);
    $fetch_inventory2_stmt->execute();
    $fetch_inventory2_stmt->store_result();
    $fetch_inventory2_stmt->bind_result($inventory2_quantity);
    $fetch_inventory2_stmt->fetch();

    // Fetch existing quantity from the archive table
    $fetch_archive_stmt->bind_param("s", $item_code);
    $fetch_archive_stmt->execute();
    $fetch_archive_stmt->store_result();
    $fetch_archive_stmt->bind_result($archive_quantity);
    $fetch_archive_stmt->fetch();

    // Calculate the new quantity
    $new_quantity = ($existing_quantity !== null ? $existing_quantity : 0) + $quantity ;
    $new_quantity1 = ($existing_quantity !== null ? $existing_quantity : 0) - $quantity;
    $new_piquantity =  ($inventory2_quantity !== null ? $inventory2_quantity : 0) + $quantity;;


    // Determine remarks based on quantity and expiration date
    $today = new DateTime();
    $thirty_days_later = new DateTime('+30 days');
    $date_to_check = new DateTime($expiration_date);

    if ($new_quantity == 0 && $date_to_check > $thirty_days_later) {
        $remarks = 'NO QUANTITY';
    } else if ($new_quantity <= 30 && $date_to_check > $thirty_days_later) {
        $remarks = 'LOW QUANTITY';
    } else if ($new_quantity > 30 && $date_to_check <= $today || $new_quantity   <= 30 && $date_to_check <= $today) {
        $remarks = 'EXPIRED';
    } else if ($new_quantity > 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today || $new_quantity    <= 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today) {
        $remarks = 'EXPIRE SOON';
    } else {
        $remarks = 'ACTIVE';
    }



    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d g:i:s");

    if ($fetch_inventory_stmt->num_rows >  0) {
        // Update inventory if the item exists
        $update_inventory_stmt->bind_param("diississss", $sell_price, $new_quantity, $new_piquantity, $expiration_date, $remarks, $created_by, $user_id, $date_created_at, $date_updated_at, $item_code);
        if (!$update_inventory_stmt->execute()) {
            echo json_encode(array('status' => 400, 'msg' => 'Error executing update statement: ' . $update_inventory_stmt->error));
            $update_inventory_stmt->close();
            $conn->close();
            exit();
        }
    } else {
        // Insert the inventory table
        $insert_inventory_stmt->bind_param("isdiissiiss", $pr_id, $item_code, $sell_price, $existing_quantity, $quantity, $expiration_date, $remarks, $user_id, $updated_insert_by, $date_updated_at, $date_insert_updated_at);
        if (!$insert_inventory_stmt->execute()) {
            echo json_encode(array('status' => 400, 'msg' => 'Error executing insert/update statement: ' . $insert_inventory_stmt->error));
            $insert_inventory_stmt->close();
            $conn->close();
            exit();
        }
    }


    if ($fetch_archive_stmt->num_rows >  0) {
        // Update inventory if the item exists
        $update_archive_stmt->bind_param("dississss", $sell_price, $new_quantity, $expiration_date, $remarks, $created_by, $user_id, $date_created_at, $date_updated_at, $item_code);
        if (!$update_archive_stmt->execute()) {
            echo json_encode(array('status' => 400, 'msg' => 'Error executing update statement: ' . $insert_archive_stmt->error));
            $update_archive_stmt->close();
            $conn->close();
            exit();
        }
    } else {
        // Insert or update the inventory table
        $insert_archive_stmt->bind_param("isdissiiss", $pr_id, $item_code, $sell_price, $existing_quantity, $expiration_date, $remarks, $user_id, $updated_insert_by, $date_updated_at, $date_insert_updated_at);
        if (!$insert_archive_stmt->execute()) {
            echo json_encode(array('status' => 400, 'msg' => 'Error executing insert/update statement: ' . $insert_archive_stmt->error));
            $insert_archive_stmt->close();
            $conn->close();
            exit();
        }
    }


    if ($fetch_inventory_stmt->num_rows > 0 && $fetch_archive_stmt->num_rows >  0) {
        // Update the product table
        $update_product_stmt->bind_param("diss", $sell_price, $new_quantity, $expiration_date, $item_code);
        if (!$update_product_stmt->execute()) {
            echo json_encode(array('status' => 400, 'msg' => 'Error executing product update statement: ' . $update_product_stmt->error));
            $update_product_stmt->close();
            $conn->close();
            exit();
        }
    } else {
        // Update the product table
        $update_product_stmt->bind_param("diss", $sell_price, $new_quantity, $expiration_date, $item_code);
        if (!$update_product_stmt->execute()) {
            echo json_encode(array('status' => 400, 'msg' => 'Error executing product update statement: ' . $update_product_stmt->error));
            $update_product_stmt->close();
            $conn->close();
            exit();
        }
    }
}

// Close the statements and the connection
$fetch_product_stmt->close();
$fetch_inventory_stmt->close();
$insert_inventory_stmt->close();
$update_inventory_stmt->close();
$update_product_stmt->close();
$insert_archive_stmt->close();
$update_archive_stmt->close();

$conn->close();

echo json_encode(array('status' => 200, 'msg' => 'Inventory added successfully'));

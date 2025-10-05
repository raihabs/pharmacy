<?php
require '../config/connect.php';

error_reporting(0);
session_start();


if (isset($_POST['valid_physical_inventory'])) {
    $num_records = count($_POST['pr_id']); // Get the number of records submitted

    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d g:i:s");
    $user_id = $_SESSION["user_id_inventory_clerk"];

    for ($i = 0; $i < $num_records; $i++) {
        // Sanitize each input field
        $pr_id = mysqli_real_escape_string($conn, $_POST['pr_id'][$i]);
        $item_code = mysqli_real_escape_string($conn, $_POST['item_code'][$i]);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity'][$i]);
        $phquantity = mysqli_real_escape_string($conn, $_POST['phquantity'][$i]);
        $expiration_date = mysqli_real_escape_string($conn, $_POST['phexpiration_date'][$i]);
        $comments = mysqli_real_escape_string($conn, $_POST['phcomments'][$i]);
        $remarks = mysqli_real_escape_string($conn, $_POST['phremarks'][$i]);

        // Validate each set of data (add your own validation rules as needed)

        // Example validation: Check if required fields are empty
        if (empty($pr_id) || empty($item_code) || empty($quantity) ||  empty($expiration_date) || empty($remarks)) {
            $res = [
                'status' => 400,
                'msg' => 'All fields are required.' ,
            ];
            echo json_encode($res);
            return;
        }

        $sql_check_inventory = "SELECT * FROM `inventory` 
        WHERE (`item_code` = '$item_code' AND remarks = 'ACTIVE') 
        OR (`item_code` = '$item_code' AND remarks = 'LOW QUANTITY') 
        OR (`item_code` = '$item_code' AND remarks = 'EXPIRED SOON') 
        OR (`item_code` = '$item_code' AND remarks = 'NO QUANTITY')  
        OR (`item_code` = '$item_code' AND remarks = 'EXPIRED')";
        $res_check_inventory = mysqli_query($conn, $sql_check_inventory);
        $inventory = mysqli_fetch_array($res_check_inventory);


        // Insert the record into the database
        $inventory_query = "UPDATE `inventory` SET
        quantity = '" . $quantity . "',
        pi_quantity = '" . $phquantity . "',
        expiration_date = '" . $expiration_date . "',
        comment = '". $comments . "',
        remarks = '". $remarks . "',
        updated_by = '" . $user_id . "',
        date_updated_at = '" . $date_updated_at . "'
        WHERE pr_id = '" . $pr_id . "' AND `remarks` = '" . $inventory['remarks'] . "' ";
        $inventory_query_run = mysqli_query($conn, $inventory_query);

        $sql_check_archive = "SELECT * FROM `archive` 
        WHERE (`item_code` = '$item_code' AND remarks = 'ACTIVE') 
       OR (`item_code` = '$item_code' AND remarks = 'LOW QUANTITY') 
       OR (`item_code` = '$item_code' AND remarks = 'EXPIRED SOON') 
       OR (`item_code` = '$item_code' AND remarks = 'NO QUANTITY')  
       OR (`item_code` = '$item_code' AND remarks = 'EXPIRED')";
       $res_check_archive = mysqli_query($conn, $sql_check_archive);
       $archive = mysqli_fetch_array($res_check_archive);


         // Insert the record into the database
         $archive_query = "UPDATE `archive` SET
         quantity = '" . $quantity . "',
         expiration_date = '" . $expiration_date . "',
         remarks = '". $remarks . "',
         updated_by = '" . $user_id . "',
         date_updated_at = '" . $date_updated_at . "'
         WHERE pr_id = '" . $pr_id . "'  AND `remarks` = '" . $archive['remarks'] . "' ";
         $archive_query_run = mysqli_query($conn, $archive_query);



        // Insert the record into the database
        $product_query = "UPDATE `product` SET
        p_quantity = '" . $quantity . "',
        expiration_date = '" . $expiration_date . "',
        updated_by = '" . $user_id . "',
        date_updated_at = '" . $date_updated_at . "'
        WHERE pr_id = '" . $pr_id . "'  ";
                 
        $product_query_run = mysqli_query($conn, $product_query);
        
    }
    if ($inventory_query_run && $archive_query_run && $product_query_run) {
        $res = [
            'status' => 200,
            'msg' => 'Inventory updated successfully.',
        ];
        echo json_encode($res);
    } else {
        $res = [
            'status' => 500,
            'msg' => 'Error inserting records.',
        ];
        echo json_encode($res);
    }
}

?>

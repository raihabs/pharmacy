<?php
require 'config/connect.php';
session_start();

if (isset($_POST['valid_physical_inventory'])) {
    $num_records = count($_POST['in_id']); // Get the number of records submitted

    for ($i = 0; $i < $num_records; $i++) {
        // Sanitize each input field
        $in_id = mysqli_real_escape_string($conn, $_POST['in_id'][$i]);
        $quantity = mysqli_real_escape_string($conn, $_POST['quantity'][$i]);
        $remarks = mysqli_real_escape_string($conn, $_POST['remarks'][$i]);
        $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration_date'][$i]);

        // Validate each set of data (add your own validation rules as needed)

        // Example validation: Check if required fields are empty
        if (empty($in_id) || empty($quantity) || empty($expiration_date) || empty($remarks)) {
            $res = [
                'status' => 400,
                'msg' => 'All fields are required.',
            ];
            echo json_encode($res);
            return;
        }

       


        // Insert the record into the database
        $query = "UPDATE `inventory` SET
        quantity = '" . $quantity . "',
        expiration_date = '" . $expiration_date . "',
        remarks = '". $remarks . "'
        WHERE in_id = '" . $in_id . "' ";
                 
        $query_run = mysqli_query($conn, $query);

        
    }
    if ($query_run) {
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

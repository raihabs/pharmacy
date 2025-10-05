<?php
require '../config/connect.php';



if (isset($_GET['product_edit_id'])) {
    $product_id = $_GET['product_edit_id'];
    $query = "SELECT * FROM product WHERE `pr_id` = '" . $product_id . "' ";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $res = [
        'status' => 200,
        'data' => $data
    ];
    echo json_encode($res);
    return;
}


if (isset($_GET['inventory_edit_id'])) {
    $inventory_id = $_GET['inventory_edit_id'];
    $query = "SELECT p.pr_id as pr_id, p.item_code as item_code,
    COALESCE(i.in_id, 0) AS in_id, COALESCE(i.quantity, 0) AS quantity,
    COALESCE(i.expiration_date, '0000-00-00') AS expiration_date, COALESCE(i.remarks, '') AS remarks 
    FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.in_id = $inventory_id ORDER BY p.pr_id DESC";
    
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $res = [
        'status' => 200,
        'data' => $data
    ];
    echo json_encode($res);
    return;
}


if (isset($_GET['archive_edit_id'])) {
    $archive_id = $_GET['archive_edit_id'];
    $query = "SELECT p.pr_id as pr_id, p.item_code as item_code,
    COALESCE(a.ar_id, 0) AS ar_id, COALESCE(a.quantity, 0) AS quantity,
    COALESCE(a.expiration_date, '0000-00-00') AS expiration_date, COALESCE(a.remarks, '') AS remarks 
    FROM product p LEFT JOIN archive a ON p.pr_id = a.pr_id WHERE a.ar_id = $archive_id ORDER BY p.pr_id DESC ";
    
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $res = [
        'status' => 200,
        'data' => $data
    ];
    echo json_encode($res);
    return;
}

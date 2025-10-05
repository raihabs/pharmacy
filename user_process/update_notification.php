<?php

include '../config/connect.php';

error_reporting(0);
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product ID from the AJAX request
    $productId = intval($_POST['id']);

    // Get the user ID based on session
    if (isset($_SESSION["user_id_inventory_clerk"])) {
        $id = $_SESSION["user_id_inventory_clerk"];
    } else if (isset($_SESSION["user_id_admin"])) {
        $id = $_SESSION["user_id_admin"];
    } else {
        // Handle the case where no user ID is found
        echo json_encode(["status" => "error", "message" => "User ID not found."]);
        exit;
    }

    // Prepare the SQL query to insert into the notification table
    $sql = "INSERT INTO notification (pr_id, status, created_by) VALUES (?, 'TRUE', ?)";
    $stmt = $conn->prepare($sql);

    // Correctly bind parameters: productId is an integer and id is also an integer
    $stmt->bind_param("ii", $productId, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

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

if (isset($_GET['item_code'])) {
    $item_code = $_GET['item_code'];
    $sql = "SELECT * FROM product WHERE item_code = '$item_code'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }
}

$conn->close();
?>

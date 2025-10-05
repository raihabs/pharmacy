<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    // Process the barcode (e.g., save to database, perform a lookup, etc.)
    // For simplicity, we'll just return a message.
    echo "Barcode received: " . htmlspecialchars($code);
} else {
    echo "Invalid request method.";
}
?>

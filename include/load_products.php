<?php
// load_products.php

include '../config/connect.php';

if (isset($_POST['category'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $product_list_query = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category,  p.description, p.sell_price, p.manufacturing_date, p.image,
        COALESCE(i.in_id, 0) AS in_id, COALESCE(i.quantity, 0) AS quantity,
        COALESCE(i.expiration_date, '0000-00-00') AS expiration_date, 
        CASE
            WHEN COALESCE(i.quantity, 0) = 0 THEN 'NEW'
            WHEN COALESCE(i.quantity, 0) >= 30 THEN 'LESS QUANTITY'
            WHEN i.expiration_date IS NOT NULL AND i.expiration_date < DATE_SUB(i.expiration_date, INTERVAL 30 DAY) THEN 'EXPIRE SOON'
            WHEN i.expiration_date IS NOT NULL AND i.expiration_date > CURDATE() THEN 'EXPIRED'
            ELSE 'ACTIVE'
        END AS remarks
        FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id 
        WHERE i.quantity > 30 AND i.remarks = 'ACTIVE' 
        AND p.category = '$category' ORDER BY p.pr_id ASC";

    $product_list_result = mysqli_query($conn, $product_list_query);

    if (mysqli_num_rows($product_list_result) > 0) {
        while ($product = mysqli_fetch_array($product_list_result)) {
            // Output product cards as per your existing HTML structure
            echo '<div class="card-items">';
            // Include product information HTML here based on your existing code
            echo '</div>';
        }
    } else {
        echo '<p>No products found in this category.</p>';
    }
} else {
    echo '<p>Category parameter not set.</p>';
}
?>

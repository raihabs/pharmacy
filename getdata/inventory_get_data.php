<?php
require '../config/connect.php';

    if (isset($_GET['item_codes'])) {
        $item_code = $_GET['item_codes'];
        $sql = "SELECT * FROM product WHERE item_code = '".$item_code."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(null);
        }
    }


    if (isset($_GET['pi_item_codes'])) {
        $initem_code = $_GET['item_codes'];
        $insql = "SELECT * FROM product WHERE item_code = '".$initem_code."'";
        $inresult = $conn->query($insql);

        if ($inresult->num_rows > 0) {
            // Output data of each row
            $inrow = $inresult->fetch_assoc();
            echo json_encode($inrow);
        } else {
            echo json_encode(null);
        }
    }




if (isset($_GET['item_code'])) {
    $item_code = $conn->real_escape_string($_GET['item_code']);

    $sql = "SELECT p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
                    i.in_id as in_id, i.item_code as item_code, i.quantity, i.pi_quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
                    FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.item_code = '".$item_code."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product['quantity'] = 1; // Default quantity
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
}

$conn->close();
?>
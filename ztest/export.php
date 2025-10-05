
<?php
if (isset($_POST['export'])) {
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=product_list.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Start of the Excel file content
    echo "<table border='1'>";
    echo "<tr>
            <th>Product Name</th>
            <th>Image</th>
            <th>Price</th>
          </tr>";

    // Assuming these are your product details (from database or static)
    $products = [
        ['name' => 'Product 1', 'image' => 'C:\xampp\htdocs\pharmacy\brindox.png', 'price' => '$10'],
        ['name' => 'Product 2', 'image' => 'C:\xampp\htdocs\pharmacy\brindox.png', 'price' => '$20']
    ];

    // Loop through the product array to display them in the Excel table
    foreach ($products as $product) {
        echo "<tr>";
        echo "<td>" . $product['name'] . "</td>";
        echo "<td><img src='" . $product['image'] . "' width='50'></td>";
        echo "<td>" . $product['price'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}
?>

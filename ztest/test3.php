<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export HTML Table to Excel</title>
</head>
<body>
    <h2>Product List</h2>
    <table border="1" id="productTable">
        <tr>
            <th>Product Name</th>
            <th>Image</th>
            <th>Price</th>
        </tr>
        <tr>
            <td>Product 1</td>
            <td><img src="brindox.png" alt="Product 1" width="50"></td>
            <td>$10</td>
        </tr>
        <tr>
            <td>Product 2</td>
            <td><img src="brindox.png" alt="Product 2" width="50"></td>
            <td>$20</td>
        </tr>
    </table>
    <br>
    <form action="export.php" method="post">
        <input type="submit" name="export" value="Export to Excel">
    </form>
</body>
</html>
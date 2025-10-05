<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Table</title>
    <style>
        @media print {
            @page {
                margin-top: 120px;
                /* size: auto; */
            }

            body {
                margin: 0cm;
            }

            /* Default header margin for the first page */
            body:first-child header {
                margin-top: 10px;
                margin-bottom: 120px;
            }

            /* Add margin for the second page and beyond */
            body:not(:first-child) {
                margin-top: 10px;
                margin-bottom: 120px;
            }

            table {
                border-collapse: collapse;
                margin-top: 20px;
                /* width: 100%; */
            }

            thead {
                display: table-header-group;
            }

            tbody tr {
                page-break-inside: avoid;
            }

            th,
            td {
                padding: 10px;
                /* Updated padding */
                font-size: 10px;
            }

            th {
                background-color: #f2f2f2;
            }

            /* Hide specific elements when printing */
            .no-print {
                display: none !important;
            }

            /* Hide browser print header and footer */
            body::before,
            body::after {
                content: none !important;
            }

            /* Hide header and footer for print */
            header,
            footer {
                display: none;
            }
        }

        /* Regular table styles */
        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 10px;
            /* Updated padding */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Specific width for Description column */
        .description-column {
            width: 25px !important;
            /* Sets the width for Description column */
        }

        header {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div style="display: flex;justify-content: center;align-items: center;flex-direction: column;height: 100%; text-align: center;left: 25px;">
        <img src="../assets/images/default_images/brindox.png" width='100' height='100' style="border-radius: 50%; border: 0; object-fit: cover;" />
        <h1 style="margin: 0; padding: 0; line-height: 1.8; font-size: 14px; color: blue;">
            Brindox <span style="color: yellow;">Care</span> <span style="color: black;">Pharmacy</span>
        </h1>
        <h1 style="margin: 0;padding: 0;line-height: 1.8;font-size: 14px;color: blue;">
            <span style="color: black;">Contact</span> @brindoxcarepharmacy@gmail.com
        </h1>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Category</th>
                <th>Material Cost</th>
                <th>Sell Price</th>
                <th>manufacturing Date</th>
                <th>Quantity</th>
                <th>Expiration Date</th>
                <th>REMARKS</th>
                <th>OVERALL TOTAL</th>
                <th>STATUS</th>
                <th>Date Created At</th>
                <th>Date Updated At</th>
            </tr>
        </thead>
        <tbody>

            <?php
            include '../config/connect.php';

            error_reporting(0);
            session_start();

            $product_list_query = "SELECT 
    p.pr_id AS pr_id, 
    p.item_code AS product_item_code,  
    p.category, 
    p.description,
    p.material_cost, 
    p.sell_price, 
    p.manufacturing_date, 
    p.image, 
    p.expiration_date, 
    p.date_created_at AS product_date_created_at, 
    i.in_id AS in_id, 
    i.item_code AS inventory_item_code,  
    i.quantity AS inventory_quantity, 
    i.expiration_date AS inventory_expiration_date, 
    i.remarks AS inventory_remarks, 
    i.date_created_at AS inventory_date_created_at, 
    i.date_updated_at AS inventory_date_updated_at,
    s.sa_id AS sa_id, 
    s.sales_code AS sales_code, 
    s.pr_id AS sale_pr_id, 
    s.sell_price AS sale_sell_price, 
    s.quantity AS sale_quantity, 
    SUM(s.quantity) AS total_quantity,  
    s.total AS sale_total, 
    SUM(s.total) AS total_orders, 
    s.status AS sale_status, 
    s.date_created_at AS sale_date_created_at, 
    s.date_updated_at AS sale_date_updated_at,
    (SELECT SUM(s1.total)  -- This will give you the sum of all total sales for all products
     FROM sale s1 
     WHERE s1.sa_id != '') AS total_sales_for_all_products
FROM 
    product p
LEFT JOIN 
    inventory i ON p.pr_id = i.pr_id
LEFT JOIN 
    sale s ON p.pr_id = s.pr_id
WHERE 
    i.quantity > 30  
    AND i.remarks = 'ACTIVE' 
    AND p.date_created_at >= DATE_SUB(CURDATE(), INTERVAL 4 MONTH) 
    AND s.sa_id != ''
GROUP BY 
    p.pr_id
ORDER BY 
    i.pr_id DESC;

";

            $product_list_result = mysqli_query($conn, $product_list_query);

            if (mysqli_num_rows($product_list_result) > 0) {
                while ($product = mysqli_fetch_array($product_list_result)) {


            ?>
                    <tr>
                        <!-- <td><?= $product["pr_id"] ? $product["pr_id"] : '' ?></td> -->

                        <td><?php echo $product["product_item_code"] ?></td>
                        <td><?= $product["category"] ?></td>
                        <td><?= $product["material_cost"] ?></td>
                        <td><?= $product["sell_price"] ?></td>
                        <td><?= $product["manufacturing_date"] ? $product["manufacturing_date"] : '0000-00-00' ?></td>
                        <td><?= $product["inventory_quantity"] ? $product["inventory_quantity"] : '0' ?></td>
                        <td><?= $product["expiration_date"] ? $product["expiration_date"] : '0000-00-00' ?></td>
                        <td><?= $product["inventory_remarks"] ? $product["inventory_remarks"] : $product["inventory_remarks"]  ?></td>
                        <td><?= $product["total_orders"] ?></td>
                        <td><?= $product["sale_status"] ?></td>
                        <td>
                        <?php
                        if ($product["inventory_date_created_at"] != '') {
                            $date_created_at = $product["inventory_date_created_at"];
                            echo date("Y-m-d", strtotime($date_created_at)) ? date("Y-m-d", strtotime($date_created_at)) : '0000-00-00';
                        } else {
                            $date_created_at = '0000-00-00';
                        }
                        ?>
                        </td>
                        <td><?php 
                        if ($product["inventory_date_updated_at"] != '') {
                           $date_updated_at = $product["inventory_date_updated_at"];
                           echo date("g:i:s", strtotime($date_updated_at)) ? date("g:i:s", strtotime($date_updated_at)) : '00:00:00';

                        } else {
                         echo   $date_updated_at = '00:00:00';
                        }
                         ?></td>
                    </tr>
            <?php
                }
            }
            ?>

        </tbody>
    </table>


    <div style="align-items: right;flex-direction: column;height: 100%; text-align: right;right: 25px; padding-top: 50px;">
        <?php
        $user_query = "SELECT * FROM `user` WHERE `user_id` = '" . $_SESSION["user_id_admin"] . "' ORDER BY `user_id` DESC";
        $user_result = mysqli_query($conn, $user_query);
        $user = mysqli_fetch_array($user_result);

        if (is_array($user)) { ?>
            <?php if (empty($user['signature'])) { ?>
                <img src="../assets/images/default_images/Signature.png" width='120' height='120' style="opacity: 50%; border: 0; object-fit: cover;" />
            <?php } else { ?>
                <img src="../assets/images/signature_images/<?php echo $user["signature"]; ?>" width='120' height='120' style="opacity: 50%; border: 0; object-fit: cover;" />
        <?php }
        } ?>
        <h5 style="margin: 0; padding: 0; line-height: 1.8; font-size: 14px; color: black;">
            <span style="color: black;"><?php echo $user["firstname"] ?></span> <span style="color: black;"><?php echo $user["lastname"] ?></span>
        </h5>
        <h1 style="margin: 0;padding: 0;line-height: 1.8;font-size: 14px;color: blue;">
            <span style="color: black; font-weight: 900; border-top: solid 1px #000; width: 200px;">Report Owner By</span>
        </h1>
    </div>

</body>

</html>
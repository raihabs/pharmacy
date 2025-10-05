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
            <th>Date Updated At</th>
            </tr>
        </thead>
        <tbody>

            <?php
            include '../config/connect.php';

            error_reporting(0);
            session_start();

            $product_list_query = "SELECT  p.pr_id as pr_id, p.item_code as item_code, p.category, p.description, p.material_cost, p.sell_price, p.manufacturing_date, p.image, p.expiration_date, p.expiration_date, p.date_created_at, 
            i.in_id as in_id, i.item_code as item_code, i.quantity, i.expiration_date, i.remarks, i.created_by, i.updated_by, i.date_created_at, i.date_updated_at
            FROM product p LEFT JOIN inventory i ON p.pr_id = i.pr_id WHERE i.quantity > 30  AND i.remarks = 'ACTIVE' AND p.date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) ORDER BY i.pr_id DESC";
            $product_list_result = mysqli_query($conn, $product_list_query);

            if (mysqli_num_rows($product_list_result) > 0) {
                while ($product = mysqli_fetch_array($product_list_result)) {


            ?>
                    <tr>
                        <!-- <td><?= $product["pr_id"] ? $product["pr_id"] : '' ?></td> -->

                        <td><?php echo $product["item_code"] ?></td>
                        <td><?= $product["category"] ?></td>
                        <td><?= $product["material_cost"] ?></td>
                        <td><?= $product["sell_price"] ?></td>
                        <td><?= $product["manufacturing_date"] ? $product["manufacturing_date"] : '0000-00-00' ?></td>
                        <td><?= $product["quantity"] ? $product["quantity"] : '0' ?></td>
                        <td><?= $product["expiration_date"] ? $product["expiration_date"] : '0000-00-00' ?></td>
                        <td><?= $product["remarks"] ? $product["remarks"] : $product["remarks"]  ?></td>
                        <?php
                        if ($product["date_updated_at"] != '') {
                            $date_updated_at = $product["date_updated_at"];
                        } else {
                            $date_updated_at = '0000-00-00 00:00:00';
                        }
                        ?>
                        <td><?= $date_updated_at ?></td>
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Table</title>
    <style>
        @media print {
            @page {
                /* margin: 0; */
                margin-top: 120px;
                size: auto;
                /* Removes the page margin */
            }

            body {
                margin: 2cm;
            }

            /* Default header margin for the first page */
            body:first-child header {
                margin: 50px;
            }

            /* Add margin for the second page and beyond */
            body:not(:first-child) {
                margin-top: 10px;
                /* Adjust this value to increase spacing for subsequent pages */
                margin-bottom: 120px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            thead {
                display: table-header-group;
            }

            tbody tr {
                page-break-inside: avoid;
            }

            th,
            td {
                padding: 15px;
                font-size: 12px;
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
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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
        <thead style="justify-content: center;align-items: center;flex-direction: column;">
            <tr>
                <th>Item Code</th>
                <th>Price</th>
                <th>Quantity</th>
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

            $product_list_query = "SELECT s.sa_id, p.pr_id as pr_id, p.item_code as item_code, p.category,  p.image, s.sales_code,s.pr_id, s.sell_price, s.quantity, SUM(s.quantity) AS total_quantity,  s.total, SUM(s.total) AS total_orders, s.status, s.date_created_at, s.date_updated_at
    FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE sa_id != '' GROUP BY s.sales_code ORDER BY s.date_created_at DESC;";
            $product_list_result = mysqli_query($conn, $product_list_query);

            if (mysqli_num_rows($product_list_result) > 0) {
                while ($product = mysqli_fetch_array($product_list_result)) {

            ?>
                    <tr>
                        <!-- <td  style="align-items: left;"><?= $product["pr_id"] ? $product["pr_id"] : '' ?></td> -->

                        <td>
                            <?php
                            $item_code_list_query = "SELECT s.sa_id, p.pr_id as pr_id, p.item_code as item_code, 
                         p.category,  p.image, s.pr_id, s.sell_price, s.status, 
                        s.date_created_at, s.date_updated_at
                        FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE s.sales_code = '" . $product["sales_code"] . "' ORDER BY s.sales_code DESC";
                            $item_code_list_result = mysqli_query($conn, $item_code_list_query);

                            if (mysqli_num_rows($item_code_list_result) > 0) {
                                while ($item = mysqli_fetch_array($item_code_list_result)) { ?>
                                    <?php echo $item["item_code"] ?>
                            <?php   }
                            }
                            ?>
                        </td>
                        <td style="align-items: center; width: 175px;"><?= "₱" . $product["sell_price"] ? $product["sell_price"] : '' ?> PCS </td>
                        <td style="align-items: center; width: 175px;"><?= $product["total_quantity"] ? $product["total_quantity"] : '' ?> PCS </td>
                        <td style="align-items: center; width: 175px;"><?= "₱" . $product["total_orders"] ?></td>
                        <td style="align-items: center; width: 175px;"><?= $product["status"] ? $product["status"] : $product["status"]  ?></td>
                        <td style="align-items: center; width: 175px;"><?= $product["date_created_at"] ? $product["date_created_at"] : '0000-00-00 00:00:00' ?></td>
                        <td style="align-items: center; width: 175px;"><?= $product["date_updated_at"] ? $product["date_updated_at"] : '0000-00-00 00:00:00' ?></td>

                    </tr>


            <?php
                }
            }
            ?>


        </tbody>
    </table>
    <?php
    if($_SESSION["user_id_inventory_clerk"]!=''){
        $uid = $_SESSION["user_id_inventory_clerk"];
    } else{
        $uid = $_SESSION["user_id_cashier"];

    }
    ?>
    <div style="align-items: right;flex-direction: column;height: 100%; text-align: right;right: 25px; top:100px;">
        <?php
        $user_query = "SELECT * FROM `user` WHERE `user_id` = '" . $uid . "' ORDER BY `user_id` DESC";
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
            <span style="color: black;"><?= $user["firstname"] ?></span> <span style="color: black;"><?= $user["lastname"] ?></span>
        </h5>
        <h1 style="margin: 0;padding: 0;line-height: 1.8;font-size: 14px;color: blue;">
            <span style="color: black; font-weight: 900; border-top: solid 1px #000; width: 200px;">Report Owner By</span>
        </h1>
    </div>

    
</body>

</html>
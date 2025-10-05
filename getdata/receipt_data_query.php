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
                <th>Receipt Number</th>
                <th>Item Code</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

            <?php
            include '../config/connect.php';

            error_reporting(0);
            session_start();

            $change_list_query = "SELECT *  FROM receipt ORDER BY re_id DESC;";
            $change_list_result = mysqli_query($conn, $change_list_query);

            if (mysqli_num_rows($change_list_result) > 0) {
                while ($change = mysqli_fetch_array($change_list_result)) {

            ?>
                    <tr>

                        <td style="align-items: center; width: 175px;"><?= $change["sales_code"] ?  $change["sales_code"]  : ''  ?></td>
                        <td style="align-items: center; width: 175px;"><?= $change["item_code"] ?  $change["item_code"]  : ''  ?></td>

                        <td style="align-items: center; width: 175px;"><?= $change["description"] ?  $change["description"]  : ''  ?></td>

                        <td style="align-items: center; width: 175px;"><?= $change["quantity"] ?  $change["quantity"]  : ''  ?></td>
                        <td style="align-items: center; width: 175px;"><?= $change["total_amount"] ?  $change["total_amount"]  : ''  ?></td>
                        <td style="align-items: center; width: 175px;"><?= $change["status"] ?  $change["status"]  : ''  ?></td>


                    </tr>


            <?php
                }
            }
            ?>


        </tbody>
    </table>
    <?php
    if ($_SESSION["user_id_inventory_clerk"] != '') {
        $uid = $_SESSION["user_id_inventory_clerk"];
    } else {
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
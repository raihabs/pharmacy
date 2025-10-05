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
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Birthday</th>
            <th>Role</th>
            <th>Date Created At</th>
            <th>Date Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php

            include '../config/connect.php';

            error_reporting(0);
            session_start();

            $user_list_query = "SELECT * FROM `user` ORDER BY `user_id` DESC";
            $user_list_result = mysqli_query($conn, $user_list_query);

            if (mysqli_num_rows($user_list_result) > 0) {
                while ($row = mysqli_fetch_array($user_list_result)) { ?>
                    <tr>
                        <!-- <td><?php echo $row["user_id"] ?></td> -->
                        <td><?php echo $row["username"] ?></td>
                        <td><?php echo $row["firstname"] ?></td>
                        <td><?php echo $row["lastname"] ?></td>
                        <td><?php echo $row["email"] ?></td>
                        <td><?php echo $row["phone"] ?></td>
                        <td><?php echo $row["address"] ?></td>
                        <td><?php echo $row["birthday"] ?></td>
                        <td><?php echo $row["role"] ?></td>
                        <td><?php echo $row["date_created_at"] ?></td>
                        <td><?php echo $row["date_updated_at"] ?></td>
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
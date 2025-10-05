<?php

include '../config/connect.php';
error_reporting(0);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bar Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        #graph-container {
            width: 60%;
            margin: 0 auto;
            width: 100%;
            height: 400px;
        }

        #reportsTitle {
            display: none;
            /* Initially hidden */
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        #reportsTitle1 {
            display: none;
            /* Initially hidden */
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div id="reportsTitle">
        <div style="margin: 50px 0 50px 0;display: flex;justify-content: center;align-items: center;flex-direction: column;height: 100%; text-align: center;left: 25px;">
            <img src="../assets/images/default_images/brindox.png" width='100' height='100' style="border-radius: 50%; border: 0; object-fit: cover;" />
            <h1 style="margin: 0; padding: 0; line-height: 1.8; font-size: 14px; color: blue;">
                Brindox <span style="color: yellow;">Care</span> <span style="color: black;">Pharmacy</span>
            </h1>
            <h1 style="margin: 0;padding: 0;line-height: 1.8;font-size: 14px;color: blue;">
                <span style="color: black;">Contact</span> @brindoxcarepharmacy@gmail.com
            </h1>
        </div>


        <div class="row">
            <?php

            include '../config/connect.php';

            error_reporting(0);

            $first_week_query = "SELECT 
status,
DATE_FORMAT(date_created_at, '%Y-%U') AS week_year,             -- Year and week number
MIN(DATE_FORMAT(date_created_at, '%M %d, %Y')) AS start_date,    -- Start date of the week (Monday)
MAX(DATE_FORMAT(date_created_at, '%M %d, %Y')) AS end_date,      -- End date of the week (Sunday)
SUM(total) AS weekly_total
FROM 
sale
WHERE 
status = 'RELEASED'
AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY 
YEAR(date_created_at), WEEK(date_created_at, 1)                 -- Group by year and week (mode 1 for Monday start)
ORDER BY  date_created_at ASC";
            $first_week_result = mysqli_query($conn, $first_week_query);

            $first_week = mysqli_fetch_array($first_week_result);

            $last_week_query = "SELECT 
status,
DATE_FORMAT(date_created_at, '%Y-%U') AS week_year,             -- Year and week number
MIN(DATE_FORMAT(date_created_at, '%M %d, %Y')) AS start_date,    -- Start date of the week (Monday)
MAX(DATE_FORMAT(date_created_at, '%M %d, %Y')) AS end_date,      -- End date of the week (Sunday)
SUM(total) AS weekly_total
FROM 
sale
WHERE 
status = 'RELEASED'
AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY 
YEAR(date_created_at), WEEK(date_created_at, 1)                 -- Group by year and week (mode 1 for Monday start)
ORDER BY  date_created_at DESC";
            $last_week_result = mysqli_query($conn, $last_week_query);

            $last_week = mysqli_fetch_array($last_week_result);

            ?>


            <h5 style="font-size: 16px; font-weight: 800; margin:0; text-align: left;">Weekly Business Overview</h5>
            <p class="text-muted">Show overview from <?= $first_week['end_date'] ?> - <?= $last_week['end_date'] ?><a class="text-muted font-weight-medium pl-2" href="../admin/sales.php"><u>See Details</u></a>
            </p>
        </div>

    </div> <!-- Hidden Title -->
    <div id="graph-container">
        <canvas id="barGraph"></canvas>
    </div>
    <div id="reportsTitle1">
        <div class="row">
            <div class="col-sm-8">
                <p class="text-muted mb-0" style="font-size: 14px; font-weight: 800; margin: 30px 0 20px 0; text-align: left;"> This report will return the sum of the total for each month in the past 12 months, including the current month.
                </p>
            </div>

            <div class="col-sm-4">

                <p class="mb-0 text-muted" style="font-size: 16px; font-weight: 800; margin:0; text-align: left;">Sales Revenue</p>

                <?php

                $total_sales_query = "SELECT SUM(total) FROM sale 
                  WHERE  status = 'RELEASED' AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                  AND date_created_at <= LAST_DAY(CURDATE())
                  ORDER BY date_created_at DESC";

                $total_sales_result = mysqli_query($conn, $total_sales_query);
                $total_sales = mysqli_fetch_array($total_sales_result);
                ?>
                <h5 class="d-inline-block survey-value mb-0" style="font-size: 14px; font-weight: 800; margin: 0; text-align: left;">₱<?= $total_sales['SUM(total)'] ? $total_sales['SUM(total)'] : '0' ?>.<span class="h5">00</span></h5>

                <p class="d-inline-block text-danger mb-0" style="font-size: 14px; font-weight: 800; margin:0; text-align: left;"> last 3 months </p>

            </div>

        </div>
        <div style="align-items: right;flex-direction: column;height: 100%; text-align: right;right: 25px; padding-top: 20px;">
            <?php

            if (isset($_SESSION["user_id_admin"])) {
                $id = $_SESSION["user_id_admin"];
            } else {
                $id = $_SESSION["user_id_inventory_clerk"];
            }

            $user_query = "SELECT * FROM `user` WHERE `user_id` = '" . $id . "' ORDER BY `user_id` DESC";
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
    </div> <!-- Hidden Title -->
    <?php

    $bar_query = "SELECT 
    status,
    DATE_FORMAT(date_created_at, '%Y-%U') AS week_year,             -- Year and week number
    MIN(DATE_FORMAT(date_created_at, '%M %d %y')) AS start_date,    -- Start date of the week (Monday)
    MAX(DATE_FORMAT(date_created_at, '%M %d %y')) AS end_date,      -- End date of the week (Sunday)
    SUM(total) AS weekly_total
FROM 
    sale
WHERE 
    status = 'RELEASED'
    AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY 
    YEAR(date_created_at), WEEK(date_created_at, 1)                 -- Group by year and week (mode 1 for Monday start)
ORDER BY  date_created_at ASC";
    $bar_result = mysqli_query($conn, $bar_query);

    $total_query = "SELECT 
    status,
    DATE_FORMAT(date_created_at, '%Y-%U') AS week_year,             -- Year and week number
    MIN(DATE_FORMAT(date_created_at, '%M %d %y')) AS start_date,    -- Start date of the week (Monday)
    MAX(DATE_FORMAT(date_created_at, '%M %d %y')) AS end_date,      -- End date of the week (Sunday)
    SUM(total) AS weekly_total
FROM 
    sale
WHERE 
    status = 'RELEASED'
    AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY 
    YEAR(date_created_at), WEEK(date_created_at, 1)                 -- Group by year and week (mode 1 for Monday start)
ORDER BY  date_created_at DESC";
    $total_result = mysqli_query($conn, $total_query);
    ?>

    <script>
        const ctx = document.getElementById('barGraph').getContext('2d');
        const barGraph = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php
                    if (mysqli_num_rows($bar_result) > 0) {
                        $count = 0; // Initialize count before the loop
                        while ($month_row = mysqli_fetch_array($bar_result)) {
                            $count++; // Increment the count
                            echo "'Week " . $count . "'";
                            if (mysqli_num_rows($bar_result) > $count) echo ","; // Add a comma if not the last element
                        }
                    }
                    ?>
                ],

                datasets: [{
                    label: 'Current Sales',
                    barPercentage: 0.10,
                    barThickness: 40,
                    maxBarThickness: 300,
                    minBarLength: 5,
                    data: [<?php if (mysqli_num_rows($total_result) > 0) {
                                while ($total_row = mysqli_fetch_array($total_result)) {
                                    echo $total_row['weekly_total'] . ",";
                                }
                            } ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(54, 162, 235)', 'rgb(153, 102, 255)', 'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session
$id = $_SESSION["user_id_inventory_clerk"];

$sessionId = $id;

$valid_user = "SELECT * FROM `user` WHERE `user_id` = '" . $sessionId . "' && `role` != 'Inventory Clerk'";
$check_user = mysqli_query($conn, $valid_user);

if (!isset($sessionId) || mysqli_num_rows($check_user) < 0) {
    header("Location: ../usersignin/signin.php");
    session_destroy();
} else

    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user` WHERE `user_id` = $sessionId"));

include "../include/user_meta_tag.php";
include "../include/user_top.php";
?>

<title>User Account</title>
<style>
    /* Alternative for input container */
    /* use this instead if custom */
    .group-item {
        display: flex;
        flex-direction: column;
        /* overflow-x: scroll !important; */
        overflow-x: scroll !important;
        overflow-y: scroll !important;
    }

    /* Alternative for input group */
    /* use this instead if custom */
    .input-item {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
    }

    .input-item input,
    .input-item select {
        flex: 1;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin: 5px;
    }

    .input-item button {
        margin-left: 10px;
        padding: 10px 10px;
        font-size: 16px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 120px;
    }

    .input-item #add-btn {
        margin-left: 10px;
        padding: 10px 10px;
        font-size: 16px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 120px;
    }

    .input-item button:hover {
        background-color: #45a049;
    }

    .input-item button.remove-btn {
        background-color: #f44336;
    }

    .input-item button.remove-btn:hover {
        background-color: #e53935;
    }

    @media print {
        @page {
            margin: 0;
            size: auto;
        }

        body {
            margin: 5cm;
        }

    }

    /* Specific width for Description column */
    .description-column {
        width: 25px !important;
        /* Sets the width for Description column */
    }

    header {
        margin-bottom: 30px;
    }

    /* iframe {
        width: 100%;
        height: 500px;
        border: none;
        display: none;
        /* Initially hide the iframe */
    /* } */

    iframe {
        width: 100%;
        border: none;
        height: 500px;
        /* Match the iframe height */
        overflow-x: hidden;
        overflow-y: hidden;
        /* Hide scrollbars */
        display: none;
        /* display: flex; */
        /* Optional: center the iframe */
        /* justify-content: center; */
        /* Optional: center the iframe */
        /* align-items: center; */
        /* Optional: center the iframe */
    }
</style>
</head>

<body>

    <?php include "../include/user_loader.php"; ?>

    <div class="container-scroller">
        <?php include "../include/inventory_clerk_sidebar.php"; ?>

        <div class="container-fluid page-body-wrapper">
            <div id="theme-settings" class="settings-panel">
                <i class="settings-close mdi mdi-close"></i>
                <!-- <p class="settings-heading">SIDEBAR SKINS</p> -->
                <div class="sidebar-bg-options selected" id="sidebar-default-theme">
                    <div class="img-ss rounded-circle bg-light border mr-3"></div>
                </div>
                <div class="sidebar-bg-options" id="sidebar-dark-theme">
                    <div class="img-ss rounded-circle bg-dark border mr-3"></div>
                </div>
                <!-- <p class="settings-heading mt-2">HEADER SKINS</p> -->
                <div class="color-tiles mx-0 px-4">
                    <div class="tiles light"></div>
                    <div class="tiles dark"></div>
                </div>
            </div>

            <?php include "../include/inventory_clerk_header.php"; ?>


            <div class="main-panel">
                <div class="content-wrapper pb-0">

                    <div class="page-header">
                        <h3 class="page-title">Sales Report</h3>
                        <?php include "../include/user_breadcrumb.php"; ?>
                        <div class="page-header flex-wrap">
                            <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span>
                            </h3>
                            <div class="d-flex">

                                <select id="sort" name="sort" class="btn btn-sm bg-white btn-icon-text border">
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>


                                <a href="../admin/reports.php">
                                    <button type="button" class="btn btn-sm bg-white btn-icon-text border">
                                        <i class="mdi mdi-refresh btn-icon-prepend"></i>Refresh
                                    </button>
                                </a>

                                <button type="button" class="btn btn-sm bg-white btn-icon-text ml-3" onclick="printGraph()" id="printButton">
                                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                                </button>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 stretch-card grid-margin">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <h5 id="first_title">Weekly Business Overview</h5>
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
                                                <p class="text-muted" id="title_date">Show overview from <?= $first_week['end_date'] ?> - <?= $last_week['end_date'] ?><a class="text-muted font-weight-medium pl-2" href="../inventory_clerk/sales.php"><u>See Details</u></a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col-sm-12">
                                                <div class="flot-chart-wrapper">
                                                    <!-- Hidden iframe that loads user_print.php -->
                                                    <iframe id="graphIframe" src="../getdata/report_data_weekly_query_print.php"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <p class="text-muted mb-0" id="date_paragraph">This report will return the sum of the total for each week in the past three months, including the current week.
                                                </p>
                                            </div>


                                            <div class="col-sm-4">

                                                <p class="mb-0 text-muted">Sales Revenue</p>

                                                <?php

                                                $total_sales_query = "SELECT SUM(weekly_total) AS total_weekly_total
FROM (
    SELECT 
        status,
        DATE_FORMAT(date_created_at, '%Y-%U') AS week_year,
        MIN(DATE_FORMAT(date_created_at, '%M %d, %Y')) AS start_date,
        MAX(DATE_FORMAT(date_created_at, '%M %d, %Y')) AS end_date,
        SUM(total) AS weekly_total
    FROM 
        sale
    WHERE 
        status = 'RELEASED'
        AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
    GROUP BY 
        YEAR(date_created_at), WEEK(date_created_at, 1)
) AS weekly_totals;
";

                                                $total_sales_result = mysqli_query($conn, $total_sales_query);
                                                $total_sales = mysqli_fetch_array($total_sales_result);
                                                ?>


                                                <h5 class="d-inline-block survey-value mb-0" id="total_num">₱ <?= $total_sales['total_weekly_total'] ? $total_sales['total_weekly_total'] : '0'  ?>.<span class="h5">00</span></h5>

                                                <p class="d-inline-block text-danger mb-0" id="total_title"> last 3 months </p>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <?php include "../include/user_footer.php"; ?>
                </div>



            </div>
            <!-- container-scroller -->

            <?php include '../include/user_bottom.php'; ?>
            <?php include '../user_process/user_process.php'; ?>




            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

            <script>
                function updateIframeSource() {
                    const selectElement = document.getElementById('sort');
                    const iframeElement = document.getElementById('graphIframe');
                    const first_title = document.getElementById('first_title');
                    const selectedValue = selectElement.value;

                    // This report will return the sum of the total for each month in the past six months, including the current month.
                    <?php
                    $first_month_query = "SELECT status,
   DATE_FORMAT(date_created_at, '%M %Y') AS month_year, date_created_at,
   SUM(total) AS monthly_total
   FROM 
   sale
   WHERE status = 'RELEASED' AND
   date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
   GROUP BY 
   DATE_FORMAT(date_created_at, '%M  %Y')
   ORDER BY 
   date_created_at DESC";
                    $first_month_result = mysqli_query($conn, $first_month_query);

                    $first_month = mysqli_fetch_array($first_month_result);

                    $last_month_query = "SELECT status,
   DATE_FORMAT(date_created_at, '%M %Y') AS month_year, date_created_at,
   SUM(total) AS monthly_total
   FROM 
   sale
   WHERE status = 'RELEASED' AND
   date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
   GROUP BY 
   DATE_FORMAT(date_created_at, '%M  %Y')
   ORDER BY 
   date_created_at ASC";
                    $last_month_result = mysqli_query($conn, $last_month_query);

                    $last_month = mysqli_fetch_array($last_month_result);



                    $total_sales_month_query = "SELECT SUM(monthly_total) AS total_monthly_total
                    FROM (
                       SELECT status,
   DATE_FORMAT(date_created_at, '%M %Y') AS month_year, date_created_at,
   SUM(total) AS monthly_total
   FROM 
   sale
   WHERE status = 'RELEASED' AND
   date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
   GROUP BY 
   DATE_FORMAT(date_created_at, '%M  %Y')
                    ) AS monthly_totals;
                    ";

                    $total_sales_month_result = mysqli_query($conn, $total_sales_month_query);
                    $total_sales_month = mysqli_fetch_array($total_sales_month_result);

                    $first_year_query = "SELECT 
    DATE_FORMAT(date_created_at, '%Y') AS month_year,  -- Format to get year and month
    SUM(total) AS yearly_total                             -- Sum of total for each month
FROM 
    sale
WHERE 
    status = 'RELEASED'                                   -- Filter for released sales
GROUP BY 
    YEAR(date_created_at)        -- Group by year and month
ORDER BY 
    YEAR(date_created_at) DESC;       -- Order by year and month";
                    $first_year_result = mysqli_query($conn, $first_year_query);

                    $first_year = mysqli_fetch_array($first_year_result);

                    $last_year_query = "SELECT 
    DATE_FORMAT(date_created_at, '%Y') AS month_year,  -- Format to get year and month
    SUM(total) AS yearly_total                             -- Sum of total for each month
FROM 
    sale
WHERE 
    status = 'RELEASED'                                   -- Filter for released sales
GROUP BY 
    YEAR(date_created_at)        -- Group by year and month
ORDER BY 
    YEAR(date_created_at) ASC";
                    $last_year_result = mysqli_query($conn, $last_year_query);

                    $last_year = mysqli_fetch_array($last_year_result);


                    $total_sales_yearly_query = "SELECT SUM(yearly_total) AS total_yearly_total
                    FROM (
                       SELECT 
    DATE_FORMAT(date_created_at, '%Y') AS month_year,  -- Format to get year and month
    SUM(total) AS yearly_total                             -- Sum of total for each month
FROM 
    sale
WHERE 
    status = 'RELEASED'                                   -- Filter for released sales
GROUP BY 
    YEAR(date_created_at)
                    ) AS monthly_totals;
                    ";

                    $total_sales_year_result = mysqli_query($conn, $total_sales_yearly_query);
                    $total_sales_year = mysqli_fetch_array($total_sales_year_result);
                    ?>



                    // Change iframe source based on selected value
                    if (selectedValue === 'Weekly') {
                        iframeElement.src = '../getdata/report_data_weekly_query_print.php';
                        document.getElementById('first_title').textContent = 'Weekly Business Overview';
                        document.getElementById('title_date').textContent = 'Show overview from <?= $first_week['end_date'] ?> - <?= $last_week['end_date'] ?> See Details';
                        document.getElementById('date_paragraph').textContent = 'This report will return the sum of the total for each week in the past three months, including the current week.';
                        document.getElementById('total_num').textContent = '₱ <?= $total_sales['total_weekly_total'] ? $total_sales['total_weekly_total'] : '0'  ?>.00';
                        document.getElementById('total_title').textContent = ' last 3 months ';

                    } else if (selectedValue === 'Monthly') {
                        iframeElement.src = '../getdata/report_data_monthly_query_print.php';
                        document.getElementById('first_title').textContent = 'Monthly Business Overview';
                        document.getElementById('title_date').textContent = 'Show overview from <?= $first_month['month_year'] ?> - <?= $last_month['month_year'] ?> <?= $last_month['year_now'] ?> See Details';
                        document.getElementById('date_paragraph').textContent = ' This report will return the sum of the total for each month in the past twelve months, including the current month.';
                        document.getElementById('total_num').textContent = '₱ <?= $total_sales_month['total_monthly_total'] ? $total_sales_month['total_monthly_total'] : '0'  ?>.00';
                        document.getElementById('total_title').textContent = ' last 12 months ';

                    } else if (selectedValue === 'Yearly') {
                        iframeElement.src = '../getdata/report_data_yearly_query_print.php';
                        document.getElementById('first_title').textContent = 'Yearly Business Overview';
                        document.getElementById('title_date').textContent = 'Show overview from <?= $last_year['month_year'] ?> - <?= $first_year['month_year'] ?> <?= $last_year['year_now'] ?> See Details';
                        document.getElementById('date_paragraph').textContent = ' This report will return the sum of the total for each year in the past six years, including the current year.';
                        document.getElementById('total_num').textContent = '₱ <?= $total_sales_year['total_yearly_total'] ? $total_sales_year['total_yearly_total'] : '0'  ?>.00';
                        document.getElementById('total_title').textContent = ' last 6 years ';

                    }
                    iframeElement.style.width = '60%'; // Set width as needed
                    iframeElement.style.height = '500px'; // Set height as needed
                    iframeElement.style.border = 'none';
                    iframeElement.style.margin = '0';
                    iframeElement.style.overflow = 'hidden'; // Hide scrollbars
                }

                // Add event listener on page load
                document.addEventListener('DOMContentLoaded', function() {
                    const selectElement = document.getElementById('sort');
                    selectElement.addEventListener('change', updateIframeSource);
                });
            </script>

            <script>
                function printGraph() {
                    var iframe = document.getElementById('graphIframe');
                    var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;

                    // Unhide the title before printing

                    var title = iframeDocument.getElementById('reportsTitle');
                    var title1 = iframeDocument.getElementById('reportsTitle1');

                    if (title && title1) {
                        title.style.display = 'block';
                        title1.style.display = 'block';
                    }

                    iframe.contentWindow.print();

                    // Hide the title again after printing
                    if (title && title1) {
                        title.style.display = 'none';
                        title1.style.display = 'none';
                    }


                }

                // Optionally show the iframe when the page loads
                window.onload = function() {
                    var iframe = document.getElementById('graphIframe');
                    iframe.style.display = 'block'; // Show the iframe
                };
            </script>


            <?php

            $bar_query = "SELECT 
CONCAT('Week ', @row_number := @row_number + 1) AS count,  -- Row number for each result with prefix
status,
DATE_FORMAT(date_created_at, '%Y-%U') AS week_year,        -- Year and week number
MIN(DATE_FORMAT(date_created_at, '%M %d %y')) AS start_date,  -- Start date of the week (Monday)
MAX(DATE_FORMAT(date_created_at, '%M %d %y')) AS end_date,    -- End date of the week (Sunday)
SUM(total) AS weekly_total
FROM 
sale,
(SELECT @row_number := 0) AS rn                             -- Initialize row number variable
WHERE 
status = 'RELEASED'
AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY 
YEAR(date_created_at), WEEK(date_created_at, 1)            -- Group by year and week (mode 1 for Monday start)
ORDER BY 
MIN(date_created_at) ASC";
            $bar_result = mysqli_query($conn, $bar_query);

            $total_query = "SELECT 
CONCAT('Week ', @row_number := @row_number + 1) AS count,  -- Row number for each result with prefix
status,
DATE_FORMAT(date_created_at, '%Y-%U') AS week_year,        -- Year and week number
MIN(DATE_FORMAT(date_created_at, '%M %d %y')) AS start_date,  -- Start date of the week (Monday)
MAX(DATE_FORMAT(date_created_at, '%M %d %y')) AS end_date,    -- End date of the week (Sunday)
SUM(total) AS weekly_total
FROM 
sale,
(SELECT @row_number := 0) AS rn                             -- Initialize row number variable
WHERE 
status = 'RELEASED'
AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY 
YEAR(date_created_at), WEEK(date_created_at, 1)            -- Group by year and week (mode 1 for Monday start)
ORDER BY 
count DESC";
            $total_result = mysqli_query($conn, $total_query);
            ?>

            <script>
                const ctx = document.getElementById('barGraph').getContext('2d');
                const barGraph = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [<?php if (mysqli_num_rows($bar_result) > 0) {
                                        while ($month_row = mysqli_fetch_array($bar_result)) {
                                            echo "'" . $month_row['count'] . "',";
                                        }
                                    } ?>],
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
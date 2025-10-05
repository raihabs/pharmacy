<div class="main-panel">
  <div class="content-wrapper pb-0">

    <div class="page-header">
      <h3 class="page-title">Dashboard</h3>
      <?php include "../include/user_breadcrumb.php"; ?>

      <div class="row">
        <div class="col-xl-4 col-lg-4 grid-margin">



        <!-- <div class="col-xl-4 col-lg-4 grid-margin">
          <div class="card bg-success">
            <div class="card-body px-3 py-3">
              <div class="d-flex justify-content-between align-items-start">
                <div class="color-card">
                  <p class="mb-0 color-card-head">Total Near to Expire</p>
                  <?php
                  $expire_query = "SELECT COUNT(*) as current_month_expire, remarks
              FROM inventory
              WHERE remarks = 'EXPIRE SOON' AND date_created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND date_created_at < DATE_FORMAT(CURDATE() + INTERVAL 14 DAY, '%Y-%m-01')";
                  $expire_result = mysqli_query($conn, $expire_query);
                  $expire = mysqli_fetch_array($expire_result);
                  ?>
                  <h2 class="text-white"><?= $expire['current_month_expire']  ?> <span class="h5">PCS</span>
                  </h2>
                </div>
                <i class="card-icon-indicator mdi mdi-account-circle bg-inverse-icon-success"></i>
              </div>


              <?php

              // Calculate the number of products added in the current month
              $current_month_expire_query = "SELECT COUNT(*) as current_month_expire, remarks
              FROM archive
              WHERE remarks = 'EXPIRE SOON' AND date_created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND date_created_at < DATE_FORMAT(CURDATE() + INTERVAL 14 DAY, '%Y-%m-01')";

              $current_month_expire_result = mysqli_query($conn, $current_month_expire_query);
              $current_month_expire_row = mysqli_fetch_assoc($current_month_expire_result);
              $current_month_expire = $current_month_expire_row['current_month_expire'];


              // Calculate the number of products added in the last month
              $last_month_expire_query = "SELECT COUNT(*) as last_month_expire, remarks
              FROM archive
              WHERE remarks = 'EXPIRE SOON' AND 
              date_created_at <= DATE_FORMAT(CURDATE() - INTERVAL 14 DAY, '%Y-%m-01')
              AND date_created_at > DATE_FORMAT(CURDATE(), '%Y-%m-01')";

              $last_month_expire_result = mysqli_query($conn, $last_month_expire_query);
              $last_month_expire_row = mysqli_fetch_assoc($last_month_expire_result);
              $last_month_expire = $last_month_expire_row['last_month_expire'];


              // Calculate the number of products added in the last month
              $this_year_expire_query = "SELECT COUNT(*) as year_expire_total, remarks
              FROM archive
              WHERE remarks = 'EXPIRE SOON' AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
              AND date_created_at <= LAST_DAY(CURDATE())
              ORDER BY date_created_at DESC";

              $this_year_expire_result = mysqli_query($conn, $this_year_expire_query);
              $this_year_expire_row = mysqli_fetch_assoc($this_year_expire_result);
              $this_year_expire = $this_year_expire_row['year_expire_total'];

              ?>
              <h6 class="text-white">
                <?php
                // Calculate the percentage change
                if ($last_month_expire > 0) {
                  $percentage_change_expire   = (($current_month_expire + $last_month_expire) / $this_year_expire) * 100;

                  $formatted_percentage_expire = number_format($percentage_change_expire, 2);
                  echo "Percentage near to expire products: " . $formatted_percentage_expire . "%";
                } else {
                  echo "No products added ";
                }

                ?> since last month</h6>
            </div>
          </div>
        </div> -->


      </div>





      <div class="row">
        <div class="col-xl-12 col-lg-12 stretch-card grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-7">


                  <h5 id="first_title">Daily Business Overview</h5>
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
AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
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
AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
GROUP BY 
YEAR(date_created_at), WEEK(date_created_at, 1)                 -- Group by year and week (mode 1 for Monday start)
ORDER BY  date_created_at DESC";
                  $last_week_result = mysqli_query($conn, $last_week_query);

                  $last_week = mysqli_fetch_array($last_week_result);


                  ?>
                  <p class="text-muted" id="title_date">Show overview from <?= $first_week['end_date'] ?> - <?= $last_week['end_date'] ?><a class="text-muted font-weight-medium pl-2" href="../admin/sales.php"><u>See Details</u></a>
                  </p>

                  <select id="sort" name="sort" class="btn btn-sm bg-white btn-icon-text border">
                    <option value="Daily">Daily</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                  </select>
                </div>
              </div>
              <div class="row my-3">
                <div class="col-sm-12">
                  <div class="flot-chart-wrapper">
                    <iframe id="graphIframe" src="../getdata/report_data_daily_query_print.php"></iframe>

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-8">
                  <p class="text-muted mb-0" id="date_paragraph">This report will return the sum of the total for each week in the past 14 days, including the current week.
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
        AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY)
    GROUP BY 
        YEAR(date_created_at), WEEK(date_created_at, 1)
) AS weekly_totals;
";

                  $total_sales_result = mysqli_query($conn, $total_sales_query);
                  $total_sales = mysqli_fetch_array($total_sales_result);

                  ?>
                  <h5 class="d-inline-block survey-value mb-0" id="total_num">₱ <?= $total_sales['total_weekly_total'] ? $total_sales['total_weekly_total'] : '0'  ?>.<span class="h5">00</span></h5>

                  <p class="d-inline-block text-danger mb-0" id="total_title"> last 14 DAYs </p>


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
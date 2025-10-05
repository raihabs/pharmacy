<div class="main-panel">
  <div class="content-wrapper pb-0">

    <div class="page-header">
      <h3 class="page-title">Dashboard</h3>
      <?php include "../include/user_breadcrumb.php"; ?>

      <div class="row">
        <div class="col-xl-4 col-lg-4 grid-margin">


          <div class="card bg-warning">
            <div class="card-body px-3 py-3">
              <div class="d-flex justify-content-between align-items-start">
                <div class="color-card">
                  <p class="mb-0 color-card-head">Total Products</p>
                  <?php $all_products_query = "SELECT  COUNT(*), date_created_at FROM product 
                  WHERE date_created_at >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01') 
                  AND date_created_at < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')";

                  $all_products_result = mysqli_query($conn, $all_products_query);
                  $row = mysqli_fetch_array($all_products_result);

                  ?>
                  <h2 class="text-white"> <?php echo $row["COUNT(*)"] ?><span class="h5"> PCS</span>
                  </h2>
                </div>
                <i class="card-icon-indicator mdi mdi-basket bg-inverse-icon-warning"></i>
              </div>
              <?php

              // Calculate the number of products added in the current month
              $current_month_product_query = "SELECT COUNT(*) AS current_month_products, date_created_at
              FROM product
              WHERE date_created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND date_created_at < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')";
              $current_month_product_result = mysqli_query($conn, $current_month_product_query);
              $current_month_product_row = mysqli_fetch_assoc($current_month_product_result);
              $current_month_products = $current_month_product_row['current_month_products'];

              // Calculate the number of products added in the last month
              $last_month_product_query = "SELECT COUNT(*) AS last_month_products, date_created_at
              FROM product
              WHERE date_created_at >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01')
              AND date_created_at < DATE_FORMAT(CURDATE(), '%Y-%m-01')";
              $last_month_product_result = mysqli_query($conn, $last_month_product_query);
              $last_month_product_row = mysqli_fetch_assoc($last_month_product_result);
              $last_month_products = $last_month_product_row['last_month_products'];
              // Calculate the number of products added in the last month


              $this_year_product_query = "SELECT COUNT(*) AS this_year_product, date_created_at
   FROM product
   WHERE date_created_at >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
   AND date_created_at <= LAST_DAY(CURDATE()) 
   ORDER BY date_created_at DESC";

              $this_year_product_result = mysqli_query($conn, $this_year_product_query);
              $this_year_product_row = mysqli_fetch_assoc($this_year_product_result);
              $this_year_product = $this_year_product_row['this_year_product'];



              ?>

              <h6 class="text-white">
                <?php
                // Calculate the percentage change
                if ($last_month_products > 0) {
                  $percentage_change_product   = (($current_month_products + $last_month_products) / $this_year_product) * 100;

                  $formatted_percentage_product = number_format($percentage_change_product, 2);
                  echo "Percentage added in products: " . $formatted_percentage_product . "%";
                } else {
                  echo "No products added ";
                }

                ?> since last month</h6>
            </div>
          </div>
        </div>

        <div class="col-xl-4 col-lg-4 grid-margin">
          <div class="card bg-primary">
            <div class="card-body px-3 py-3">
              <div class="d-flex justify-content-between align-items-start">
                <div class="color-card">
                  <p class="mb-0 color-card-head">Total Sales</p>
                  <?php
                  $total_query = "SELECT SUM(total) FROM sale 
                  WHERE  status = 'RELEASED' AND date_created_at >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01') 
                  AND date_created_at < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')";
                  $total_result = mysqli_query($conn, $total_query);
                  $total = mysqli_fetch_array($total_result);
                  ?>
                  <h2 class="text-white">₱<?= $total['SUM(total)'] ? $total['SUM(total)'] : '0' ?>.<span class="h5">00</span>
                  </h2>
                </div>
                <i class="card-icon-indicator mdi mdi-briefcase-outline bg-inverse-icon-primary"></i>
              </div>
              <?php

              // Calculate the number of products added in the current month
              $current_month_sales_query = "SELECT SUM(total) AS current_month_sales, status
              FROM sale
              WHERE status = 'RELEASED' AND date_created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND date_created_at < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')";
              $current_month_sales_result = mysqli_query($conn, $current_month_sales_query);
              $current_month_sales_row = mysqli_fetch_assoc($current_month_sales_result);
              $current_month_sales = $current_month_sales_row['current_month_sales'];

              // Calculate the number of products added in the last month
              $last_month_sales_query = "SELECT SUM(total) AS last_month_sales
              FROM sale
              WHERE status = 'RELEASED' AND date_created_at >= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01')
              AND date_created_at < DATE_FORMAT(CURDATE(), '%Y-%m-01') ";
              $last_month_sales_result = mysqli_query($conn, $last_month_sales_query);
              $last_month_sales_row = mysqli_fetch_assoc($last_month_sales_result);
              $last_month_sales = $last_month_sales_row['last_month_sales'];

              // Calculate the number of products added in the last month
              $this_year_sales_query = "SELECT SUM(total) AS year_sales_total
              FROM sale
              WHERE status = 'RELEASED' AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
              AND date_created_at <= LAST_DAY(CURDATE()) 
              ORDER BY date_created_at DESC";

              $this_year_sales_result = mysqli_query($conn, $this_year_sales_query);
              $this_year_sales_row = mysqli_fetch_assoc($this_year_sales_result);
              $this_year_sales = $this_year_sales_row['year_sales_total'];

              ?>
              <h6 class="text-white">
                <?php
                // Calculate the percentage change
                if ($last_month_sales > 0) {
                  $percentage_change_sales   = (($current_month_sales + $last_month_sales) / $this_year_sales) * 100;

                  $formatted_percentage_sales = number_format($percentage_change_sales, 2);
                  echo "Percentage added in sales: " . $formatted_percentage_sales . "%";
                } else {
                  echo "No products added ";
                }

                ?> since last month</h6>
            </div>
          </div>
        </div>

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
              AND date_created_at < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')";
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
              AND date_created_at < DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')";

              $current_month_expire_result = mysqli_query($conn, $current_month_expire_query);
              $current_month_expire_row = mysqli_fetch_assoc($current_month_expire_result);
              $current_month_expire = $current_month_expire_row['current_month_expire'];


              // Calculate the number of products added in the last month
              $last_month_expire_query = "SELECT COUNT(*) as last_month_expire, remarks
              FROM archive
              WHERE remarks = 'EXPIRE SOON' AND 
              date_created_at <= DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m-01')
              AND date_created_at > DATE_FORMAT(CURDATE(), '%Y-%m-01')";

              $last_month_expire_result = mysqli_query($conn, $last_month_expire_query);
              $last_month_expire_row = mysqli_fetch_assoc($last_month_expire_result);
              $last_month_expire = $last_month_expire_row['last_month_expire'];


              // Calculate the number of products added in the last month
              $this_year_expire_query = "SELECT COUNT(*) as year_expire_total, remarks
              FROM archive
              WHERE remarks = 'EXPIRE SOON' AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
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
                  <p class="text-muted" id="title_date">Show overview from <?= $first_week['end_date'] ?> - <?= $last_week['end_date'] ?><a class="text-muted font-weight-medium pl-2" href="../admin/sales.php"><u>See Details</u></a>
                  </p>

                  <select id="sort" name="sort" class="btn btn-sm bg-white btn-icon-text border">
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                  </select>
                </div>
              </div>
              <div class="row my-3">
                <div class="col-sm-12">
                  <div class="flot-chart-wrapper">
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
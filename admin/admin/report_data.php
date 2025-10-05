<div class="row">
  <div class="col-xl-12 col-lg-12 stretch-card grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-7">
            <h5>Business Overview</h5>
            <?php
            $first_month_query = "SELECT DATE_FORMAT(date_created_at, '%M') AS month_year, date_created_at, SUM(total) AS monthly_total FROM sale WHERE  date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) GROUP BY DATE_FORMAT(date_created_at, '%M') ORDER BY  date_created_at DESC";
            $first_month_result = mysqli_query($conn, $first_month_query);

            $first_month = mysqli_fetch_array($first_month_result);

            $last_month_query = "SELECT DATE_FORMAT(date_created_at, '%M') AS month_year, date_created_at, SUM(total) AS monthly_total FROM sale WHERE  date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) GROUP BY DATE_FORMAT(date_created_at, '%M') ORDER BY  date_created_at ASC";
            $last_month_result = mysqli_query($conn, $last_month_query);

            $last_month = mysqli_fetch_array($last_month_result);

            ?>
            <p class="text-muted"> Show overview jan <?= $last_month['month_year'] ?>-<?= $first_month['month_year'] ?> <?= $last_month['year_now'] ?> <a class="text-muted font-weight-medium pl-2" href="../admin/sales.php"><u>See Details</u></a>
            </p>
          </div>
        </div>
        <div class="row my-3">
          <div class="col-sm-12">
            <div class="flot-chart-wrapper">
              <canvas id="myChart"></canvas>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-8">
            <p class="text-muted mb-0"> This report will return the sum of the total for each month in the past six months, including the current month.
            </p>
          </div>


          <div class="col-sm-4">

            <p class="mb-0 text-muted">Sales Revenue</p>

            <?php

            $total_sales_query = "SELECT SUM(total), status FROM sale 
                  WHERE  status = 'RELEASED' AND date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
                  AND date_created_at <= LAST_DAY(CURDATE())
                  ORDER BY date_created_at DESC";

            $total_sales_result = mysqli_query($conn, $total_sales_query);
            $total_sales = mysqli_fetch_array($total_sales_result);
            ?>
            <h5 class="d-inline-block survey-value mb-0">₱<?= $total_sales['SUM(total)'] ? $total_sales['SUM(total)'] : '0' ?>.<span class="h5">00</span></h5>

            <p class="d-inline-block text-danger mb-0"> last 12 months </p>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
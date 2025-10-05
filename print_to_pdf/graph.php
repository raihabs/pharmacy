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
            width: 40%;
            margin: 0 auto;
            align-items: left;
        }
    </style>
</head>

<body>
    <div id="graph-container">
        <canvas id="barGraph"></canvas>
    </div>

    <?php
    $bar_query = "SELECT status,
    DATE_FORMAT(date_created_at, '%M') AS month_year,
    SUM(total) AS monthly_total
    FROM 
    sale
    WHERE status = 'RELEASED' AND
    date_created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY 
    DATE_FORMAT(date_created_at, '%M')
    ORDER BY 
    month_year";

    $bar_result = mysqli_query($conn, $bar_query);

    $total_query = "SELECT status,
  DATE_FORMAT(date_created_at, '%Y-%m') AS month_year,
  SUM(total) AS monthly_total
  FROM 
  sale
  WHERE status = 'RELEASED' AND
  date_created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
  GROUP BY 
  DATE_FORMAT(date_created_at, '%Y-%m')
  ORDER BY 
  month_year";
    $total_result = mysqli_query($conn, $total_query);
    ?>

    <script>
        const ctx = document.getElementById('barGraph').getContext('2d');

        const barGraph = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php
                            if (mysqli_num_rows($bar_result) > 0) {
                                while ($month_row = mysqli_fetch_array($bar_result)) {
                                    echo "'" . $month_row['month_year'] . "',";
                                }
                            }
                            ?>],
                datasets: [{
                barPercentage: 0.10,
                barThickness: 40,
                maxBarThickness: 300,
                minBarLength: 5,
                label: 'Current Sales',
                    data: [
                        <?php
                        if (mysqli_num_rows($total_result) > 0) {
                            while ($total_row = mysqli_fetch_array($total_result)) {
                                echo $total_row['monthly_total'] . ",";
                            }
                        }
                        ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Content Example with DataTables</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body>

    <div class="container">
        <div class="button-container mt-3">
            <button id="activeButton" class="btn active-button">Active</button>
            <button id="archiveButton" class="btn ml-3">Archive</button>
        </div>

        <div id="contentContainer" class="mt-4">
            <!-- Active content by default -->
            <div class="row" id="activeContent">
                <div class="col-lg-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Active Accounts</h4>
                            <p class="card-description">List of active accounts.</p>
                            <div class="table-responsive">
                                <!-- Including PHP file for active accounts -->
                                <?php include "../admin/account_data_active.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Archive content, initially hidden -->
            <div class="row" id="archiveContent" style="display: none;">
                <div class="col-lg-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Archived Accounts</h4>
                            <p class="card-description">List of archived accounts.</p>
                            <div class="table-responsive">
                                <!-- Including PHP file for archived accounts -->
                                <?php include "../admin/account_data_archive.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable for both Active and Archive sections only once
            $('#activeContent .table-responsive table').DataTable();
            $('#archiveContent .table-responsive table').DataTable();

            // Add click event for the Active button
            $('#activeButton').click(function() {
                $('#archiveContent').hide();
                $('#activeContent').show();

                $('#activeButton').addClass('active-button');
                $('#archiveButton').removeClass('active-button');
            });

            // Add click event for the Archive button
            $('#archiveButton').click(function() {
                $('#activeContent').hide();
                $('#archiveContent').show();

                $('#archiveButton').addClass('active-button');
                $('#activeButton').removeClass('active-button');

            });

            function initializeDataTable(selector) {
                // Destroy existing table instances to avoid conflicts
                if ($.fn.DataTable.isDataTable(selector)) {
                    $(selector).DataTable().clear().destroy();
                }
                // Initialize DataTables on the visible table
                $(selector).DataTable({
                    // DataTables options
                });
            }

            // Initial DataTable setup
            initializeDataTable('#activeContent .table-responsive table');
        });
    </script>

</body>

</html>
<?php
include '../config/connect.php';



// Add User Product
if (isset($_POST['valid_product'])) {

    $item_code = mysqli_real_escape_string($conn, $_POST['item_code']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $batch_no = mysqli_real_escape_string($conn, $_POST['batch_no']);
    $lot_no = mysqli_real_escape_string($conn, $_POST['lot_no']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $material_cost = mysqli_real_escape_string($conn, $_POST['material_cost']);
    $sell_price = mysqli_real_escape_string($conn, $_POST['sell_price']);

    $p_quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration_date']);




    $manufacturing_date = mysqli_real_escape_string($conn, $_POST['manufacturing_date']);

    $sql_product = "SELECT `item_code` FROM `product` WHERE `item_code` = '" . $item_code . "' ";
    $res_product = mysqli_query($conn, $sql_product);

    function validateManufactureDate($manufacturing_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $manufacturing_date)) {
            // Parse the date into components
            $dateComponents = explode('-', $manufacturing_date);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateManufactureDateYear($manufacturing_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $manufacturing_date)) {

            // Get today's date as a DateTime object
            $today = new DateTime();

            // Calculate the date 5 years ago from today
            $five_years_ago = new DateTime('-5 years');

            // Example date to check (you can replace this with any date you want to check)
            $date_to_check_str = $manufacturing_date;  // Example date to check
            $date_to_check = new DateTime($date_to_check_str);

            //  2021-07-03 <= 2020-07-03 - 2021-07-02 || 2020-07-03 <= 2024-07-03 = 2024-07-04
            if ($date_to_check >= $five_years_ago && $date_to_check <= $today) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }



    function validateDate($expiration_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {
            // Parse the date into components
            $dateComponents = explode('-', $expiration_date);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateDateYear($expiration_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {

            // Get today's date as a DateTime object
            $today = new DateTime();

            // Calculate the date 5 years from apart from today
            $five_years_apart = new DateTime('+5 years');
            $five_years_ago = new DateTime('-5 years');

            // Example date to check (you can replace this with any date you want to check)
            $date_to_check_str = $expiration_date;  // Example date to check
            $date_to_check = new DateTime($date_to_check_str);

            //  2021-07-03 <= 2024-07-05 - 2021-07-02 && 2021-07-03 <= 2029-07-05 = 2024-07-04
            if ($date_to_check >= $five_years_ago && $date_to_check <= $five_years_apart) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }


    date_default_timezone_set('Asia/Manila');
    $date_created_at = date("Y-m-d g:i:s");

    if ($item_code == "" || $description == "" || $batch_no == "" || $lot_no == "" || $brand == "" || $material_cost == "" || $sell_price == "" || $manufacturing_date == "" || $p_quantity == "" || $expiration_date == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.' . $material_cost,
        ];
        echo json_encode($res);
        return;
    } else if ($category == "Select Category Option") {
        $res = [
            'status' => 400,
            'msg' => 'Choose other Category Option.',
        ];
        echo json_encode($res);
        return;
    } else if (mysqli_num_rows($res_product) > 0) {
        $res = [
            'status' => 400,
            'msg' => 'The ' . $item_code . ' product is already exist.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateManufactureDate($manufacturing_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid manufacturing date format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateManufactureDateYear($manufacturing_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid manufacturing format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!is_numeric($sell_price)) {
        $res = [
            'status' => 400,
            'msg' => 'Input must be a non-decimal numeric value.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateDate($expiration_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid expiration format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateDateYear($expiration_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid expiration format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!is_numeric($p_quantity)) {
        $res = [
            'status' => 400,
            'msg' => 'Input Quantity must be a non-decimal numeric value.',
        ];
        echo json_encode($res);
        return;
    } else if ($p_quantity <= 0) {
        $res = [
            'status' => 400,
            'msg' => 'Input Quantity must be a numeric value.',
        ];
        echo json_encode($res);
        return;
    } else if ($material_cost <= 0) {
        $res = [
            'status' => 400,
            'msg' => 'Input Material Cost must be a numeric value.',
        ];
        echo json_encode($res);
        return;
    } else if ($sell_price <= 0) {
        $res = [
            'status' => 400,
            'msg' => 'Input Sell Price must be a numeric value.',
        ];
        echo json_encode($res);
        return;
    } else {
        if (!strpos($material_cost, '.') !== false && !strpos($sell_price, '.') !== false) {
            $material_cost = $material_cost . ".00";
            $sell_price = $sell_price . ".00";
        } else {
            $material_cost;
            $sell_price;
        }
        // pr_id, item_code,  category, material_cost, sell_price,manufacturing_date, date_created_at, date_updated_at

        $query_add_product = "INSERT INTO `product` (`item_code`,  `description`,  `batch_no`,  `lot_no`,  `category`, `brand`, `material_cost`, `sell_price`, `manufacturing_date`, `p_quantity`, `expiration_date`, `date_created_at`) VALUE ('$item_code',  '$description', '$batch_no', '$lot_no', '$category', '$brand', $material_cost, $sell_price, '$manufacturing_date', '$p_quantity', '$expiration_date', '$date_created_at')";
        $query_add_product_run = mysqli_query($conn, $query_add_product);

        $today = new DateTime();
        $thirty_days_later = new DateTime('+30 days');
        $date_to_check = new DateTime($expiration_date);

        if ($p_quantity == 0 && $date_to_check > $thirty_days_later) {
            $remarks = 'NO QUANTITY';
        } else if ($p_quantity <= 30 && $date_to_check > $thirty_days_later) {
            $remarks = 'LOW QUANTITY';
        } else if ($p_quantity > 30 && $date_to_check <= $today || $p_quantity <= 30 && $date_to_check <= $today) {
            $remarks = 'EXPIRED';
        } else if ($p_quantity > 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today || $p_quantity <= 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today) {
            $remarks = 'EXPIRE SOON';
        } else {
            $remarks = 'ACTIVE';
        }


        $sql_check_inventory = "SELECT `pr_id`, `item_code` FROM `product` WHERE `item_code` = '" . $item_code . "' ";
        $res_check_inventory = mysqli_query($conn, $sql_check_inventory);
        $product = mysqli_fetch_array($res_check_inventory);
        $pr_id = $product['pr_id'];

        $query_archive = "INSERT INTO `archive` (`pr_id`, `item_code`, `sell_price`,  `quantity`, `expiration_date`, `remarks`,  `date_created_at`) VALUE ('$pr_id', '$item_code', $sell_price, '$p_quantity', '$expiration_date',  'NEW',  '$date_created_at')";
        $query_run_archive_run = mysqli_query($conn, $query_archive);

        if ($query_add_product_run && $query_run_archive_run) {
            $res = [
                'status' => 200,
                'msg' => 'Product Submit Successfully! ',
            ];

            echo json_encode($res);
            return;
            $url = '../admin/product.php';
            header('Location: ' . $url);
        }
    }
}



// Update User Product
if (isset($_POST['update_product'])) {
    $pr_id = $_POST['pr_id'];

    $item_code = mysqli_real_escape_string($conn, $_POST['item_code']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $batch_no = mysqli_real_escape_string($conn, $_POST['batch_no']);
    $lot_no = mysqli_real_escape_string($conn, $_POST['lot_no']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);

    $material_cost = mysqli_real_escape_string($conn, $_POST['material_cost']);
    $sell_price = mysqli_real_escape_string($conn, $_POST['sell_price']);

    $p_quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration_date']);

    if (!strpos($material_cost, '.') !== false && !strpos($sell_price, '.') !== false) {
        $material_cost = $material_cost . ".00";
        $sell_price = $sell_price . ".00";
    } else {
        $material_cost;
        $sell_price;
    }

    $manufacturing_date = mysqli_real_escape_string($conn, $_POST['manufacturing_date']);

    // $sell_price = isset($_POST['sell_price']) ? floatval($_POST['sell_price']) : 0.0;
    // $manufacturing_date =  $_POST['manufacturing_date'];

    $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `product` WHERE `pr_id` = $pr_id"));

    $query_update_product = "SELECT * FROM `product` 
    WHERE `item_code` = '" . $product['item_code'] . "' AND `item_code` = '" . $item_code . "'
    AND `description` = '" . $product['description'] . "' AND `description` = '" . $description . "' 
    AND `batch_no` = '" . $product['batch_no'] . "' AND `batch_no` = '" . $batch_no . "' 
    AND `lot_no` = '" . $product['lot_no'] . "' AND `lot_no` = '" . $lot_no . "' 
    AND `category` = '" . $product['category'] . "' AND `category` = '" . $category . "' 
    AND `brand` = '" . $product['brand'] . "' AND `brand` = '" . $brand . "' 
    AND `material_cost` = '" . $product['material_cost'] . "' AND `material_cost` = '" . $material_cost . "' 
    AND `sell_price` = '" . $product['sell_price'] . "' AND `sell_price` = '" . $sell_price . "' 
    AND `manufacturing_date` = '" . $product['manufacturing_date'] . "' AND `manufacturing_date` = '" . $manufacturing_date . "'
    AND `p_quantity` = '" . $product['p_quantity'] . "' AND `p_quantity` = '" . $p_quantity . "'
    AND `expiration_date` = '" . $product['expiration_date'] . "' AND `expiration_date` = '" . $expiration_date . "'
    ";
    $result_update_product = mysqli_query($conn, $query_update_product);

    function validateManufactureDate($manufacturing_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $manufacturing_date)) {
            // Parse the date into components
            $dateComponents = explode('-', $manufacturing_date);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateManufactureDateYear($manufacturing_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $manufacturing_date)) {

            // Get today's date as a DateTime object
            $today = new DateTime();

            // Calculate the date 5 years ago from today
            $five_years_ago = new DateTime('-5 years');

            // Example date to check (you can replace this with any date you want to check)
            $date_to_check_str = $manufacturing_date;  // Example date to check
            $date_to_check = new DateTime($date_to_check_str);

            //  2021-07-03 <= 2020-07-03 - 2021-07-02 || 2020-07-03 <= 2024-07-03 = 2024-07-04
            if ($date_to_check >= $five_years_ago && $date_to_check <= $today) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateExpirationDate($expiration_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {
            // Parse the date into components
            $dateComponents = explode('-', $expiration_date);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateExpirationDateYear($expiration_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {

            // Get today's date as a DateTime object
            $today = new DateTime();

            // Calculate the date 5 years from apart from today
            $five_years_apart = new DateTime('+5 years');
            $five_years_ago = new DateTime('-5 years');

            // Example date to check (you can replace this with any date you want to check)
            $date_to_check_str = $expiration_date;  // Example date to check
            $date_to_check = new DateTime($date_to_check_str);

            //  2021-07-03 <= 2024-07-05 - 2021-07-02 && 2021-07-03 <= 2029-07-05 = 2024-07-04
            if ($date_to_check >= $five_years_ago && $date_to_check <= $five_years_apart) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }



    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d g:i:s");

    if ($item_code == "" || $description == "" || $category == "" || $brand == "" || $material_cost == "" || $sell_price == "" || $manufacturing_date == "" || $p_quantity == "" || $expiration_date == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.' . $manufacturing_date,
        ];
        echo json_encode($res);
        return;
    } else if (mysqli_num_rows($result_update_product) > 0) {
        $res = [
            'status' => 400,
            'msg' => 'There\'s no changes in data field.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateManufactureDate($manufacturing_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid manufacturing format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateManufactureDateYear($manufacturing_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid manufacturing format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!is_numeric($sell_price)) {
        $res = [
            'status' => 400,
            'msg' => 'Input must be a non-decimal numeric value.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateExpirationDate($expiration_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid expiration format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateExpirationDateYear($expiration_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid expiration format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!is_numeric($p_quantity)) {
        $res = [
            'status' => 400,
            'msg' => 'Input Quantity must be a non-decimal numeric value.',
        ];
        echo json_encode($res);
        return;
    } else {

        $query_upd_product = "UPDATE `product` 
        SET `item_code` = '" . $item_code . "',
        `description` = '" . $description . "',
        `batch_no` = '" . $batch_no . "',
        `lot_no` = '" . $lot_no . "',
        `category` = '" . $category . "',
        `brand` = '" . $brand . "', 
        `material_cost` = '" . $material_cost . "', 
        `sell_price` = '" . $sell_price . "', 
        `manufacturing_date` = '" . $manufacturing_date . "', 
        `p_quantity` = '" . $p_quantity . "', 
        `expiration_date` = '" . $expiration_date . "', 
        `date_updated_at` = '" . $date_updated_at . "' 
        WHERE `pr_id` = '" . $pr_id . "'  ";
        $query_run_upd_product = mysqli_query($conn, $query_upd_product);



        $today = new DateTime();
        $thirty_days_later = new DateTime('+30 days');
        $date_to_check = new DateTime($expiration_date);



        if ($p_quantity == 0 && $date_to_check > $thirty_days_later) {
            $remarks = 'NO QUANTITY';
        } else if ($p_quantity <= 30 && $date_to_check > $thirty_days_later) {
            $remarks = 'LOW QUANTITY';
        } else if ($p_quantity > 30 && $date_to_check <= $today || $p_quantity <= 30 && $date_to_check <= $today) {
            $remarks = 'EXPIRED';
        } else if ($p_quantity > 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today || $p_quantity <= 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today) {
            $remarks = 'EXPIRE SOON';
        } else {
            $remarks = 'ACTIVE';
        }

        $sql_check_product = "SELECT * FROM `product` WHERE `pr_id` = $pr_id ";
        $res_check_product = mysqli_query($conn, $sql_check_product);
        $product = mysqli_fetch_array($res_check_product);

        $sql_check_archived  = "SELECT `pr_id`, `remarks` FROM `archive` WHERE `pr_id` = '" . $pr_id . "' AND `remarks` != 'NEW' ";
        $res_check_archived = mysqli_query($conn, $sql_check_archived);

        $sql_check_inventory = "SELECT * FROM `inventory` 
        WHERE (`item_code` = '$item_code' AND remarks = 'ACTIVE') 
        OR (`item_code` = '$item_code' AND remarks = 'LOW QUANTITY') 
        OR (`item_code` = '$item_code' AND remarks = 'EXPIRED SOON') 
        OR (`item_code` = '$item_code' AND remarks = 'NO QUANTITY')  
        OR (`item_code` = '$item_code' AND remarks = 'EXPIRED')";
        $res_check_inventory = mysqli_query($conn, $sql_check_inventory);
        $inventory = mysqli_fetch_array($res_check_inventory);


        if (mysqli_num_rows($res_check_inventory) > 0) {
            $query_inventory = "UPDATE `inventory` 
            SET `pr_id` = '" . $pr_id . "',
            `item_code` = '" . $item_code . "',
            `sell_price` = '" . $sell_price . "', 
            `quantity` = '" . $p_quantity . "',
            `expiration_date` = '" . $expiration_date . "',
            `remarks` = '" . $remarks . "',
            `created_by` = '" . $product['created_by'] . "',
            `date_created_at` = '" . $product['date_created_at'] . "',
            `date_updated_at` = '" . $date_updated_at . "'
            WHERE `pr_id` = '" . $pr_id . "' AND `remarks` = '" . $inventory['remarks'] . "' ";
            $query_run_inventory_run = mysqli_query($conn, $query_inventory);
        } else {
        }



        $sql_check_archive = "SELECT * FROM `archive` 
         WHERE (`item_code` = '$item_code' AND remarks = 'ACTIVE') 
        OR (`item_code` = '$item_code' AND remarks = 'LOW QUANTITY') 
        OR (`item_code` = '$item_code' AND remarks = 'EXPIRED SOON') 
        OR (`item_code` = '$item_code' AND remarks = 'NO QUANTITY')  
        OR (`item_code` = '$item_code' AND remarks = 'EXPIRED')";
        $res_check_archive = mysqli_query($conn, $sql_check_archive);
        $archive = mysqli_fetch_array($res_check_archive);


        if (mysqli_num_rows($res_check_archive) > 0) {
            $query_archive = "UPDATE `archive` 
            SET `pr_id` = '" . $pr_id . "',
            `item_code` = '" . $item_code . "',
            `batch_no` = '" . $batch_no . "',
            `lot_no` = '" . $lot_no . "',
            `sell_price` = '" . $sell_price . "', 
            `quantity` = '" . $p_quantity . "',
            `expiration_date` = '" . $expiration_date . "',
            `remarks` = '" . $remarks . "',
            `created_by` = '" . $product['created_by'] . "',
            `date_created_at` = '" . $product['date_created_at'] . "',
            `date_updated_at` = '" . $date_updated_at . "'
            WHERE `pr_id` = '" . $pr_id . "' AND `remarks` = '" . $archive['remarks'] . "' ";
        } else {
            $query_archive = "INSERT INTO `archive` (`pr_id`, `item_code`, `sell_price`,  `quantity`, `expiration_date`, `remarks`,  `updated_by`, `date_created_at`, `date_updated_at`) VALUE ('$pr_id', '$item_code',  '$sell_price', '$p_quantity', '$expiration_date',  '$remarks',  '" . $product['created_by'] . "', '" . $product['date_created_at'] . "', '$date_updated_at')";
        }
        $query_run_archive_run = mysqli_query($conn, $query_archive);

        if ($query_run_upd_product && $query_run_archive_run) {
            $res = [
                'status' => 200,
                'msg' => 'Product Updated Successfully!',
            ];
            echo json_encode($res);
            return;
        }
    }
}





// Add Product in Inventory
if (isset($_POST['update_inventory'])) {
    $pr_id = $_POST['pr_id'];

    $old_remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $item_code = mysqli_real_escape_string($conn, $_POST['item_code']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration_date']);


    $sql_check_inventory = "SELECT `pr_id` FROM `inventory` WHERE `pr_id` = '" . $pr_id . "' ";
    $res_check_inventory = mysqli_query($conn, $sql_check_inventory);

    if (mysqli_num_rows($res_check_inventory) != 0) {
        $inventory = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `inventory` WHERE `pr_id` = $pr_id "));

        $sql_check_inventory = "SELECT * FROM `inventory` 
        WHERE `pr_id` = '" . $inventory['pr_id'] . "' AND `pr_id` = '" . $pr_id . "'
        AND `quantity` = '" . $inventory['quantity'] . "' AND `quantity` = '" . $quantity . "' 
        AND `expiration_date` = '" . $inventory['expiration_date'] . "' AND `expiration_date` = '" . $expiration_date . "' 
        AND `remarks` = '" . $inventory['remarks'] . "' AND `remarks` = '" . $old_remarks . "' 
        ";
        $res_check_inventory = mysqli_query($conn, $sql_check_inventory);

        if (mysqli_num_rows($res_check_inventory) > 0) {
            $res = [
                'status' => 400,
                'msg' => 'There\'s no changes in data field.',
            ];
            echo json_encode($res);
            return;
        }
    }



    function validateDate($expiration_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {
            // Parse the date into components
            $dateComponents = explode('-', $expiration_date);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateDateYear($expiration_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {

            // Get today's date as a DateTime object
            $today = new DateTime();

            // Calculate the date 5 years from apart from today
            $five_years_apart = new DateTime('+5 years');
            $five_years_ago = new DateTime('-5 years');

            // Example date to check (you can replace this with any date you want to check)
            $date_to_check_str = $expiration_date;  // Example date to check
            $date_to_check = new DateTime($date_to_check_str);

            //  2021-07-03 <= 2024-07-05 - 2021-07-02 && 2021-07-03 <= 2029-07-05 = 2024-07-04
            if ($date_to_check >= $five_years_ago && $date_to_check <= $five_years_apart) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d g:i:s");

    if ($quantity == "" || $expiration_date == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateDate($expiration_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid expiration format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateDateYear($expiration_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid expiration format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!is_numeric($quantity)) {
        $res = [
            'status' => 400,
            'msg' => 'Input Quantity must be a non-decimal numeric value.',
        ];
        echo json_encode($res);
        return;
    } else {

        $today = new DateTime();

        $thirty_days_later = new DateTime('+30 days');

        // Convert expiration date string to a DateTime object        
        $date_to_check = new DateTime($expiration_date);




        if ($quantity == 0 && $date_to_check > $thirty_days_later) {
            $remarks = 'NO QUANTITY';
        } else if ($quantity <= 30 && $date_to_check > $thirty_days_later) {
            $remarks = 'LOW QUANTITY';
        } else if ($quantity > 30 && $date_to_check <= $today || $quantity <= 30 && $date_to_check <= $today) {
            $remarks = 'EXPIRED';
        } else if ($quantity > 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today || $quantity <= 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today) {
            $remarks = 'EXPIRE SOON';
        } else {
            $remarks = 'ACTIVE';
        }


        $sql_check_product = "SELECT * FROM `product` WHERE `pr_id` = $pr_id ";
        $res_check_product = mysqli_query($conn, $sql_check_product);
        $product = mysqli_fetch_array($res_check_product);

        $query_archive = "UPDATE `archive` 
        SET `pr_id` = '" . $pr_id . "',
        `item_code` = '" . $item_code . "',
        `sell_price` = '" . $product['sell_price'] . "', 
        `quantity` = '" . $quantity . "',
        `expiration_date` = '" . $expiration_date . "',
        `remarks` = '" . $remarks . "',
        `created_by` = '" . $product['created_by'] . "',
        `date_created_at` = '" . $product['date_created_at'] . "',
        `date_updated_at` = '" . $date_updated_at . "'
        WHERE `pr_id` = '" . $pr_id . "' AND `remarks` = '" . $old_remarks . "' ";
        $query_run_archive_run = mysqli_query($conn, $query_archive);


        $query_inventory = "UPDATE `inventory` 
        SET `pr_id` = '" . $pr_id . "',
        `item_code` = '" . $item_code . "',
        `sell_price` = '" . $product['sell_price'] . "', 
        `quantity` = '" . $quantity . "',
        `expiration_date` = '" . $expiration_date . "',
        `remarks` = '" . $remarks . "',
        `created_by` = '" . $product['created_by'] . "',
        `date_created_at` = '" . $product['date_created_at'] . "',
        `date_updated_at` = '" . $date_updated_at . "'
        WHERE `pr_id` = '" . $pr_id . "' AND `remarks` = '" . $old_remarks . "' ";
        $query_run_inventory_run = mysqli_query($conn, $query_inventory);

        $query_product = "UPDATE `product` 
            SET `pr_id` = '" . $pr_id . "',
            `expiration_date` = '" . $expiration_date . "',
            `p_quantity` = '" . $quantity . "',
            `date_updated_at` = '" . $date_updated_at . "'
            WHERE `pr_id` = '" . $pr_id . "'  ";
        $query_run_product = mysqli_query($conn, $query_product);



        if ($query_run_inventory_run && $query_run_archive_run && $query_run_product) {
            $res = [
                'status' => 200,
                'msg' => 'Product Updated Successfully! ',
            ];
            echo json_encode($res);
            return;
            $url = '../admin/inventory.php';
            header('Location: ' . $url);
        }
    }
}

if (isset($_POST['update_archive'])) {
    $pr_id = $_POST['pr_id'];

    $old_remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $item_code = mysqli_real_escape_string($conn, $_POST['item_code']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $expiration_date = mysqli_real_escape_string($conn, $_POST['expiration_date']);


    $sql_check_archive = "SELECT `pr_id` FROM `archive` WHERE `pr_id` = '" . $pr_id . "' ";
    $res_check_archive = mysqli_query($conn, $sql_check_archive);

    if (mysqli_num_rows($res_check_archive) != 0) {
        $archive_show = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `archive` WHERE `pr_id` = $pr_id "));

        $sql_check_archive = "SELECT * FROM `archive` 
        WHERE `pr_id` = '" . $archive_show['pr_id'] . "' AND `pr_id` = '" . $pr_id . "'
        AND `quantity` = '" . $archive_show['quantity'] . "' AND `quantity` = '" . $quantity . "' 
        AND `expiration_date` = '" . $archive_show['expiration_date'] . "' AND `expiration_date` = '" . $expiration_date . "' 
        AND `remarks` = '" . $archive_show['remarks'] . "' AND `remarks` = '" . $old_remarks . "' 
        ";
        $res_check_archive = mysqli_query($conn, $sql_check_archive);

        if (mysqli_num_rows($res_check_archive) > 0) {
            $res = [
                'status' => 400,
                'msg' => 'There\'s no changes in data field.',
            ];
            echo json_encode($res);
            return;
        }
    }



    function validateDate($expiration_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {
            // Parse the date into components
            $dateComponents = explode('-', $expiration_date);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateDateYear($expiration_date)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $expiration_date)) {

            // Get today's date as a DateTime object
            $today = new DateTime();

            // Calculate the date 5 years from apart from today
            $five_years_apart = new DateTime('+5 years');
            $five_years_ago = new DateTime('-5 years');

            // Example date to check (you can replace this with any date you want to check)
            $date_to_check_str = $expiration_date;  // Example date to check
            $date_to_check = new DateTime($date_to_check_str);

            //  2021-07-03 <= 2024-07-05 - 2021-07-02 && 2021-07-03 <= 2029-07-05 = 2024-07-04
            if ($date_to_check >= $five_years_ago && $date_to_check <= $five_years_apart) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d g:i:s");

    if ($quantity == "" || $expiration_date == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateDate($expiration_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid expiration format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!validateDateYear($expiration_date)) {
        $res = [
            'status' => 400,
            'msg' => 'Invalid expiration format or date.',
        ];
        echo json_encode($res);
        return;
    } else if (!is_numeric($quantity)) {
        $res = [
            'status' => 400,
            'msg' => 'Input Quantity must be a non-decimal numeric value.',
        ];
        echo json_encode($res);
        return;
    } else {

        $today = new DateTime();

        $thirty_days_later = new DateTime('+30 days');

        // Convert expiration date string to a DateTime object        
        $date_to_check = new DateTime($expiration_date);


        if ($quantity == 0 && $date_to_check > $thirty_days_later) {
            $remarks = 'NO QUANTITY';
        } else if ($quantity <= 30 && $date_to_check > $thirty_days_later) {
            $remarks = 'LOW QUANTITY';
        } else if ($quantity > 30 && $date_to_check <= $today || $quantity <= 30 && $date_to_check <= $today) {
            $remarks = 'EXPIRED';
        } else if ($quantity > 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today || $quantity <= 30 && $date_to_check <= $thirty_days_later && $date_to_check > $today) {
            $remarks = 'EXPIRE SOON';
        } else {
            $remarks = 'ACTIVE';
        }




        $sql_check_product = "SELECT * FROM `product` WHERE `pr_id` = $pr_id ";
        $res_check_product = mysqli_query($conn, $sql_check_product);
        $product = mysqli_fetch_array($res_check_product);

        $query_archive = "UPDATE `archive` 
        SET `pr_id` = '" . $pr_id . "',
        `item_code` = '" . $item_code . "',
        `sell_price` = '" . $product['sell_price'] . "', 
        `quantity` = '" . $quantity . "',
        `expiration_date` = '" . $expiration_date . "',
        `remarks` = '" . $remarks . "',
        `created_by` = '" . $product['created_by'] . "',
        `date_created_at` = '" . $product['date_created_at'] . "',
        `date_updated_at` = '" . $date_updated_at . "'
        WHERE `pr_id` = '" . $pr_id . "' AND `remarks` = '" . $old_remarks . "' ";
        $query_run_archive_run = mysqli_query($conn, $query_archive);


        $query_inventory = "UPDATE `inventory` 
        SET `pr_id` = '" . $pr_id . "',
        `item_code` = '" . $item_code . "',
        `sell_price` = '" . $product['sell_price'] . "', 
        `quantity` = '" . $quantity . "',
        `expiration_date` = '" . $expiration_date . "',
        `remarks` = '" . $remarks . "',
        `created_by` = '" . $product['created_by'] . "',
        `date_created_at` = '" . $product['date_created_at'] . "',
        `date_updated_at` = '" . $date_updated_at . "'
        WHERE `pr_id` = '" . $pr_id . "' AND `remarks` = '" . $old_remarks . "' ";
        $query_run_inventory_run = mysqli_query($conn, $query_inventory);

        $query_product = "UPDATE `product` 
            SET `expiration_date` = '" . $expiration_date . "',
            `p_quantity` = '" . $quantity . "',
            `date_updated_at` = '" . $date_updated_at . "'
            WHERE `pr_id` = '" . $pr_id . "'  ";
        $query_run_product = mysqli_query($conn, $query_product);


        if ($query_run_archive_run && $query_run_inventory_run && $query_run_product) {
            $res = [
                'status' => 200,
                'msg' => 'Product Updated Successfully! ',
            ];
            echo json_encode($res);
            return;
            $url = '../admin/inventory.php';
            header('Location: ' . $url);
        }
    }
}





if (isset($_FILES["image"]["name"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];

    $imageName = $_FILES["image"]["name"];
    $imageSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    // Image validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));

    if (!in_array($imageExtension, $validImageExtension)) {  ?>

        <script>
            Swal.fire({
                    icon: 'warning',
                    title: 'Something Went Wrong.',
                    text: 'Invalid Extensions, Use: JPG, JPEG, PNG, SVG',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/product.php';
                });
        </script>

    <?php } else if ($imageSize > 1200000) { ?>

        <script>
            Swal.fire({
                    icon: 'warning',
                    title: 'Something Went Wrong.',
                    text: 'Please Dont Use High Image Size',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/product.php';
                });
        </script>

    <?php } else {

        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `product` WHERE `pr_id` = $id"));

        unlink('../assets/images/product_images/' . $product["image"]);

        $newImageName = $name . " - " . date("Y.m.d") . " - " . date("h.i.sa"); // Generate new image name

        $newImageName = $newImageName . '.' . $imageExtension;
        $query = "UPDATE product  SET `image` = '$newImageName' WHERE `pr_id` = $id ";

        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, '../assets/images/product_images/' . $newImageName);

    ?>

        <script>
            Swal.fire({
                    icon: 'success',
                    title: 'SUCCESS',
                    text: 'Successfully Change Product Image',
                    timer: 9000
                })
                .then(function() {
                    document.location.href = '../admin/product.php';
                });
        </script>

<?php  }
}


if (isset($_POST['add_sale'])) {
    // Initialize input arrays with default values
    $pr_ids = $_POST['pr_id'] ?? [];
    $item_codes = $_POST['item_code'] ?? [];
    $sell_prices = $_POST['sell_price'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    $enter_stocks = $_POST['enterstock'] ?? [];
    $totals = $_POST['total'] ?? [];
    $full_names = $_POST['full_name'] ?? [];
    $id_nos = $_POST['id_no'] ?? [];
    $addresses = $_POST['address'] ?? [];
    $discounts = $_POST['discount'] ?? [];

    // Validate if required data exists
    if (empty($pr_ids)) {
        $res = ['status' => 400, 'msg' => 'No items provided for sale.'];
        echo json_encode($res);
        return;
    }

    // Generate a single `combinedVariable` for the sale transaction
    $currentYear = date("Y");
    $randomLetter = chr(rand(65, 90));
    $randomNumber = rand(100, 999);
    $combinedVariable = $currentYear . $randomLetter . $randomNumber;


    // Iterate through items
    for ($i = 0; $i < count($item_codes); $i++) {
        // // Validate all required array indexes
        // if (
        //     !isset( $full_names[$i], )
        // ) {
        //     $res = ['status' => 400, 'msg' => "Incomplete data for item at index $i."];
        //     echo json_encode($res);
        //     return;
        // }

        // Escape inputs to prevent SQL injection
        $pr_id = $conn->real_escape_string($pr_ids[$i]) ?? '';
        $item_code = $conn->real_escape_string($item_codes[$i]) ?? '';
        $sell_price = $conn->real_escape_string($sell_prices[$i]) ?? '';
        $requested_quantity = $conn->real_escape_string($quantities[$i]) ?? '';
        $enter_stock = $conn->real_escape_string($enter_stocks[$i]) ?? '';
        $total = $conn->real_escape_string($totals[$i]) ?? '';
        $full_name = $conn->real_escape_string($full_names[$i]) ?? '';
        $id_no = $conn->real_escape_string($id_nos[$i]) ?? '';
        $address = $conn->real_escape_string($addresses[$i]) ?? '';
        $discount = $conn->real_escape_string($discounts[$i]) ?? '';

        // Fetch inventory details
        $inventory_query = "SELECT * FROM inventory WHERE item_code = '$item_code'";
        $inventory_result = mysqli_query($conn, $inventory_query);
        $inventory_quantity = mysqli_fetch_assoc($inventory_result);

        // Check if inventory data is valid
        if (!$inventory_quantity) {
            $res = ['status' => 400, 'msg' => "Invalid item code: $item_code"];
            echo json_encode($res);
            return;
        }

        // Fetch product details
        $product_query = "SELECT * FROM product WHERE item_code = '$item_code'";
        $product_result = mysqli_query($conn, $product_query);
        $product_data = mysqli_fetch_assoc($product_result);

        // Check if product data is valid
        if (!$product_data) {
            $res = ['status' => 400, 'msg' => "Invalid product for item code: $item_code"];
            echo json_encode($res);
            return;
        }

        // Fetch archive details
        $archive_query = "SELECT * FROM archive WHERE pr_id = '$pr_id' ";
        $archive_result = mysqli_query($conn, $archive_query);
        $archive_data = mysqli_fetch_assoc($archive_result);

        // Check if archive data is valid
        if (!$archive_data) {
            $res = ['status' => 400, 'msg' => "No active archive entry found for pr_id: $pr_id"];
            echo json_encode($res);
            return;
        }

        // Validate requested quantity and stock
        if (empty($requested_quantity) || $requested_quantity <= 0) {
            $res = ['status' => 400, 'msg' => 'Quantity must be greater than zero.'];
            echo json_encode($res);
            return;
        } elseif ($requested_quantity > $inventory_quantity['pi_quantity']) {
            $res = ['status' => 400, 'msg' => 'Insufficient stock for item: ' . $item_code];
            echo json_encode($res);
            return;
        }

        // Calculate updated quantities
        $new_inventory_quantity = $inventory_quantity['quantity'] - $requested_quantity;
        $new_pi_quantity = $inventory_quantity['pi_quantity'] - $requested_quantity;
        $new_product_quantity = $product_data['p_quantity'] - $requested_quantity;
        $new_archive_quantity = $archive_data['quantity'] - $requested_quantity;

        // Proceed with the rest of the logic...

        // Set timestamps and status
        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d g:i:s");
        $date_updated_at = date("Y-m-d g:i:s");
        $status = 'RELEASED';

        // Insert sale record
        if ( $full_name=='' || $id_no=='' || $address =='' && $discount == 'Choose Type of discount') {
            // Insert sale record
            $total = $totals[$i] * $quantities[$i];
            $query_sale = "INSERT INTO sale (sales_code, pr_id, item_code, sell_price, quantity, total, full_name, id_number, address, discount, status, date_created_at) 
 VALUES ('$combinedVariable', '$pr_id', '$item_code', '$sell_price', '$quantities[$i]', '$total', '$full_name', '$id_no', '$address', '$discount', '$status',  '$date_created_at')";
        } else {
            // Insert sale record
            $total = $totals[$i] * $quantities[$i];
            $total = $total * 0.80;
            $query_sale = "INSERT INTO sale (sales_code, pr_id, item_code, sell_price, quantity, total, full_name, id_number, address, discount, status, date_created_at) 
 VALUES ('$combinedVariable', '$pr_id', '$item_code', '$sell_price', '$quantities[$i]',  '$total', '$full_name', '$id_no', '$address', '$discount', '$status', '$date_created_at')";
        }
        // Update inventory
        $query_upd_inventory = "UPDATE inventory SET quantity = '$new_inventory_quantity', pi_quantity = '$new_pi_quantity', updated_by = date_updated_at = '$date_updated_at' WHERE pr_id = '$pr_id'";

        // Update product
        $query_upd_product = "UPDATE product SET p_quantity = '$new_product_quantity', updated_by = date_updated_at = '$date_updated_at' WHERE pr_id = '$pr_id'";

        // Update archive
        $query_upd_archive = "UPDATE archive SET quantity = '$new_archive_quantity', updated_by = date_updated_at = '$date_updated_at' WHERE pr_id = '$pr_id' ";

        // Execute queries
        if (mysqli_query($conn, $query_sale) && mysqli_query($conn, $query_upd_inventory) && mysqli_query($conn, $query_upd_product) && mysqli_query($conn, $query_upd_archive)) {
            continue;
        } else {
            $res = ['status' => 500, 'msg' => 'Error processing sale for item: ' . $item_code];
            echo json_encode($res);
            return;
        }
    }

    $res = [
        'status' => 200,
        'msg' => 'Sale transaction added successfully!.',
    ];
    echo json_encode($res);
    return;
}





// if (isset($_POST['update_sales'])) {

//     $pr_id = $_POST['pr_id'] ?? [];
//     $quantities = $_POST['quantity'] ?? [];
//     $status = $_POST['status'] ?? [];
//     $status = $_POST['date_created_at'] ?? [];

//     foreach ($pr_ids as $key => $pr_id) {
//         $quantity = $quantities[$key];
//         $status = $status[$key];
//         $date_created_at = $date_created_at[$key];


//         date_default_timezone_set('Asia/Manila');
//         $date_updated_at = date("Y-m-d g:i:s");


//         $inventory = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `inventory` WHERE `pr_id` = $pr_id "));

//         $new_quantity = $inventory['quantity'] + $quantity;

//         $query_sale = "UPDATE `sale` 
//         SET `status` = '" . $status . "'
//         `date_updated_at` = '" . $date_updated_at . "' 
//         WHERE `pr_id` = '" . $pr_id . "'  ";

//         $query_sale_run = mysqli_query($conn, $query_sale);

//         $query_upd_product = "UPDATE `inventory` 
//         SET `quantity` = '" . $new_quantity . "',
//         `date_updated_at` = '" . $date_updated_at . "' 
//         WHERE `pr_id` = '" . $pr_id . "'  ";

//         if ($status == "RELEASED") {
//             $res = [
//                 'status' => 400,
//                 'msg' => 'Item cannot be released.',
//             ];
//             echo json_encode($res);
//             return;
//         } else {

//             $query_inventory_run = mysqli_query($conn, $query_inventory);
//             if ($query_sale_run || $query_inventory_run) {
//                 $res = [
//                     'status' => 200,
//                     'msg' => 'Product Updated Successfully! ',
//                 ];


//                 echo json_encode($res);
//                 return;

//                 $url = '../admin/sales.php';
//                 header('Location: ' . $url);
//             }
//         }
//     }
// }



if (isset($_POST['update_sales'])) {
    $pr_ids = $_POST['pr_id'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    $istatus = $_POST['status'] ?? [];
    $idate_created_at = $_POST['date_created_at'] ?? [];

    foreach ($pr_ids as $key => $pr_id) {
        $quantity = $quantities[$key];
        $status = $istatus[$key];
        $date_created_at = $idate_created_at[$key];

        if (empty($quantity)) {
            $res = [
                'status' => 400,
                'msg' => 'Fields are required.',
            ];
            echo json_encode($res);
            return;
        } else if ($quantity == 0) {
            $res = [
                'status' => 400,
                'msg' => 'Quantity cannot be 0.',
            ];
            echo json_encode($res);
            return;
        } else


            date_default_timezone_set('Asia/Manila');
        $date_updated_at = date("Y-m-d g:i:s");


        $query_sale = "UPDATE `sale` 
        SET `status` = '" . $status . "',
        `date_updated_at` = '" . $date_updated_at . "' 
        WHERE `date_created_at` = '" . $date_created_at . "'  ";


        $inventory = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `inventory` WHERE `pr_id` = $pr_id "));

        $new_quantity_inventory = $inventory['quantity'] + $quantity;

        $query_upd_inventory = "UPDATE `inventory` 
SET `quantity` = '" . $new_quantity_inventory . "',
`date_updated_at` = '" . $date_updated_at . "' 
WHERE `pr_id` = '" . $pr_id . "'  ";


        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `product` WHERE `pr_id` = $pr_id "));

        $new_quantity_product = $product['p_quantity'] + $quantity;

        $query_upd_product = "UPDATE `product` 
SET `p_quantity` = '" . $new_quantity_product . "',
`date_updated_at` = '" . $date_updated_at . "' 
WHERE `pr_id` = '" . $pr_id . "'  ";



        $archive = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `archive` WHERE `pr_id` = $pr_id "));

        $new_quantity_archive = $archive['quantity'] + $quantity;

        $query_upd_archive = "UPDATE `archive` 
SET `quantity` = '" . $new_quantity_archive . "',
`date_updated_at` = '" . $date_updated_at . "' 
WHERE `pr_id` = '" . $pr_id . "'  AND `remarks` = 'ACTIVE' ";



        if ($conn->query($query_sale) !== TRUE || $conn->query($query_upd_inventory) !== TRUE || $conn->query($query_upd_product) !== TRUE || $conn->query($query_upd_archive) !== TRUE) {
            $res = [
                'status' => 500,
                'msg' => 'Error: ' . $sql . "<br>" . $conn->error,
            ];
            echo json_encode($res);
            return;
        }
    }

    $res = [
        'status' => 200,
        'msg' => 'Product details updated successfully.',
    ];
    echo json_encode($res);
    return;
}















if (isset($_POST['add_receipt'])) {

    $receipt_no = mysqli_real_escape_string($conn, $_POST['receipt_no']);
    $item_code = mysqli_real_escape_string($conn, $_POST['item_code']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);


    date_default_timezone_set('Asia/Manila');
    $date_created_at = date("Y-m-d g:i:s");

    if ($receipt_no == "" || $item_code == "" || $description == "" || $quantity == "" || $total_amount == "" || $type == "") {
        $res = [
            'status' => 400,
            'msg' => 'Fields are Required.',
        ];
        echo json_encode($res);
        return;
    } else if (!is_numeric($quantity) || !is_numeric($total_amount)) {
        $res = [
            'status' => 400,
            'msg' => 'Input must be a non-decimal numeric value.',
        ];
        echo json_encode($res);
        return;
    } else {
        // pr_id, item_code,  category, material_cost, sell_price,manufacturing_date, date_created_at, date_updated_at

        $query_add_product = "INSERT INTO `receipt` (`sales_code`,  `item_code`,  `description`,  `quantity`,  `total_amount`, `status`, `type`) VALUE ('$receipt_no',  '$item_code', '$description', '$quantity', '$total_amount', '$status', '$type')";
        $query_add_product_run = mysqli_query($conn, $query_add_product);

        if ($query_add_product_run) {
            $res = [
                'status' => 200,
                'msg' => 'Product Submit Successfully! ',
            ];

            echo json_encode($res);
            return;
        }
    }
}

?>
<?php

date_default_timezone_set('Asia/Manila');
$data_name = "BrindoxCare_ArchiveData_" . date("_Y_m_d_H_i_s") . ".xls";

// Header for Download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; Filename = $data_name");

// require 'dmp_data.php';
require '../getdata/archive_data_query.php';

?>
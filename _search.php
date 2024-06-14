<?php
if (isset($_GET['discipline'])) {
    $_SESSION['discipline'] = $_GET['discipline'];
}

$start_date = isset($_SESSION['start_date']) ? $_SESSION['start_date'] : '';
$end_date = isset($_SESSION['end_date']) ? $_SESSION['end_date'] : '';
$discipline = isset($_SESSION['discipline']) ? $_SESSION['discipline'] : '';
$work = isset($_SESSION['work']) ? $_SESSION['work'] : '';
$type = isset($_SESSION['type']) ? $_SESSION['type'] : '';
$search = isset($_SESSION['search']) ? $_SESSION['search'] : '';
if ($start_date == "") {
    $start_date = date("Y-01-01");
}
if ($end_date == "") {
    $end_date = date('Y-m-d');
}
if ($discipline != "") {
    $condition = " AND `discipline` = '" . $discipline . "'";
} else {
    $condition = "";
}
if ($work != "") {
    $condition .= " AND `work` = '" . $work . "'";
} else {
    $condition .= "";
}
if ($type != "") {
    $condition .= " AND `type` = '" . $type . "'";
} else {
    $condition .= "";
}

if ($search != "") {
    $condition .= " AND (`doc_no` LIKE '%$search%' OR `doc_name` LIKE '%$search%' OR `date` LIKE '%$search%' OR `prepared_by` LIKE '%$search%')";
} else {
    $condition .= "";
}

$sql = "SELECT * FROM `documents` WHERE `approved` = 1" . $condition;
$result = $conDB->sqlQuery($sql);
?>
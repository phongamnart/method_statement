<?php
include("connect.php");
$conDB = new db_conn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $action = isset($_POST['approve']) ? 'approve' : (isset($_POST['reject']) ? 'reject' : '');
    $reject_reason = isset($_POST['reject_reason']) ? $_POST['reject_reason'] : '';

    $sql =  "SELECT * FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1";
    $objQuery = $conDB->sqlQuery($sql);

    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $doc_no = $objResult['doc_no'];
    }

    $sql2 =  "SELECT * FROM `role` WHERE `role` = 'approver' LIMIT 1";
    $objQuery = $conDB->sqlQuery($sql2);

    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $email = $objResult['email'];
    }

    if ($action == 'approve') {
        $strSQL = "UPDATE `documents` SET `approved` = 1 WHERE md5(`id`) = '$id'";

        $strSQL2 = "INSERT INTO `approval` (`id`, `doc_no`, `email`, `date_time`, `status`, `reject_reason`)
        VALUES ('$id', '$doc_no', '$email', NOW(), 'Approve', '$reject_reason')";
    } elseif ($action == 'reject') {
        $strSQL = "INSERT INTO `approval` (`id`, `doc_no`, `email`, `date_time`, `status`, `reject_reason`)
        VALUES ('$id', '$doc_no', '$email', NOW(), 'Reject', '$reject_reason')";
    }

    $conDB->sqlQuery($strSQL);
    $conDB->sqlQuery($strSQL2);
        
    header("Location: list_approve.php");
    exit();
}
?>
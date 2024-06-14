<?php
include("connect.php");
$conDB = new db_conn();

if (isset($_POST['doc_no'])) {
    $doc_no = $_POST['doc_no'];

    $sql = "INSERT INTO `ckeditor` (`doc_no`) VALUES ('$doc_no')";
    $conDB->sqlQuery($sql);
}

?>
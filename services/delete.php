<?php
session_start() ;
include("../connect.php");
$conDB = new db_conn();
$id = $conDB->sqlEscapestr($_POST['id']);
$table = $conDB->sqlEscapestr($_POST['table']);

echo $sql = "DELETE FROM `$table` WHERE `id` = '$id' LIMIT 1" ;
$conDB->sqlQuery($sql);
?>
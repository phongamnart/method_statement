<?php
session_start() ;
include("../connect.php");
$conDB = new db_conn();
$param = $conDB->sqlEscapestr($_POST['param']);
$value = $conDB->sqlEscapestr($_POST['value']);
$_SESSION[$param] = $value;
?>
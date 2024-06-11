<?php
session_start();
include("connect.php");
$conDB = new db_conn();

$id = isset($_POST['id']) ? $_POST['id'] : '';

$sql1 = "SELECT * FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1";
$objQuery = $conDB->sqlQuery($sql1);
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $created_by = $objResult['prepared_by'];
    $doc_no = $objResult['doc_no'];
}

if(isset($_POST['editor_content']) && isset($_POST['sections'])) {
    $editor_content = $_POST['editor_content'];
    $sections = $_POST['sections'];

    foreach($editor_content as $index => $content) {
        if(isset($sections[$index]) && !empty($sections[$index])) {
            $section = $sections[$index];
            $sql2 = "INSERT INTO `sub_content` (`doc_no`, `created`, `created_by`, `section`, `content`) VALUES ('$doc_no', NOW(), '$created_by', '$section', '$content')";
            $conDB->sqlQuery($sql2);
        }
    }
    header("Location: list_doc.php");
    exit();
} 
?>

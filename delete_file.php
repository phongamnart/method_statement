<?php
include("connect.php");
$conDB = new db_conn();

if (isset($_POST['id']) && isset($_POST['doc_file'])) {
    $id = $_POST['id'];
    $doc_file = $_POST['doc_file'];

    $file_path = "saved_docx_files/" . $doc_file;
    if (file_exists($file_path)) {
        unlink($file_path);
        
        $sql = "UPDATE `documents` SET `doc_file` = '' WHERE `id` = '$id'";
        if ($conDB->sqlQuery($sql)) {
            header("Location: list_doc.php");
            exit();
        } else {
            echo "Error updating record: ";
        }
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request";
}

?>

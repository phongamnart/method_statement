<?php
include("connect.php"); //connect DB
$conDB = new db_conn();

if (isset($_GET['id'])) { //check param
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $docNoSQL = "SELECT `doc_no` FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1"; //ดึง doc_no from DB
    $result = $conDB->sqlQuery($docNoSQL);
    $docNo = mysqli_fetch_assoc($result);
    $doc_no = $docNo['doc_no'];

    echo "$doc_no";

    $filePath = __DIR__ . '/uploads/'. $doc_no . '/' . $doc_no . '.docx'; //path

    echo "Trying to download: " . $filePath . "<br>"; //debug

    if (file_exists($filePath)) { //check file
        header('Content-Description: File Transfer'); //set header for file transfer
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //set header for file type
        header('Content-Disposition: attachment; filename="' . $doc_no . '.docx"'); //set header for file name
        header('Expires: 0'); //set header for not cache
        header('Cache-Control: must-revalidate');
        header('Pragma: public'); // set header for call everytime
        header('Content-Length: ' . filesize($filePath)); // set header for specifies the size of the file

        ob_clean(); //clear obj ก่อนส่งให้บราวเซอร์ download กันข้อมูลอื่นติดไปกับไฟล์
        flush();
        
        readfile($filePath);
        exit;
    } else {
        echo "File not found: " . $filePath;
    }
} else {
    echo "No file specified.";
}
?>

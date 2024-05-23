<?php
if (isset($_GET['file'])) { //check param
    $file = basename($_GET['file']); //ดึงชื่อไฟล์ที่ param ส่งมา
    $filePath = __DIR__ . '/test_save/' . $file; //path

    echo "Trying to download: " . $filePath . "<br>"; //debug

    if (file_exists($filePath)) { //check file
        header('Content-Description: File Transfer'); //set header for file transfer
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document'); //set header for file type
        header('Content-Disposition: attachment; filename="' . $file . '"'); //set header for file name
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

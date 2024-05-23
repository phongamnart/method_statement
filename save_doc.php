<?php
require 'vendor/autoload.php'; //import

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html; 

include("connect.php"); //connect DB

if ($_SERVER["REQUEST_METHOD"] == "POST") { //check method

    if (!isset($_POST['id'])) {
        echo "ID not specified.";
        exit;
    }

    $content = $_POST['editor_content']; //content ที่ส่งมาจากหน้า index
    $id = $_POST['id'];

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    $doc = new DOMDocument(); //create obj
    libxml_use_internal_errors(true); //manage error
    $doc->loadHTML('<html><body>' . $content . '</body></html>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); //load html
    libxml_clear_errors(); //clear error

    $body = $doc->getElementsByTagName('body')->item(0); //ดึง <body>

    if ($body) { // check <body>
        foreach ($body->childNodes as $childNode) {
            if ($childNode->nodeName == 'figure' && $childNode->getElementsByTagName('img')->length > 0) { //หา <figure> และ <img>
                $imgNode = $childNode->getElementsByTagName('img')->item(0); //ดึง <img>
                $imgSrc = $imgNode->getAttribute('src'); //ดึงรูปใน <src>
                $section->addImage($imgSrc); //add image ที่ได้จาก <src>
            } else { //ถ้าไม่มี <figure> และ <img>
                $htmlContent = $doc->saveHTML($childNode); //เก็บไว้ในตัวแปล $htmlContent
                Html::addHtml($section, $htmlContent, false, false); //convert html to text
            }
        }
    } else {
        echo "Failed to parse HTML content.";
        exit;
    }

    $currentTime = date("YmdHis");
    $randomNumber = uniqid();
    $filename = 'test_save/' . $currentTime . '_' . $randomNumber . '.docx';
    $phpWord->save($filename);

    $query = "update documents set doc_file = ? where id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $filename, $id);

    if ($stmt->execute()) {
        echo "File saved successfully as " . basename($filename);
    } else {
        echo "Failed to save file information to the database.";
    }

    $stmt->close();
    $conn->close();
    
} else {
    echo "Invalid request method.";
}
?>

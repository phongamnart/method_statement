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

    $content = $_POST['editor_content'];
    $id = $_POST['id'];

    $phpWord = new PhpWord();
    $section1 = $phpWord->addSection();

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
                $section1->addImage($imgSrc); //add image ที่ได้จาก <src>
            } else { //ถ้าไม่มี <figure> และ <img>
                $htmlContent = $doc->saveHTML($childNode); //เก็บไว้ในตัวแปล $htmlContent
                Html::addHtml($section1, $htmlContent, false, false); //convert html to text
            }
        }
    } else {
        echo "Failed to parse HTML content.";
        exit;
    }

    $currentTime = date("YmdHis");
    $randomNum = uniqid();
    $doc_file = 'saved_docx_files/' . $currentTime . '_' . $randomNum . '_docucment.docx';
    $phpWord->save($doc_file); //docx file

    $phpHtml = new PhpWord();
    $section2 = $phpHtml->addSection();
    $section2->addText(htmlspecialchars($content));

    $html_file = 'saved_html_files/' . $currentTime . '_' . $randomNum . '_html.docx';
    $phpHtml->save($html_file); //html file

    $query = "update documents set doc_file = ?, html_file = ? where id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $doc_file, $html_file, $id);

    if ($stmt->execute()) {

        $stmt->close();
        $conn->close();
        echo "<script>alert('Files saved successfully as " . basename($doc_file) . " and " . basename($html_file) . "'); window.location.href = 'list_doc.php';</script>";
    } else {
        echo "<script>alert('Failed to save file information to the database.); window.location.href = 'list_doc.php';</script>";
    }
} else {
    echo "Invalid request method.";
}

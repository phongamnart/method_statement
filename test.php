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

    // Check if the document exists in the database
    $query = "SELECT doc_file, html_file FROM documents WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) { // Document exists in the database
        $stmt->bind_result($doc_file, $html_file);
        $stmt->fetch();
        $stmt->close();

        // Update existing files instead of creating new ones
        $doc_file_path = $doc_file;
        $html_file_path = $html_file;
    } else { // Document does not exist in the database
        $currentTime = date("YmdHis");
        $randomNum = uniqid();
        $doc_file_path = 'saved_docx_files/' . $currentTime . '_' . $randomNum . '_document.docx';
        $html_file_path = 'saved_html_files/' . $currentTime . '_' . $randomNum . '_html.html';
    }

    // Check if the files already exist in the directory
    if (!file_exists($doc_file_path) || !file_exists($html_file_path)) {
        // Create PhpWord object and add content
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

        // Save PhpWord objects as files
        $phpWord->save($doc_file_path); //docx file

        $phpHtml = new PhpWord();
        $section2 = $phpHtml->addSection();
        $section2->addText(htmlspecialchars($content));

        $phpHtml->save($html_file_path); //html file

        if (!empty($doc_file_path)) {
            $phpWord->save($doc_file_path); // บันทึกไฟล์ docx
        }
        
        if (!empty($html_file_path)) {
            $phpHtml->save($html_file_path); // บันทึกไฟล์ html
        }
    }

    // Update the database with file paths
    $query = "UPDATE documents SET doc_file = ?, html_file = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $doc_file_path, $html_file_path, $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        echo "<script>alert('Files saved successfully as " . basename($doc_file_path) . " and " . basename($html_file_path) . "'); window.location.href = 'list_doc.php';</script>";
    } else {
        echo "<script>alert('Failed to save file information to the database.'); window.location.href = 'list_doc.php';</script>";
    }
} else {
    echo "Invalid request method.";
}

<?php
require 'vendor/autoload.php'; //import

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use Mpdf\Mpdf;

include("connect.php"); //connect DB
$conDB = new db_conn();

if ($_SERVER["REQUEST_METHOD"] == "POST") { //check method

    if (!isset($_POST['id'])) {
        echo "ID not specified.";
        exit;
    }

    $content = $_POST['editor_content'];
    $id = $_POST['id'];

    $docNoSQL = "SELECT `doc_no` FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1"; //ดึง doc_no from DB
    $result = $conDB->sqlQuery($docNoSQL);
    $docNo = mysqli_fetch_assoc($result);

    if (!$docNo) {
        echo "Document not found";
        exit;
    }

    $doc_no = $docNo['doc_no'];

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

    $uploadDir = 'uploads/';
    $idDir = $uploadDir . $doc_no . '/'; //กำหนด path ตั้งโฟลเดอร์ตาม doc_no from DB

    if (!is_dir($idDir)) { //ถ้าไม่มีโฟลเดอร์ตามที่กำหนด path ให้สร้างขึ้นมา
        mkdir($idDir, 0777, true);
    }

    $date = date("Y-m-d");
    $randomNum = uniqid();
    $doc_file = $idDir . '/' . $doc_no . '.docx';
    $phpWord->save($doc_file); //docx file

    $tag_html = htmlspecialchars($content, ENT_QUOTES, 'UTF-8'); //tag_html

    $mpdf = new Mpdf();
    $mpdf->WriteHTML($content);
    $pdf_file = $idDir . '/' . $doc_no . '.pdf';
    $mpdf->Output($pdf_file, 'F'); //pdf_file

    $query = "UPDATE `documents` SET `doc_file` = '$doc_file', `tag_html` = '$tag_html', `pdf_file` = '$pdf_file', `date` = '$date' WHERE md5(`id`) = '$id'"; //update DB
    $conDB->sqlQuery($query);

    $alertMessage = "Files saved successfully as " . basename($doc_file) . " and " . basename($pdf_file) . ".";

    //alert success
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));
                document.getElementById('alertMessage').textContent = '$alertMessage';
                alertModal.show();
            });
          </script>";
} else {
    echo "Invalid request method.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Document Save Alert</title>
</head>

<body>
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true"> <!--alert success style-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="alertMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.href='list_doc.php';">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use Mpdf\Mpdf;

include("connect.php");
$conDB = new db_conn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contents = $_POST['editor_content'];

    $sql1 = "SELECT `image` FROM `test_word` ORDER BY `id` DESC LIMIT 1";
    $result = $conDB->sqlQuery($sql1);
    $imagePath = '';
    while ($objResult = mysqli_fetch_assoc($result)) {
        $imagePath = $objResult['image'];
    }

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    $imageHtml = !empty($imagePath) ? '<div style="text-align: center;"><img src="' . $imagePath . '" style="width: 200px; height: 200px;"></div>' : '';
    $htmlContent = '';

    foreach ($contents as $content) {
        if (is_string($content)) {
            $plainTextContent = htmlspecialchars_decode(strip_tags($content)); // Decode HTML to text
            $plainTextContent = str_replace('&nbsp;', ' ', $plainTextContent); // Replace &nbsp; with space
            $encodedText = htmlspecialchars($plainTextContent, ENT_QUOTES, 'UTF-8'); // Encode special characters
            $htmlContent .= '<p>' . $encodedText . '</p>';
            $section->addText($encodedText);
        }
    }
    $htmlContent = $htmlContent . $imageHtml;
    
    if (!empty($imagePath)) {
        $imageStyle = array('width' => 200, 'height' => 200, 'alignment' => Jc::CENTER);
        $section->addImage($imagePath, $imageStyle);
    }

    $currentTime = date("YmdHis");
    $randomNum = uniqid();
    $doc_file = 'test_upload/word/' . $currentTime . '_' . $randomNum . '.docx';
    $phpWord->save($doc_file);

    $mpdf = new Mpdf([
        'fontDir' => __DIR__ . '/fonts/',
        'fontdata' => [
            "thsarabunnew" => [
                'R' => "THSarabunNew.ttf",
                'I' => "THSarabunNew Italic.ttf",
                'B' => "THSarabunNew Bold.ttf",
                'BI' => "THSarabunNew BoldItalic.ttf",
            ],
        ],
        'default_font' => 'thsarabunnew'
    ]);
    $mpdf->WriteHTML($htmlContent);
    $pdf_file = 'test_upload/pdf/' . $currentTime . '_' . $randomNum . '.pdf';
    $mpdf->Output($pdf_file, 'F');

    $sql2 = "UPDATE `test_word` SET `content` = '$encodedText' WHERE `doc_no` = 'MS-CE-0001'";
    $conDB->sqlQuery($sql2);

    echo "<script>alert('Files saved successfully as " . basename($doc_file) . "'); window.location.href = 'test_word.php';</script>";
} else {
    echo "Invalid request method.";
}

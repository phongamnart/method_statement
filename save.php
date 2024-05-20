<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
// use PhpOffice\PhpWord\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['editor_content'];

    // $uploadDirectory = 'uploads/';
    $imagePath = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png'; 
    

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    $section->addHeader()->addImage($imagePath);

    // $section->addText(htmlspecialchars($content));
    // $section->addText(htmlspecialchars_decode(strip_tags($content)));

    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content, false, false);

    // $section->addText($content);
    $filename = 'test_save/test.docx';
    // $filename = "test_save/" . date("Ymd_His") . ".docx";
    // $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $phpWord->save($filename);

    echo "File saved successfully as " . basename($filename);
} else {
    echo "Invalid request method.";
}
?>

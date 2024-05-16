<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['editor_content'];
    
    $phpWord = new PhpWord();

    $section = $phpWord->addSection();

    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content, false, false);

    $filename = "saved_files/" . date("Ymd_His") . ".docx";

    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filename);

    echo "File saved successfully as " . basename($filename);
} else {
    echo "Invalid request method.";
}
?>

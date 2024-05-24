<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['id'])) {
        echo "ID not specified.";
        exit;
    }

    $content = $_POST['editor_content'];

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    $section->addText(htmlspecialchars($content));//tag html

    $currentTime = date("YmdHis");
    $randomNumber = uniqid();
    $filename = 'test_save/' . $currentTime . '_' . $randomNumber . '.docx';
    $phpWord->save($filename);

    echo "Save file Success " . basename($filename);
} else {
    echo "Invalid request method.";
}
?>

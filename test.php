<?php
require 'vendor/autoload.php';
// use PhpOffice\PhpWord\Settings;
$phpWord = new \PhpOffice\PhpWord\PhpWord();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['editor_content'];
}

$imagePath = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png'; 

$section = $phpWord->addSection();

$html = $content;

\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

$section->addHeader()->addImage($imagePath);
// $section->addFooter()->addPreserveText('{PAGE}', null, ['alignment' => 'right']);

// $imagePath = 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png'; 
// $section->addImage($imagePath, array('width' => 200, 'height' => 200));

// $section->addPageBreak();
// $section->addHeader()->addImage($imagePath, array('width' => 100, 'height' => 30));
// $section->addImage($imagePath, array('width' => 200, 'height' => 200));

$filename = 'test_save/test.docx';
$phpWord->save($filename);

echo "Word document generated successfully: $filename";
?>
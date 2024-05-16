<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['editor_content'];
    
    // สร้าง PHPWord object
    $phpWord = new PhpWord();

    // เพิ่ม section
    $section = $phpWord->addSection();

    // เพิ่มเนื้อหา HTML ลงใน section
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $content, false, false);

    // ตั้งชื่อไฟล์ Word ที่จะบันทึก (เช่น ใช้วันที่และเวลา)
    $filename = "saved_files/" . date("Ymd_His") . ".docx";

    // บันทึกไฟล์ Word
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filename);

    echo "File saved successfully as " . basename($filename);
} else {
    echo "Invalid request method.";
}
?>

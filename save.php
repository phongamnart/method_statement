<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;

include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM uploaded_files ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row["url"];
    } else {
        echo "No image found in database.";
        exit;
    }

    $content = $_POST['editor_content'];

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();
    $section->addImage($imagePath);

    $section->addText(htmlspecialchars_decode(strip_tags($content)));

    $currentTime = date("Y-m-d_H-i-s");
    $randomNumber = uniqid();
    $filename = 'test_save/' . $currentTime . '_' . $randomNumber . '.docx';
    $phpWord->save($filename);

    echo "File saved successfully as " . basename($filename);
} else {
    echo "Invalid request method.";
}

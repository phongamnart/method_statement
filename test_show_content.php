<?php
require 'vendor/autoload.php'; //import

use PhpOffice\PhpWord\IOFactory;

// Check if file parameter is set in the URL
if (!isset($_GET['file'])) {
    echo "File parameter not specified.";
    exit;
}

// Get the file name from the URL parameter
$fileName = $_GET['file'];

// Load the .docx file
$phpWord = IOFactory::load($fileName);

// Get the HTML content from the .docx file
$htmlContent = $phpWord->getContent();

// Display the HTML content in the edit_doc.php page
echo $htmlContent;
?>

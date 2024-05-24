<?php
include("connect.php");
$conDB = new db_conn();
function generateDocNo($major, $conDB)
{
    $prefix = '';
    switch ($major) {
        case 'Civil':
            $prefix = 'MS-CE-';
            break;
        case 'Electrical':
            $prefix = 'MS-EE-';
            break;
        case 'Mechanical':
            $prefix = 'MS-ME-';
            break;
    }

    $sql = "SELECT `doc_no` FROM `documents` WHERE `major`='$major' ORDER BY id DESC LIMIT 1";
    $result = $conDB->sqlQuery($sql);
    $latest_doc_no = mysqli_fetch_assoc($result);

    if ($latest_doc_no) {
        $last_number = (int)substr($latest_doc_no['doc_no'], strlen($prefix));
        $new_number = $last_number + 1;
    } else {
        $new_number = 1;
    }

    return $prefix . str_pad($new_number, 4, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $major = $_POST['major'];
    $doc_no = generateDocNo($major, $conDB);
    $doc_name = $_POST['doc_name'];
    $date = date('Y-m-d H:i:s');
    $owner = $_POST['owner'];

    $doc_dir = 'saved_docx_files/';
    $html_dir = 'saved_html_files/';
    $pdf_dir = 'saved_pdf_files/';

    if (!is_dir($doc_dir)) {
        mkdir($doc_dir, 0777, true);
    }

    if (!is_dir($html_dir)) {
        mkdir($html_dir, 0777, true);
    }

    if (!is_dir($pdf_dir)) {
        mkdir($pdf_dir, 0777, true);
    }

    $sql = "INSERT INTO `documents` (`major`, `doc_no`, `doc_name`, `doc_file`, `html_file`, `pdf_file`, `date`, `owner`) 
            VALUES ('$major', '$doc_no', '$doc_name', '$doc_file_path', '$html_file_path', '$pdf_file_path', '$date', '$owner')";

    $conDB->sqlQuery($sql);

    $strSQL3 = "SELECT * FROM `documents` WHERE `date` = '$date' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQL3);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $no = $objResult['id'];
    }
    header("Location: edit_doc.php?id=".md5($no)."");
    exit();
}

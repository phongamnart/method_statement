<?php
include("connect.php");

date_default_timezone_set('Asia/Bangkok');

function generateDocNo($major, $conn) {
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

    $sql = "SELECT doc_no FROM documents WHERE major='$major' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
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
    $doc_no = generateDocNo($major, $conn);
    $doc_name = $_POST['doc_name'];
    $date = date('Y-m-d H:i:s');
    $owner = $_POST['owner'];

    $doc_dir = 'saved_doc_files/';
    $pdf_dir = 'saved_pdf_files/';

    if (!is_dir($doc_dir)) {
        mkdir($doc_dir, 0777, true);
    }

    if (!is_dir($pdf_dir)) {
        mkdir($pdf_dir, 0777, true);
    }

    $doc_file_path = '';
    if (isset($_FILES['doc_file']) && $_FILES['doc_file']['error'] == UPLOAD_ERR_OK) {
        $timestamp = date('YmdHis');
        $random_number = rand(1000, 9999);
        $doc_extension = pathinfo($_FILES['doc_file']['name'], PATHINFO_EXTENSION);
        $doc_new_name = $timestamp . '_' . $random_number . '.' . $doc_extension;
        $doc_file_path = $doc_dir . $doc_new_name;

        if (!move_uploaded_file($_FILES['doc_file']['tmp_name'], $doc_file_path)) {
            echo "Failed to upload DOC file.";
            exit();
        }
    }

    $pdf_file_path = '';
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == UPLOAD_ERR_OK) {
        $timestamp = date('YmdHis');
        $random_number = rand(1000, 9999);
        $pdf_extension = pathinfo($_FILES['pdf_file']['name'], PATHINFO_EXTENSION);
        $pdf_new_name = $timestamp . '_' . $random_number . '.' . $pdf_extension;
        $pdf_file_path = $pdf_dir . $pdf_new_name;

        if (!move_uploaded_file($_FILES['pdf_file']['tmp_name'], $pdf_file_path)) {
            echo "Failed to upload PDF file.";
            exit();
        }
    }

    $sql = "INSERT INTO documents (major, doc_no, doc_name, doc_file, pdf_file, date, owner) 
            VALUES ('$major', '$doc_no', '$doc_name', '$doc_new_name', '$pdf_new_name', '$date', '$owner')";

    if (mysqli_query($conn, $sql)) {
        header("Location: list_doc.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

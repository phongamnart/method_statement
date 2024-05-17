<?php
include("connect.php");

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
    $dateCreate = date('Y-m-d H:i:s');
    $owner = $_POST['owner'];

    $timestamp = date('YmdHis');
    $random_number = rand(1000, 9999);
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $newname = $timestamp . '_' . $random_number . '.' . $extension;
    $file_path = 'saved_files/' . $newname;

    if (!is_dir('saved_files')) {
        mkdir('saved_files', 0777, true);
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
        $sql = "INSERT INTO documents (major, doc_no, doc_name, doc_file, date, owner) 
                VALUES ('$major', '$doc_no', '$doc_name' , '$newname', NOW(), '$owner')";

        echo $sql;

        if (mysqli_query($conn, $sql)) {
            header("Location: list_doc.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload file.";
    }
}
?>

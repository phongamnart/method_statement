<?php
include("connect.php");

if (isset($_POST['id']) && isset($_POST['doc_file'])) {
    $id = $_POST['id'];
    $doc_file = $_POST['doc_file'];

    $file_path = "saved_files/" . $doc_file;
    if (file_exists($file_path)) {
        unlink($file_path);
        
        $sql = "UPDATE documents SET doc_file = '' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: edit.php?id=$id");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request";
}

mysqli_close($conn);
?>

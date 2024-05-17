<?php
include("connect.php");

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    
    $sql_select_file = "SELECT doc_file FROM documents WHERE id = $id";
    $result_select_file = mysqli_query($conn, $sql_select_file);
    if($result_select_file && mysqli_num_rows($result_select_file) > 0) {
        $row = mysqli_fetch_assoc($result_select_file);
        $file_name = $row['doc_file'];
        
        $file_path = "saved_files/" . $file_name;
        if(file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    $sql_delete = "DELETE FROM documents WHERE id = $id";
    if(mysqli_query($conn, $sql_delete)){
        header("location: list_doc.php");
        exit();
    } else {
        echo "Error: ". mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}

mysqli_close($conn);
?>

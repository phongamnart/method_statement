<?php
include("connect.php");

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    
    $sql_select_files = "SELECT doc_file, pdf_file FROM documents WHERE id = $id";
    $result_select_files = mysqli_query($conn, $sql_select_files);
    if($result_select_files && mysqli_num_rows($result_select_files) > 0) {
        $row = mysqli_fetch_assoc($result_select_files);
        $doc_file_name = $row['doc_file'];
        $pdf_file_name = $row['pdf_file'];
        
        $doc_file_path = "saved_doc_files/" . $doc_file_name;
        $pdf_file_path = "saved_pdf_files/" . $pdf_file_name;

        if(file_exists($doc_file_path)) {
            unlink($doc_file_path);
        }

        if(file_exists($pdf_file_path)) {
            unlink($pdf_file_path);
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

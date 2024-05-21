<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
    $file = $_FILES['upload'];
    $uploadDirectory = 'uploads/';
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $uploadPath = $uploadDirectory . $filename;

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/method_statement/' . $uploadPath;
        $response = [
            "uploaded" => 1,
            "fileName" => $filename,
            "url" => $url
        ];
    } else {
        $response = [
            "uploaded" => 0,
            "error" => ["message" => "File upload failed."]
        ];
    }

    echo json_encode($response);
}
?>
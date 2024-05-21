<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
    $file = $_FILES['upload'];
    $uploadDirectory = 'uploads/';
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $uploadPath = $uploadDirectory . $filename;

    include("connect.php");

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/method_statement/' . $uploadPath;

        $stmt = $conn->prepare("insert into uploaded_files (filename, url) values (?, ?)");
        $stmt->bind_param("ss", $filename, $url);
        if($stmt->execute()){
            $response = [
                "uploaded" => 1,
                "fileName" => $filename,
                "url" => $url
            ];
        } else {
            $response = [
                "uploaded" => 0,
                "error" => ["message" => "File to save file into to database."]
            ];
        }
        $stmt->close();
    } else {
        $response = [
            "uploaded" => 0,
            "error" => ["message" => "File upload failed."]
        ];
    }

    $conn->close();

    echo json_encode($response);
}
?>

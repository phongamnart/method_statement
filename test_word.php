<?php
session_start();
include("connect.php");
$conDB = new db_conn();

$sql = "SELECT * FROM `ckeditor` WHERE `doc_no` = 'MS-CE-0001' AND `section` = 'Scope of work'";
$objQuery = $conDB->sqlQuery($sql);
$rows = [];
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $section = $objResult['section'];
    $doc_no = $objResult['doc_no'];
    $rows[] = $objResult;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <?php include("_header.php"); ?>
    <?php include("_navbar.php"); ?>
</head>

<body>
    <div class="full-container-header">
        <div class="row">
            <div class="col">
                <h2>Document No.: <?php echo $doc_no; ?></h2>
                <form id="editorForm" action="save_file.php" method="post">
                    <h4><?php echo $section; ?></h4>
                    <?php foreach ($rows as $index => $row) { ?>
                        <div class="editor-container">
                            <textarea name="editor_content[]" id="editor<?php echo $index + 1; ?>"><?php echo htmlspecialchars($row['content']); ?></textarea>
                        </div><br>
                    <?php } ?>
                    <div id="uploadStatus" class="d-flex justify-content-center"></div>
                    <div id="imageContainer" class="d-flex justify-content-center"></div>
                    <input type="submit" value="Save as Word" class="btn btn-success">
                </form><br>
                <form id="uploadForm" enctype="multipart/form-data" class="d-inline">
                    <a href="#" id="filePicker" class="btn btn-primary">Add Image</a>&nbsp;
                </form>
                <a href="#" id="addTextButton" class="btn btn-secondary">Add Text</a>&nbsp;
                <a href="#" id="deleteTextButton" class="btn btn-danger">Delete Text</a>
            </div>
        </div>
    </div>
    <!-- <div id="container">
        <div id="editor">
        </div>
    </div> -->
    <?php include("_script.php"); ?>
    <?php include("_test_ck.php"); ?>
</body>

</html>
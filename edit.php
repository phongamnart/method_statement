<?php
session_start();
include("connect.php");
$conDB = new db_conn();

$id = isset($_POST['id']) ? $_POST['id'] : '';

$sql1 = "SELECT * FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1";
$objQuery = $conDB->sqlQuery($sql1);
while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $created_by = $objResult['prepared_by'];
    $doc_no = $objResult['doc_no'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CKEditor Dynamic Example</title>
    <?php include("_header.php"); ?>
    <style>
        form {
            margin-top: 20px;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 5px;
            width: 100%;
            display: grid;
            gap: 20px;
        }
    </style>
</head>

<body>
    <div class="content-container">
        <form action="save_content.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <?php
            $checkboxes = isset($_POST['checkboxes']) ? $_POST['checkboxes'] : [];
            if (empty($checkboxes)) {
            ?>
                <div class="form-group">
                    <label for="editor0">Content</label>
                    <textarea name="editor_content[]" id="editor0"></textarea>
                    <input type="hidden" name="sections[]" value="">
                </div>
                <?php
            } else {
                foreach ($checkboxes as $index => $checkbox) {
                    $section = htmlspecialchars($checkbox);
                    $sql2 = "INSERT INTO `content` (`doc_no`, `created`, `created_by`, `section`) VALUES ('$doc_no', NOW(), '$created_by', '$section')";
                    $conDB->sqlQuery($sql2);

                    $sql3 = "SELECT `content` FROM `sub_content` WHERE `doc_no` = '$doc_no' AND `section` = '$section' LIMIT 1";
                    $contentQuery = $conDB->sqlQuery($sql3);
                    $contentResult = mysqli_fetch_assoc($contentQuery);
                    $content = isset($contentResult['content']) ? $contentResult['content'] : '';

                ?>
                    <div class="form-group">
                        <label for="editor<?php echo $index; ?>"><?php echo $section ?></label>
                        <textarea name="editor_content[]" id="editor<?php echo $index; ?>"><?php echo htmlspecialchars($content); ?></textarea>
                        <input type="hidden" name="sections[]" value="<?php echo $section ?>">
                    </div>
            <?php
                }
            }
            ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Save" class="btn btn-success">
        </form>
    </div>
    <?php include("_script.php"); ?>
    <?php include("_create_content.php"); ?>

</body>

</html>
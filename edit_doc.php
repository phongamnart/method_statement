<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</head>

<body>
    <button onclick="history.back()">Back</button>
    <button class="btn-home" onclick="location.href='index.php';">Home</button>
    <br><br>

    <?php
    include("connect.php");
    $conDB = new db_conn();

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $strSQLl =  "SELECT * FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQLl);

    while($objResult = mysqli_fetch_assoc($objQuery)) { 
        $tag_html = $objResult['tag_html'];
    }

    ?>

    <form action="save_doc.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <textarea name="editor_content" id="editor"><?php echo $tag_html; ?></textarea>
        <br>
        <input type="submit" value="Save as Word">
    </form>
    <script>
    var documentId = "<?php echo $id; ?>";

    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "upload_img.php?id=" + documentId + "&command=QuickUpload&type=Files&responseType=json"
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button onclick="history.back()" class="btn btn-secondary me-2">Back</button>
                <button class="btn btn-primary btn-home" onclick="location.href='index.php';">Home</button>
            </div>
        </div>

        <?php
        include("connect.php");
        $conDB = new db_conn();

        $id = isset($_GET['id']) ? $_GET['id'] : '';
        $strSQLl =  "SELECT * FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1";
        $objQuery = $conDB->sqlQuery($strSQLl);

        while ($objResult = mysqli_fetch_assoc($objQuery)) {
            $tag_html = $objResult['tag_html'];
        }

        ?>

        <div class="row mt-3">
            <div class="col">
                <form action="save_doc.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <textarea name="editor_content" id="editor"><?php echo $tag_html; ?></textarea>
                    <br>
                    <input type="submit" value="Save as Word" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
</body>

</html>
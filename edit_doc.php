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
    $id = $_GET['id'];
    ?>
    <form action="save_doc.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
        <textarea name="editor_content" id="editor"></textarea>
        <br>
        <input type="submit" value="Save as Word">
    </form>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: 'upload_img.php?command=QuickUpload&type=Files&responseType=json'
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>
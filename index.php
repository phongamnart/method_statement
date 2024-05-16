<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
</head>
<body>
    <form action="save.php" method="post">
        <textarea name="editor_content" id="editor"></textarea>
        <br>
        <input type="submit" value="Save as Word">
    </form>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>
</html>

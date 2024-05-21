<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable[role="textbox"] {
                /* Editing area */
                min-height: 200px;
            }
    </style>
</head>
<body>
    <form action="test.php" method="post">
        <textarea name="editor_content" id="editor"></textarea>
        <br>
        <input type="submit" value="Save as Word">
    </form>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: 'upload.php?command=QuickUpload&type=Files&responseType=json'
                }
            })
            .then(editor => {
                const editorElement = editor.ui.view.editable.element;
                editorElement.style.height = '100%';
                editorElement.style.width = '100%';
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>
</html>

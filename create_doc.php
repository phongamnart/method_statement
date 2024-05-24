<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Document</title>
    <style>
        form {
            width: 50%;
            margin: 0 auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Create Document</h1>
    <form action="create_doc_be.php" method="post" enctype="multipart/form-data">
        <label for="major">Major:</label>
        <select name="major" id="major" required>
            <option value="Civil">Civil</option>
            <option value="Electrical">Electrical</option>
            <option value="Mechanical">Mechanical</option>
        </select>

        <label for="doc_name">Document Title:</label>
        <input type="text" name="doc_name" id="doc_name" required>

        <label for="owner">Prepared By:</label>
        <input type="text" name="owner" id="owner" required>

        <!-- <label for="file">Upload DOC File:</label>
        <input type="file" name="doc_file" id="doc_file" accept=".doc,.docx">

        <label for="pdf_file">Upload PDF File:</label>
        <input type="file" name="pdf_file" id="pdf_file" accept=".pdf"> -->

        <input type="submit" value="Create Document">
    </form>
</body>
</html>
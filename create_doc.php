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
            <option value="civil">Civil</option>
            <option value="electrical">Electrical</option>
            <option value="mechanical">Mechanical</option>
        </select>

        <label for="doc_name">Document Title:</label>
        <input type="text" name="doc_name" id="doc_name" required>

        <label for="owner">Prepared By:</label>
        <input type="text" name="owner" id="owner" required>

        <label for="file">Upload File:</label>
        <input type="file" name="file" id="file" required>

        <input type="submit" value="Create Document">
    </form>
</body>
</html>
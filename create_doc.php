<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Create Document</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Create Document</h1>
        <form action="create_doc_be.php" method="post" enctype="multipart/form-data">
            <div class="container d-flex justify-content-center">
                <div class="mb-3 col-8">
                    <label for="major" class="form-label">Discipline:</label>
                    <select name="major" id="major" class="form-select" required>
                        <option value="">-- Select Discipline --</option>
                        <option value="Civil">Civil</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Mechanical">Mechanical</option>
                    </select>
                </div>
            </div>

            <div class="container d-flex justify-content-center">
                <div class="mb-3 col-8">
                    <label for="doc_name" class="form-label">Document Title:</label>
                    <input type="text" name="doc_name" id="doc_name" class="form-control" required>
                </div>
            </div>

            <div class="container d-flex justify-content-center">
                <div class="mb-3 col-8">
                    <label for="owner" class="form-label">Prepared By:</label>
                    <input type="text" name="owner" id="owner" class="form-control" required>
                </div>
            </div><br>


            <!-- <div class="mb-3">
                <label for="doc_file" class="form-label">Upload DOC File:</label>
                <input type="file" name="doc_file" id="doc_file" class="form-control" accept=".doc,.docx">
            </div>

            <div class="mb-3">
                <label for="pdf_file" class="form-label">Upload PDF File:</label>
                <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept=".pdf">
            </div> -->

            <div class="container">
                <div class="mb-3 mx-auto">
                    <button type="submit" class="btn btn-primary d-block mx-auto">Create Document</button>
                </div>
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
</body>

</html>
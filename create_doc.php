<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Create Document</title>
</head>

<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-custom" onclick="window.location.href='list_doc.php'" title="Back">
                <i class="bi bi-arrow-left fs-4"></i>
            </button>
            <button class="btn btn-custom" onclick="location.href='index.php';" title="Home">
                <i class="bi bi-house fs-4"></i>
            </button>
            <button class="btn btn-custom" onclick="window.location.href='create_doc.php'" title="Refresh">
                <i class="bi bi-arrow-clockwise fs-4"></i>
            </button>
        </div><br>
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

            <!-- เผื่อเพิ่ม -->
            <!-- <div class="mb-3">
                <label for="doc_file" class="form-label">Upload DOC File:</label>
                <input type="file" name="doc_file" id="doc_file" class="form-control" accept=".doc,.docx">
            </div>

            <div class="mb-3">
                <label for="pdf_file" class="form-label">Upload PDF File:</label>
                <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept=".pdf">
            </div> -->

            <div class="container d-flex justify-content-center">
                <div class="mb-3 col-8 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Create Document</button> <!-- ปุ่มสร้างเอกสาร -->
                </div>
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
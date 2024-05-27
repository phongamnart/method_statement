<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>List Documents</title>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this document?")) {
                location.href = 'delete.php?id=' + id;
            }
        }

        function searchDocuments() {
            var major = document.getElementById('major').value;
            var searchText = document.getElementById('searchText').value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.querySelector('table').innerHTML = this.responseText;
                }
            };
            xhr.open('GET', 'search.php?major=' + major + '&searchText=' + searchText, true);
            xhr.send();
        }
    </script>
</head>

<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-secondary" onclick="history.back()">Back</button>
            <button class="btn btn-primary btn-home" onclick="location.href='index.php';">Home</button>
        </div>
        <h1>List Documents</h1>
        <div class="search-container mb-3 row">
            <div class="col">
            <select name="major" id="major" class="form-select">
                <option value="">All</option>
                <option value="civil">Civil</option>
                <option value="electrical">Electrical</option>
                <option value="mechanical">Mechanical</option>
            </select>
            </div>
            <div class="col-md-6">
            <input type="text" id="searchText" class="form-control" placeholder="Search" onkeyup="searchDocuments()">
            </div>
        </div>

        <!-- <label for="fileType">Filter by Type:</label>
        <select name="fileType" id="fileType">
            <option value="">All</option>
            <option value="doc">Docx</option>
            <option value="pdf">PDF</option>
            <option value="both">Both</option>
        </select> -->


        <button class="btn btn-success mb-3" onclick="location.href='create_doc.php'">Create document</button>
        <br><br>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Item</th>
                        <th>Discipline</th>
                        <th>Document No.</th>
                        <th>Document Title</th>
                        <th>Date</th>
                        <th>Prepared By</th>
                        <th>Edit .docx</th>
                        <th>Download .docx</th>
                        <th>PDF</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("connect.php");
                    $conDB = new db_conn();

                    $sql = "SELECT * FROM documents";
                    $result = $conDB->sqlQuery($sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['major']}</td>";
                            echo "<td>{$row['doc_no']}</td>";
                            echo "<td>{$row['doc_name']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['owner']}</td>";

                            echo "<td><button onclick=\"location.href='edit_doc.php?id=" . md5($row['id']) . "'\" class='btn btn-primary'>Edit .docx</button></td>";

                            // echo "<td><button onclick=\"location.href='edit_doc.php?id={$row['id']}'\">Edit .docx</button></td>";

                            if (!empty($row['doc_file'])) { //download docx
                                echo "<td><button onclick=\"window.open('download.php?file={$row['doc_file']}')\" class='btn btn-secondary'>Download .docx</button></td>";
                            } else {
                                echo "<td>-</td>";
                            }

                            if (!empty($row['pdf_file'])) { ?>
                                <td><button onclick="window.open('saved_pdf_files/<?php echo $row['pdf_file']; ?>', '_blank');">PDF</button></td>
                    <?php } else {
                                echo "<td>-</td>";
                            }

                            echo "<td><button onclick='confirmDelete({$row['id']})' class='btn btn-danger'>Delete</button></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>

    <script>
        document.getElementById('major').addEventListener('change', function() {
            var major = this.value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.querySelector('table').innerHTML = this.responseText;
                }
            };
            xhr.open('GET', 'search.php?major=' + major, true);
            xhr.send();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
</body>

</html>
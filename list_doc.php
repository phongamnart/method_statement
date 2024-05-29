<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .btn-custom {
            padding: 0.5rem 1rem;
            background-color: transparent !important;
            border: none;
        }

        .table td,
        .table th {
            text-align: center;
            vertical-align: middle;
        }

        .text-left {
            text-align: left !important;
        }
    </style>
    <title>List Documents</title>
</head>

<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-custom" onclick="window.location.href='index.php'" title="Back">
                <i class="bi bi-arrow-left fs-4"></i>
            </button>
            <button class="btn btn-custom" onclick="location.href='index.php';" title="Home">
                <i class="bi bi-house fs-4"></i>
            </button>
            <button class="btn btn-custom" onclick="window.location.href='list_doc.php'" title="Refresh">
                <i class="bi bi-arrow-clockwise fs-4"></i>
            </button>
        </div>
        <h1>List Documents</h1><br>
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
            <div class="col">
                <input type="date" id="start_date" class="form-control" name="start_date" onchange="searchDocuments()">
            </div>
            <div class="col">
                <input type="date" id="end_date" class="form-control" name="end_date" onchange="searchDocuments()">
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-end">
            <button class="btn custom" onclick="location.href='create_doc.php'">
                <i class="bi bi-file-earmark-plus fs-1"></i>
            </button>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">Item</th>
                        <th width="8%">Discipline</th>
                        <th width="10%">Document No.</th>
                        <th width="49%">Document Title</th>
                        <th width="8%">Date</th>
                        <th width="10%">Prepared By</th>
                        <th width="10%">Revise</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("connect.php");
                    $conDB = new db_conn();

                    if (isset($_GET['major'])) {
                        $major = $_GET['major'];
                        $sql = "SELECT * FROM `documents` WHERE `major` = '$major'";
                    } else {
                        $sql = "SELECT * FROM documents";
                    }

                    $result = $conDB->sqlQuery($sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['major']}</td>";
                            echo "<td>{$row['doc_no']}</td>";
                            echo "<td class='text-left'>{$row['doc_name']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['owner']}</td>";

                            echo "<td><button onclick=\"location.href='edit_doc.php?id=" . md5($row['id']) . "'\" class='btn custom'>
                            <i class='bi bi-file-earmark-text fs-4'></i>
                            </button>
                            <button onclick='showDeleteModal({$row['id']})' class='btn custom'>
                            <i class='bi bi-trash fs-4'></i>
                            </button>
                            </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this document?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(id) { //confirm delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            document.getElementById('confirmDeleteButton').onclick = function() {
                location.href = 'delete.php?id=' + id;
            };
            deleteModal.show();
        }

        function searchDocuments() { //search
            var major = document.getElementById('major').value;
            var searchText = document.getElementById('searchText').value;
            var start_date = document.getElementById('start_date').value;
            var end_date = document.getElementById('end_date').value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.querySelector('table').innerHTML = this.responseText;
                }
            };
            xhr.open('GET', 'search.php?major=' + major + '&searchText=' + searchText + '&start_date=' + start_date + '&end_date=' + end_date, true);
            xhr.send();
        }

        document.getElementById('major').addEventListener('change', function() { //รับ major จาก index
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>List Documents</title>
</head>

<body>
    <div class="full-container-header-color">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-custom" onclick="history.back()" title="Back">
                <i class="bi bi-arrow-left fs-2"></i>
            </button>
            <button class="btn btn-custom" onclick="location.href='index.php';" title="Home">
                <img src="insert_img/logo.svg" alt="home" width="200" height="100">
            </button>
            <button class="btn btn-custom" onclick="window.location.href='list_elec.php'" title="Refresh">
                <i class="bi bi-arrow-clockwise fs-2"></i>
            </button>
        </div>
        <div class="search-container mb-3">
            <div class="row">
                <div class="col-md-2 d-flex justify-content-center">
                    <button class="btn custom" onclick="location.href='create_doc_elec.php'" title="add file">
                        <img src="insert_img/add.png" alt="add" width="70" height="70">
                    </button>
                </div>
                <div class="col-md-2">
                    <label for="discipline">Discipline: </label>
                    <select name="discipline" id="discipline" class="form-select">
                        <option value="electrical">Electrical</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="discipline">Work: </label>
                    <select name="discipline" id="discipline" class="form-select">
                        <option value="">All</option>
                        <option value="civil">Installation</option>
                        <option value="electrical">Test</option>
                        <option value="mechanical">Transportation</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="discipline">Type: </label>
                    <select name="discipline" id="discipline" class="form-select">
                        <option value="">All</option>
                        <option value="civil">Civil</option>
                        <option value="electrical">Electrical</option>
                        <option value="mechanical">Mechanical</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="search">Search: </label>
                    <input type="text" id="searchText" class="form-control" placeholder="Search" onkeyup="searchDocuments()">
                </div>
                <div class="col-md-2 offset-md-2">
                    <label for="start">Form: </label>
                    <input type="date" id="start_date" class="form-control" name="start_date" onchange="searchDocuments()">
                </div>
                <div class="col-md-2">
                    <label for="end">To: </label>
                    <input type="date" id="end_date" class="form-control" name="end_date" onchange="searchDocuments()">
                </div>
            </div>
        </div>
    </div>

    <div class="full-container">
        <div class="table-responsive">
            <table class="table table-bordered fixed-table">
                <thead class="table-secondary">
                    <tr>
                        <th>Item</th>
                        <th>Discipline</th>
                        <th>Document No.</th>
                        <th>Document Title</th>
                        <th>Date</th>
                        <th>Prepared By</th>
                        <th>Revise</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("connect.php");
                    $conDB = new db_conn();

                    $sql = "SELECT * FROM `documents` WHERE `discipline` = 'electrical'";

                    $result = $conDB->sqlQuery($sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['discipline']}</td>";
                            echo "<td>{$row['doc_no']}</td>";
                            echo "<td class='text-left'>{$row['doc_name']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['prepared_by']}</td>";
                            echo "<td><div class='button-group'>
                                    <button onclick=\"location.href='edit_doc_fix.php?id=" . md5($row['id']) . "'\" class='btn custom'>
                                        <img src='insert_img/edit-file.png' alt='edit' width='40' height='40'>
                                    </button>
                                    <button onclick='showDeleteModal({$row['id']})' class='btn custom'>
                                        <img src='insert_img/delete.png' alt='delete' width='40' height='40'>
                                    </button>
                                </div>
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
            var discipline = document.getElementById('discipline').value;
            var searchText = document.getElementById('searchText').value;
            var start_date = document.getElementById('start_date').value;
            var end_date = document.getElementById('end_date').value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.querySelector('table').innerHTML = this.responseText;
                }
            };
            xhr.open('GET', 'search.php?discipline=' + discipline + '&searchText=' + searchText + '&start_date=' + start_date + '&end_date=' + end_date, true);
            xhr.send();
        }

        document.getElementById('discipline').addEventListener('change', function() {
            var discipline = this.value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.querySelector('table').innerHTML = this.responseText;
                }
            };
            xhr.open('GET', 'search.php?discipline=' + discipline, true);
            xhr.send();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
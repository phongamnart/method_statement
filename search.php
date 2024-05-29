<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <title>Search Documents</title>
</head>

<body>
    <div class="container">
        <?php
        include("connect.php");
        $conDB = new db_conn();

        if (isset($_GET['major']) || isset($_GET['searchText']) || (isset($_GET['start_date']) && isset($_GET['end_date']))) {
            $major = isset($_GET['major']) ? $_GET['major'] : '';
            $searchText = isset($_GET['searchText']) ? $_GET['searchText'] : '';
            $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
            $sql = "SELECT * FROM `documents` WHERE 1=1";

            if (!empty($major) || !empty($searchText) || (!empty($start_date) && !empty($end_date))) {
                // Append WHERE clause based on conditions
                $sql .= " AND";
        
                // Append major condition
                if (!empty($major)) {
                    $sql .= " `major` = '$major'";
                }
        
                // Append searchText condition
                if (!empty($searchText)) {
                    if (!empty($major)) {
                        $sql .= " AND";
                    }
                    $sql .= " (`doc_no` LIKE '%$searchText%' OR `doc_name` LIKE '%$searchText%' OR `date` LIKE '%$searchText%' OR `owner` LIKE '%$searchText%')";
                }
        
                // Append date range condition
                if (!empty($start_date) && !empty($end_date)) {
                    if (!empty($major) || !empty($searchText)) {
                        $sql .= " AND";
                    }
                    $sql .= " `date` BETWEEN '$start_date' AND '$end_date'";
                }
            }
            
            // echo "query: " . $sql;
            $result = $conDB->sqlQuery($sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered'>";
                echo "<thead class='table-dark'>";
                echo "<tr>";
                echo "<th>Item</th>";
                echo "<th>Discipline</th>";
                echo "<th>Document No.</th>";
                echo "<th>Document Title</th>";
                echo "<th>Date</th>";
                echo "<th>Prepared By</th>";
                echo "<th>Edit .docx</th>";
                echo "<th>Download .docx</th>";
                echo "<th>PDF</th>";
                echo "<th>Delete</th>";
                echo "</tr>";
                echo "</thead>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['major']}</td>";
                    echo "<td>{$row['doc_no']}</td>";
                    echo "<td>{$row['doc_name']}</td>";
                    echo "<td>{$row['date']}</td>";
                    echo "<td>{$row['owner']}</td>";
                    echo "<td><button onclick=\"location.href='edit_doc.php?id=" . md5($row['id']) . "'\" class='btn btn-primary'>Edit .docx</button></td>";

                    if (!empty($row['doc_file'])) {
                        echo "<td><button onclick=\"window.open('download.php?file={$row['doc_file']}')\" class='btn btn-secondary'>Download .docx</button></td>";
                    } else {
                        echo "<td>-</td>";
                    }

                    if (!empty($row['pdf_file'])) {
                        echo "<td><button onclick=\"window.open('{$row['pdf_file']}', '_blank');\" class='btn btn-success'>PDF</button></td>";
                    } else {
                        echo "<td>-</td>";
                    }

                    echo "<td><button onclick='showDeleteModal({$row['id']})' class='btn btn-danger'>Delete</button></td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "<tr><td colspan='10'>No documents found</td></tr>";
            }
        }
        ?>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true"> <!--confirm delete style-->
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
        function showDeleteModal(id) {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            document.getElementById('confirmDeleteButton').onclick = function() {
                location.href = 'delete.php?id=' + id;
            };
            deleteModal.show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Documents</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid;
            font-size: 20px;
        }

        .btn-add {
            float: right;
            cursor: pointer;
        }

        .search-container {
            text-align: right;
            margin-bottom: 20px;
        }
    </style>
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
    <button onclick="history.back()">Back</button>
    <button class="btn-home" onclick="location.href='index.php';">Home</button>
    <h1>List Documents</h1>
    <div class="search-container">
        <label for="major">Filter by Discipline:</label>
        <select name="major" id="major">
            <option value="">All</option>
            <option value="civil">Civil</option>
            <option value="electrical">Electrical</option>
            <option value="mechanical">Machenical</option>
        </select>
        <!-- <label for="fileType">Filter by Type:</label>
        <select name="fileType" id="fileType">
            <option value="">All</option>
            <option value="doc">Docx</option>
            <option value="pdf">PDF</option>
            <option value="both">Both</option>
        </select> -->
        <input type="text" id="searchText" placeholder="Search" onkeyup="searchDocuments()">
    </div>
    <button class="btn-add" onclick="location.href='create_doc.php'">Create document</button>
    <br><br>
    <table>
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

                echo "<td><button onclick=\"location.href='edit_doc.php?id=".md5($row['id'])."'\">Edit .docx</button></td>";

                // echo "<td><button onclick=\"location.href='edit_doc.php?id={$row['id']}'\">Edit .docx</button></td>";

                if (!empty($row['doc_file'])) { //download docx
                    echo "<td><button onclick=\"window.open('download.php?file={$row['doc_file']}')\">Download .docx</button></td>";
                } else {
                    echo "<td>-</td>";
                }

                if (!empty($row['pdf_file'])) { ?>
                    <td><button onclick="window.open('saved_pdf_files/<?php echo $row['pdf_file']; ?>', '_blank');">PDF</button></td>
        <?php } else {
                    echo "<td>-</td>";
                }

                echo "<td><button onclick='confirmDelete({$row['id']})'>Delete</button></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
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
</body>

</html>
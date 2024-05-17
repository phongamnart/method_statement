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
        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid;
            font-size: 20px;
        }
        h1 {
            text-align: left;
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
</head>
<body>
    <h1>List Documents</h1>
    <div class="search-container">
        <label for="major">Filter by Major:</label>
        <select name="major" id="major">
            <option value="">All</option>
            <option value="civil">Civil</option>
            <option value="electrical">Electrical</option>
            <option value="mechanical">Mechanical</option>
        </select>
    </div>
    <button class="btn-add" onclick="location.href='create_doc.php'">Create file</button>
    <br><br>
    <table>
        <tr>
            <th>Item</th>
            <th>Discipline</th>
            <th>Document No.</th>
            <th>Document Title</th>
            <th>Date</th>
            <th>Prepared By</th>
            <th>Revise</th>
        </tr>
        <?php
        include("connect.php");

        $sql = "SELECT * FROM documents";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['major']}</td>";
                echo "<td>{$row['doc_no']}</td>";
                echo "<td>{$row['doc_name']}</td>";
                echo "<td>{$row['dateCreate']}</td>";
                echo "<td>{$row['owner']}</td>";
                echo "<td><button onclick(window.open'download.php?file={$row['doc_file']}')>revise</button>&nbsp;&nbsp;<button>delete</button></td>";
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

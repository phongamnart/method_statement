<?php
include("connect.php");

if(isset($_GET['major'])) {
    $major = $_GET['major'];
    $sql = "SELECT * FROM documents";
    if (!empty($major)) {
        $sql .= " WHERE major = '$major'";
    }

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        echo "<tr>";
        echo "<th>Item</th>";
        echo "<th>Discipline</th>";
        echo "<th>Document No.</th>";
        echo "<th>Document Title</th>";
        echo "<th>Date</th>";
        echo "<th>Prepared By</th>";
        echo "<th>Revise</th>";
        echo "</tr>";

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['major']}</td>";
            echo "<td>{$row['doc_no']}</td>";
            echo "<td>{$row['doc_name']}</td>";
            echo "<td>{$row['dateCreate']}</td>";
            echo "<td>{$row['owner']}</td>";
            echo "<td><button>edit</button>&nbsp;&nbsp;<button>delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No documents found</td></tr>";
    }
}
?>

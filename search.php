<?php
include("connect.php");
//isset($_GET['major']) || isset($_GET['searchText']) || 
if(isset($_GET['major']) || isset($_GET['searchText'])) {
    $major = isset($_GET['major']) ? $_GET['major'] : '';
    $searchText = isset($_GET['searchText']) ? $_GET['searchText'] : '';
    // $major = isset($_GET['major']) ? $_GET['major'] : '';
    $sql = "SELECT * FROM documents WHERE 1=1";

    if (!empty($major) && !empty($searchText)) {
        $sql .= " AND major = '$major' AND (doc_no LIKE '%$searchText%' OR doc_name LIKE '%$searchText%' OR date LIKE '%$searchText%' OR owner LIKE '%$searchText%')";
    } elseif (!empty($major)) {
        $sql .= " AND major = '$major'";
    } elseif (!empty($searchText)) {
        $sql .= " AND (doc_no LIKE '%$searchText%' OR doc_name LIKE '%$searchText%' OR date LIKE '%$searchText%' OR owner LIKE '%$searchText%')";
    }
    // if (!empty($major)) {
    //     if ($major == "docx") {
    //         $sql .= " AND doc_file != '' AND pdf_file = ''";
    //     } elseif ($major == "pdf") {
    //         $sql .= " AND pdf_file != '' AND doc_file = ''";
    //     } elseif ($major == "both"){
    //         $sql .= " AND doc_file AND pdf_file";
    //     }
    // }

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        echo "<tr>";
        echo "<th>Item</th>";
        echo "<th>Discipline</th>";
        echo "<th>Document No.</th>";
        echo "<th>Document Title</th>";
        echo "<th>Date</th>";
        echo "<th>Prepared By</th>";
        echo "<th>Revise DOC</th>";
        echo "<th>PDF</th>";
        echo "<th>Delete</th>";
        echo "</tr>";

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['major']}</td>";
            echo "<td>{$row['doc_no']}</td>";
            echo "<td>{$row['doc_name']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['owner']}</td>";
            if (!empty($row['doc_file'])) {
                echo "<td><button onclick=\"window.open('resive.php?file={$row['doc_file']}')\">Revise DOC</button></td>";
            } else {
                echo "<td>-</td>";
            }

            if (!empty($row['pdf_file'])) {
                echo "<td><button onclick=\"window.open('saved_pdf_files/{$row['pdf_file']}', '_blank');\">PDF</button></td>";
            } else {
                echo "<td>-</td>";
            }

            echo "<td><button onclick='confirmDelete({$row['id']})'>Delete</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No documents found</td></tr>";
    }
}

?>

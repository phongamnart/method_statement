<?php
include("connect.php");
$conDB = new db_conn();

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

    $result = $conDB->sqlQuery($sql);

    if(mysqli_num_rows($result) > 0) {
        echo "<tr>";
        echo "<th>Item</th>";
        echo "<th>Discipline</th>";
        echo "<th>Document No.</th>";
        echo "<th>Document Title</th>";
        echo "<th>Date</th>";
        echo "<th>Prepared By</th>";
        echo "<th>Edit DOC</th>";
        echo "<th>Download .docx</th>";
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
            echo "<td><button onclick=\"location.href='edit_doc.php?id=".md5($row['id'])."'\">Edit .docx</button></td>";

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
    } else {
        echo "<tr><td colspan='7'>No documents found</td></tr>";
    }
}

?>

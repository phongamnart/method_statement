<?php
session_start();
include("connect.php");
$conDB = new db_conn();

if (isset($_GET['discipline'])) {
    $_SESSION['discipline'] = $_GET['discipline'];
}

$start_date = isset($_SESSION['start_date']) ? $_SESSION['start_date'] : '';
$end_date = isset($_SESSION['end_date']) ? $_SESSION['end_date'] : '';
$discipline = isset($_SESSION['discipline']) ? $_SESSION['discipline'] : '';
$work = isset($_SESSION['work']) ? $_SESSION['work'] : '';
$type = isset($_SESSION['type']) ? $_SESSION['type'] : '';
$search = isset($_SESSION['search']) ? $_SESSION['search'] : '';

$sql = "SELECT * FROM `documents` WHERE `approved` = 0";
$result = $conDB->sqlQuery($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("_header.php"); ?>
    <title>List Approve</title>
</head>

<body>
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
                        <th>Approve</th>
                    </tr>
                </thead>
                <tbody><?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row["id"];
                        ?>
                        <tr>
                            <td><?php echo $id = $row["id"]; ?></td>
                            <td><?php echo $discipline = $row["discipline"]; ?></td>
                            <td><?php echo $doc_no = $row["doc_no"]; ?></td>
                            <td><?php echo $doc_name = $row["doc_name"]; ?></td>
                            <td><?php echo $date = $row["date"]; ?></td>
                            <td><?php echo $prepared_by = $row["prepared_by"] ?></td>
                            <td>
                                <div class='button-group'>
                                    <button onclick="location.href='approve_doc.php?id=<?php echo md5($row['id']) ?>'" class='btn custom'>
                                        <img src='insert_img/approve.png' alt='edit' width='30' height='30'>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include("_script.php"); ?>
</body>

</html>
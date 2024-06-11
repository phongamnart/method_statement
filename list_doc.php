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
if ($start_date == "") {
    $start_date = date("Y-01-01");
}
if ($end_date == "") {
    $end_date = date('Y-m-d');
}
if ($discipline != "") {
    $condition = " AND `discipline` = '" . $discipline . "'";
} else {
    $condition = "";
}
if ($work != "") {
    $condition .= " AND `work` = '" . $work . "'";
} else {
    $condition .= "";
}
if ($type != "") {
    $condition .= " AND `type` = '" . $type . "'";
} else {
    $condition .= "";
}

if ($search != "") {
    $condition .= " AND (`doc_no` LIKE '%$search%' OR `doc_name` LIKE '%$search%' OR `date` LIKE '%$search%' OR `prepared_by` LIKE '%$search%')";
} else {
    $condition .= "";
}

$sql = "SELECT * FROM `documents` WHERE `approved` = 1" . $condition;
$result = $conDB->sqlQuery($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("_header.php"); ?>
    <title>CMS: List Documents</title>
</head>

<body>
    <div class="row">
        <div class="col-md-2 d-flex justify-content-center">
            <button class="btn custom" onclick="location.href='create_doc.php'" title="add file">
                <img src="insert_img/add.png" alt="add" width="60" height="60">
            </button>
        </div>
        <div class="col-md-2">
            <label for="discipline">Discipline: </label>
            <select class="form-select" onchange="setFillter('discipline',this.value)">
                <option value="" <?php if ($discipline == '') {
                                        echo "selected";
                                    } ?>>All</option>
                <?php
                $sql2 = "SELECT DISTINCT `discipline` FROM `documents` WHERE `approved` = 1";
                $objQuery = $conDB->sqlQuery($sql2);

                while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                    <option value="<?php echo $objResult['discipline']; ?>" <?php if ($discipline == $objResult['discipline']) {
                                                                                echo "selected";
                                                                            } ?>>
                        <?php echo $objResult['discipline']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="work">Work: </label>
            <select class="form-select" onchange="setFillter('work',this.value)">
                <option value="" <?php if ($work == '') {
                                        echo "selected";
                                    } ?>>All</option>
                <?php
                if ($discipline != "") {
                    $condition2 = " AND `discipline` = '$discipline'";
                }
                $sql2 = "SELECT DISTINCT `work` FROM `documents` WHERE `approved` = 1" . $condition2;
                $objQuery = $conDB->sqlQuery($sql2);

                while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                    <option value="<?php echo $objResult['work']; ?>" <?php if ($work == $objResult['work']) {
                                                                            echo "selected";
                                                                        } ?>>
                        <?php echo $objResult['work']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="type">Type: </label>
            <select class="form-select" onchange="setFillter('type',this.value)">
                <option value="" <?php if ($type == '') {
                                        echo "selected";
                                    } ?>>All</option>
                <?php
                if ($work != "") {
                    $condition2 = " AND `work` = '$work'";
                }
                $sql2 = "SELECT DISTINCT `type` FROM `documents` WHERE `approved` = 1" . $condition2;
                $objQuery = $conDB->sqlQuery($sql2);

                while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                    <option value="<?php echo $objResult['type']; ?>" <?php if ($type == $objResult['type']) {
                                                                            echo "selected";
                                                                        } ?>>
                        <?php echo $objResult['type']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="search">Search: </label>
            <input type="text" id="search" class="form-control" placeholder="Search" onchange="setFillter('search', this.value)" value="<?php echo $search ?>">
        </div>
        <!-- <div class="col-md-2 offset-md-2">
                    <label for="start">Form: </label>
                    <input type="date" id="start_date" class="form-control" name="start_date" onchange="searchDocuments()">
                </div>
                <div class="col-md-2">
                    <label for="end">To: </label>
                    <input type="date" id="end_date" class="form-control" name="end_date" onchange="searchDocuments()">
                </div> -->
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
                        <th>Preview</th>
                        <th>Revise</th>
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
                            <td><button onclick="location.href='preview.php?id=<?php echo md5($row['id']) ?>'" class="btn-custom" title="Preview">
                                <img src="insert_img/preview.png" alt="preview" width="25" height="25">
                            </button></td>
                            <td>
                                <div class='button-group'>
                                    <button onclick="location.href='content.php?id=<?php echo md5($row['id']) ?>'" class='btn-custom' title="Edit document">
                                        <img src='insert_img/edit-file.png' alt='edit' width='25' height='25'>
                                    </button>
                                    <button onclick="setDelete('<?php echo $id ?>', '<?php echo $doc_no ?>')" class='btn-custom' title="Delete document">
                                        <img src='insert_img/delete.png' alt='delete' width='25' height='25'>
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
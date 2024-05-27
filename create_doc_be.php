<?php
include("connect.php");
$conDB = new db_conn();
function generateDocNo($major, $conDB)
{
    $prefix = '';
    switch ($major) {
        case 'Civil':
            $prefix = 'MS-CE-';
            break;
        case 'Electrical':
            $prefix = 'MS-EE-';
            break;
        case 'Mechanical':
            $prefix = 'MS-ME-';
            break;
    }

    $sql = "SELECT `doc_no` FROM `documents` WHERE `major`='$major' ORDER BY id DESC LIMIT 1";
    $result = $conDB->sqlQuery($sql);
    $latest_doc_no = mysqli_fetch_assoc($result);

    if ($latest_doc_no) {
        $last_number = (int)substr($latest_doc_no['doc_no'], strlen($prefix));
        $new_number = $last_number + 1;
    } else {
        $new_number = 1;
    }

    return $prefix . str_pad($new_number, 4, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $major = $_POST['major'];
    $doc_no = generateDocNo($major, $conDB);
    $doc_name = $_POST['doc_name'];
    $date = date('Y-m-d H:i:s');
    $owner = $_POST['owner'];

    echo $sql = "INSERT INTO `documents` (`major`, `doc_no`, `doc_name`, `date`, `owner`)
            VALUES ('$major', '$doc_no', '$doc_name', '$date', '$owner')";

    $conDB->sqlQuery($sql);

    $strSQL = "SELECT * FROM `documents` WHERE `date` = '$date' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQL);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $id = $objResult['id'];
    }
    header("Location: edit_doc.php?id=".md5($id)."");
    exit();
}

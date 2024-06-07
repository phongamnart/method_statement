<?php
include("connect.php");
$conDB = new db_conn();
function generateDocNo($discipline, $conDB)
{
    $prefix = '';
    switch ($discipline) {
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

    $sql = "SELECT `doc_no` FROM `documents` WHERE `discipline`='$discipline' ORDER BY id DESC LIMIT 1";
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
    $discipline = $_POST['discipline'];
    $work = $_POST['work'];
    $doc_no = generateDocNo($discipline, $conDB);
    $doc_name = $_POST['doc_name'];
    $date = date('Y-m-d');
    $prepared_by = $_POST['prepared_by'];

    $sql = "INSERT INTO `documents` (`discipline`, `work`, `doc_no`, `doc_name`, `date`, `prepared_by`)
            VALUES ('$discipline', '$work', '$doc_no', '$doc_name', '$date', '$prepared_by')";

    $conDB->sqlQuery($sql);

    $strSQL = "SELECT * FROM `documents` ORDER BY `id` DESC LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQL);
    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $id = $objResult['id'];
    }
    $_SESSION['discipline'] = $_POST['discipline'];
    $_SESSION['work'] = "";
    $_SESSION['type'] = "";
    
    header("Location: edit_doc.php?id=" . md5($id) . "");
    exit();
}

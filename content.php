<?php
session_start();
include("connect.php");
$conDB = new db_conn();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$sql = "SELECT * FROM `documents` WHERE md5(`id`) = '$id'";
$objQuery = $conDB->sqlQuery($sql);

while ($objResult = mysqli_fetch_assoc($objQuery)) {
    $doc_no = $objResult['doc_no'];
    $doc_name = $objResult['doc_name'];
}

$section_sql = "SELECT `section` FROM `content` WHERE `doc_no` = '$doc_no'";
$section_query = $conDB->sqlQuery($section_sql);
$existing_sections = [];

while ($section_result = mysqli_fetch_assoc($section_query)) {
    $existing_sections[] = $section_result['section'];
}

$sections = [
    "Scope of work", "Definitions", "References", "Tool & Equipment",
    "Responsibilities", "Manpower Required", "Material Requirements",
    "Equipment Requirements", "Health and Safety", "Work sequence",
    "Quality Control", "Inspection", "Test & Commissioning",
    "Supporting Documentation", "Distribution", "Appendix"
];

function isChecked($section, $existing_sections) {
    return in_array($section, $existing_sections) ? "checked" : "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content</title>
    <?php include("_header.php"); ?>
    <style>
        form {
            margin-top: 20px;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 5px;
            width: 80%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .content-container {
            margin: 20px;
        }
    </style>
</head>

<body>
    <div class="content-container">
        <div class="d-flex justify-content-between">
            <h3>Title: <?php echo $doc_name; ?></h3>
            <h3>Document No.: <?php echo $doc_no; ?></h3>
        </div>
        <div class="d-flex justify-content-center">
            <form action="edit.php?id=<?php echo $id; ?>" method="post" id="myForm">
                <h4>Content:</h4><br>
                <div>
                    <?php for ($i = 0; $i < 8; $i++) : ?>
                        <div class="form-group">
                            <input type="checkbox" id="checkbox<?php echo $i + 1; ?>" name="checkboxes[]" value="<?php echo $sections[$i]; ?>" <?php echo isChecked($sections[$i], $existing_sections); ?>>
                            <label for="checkbox<?php echo $i + 1; ?>"><?php echo $i + 1 . ' ' . $sections[$i]; ?></label>
                        </div>
                    <?php endfor; ?>
                </div>
                <div>
                    <?php for ($i = 8; $i < count($sections); $i++) : ?>
                        <div class="form-group">
                            <input type="checkbox" id="checkbox<?php echo $i + 1; ?>" name="checkboxes[]" value="<?php echo $sections[$i]; ?>" <?php echo isChecked($sections[$i], $existing_sections); ?>>
                            <label for="checkbox<?php echo $i + 1; ?>"><?php echo $i + 1 . ' ' . $sections[$i]; ?></label>
                        </div>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            </form>
        </div>
        <button type="submit" class="btn btn-success" id="nextBtn">Next</button>
    </div>
    <script>
        document.getElementById("nextBtn").addEventListener("click", function() {
            document.getElementById("myForm").submit();
        });
    </script>
</body>

</html>

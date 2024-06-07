<?php
session_start();
include("connect.php");
$conDB = new db_conn();
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
            <h3>Title: </h3>
            <h3>Document No.: </h3>
        </div>
        <div class="d-flex justify-content-center">
            <form action="edit.php" method="post" id="myForm">
                <h4>Content:</h4><br>
                <div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox1" name="checkboxes[]" value="1 Scope of work">
                        <label for="checkbox1">1 Scope of work</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox2" name="checkboxes[]" value="2 Definitions">
                        <label for="checkbox2">2 Definitions</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox3" name="checkboxes[]" value="3 References">
                        <label for="checkbox3">3 References</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox4" name="checkboxes[]" value="4 Tool & Equipment">
                        <label for="checkbox4">4 Tool & Equipment</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox5" name="checkboxes[]" value="5 Responsibilities">
                        <label for="checkbox5">5 Responsibilities</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox6" name="checkboxes[]" value="6 Manpower Required">
                        <label for="checkbox6">6 Manpower Required</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox7" name="checkboxes[]" value="7 Material Requirements">
                        <label for="checkbox7">7 Material Requirements</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox8" name="checkboxes[]" value="8 Equipment Requirements">
                        <label for="checkbox8">8 Equipment Requirements</label>
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox9" name="checkboxes[]" value="9 Health and Safety">
                        <label for="checkbox9">9 Health and Safety</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox10" name="checkboxes[]" value="10 Work requence">
                        <label for="checkbox10">10 Work requence</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox11" name="checkboxes[]" value="11 Qualitty Control">
                        <label for="checkbox11">11 Qualitty Control</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox12" name="checkboxes[]" value="12 Inspection">
                        <label for="checkbox12">12 Inspection</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox13" name="checkboxes[]" value="13 Test & Commissioning">
                        <label for="checkbox13">13 Test & Commissioning</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox14" name="checkboxes[]" value="14 Supporting Documentation">
                        <label for="checkbox14">14 Supporting Documentation</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox15" name="checkboxes[]" value="15 Distribution">
                        <label for="checkbox15">15 Distribution</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="checkbox16" name="checkboxes[]" value="16 Appendix">
                        <label for="checkbox16">16 Appendix</label>
                    </div>
                </div>
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
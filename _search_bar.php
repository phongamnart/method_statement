<div class="row">
        <div class="col-md-2 d-flex justify-content-center">
            <button class="btn custom" onclick="location.href='create_doc.php'" title="add file">
                <img src="insert_img/add.png" alt="add" width="50" height="50">
            </button>
        </div>
        <div class="col-md-2">
            <label for="discipline">Discipline: </label>
            <select class="form-select search-bar" onchange="setFillter('discipline',this.value)">
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
            <select class="form-select search-bar" onchange="setFillter('work',this.value)">
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
            <select class="form-select search-bar" onchange="setFillter('type',this.value)">
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
        <div class="col-md-3">
            <label for="search">Search: </label>
            <input type="text" id="search" class="form-control search-bar" placeholder="Search" onchange="setFillter('search', this.value)">
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
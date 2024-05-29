<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS : Construction method statement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <style>
        .btn-clear {
            background-color: transparent !important;
            /*ลบพื้นหลัง*/
            border: 5px solid aqua;
        }

        .btn-circle {
            /*ทำปุ่มกลม*/
            width: 150px;
            height: 150px;
            border-radius: 100%;
            overflow: hidden;
            /*ตัดรูปถ้าเกินขอบ*/
        }

        .btn-main {
            /*ปุ่มเข้าหน้า list_doc*/
            width: 200px;
            height: 200px;
            border-radius: 100%;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="display-3">CMS</h1>
        <h5 class="display-6">CONSTRUCTION METHOD STATEMENT</h5>
        <br><br><br><br>
        <div class="d-flex justify-content-center">
            <button onclick="window.location.href='list_doc.php'" class="btn btn-primary btn-main btn-clear"> <!--ปุ่มไปหน้า list_doc-->
                <img src="insert_img/all_doc.png" alt="list_doc" width="140" height="140">
            </button>
        </div>
        <div class="d-flex justify-content-end">
            <button onclick="searchDocuments('civil')" class="btn btn-primary btn-circle btn-clear mx-2"> <!--ปุ่มไปหน้าค้นหา Civil-->
                <img src="insert_img/civil.png" alt="civil" width="100" height="100">
            </button>
            <button onclick="searchDocuments('electrical')" class="btn btn-primary btn-circle btn-clear mx-2"> <!--ปุ่มไปหน้าค้นหา Electrical-->
                <img src="insert_img/elec.png" alt="electrical" width="100" height="100">
            </button>
            <button onclick="searchDocuments('mechanical')" class="btn btn-primary btn-circle btn-clear mx-2"> <!--ปุ่มไปหน้าค้นหา Mechanical-->
                <img src="insert_img/mec.png" alt="mechanical" width="100" height="100">
            </button>
        </div>
    </div>
    <script>
        function searchDocuments(major) {
            window.location.href = 'list_doc.php?major=' + major;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
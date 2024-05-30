<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-custom {
            padding: 0.5rem 1rem;
            background-color: transparent !important;
            border: none;
        }

        #container {
            width: 100%;
            margin: 20px auto;
            padding: 20px auto;
        }

        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            min-height: 200px;
        }

        .ck-content .image {
            /* Block images */
            max-width: 80%;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <?php
    include("connect.php");
    $conDB = new db_conn();

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $strSQLl =  "SELECT * FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQLl);

    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $tag_html = $objResult['tag_html'];
        $pdf_file = $objResult['pdf_file'];
    }

    ?>
    <div class="full-container-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-custom" onclick="history.back()" title="Back">
                <i class="bi bi-arrow-left fs-2"></i>
            </button>
            <button class="btn btn-custom" onclick="location.href='index.php';" title="Home">
                <img src="insert_img/ite_logo.png" alt="home" width="200" height="60">
            </button>
            <button class="btn btn-custom" onclick="window.location.href='edit_doc.php?id=<?php echo $id ?>'" title="Refresh">
                <i class="bi bi-arrow-clockwise fs-2"></i>
            </button>
        </div>
        <div class="d-flex justify-content-end">
            <button onclick="window.location.href='download.php?id=<?php echo $id ?>'" title="Download .docx file" class="btn custom">
                <img src="insert_img/word.png" alt="home" width="50" height="50">
            </button>
            <button onclick="window.open('<?php echo $pdf_file; ?>', '_blank');" title="Download .pdf file" class="btn custom">
                <img src="insert_img/pdf.png" alt="home" width="50" height="50">
            </button>
        </div>
        <div class="row mt-3">
            <div class="col">
                <form action="save_doc.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <textarea name="editor_content" id="editor"><?php echo $tag_html; ?></textarea>
                    <br>
                    <input type="submit" value="Save as Word" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
    <div id="container">
        <div id="editor">
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <script>
        CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
            toolbar: {
                items: [
                    'undo', 'redo',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'alignment', '|',
                    'link', 'uploadImage', 'insertTable', 'mediaEmbed', '|',
                    'horizontalLine', 'pageBreak', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            placeholder: 'Create document from CMS: Construction method statement',
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            uploadAdapter: {
                uploadUrl: "upload_img.php", // URL ของไฟล์ upload_img.php
                withCredentials: true, // กำหนดให้ใช้งาน cookies และโทเค็นของอินเทอร์เฟซสำหรับการอัปโหลดภาพ
            },
            removePlugins: [
                // These two are commercial, but you can try them out without registering to a trial.
                // 'ExportPdf',
                // 'ExportWord',
                'AIAssistant',
                'CKBox',
                'CKFinder',
                'EasyImage',
                // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                // Storing images as Base64 is usually a very bad idea.
                // Replace it on production website with other solutions:
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                // 'Base64UploadAdapter',
                'MultiLevelList',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                'MathType',
                // The following features are part of the Productivity Pack and require additional license.
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents',
                'PasteFromOfficeEnhanced',
                'CaseChange'
            ]
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>
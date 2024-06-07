<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <?php include("_header.php");?>
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
        $doc_no = $objResult['doc_no'];
        $doc_name = $objResult['doc_name'];
    }

    ?>
    <div class="full-container-header">
        <div class="row">
            <div class="col">
                <form action="save_doc.php" method="post">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="inline-elements">
                            <h2 id="docNo"><?php echo $doc_no; ?></h2>
                            <h2><?php echo $doc_name; ?></h2>
                        </div>
                        <div>
                            <button onclick="window.location.href='download.php?id=<?php echo $id ?>'" title="Download .docx file" class="btn custom">
                                <img src="insert_img/word.png" alt="home" width="50" height="50">
                            </button>
                            <button onclick="window.open('<?php echo $pdf_file; ?>', '_blank');" title="Download .pdf file" class="btn custom">
                                <img src="insert_img/pdf.png" alt="home" width="50" height="50">
                            </button>
                        </div>
                    </div>
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
    <?php include("_script.php");?>
    <script>
        var documentId = "<?php echo $id; ?>";
        CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
            ckfinder: {
                uploadUrl: "upload_img.php?id=" + documentId + "&command=QuickUpload&type=Files&responseType=json"
            },
            toolbar: {
                items: [
                    'undo', 'redo',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'alignment', '|',
                    '-',
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
            // placeholder: 'Create document from CMS: Construction method statement',
            fontFamily: {
                options: ['Browallia New'],
                supportAllValues: true,
                default: 'Browallia New'
            },
            fontSize: {
                options: [20],
                supportAllValues: true,
                default: '20px'
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
            // uploadAdapter: {
            //     uploadUrl: "upload_img.php", // URL ของไฟล์ upload_img.php
            //     withCredentials: true, // กำหนดให้ใช้งาน cookies และโทเค็นของอินเทอร์เฟซสำหรับการอัปโหลดภาพ
            // },
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
</body>

</html>
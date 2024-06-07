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
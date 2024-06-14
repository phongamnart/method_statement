<script>
    function createEditor(element) {
        CKEDITOR.ClassicEditor.create(element, {
            toolbar: {
                items: [
                    'undo', 'redo',
                    'alignment', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'bold', 'italic', 'underline', 'subscript', 'superscript', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'insertTable', '|',
                    'horizontalLine', 'pageBreak', '|',
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
            removePlugins: [
                // 'ExportPdf',
                // 'ExportWord',
                'AIAssistant',
                'CKBox',
                'CKFinder',
                'EasyImage',
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
                'MathType',
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents',
                'PasteFromOfficeEnhanced',
                'CaseChange'
            ]
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // createEditor(document.getElementById("editor"));
        document.querySelectorAll('textarea').forEach(function(textarea) {
            createEditor(textarea);
        });

        document.getElementById("addTextButton").addEventListener("click", function() {
            addNewEditor();
        });

        document.getElementById("deleteTextButton").addEventListener("click", function(event) {
            event.preventDefault();
            deleteLastEditor();
        });

        function addNewEditor() {
            const form = document.getElementById("editorForm");

            // Create a new div and textarea for the CKEditor
            const newEditorContainer = document.createElement("div");
            newEditorContainer.className = "editor-container";
            const newTextArea = document.createElement("textarea");
            newTextArea.name = "editor_content[]";
            newTextArea.className = "editor";
            newTextArea.id = "editor" + (document.querySelectorAll("textarea").length + 1);

            // Append the new textarea to the div container
            newEditorContainer.appendChild(newTextArea);

            const br = document.createElement("br");

            // Insert the new editor before the submit button
            form.insertBefore(br, form.querySelector('input[type="submit"]'));
            form.insertBefore(newEditorContainer, form.querySelector('input[type="submit"]'));
            form.insertBefore(br, form.querySelector('input[type="submit"]'));

            // Create the CKEditor for the new textarea
            createEditor(newTextArea);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'insert_to_db.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Data inserted successfully!');
                } else {
                    console.error('Error occurred while inserting data.');
                }
            };
            xhr.send('doc_no=<?php echo $rows[0]['doc_no']; ?>');
        }

        function deleteLastEditor() {
            const form = document.getElementById("editorForm");
            const editors = form.querySelectorAll(".editor-container");
            const brs = form.querySelectorAll("br");

            if (editors.length > 1) {
                const lastEditor = editors[editors.length - 1];
                const lastBrBefore = brs[brs.length - 2];
                const lastBrAfter = brs[brs.length - 1];

                form.removeChild(lastEditor);
                form.removeChild(lastBrBefore);
                form.removeChild(lastBrAfter);
            }
        }

        function filePickerHandler() {
            var fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*'; // กำหนดให้เฉพาะไฟล์ภาพ
            fileInput.style.display = 'none'; // ซ่อน input element ไว้

            // เมื่อผู้ใช้เลือกไฟล์ ให้ทำการอัปโหลด
            fileInput.addEventListener('change', function() {
                var formData = new FormData();
                formData.append('image', fileInput.files[0]); // เพิ่มไฟล์ที่เลือกลงใน FormData

                // ส่งข้อมูลไปยัง upload_img.php ด้วย XMLHttpRequest
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_img.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.uploaded) {
                            document.getElementById('uploadStatus').innerHTML = '';
                            var imageContainer = document.getElementById('imageContainer');
                            var img = document.createElement('img');
                            img.src = response.url;
                            img.style.maxWidth = '100%';
                            imageContainer.appendChild(img);
                        } else {
                            document.getElementById('uploadStatus').innerHTML = '<p style="color: red;">Error: ' + response.error.message + '</p>';
                        }
                    } else {
                        document.getElementById('uploadStatus').innerHTML = '<p style="color: red;">An error occurred while uploading the image.</p>';
                    }
                };
                xhr.send(formData);
            });

            // คลิกที่ input element โดยอัตโนมัติ
            fileInput.click();
        }

        document.getElementById('filePicker').addEventListener('click', function(event) {
            event.preventDefault();
            filePickerHandler();
        });
    });
</script>
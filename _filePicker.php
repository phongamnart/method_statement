<script>
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
</script>
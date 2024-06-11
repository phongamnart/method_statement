<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>


<script>
    function setFillter(param, value) {
        console.log(param + value)
        $.post("services/setfillter.php", {
                param: param,
                value: value
            })
            .done(function(data) {
                console.log(value);
                window.location.reload();
            });
        return false;
        console.log(param);
    }

    function setDelete(id, doc_no) {
        if (confirm("Do you want to delete this " + doc_no + " Yes/No?") == true) {
            deleteData(id, "documents")
        }
    }

    function deleteData(id, table) {
        $.post("services/delete.php", {
                id: id,
                table: table
            })
            .done(function(data) {
                window.location.reload();
            });
        return false;
        console.log(id);
    }

    function combineAndSubmit() {
        var allContent = "";
        var editors = document.querySelectorAll('[name="editor_content[]"]');
        editors.forEach(function(editor) {
            allContent += editor.value + "\n";
        });
        document.querySelector('[name="editor_content[]"]').value = allContent;
        document.getElementById("ckeditorForm").submit();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const pageTitle = document.getElementById('page-title');
        const currentUrl = window.location.href;

        if (currentUrl.includes('list_doc.php')) {
            pageTitle.textContent = 'CMS: List Documents';
        } else if (currentUrl.includes('list_approve.php')) {
            pageTitle.textContent = 'CMS: List Approves';
        } else if (currentUrl.includes('create_doc.php')) {
            pageTitle.textContent = 'CMS: Create Document';
        } else {
            pageTitle.textContent = 'CMS';
        }
    });
</script>
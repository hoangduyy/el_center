$(document).ready(function () {
    ProductController.init();
});

var ProductController = {
    init: function () {
        $('select[name="category_id"]').select2({
            allowClear: true
        });

        $('select[name="ram"]').select2({
            allowClear: true
        });

        $('select[name="cpu"]').select2({
            allowClear: true
        });

        $('select[name="hot"]').select2({
            allowClear: true
        });

        ProductController.handelQuillEditor();
    },

    handelQuillEditor() {
        if (selectorIsExits("#editor__short_description")) {
            var quillValue = $('input[name=short_description]').val();
            var quill = new Quill('#editor__short_description', {
                modules: {
                    toolbar: [
                        ['bold', 'italic'],
                        ['link', 'blockquote', 'code-block'], // 'image'
                        [{ list: 'ordered' }, { list: 'bullet' }]
                    ]
                },
                placeholder: 'Nhập mô tả ngắn giới thiệu thông tin khóa học',
                theme: 'snow'
            });
            quill.root.innerHTML = quillValue;

            var form = document.getElementById("store-update-course");
            form.onsubmit = function() {
                var name = document.querySelector('input[name=short_description]');
                // name.value = quill.getText(); // quillText
                name.value = quill.root.innerHTML.trim(); // quillHTML
                return true; // submit form
            }
        }
    },
};

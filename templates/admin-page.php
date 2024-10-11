<div class="wrap">
    <h1>Gaza Page Builder</h1>

    <!-- نموذج الصفحة -->
    <form id="gaza-form" method="post" action="">
        <!-- Nonce لحماية النموذج -->
        <?php wp_nonce_field('save_gaza_page', 'gaza_nonce'); ?>

        <!-- ID الصفحة المخفية -->
        <input type="hidden" name="page_id" value="<?php echo esc_attr($post_id); ?>">

        <!-- إدخال عنوان الصفحة -->
        <div class="form-group">
            <label for="page-title"><strong>Page Title:</strong></label>
            <input type="text" id="page-title" name="page_title" style="width:100%;" 
                   value="<?php echo esc_attr($page_title); ?>" required>
        </div>

        <div class="form-group">
            <label><strong>HTML Preview:</strong></label>
            <div id="html-preview" style="border: 1px solid #ccc; padding: 10px; min-height: 200px;"></div>
        </div>

        <!-- إدراج عناصر HTML -->
        <div class="form-group">
            <label for="html-snippets"><strong>Insert HTML Snippet:</strong></label>
            <select id="html-snippets" style="width:100%; margin-bottom: 10px;">
                <option value="">Select a snippet</option>
                <option value="<div class='alert alert-info'>This is an Info Alert</div>">Info Alert</option>
                <option value="<div class='container'></div>">Container</option>
                <option value="<div class='row'>1</div>">Row</option>
                <option value="<div class='card'>1</div>">Card</option>
                <option value="<button class='btn btn-primary'>Primary Button</button>">Primary Button</option>
                <option value="<h1 class='display-4'>Heading 1</h1>">Heading 1</option>
                <option value="<img src='https://via.placeholder.com/150' alt='Sample Image' class='img-fluid rounded' />">Image Placeholder</option>
                <option value="<div class='row'><div class='col-md-6'>Column 1</div><div class='col-md-6'>Column 2</div></div>">Two Columns Row</option>
                <option value="<table class='table'><thead><tr><th>Header</th></tr></thead><tbody><tr><td>Data</td></tr></tbody></table>">Table</option>
            </select>
            <button type="button" id="insert-snippet" class="button">Insert Snippet</button>
        </div>

        <!-- زر لتحميل الصور من مكتبة الوسائط -->
        <div class="form-group">
            <label for="media-upload"><strong>Insert Image:</strong></label><br>
            <button type="button" id="upload-image" class="button">Upload Image</button>
        </div>

        <!-- إدخال الكود HTML المخصص باستخدام CodeMirror -->
        <div class="form-group">
            <label for="custom-html-editor"><strong>Page Content (HTML):</strong></label>
            <textarea id="custom-html-editor" name="page_content" rows="15" style="width:100%;"><?php
            if (!empty($page_content)) {
                echo esc_textarea($page_content);
            }
            ?></textarea>
        </div>

        <!-- قسم المعاينة (العرض المباشر) -->


        <!-- زر لحفظ الصفحة -->
        <div class="form-group">
            <button type="submit" name="submit_page" class="button button-primary">Save Page</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editorElement = document.getElementById('custom-html-editor');
        var previewElement = document.getElementById('html-preview');

        if (editorElement) {
            // تهيئة CodeMirror في محرر النصوص
            var codeMirrorEditor = wp.codeEditor.initialize(editorElement, {
                mode: 'htmlmixed',
                lineNumbers: true,
                indentUnit: 4,
                tabSize: 4,
                autoCloseTags: true,
                matchBrackets: true,
                extraKeys: { "Ctrl-Space": "autocomplete" },
            });

            // تحديث المعاينة عند تغيير محتوى CodeMirror
            codeMirrorEditor.codemirror.on('change', function() {
                // جلب محتوى المحرر
                var htmlContent = codeMirrorEditor.codemirror.getValue();
                var bootstrapCSS = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';
                // تحديث محتوى المعاينة
                previewElement.innerHTML = htmlContent + bootstrapCSS ;
            });

            // زر إدراج snippet
            var insertSnippetBtn = document.getElementById('insert-snippet');
            var htmlSnippets = document.getElementById('html-snippets');

            insertSnippetBtn.addEventListener('click', function () {
                var snippet = htmlSnippets.value;
                if (snippet) {
                    // إدراج الكود في CodeMirror
                    codeMirrorEditor.codemirror.replaceRange(snippet + "\n", codeMirrorEditor.codemirror.getCursor());
                }
            });

            // التعامل مع مكتبة الوسائط الخاصة بووردبريس
            document.getElementById('upload-image').addEventListener('click', function (e) {
                e.preventDefault();
                
                // فتح مكتبة الوسائط الخاصة بووردبريس
                var mediaUploader = wp.media({
                    title: 'Insert Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false 
                });

                mediaUploader.on('select', function () {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    var imgSnippet = '<img src="' + attachment.url + '" alt="' + attachment.alt + '" class="img-fluid" />';
                    
                    // إدراج الصورة في محرر CodeMirror
                    codeMirrorEditor.codemirror.replaceRange(imgSnippet + "\n", codeMirrorEditor.codemirror.getCursor());
                });

                mediaUploader.open();
            });
        }
    });
</script>

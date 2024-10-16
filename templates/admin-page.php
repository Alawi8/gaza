<div class="wrap">
    <h1>Gaza Page Builder</h1>

    <!-- نموذج الصفحة -->
    <form id="gaza-form" method="post" action="">
        <!-- Nonce لحماية النموذج -->
        <?php wp_nonce_field('save_gaza_page', 'gaza_nonce'); ?>

 <?php       // شورت كود يعرض رسالة ترحيبية
function welcome_message_shortcode() {
    return '<p>Welcome to our website!</p>';
}
add_shortcode('welcome_message', 'welcome_message_shortcode');

// شورت كود يعرض صورة
function image_shortcode() {
    return '<img src="https://via.placeholder.com/150" alt="Placeholder Image" />';
}
add_shortcode('image_placeholder', 'image_shortcode');

// شورت كود يعرض جدول
function table_shortcode() {
    return '<table border="1"><tr><th>Header</th></tr><tr><td>Data</td></tr></table>';
}
add_shortcode('simple_table', 'table_shortcode');?>
<?php
function display_page_content_with_shortcodes($content) {
    // تفسير الشورت كود في المحتوى باستخدام do_shortcode
    return do_shortcode($content);
}

// استدعاء الدالة عند عرض محتوى الصفحة
add_filter('the_content', 'display_page_content_with_shortcodes');?>


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
                <option
                    value="<img src='https://via.placeholder.com/150' alt='Sample Image' class='img-fluid rounded' />">
                    Image Placeholder</option>
                <option
                    value="<div class='row'><div class='col-md-6'>Column 1</div><div class='col-md-6'>Column 2</div></div>">
                    Two Columns Row</option>
                <option
                    value="<table class='table'><thead><tr><th>Header</th></tr></thead><tbody><tr><td>Data</td></tr></tbody></table>">
                    Table</option>
            </select>
            <button type="button" id="insert-snippet" class="button">Insert Snippet</button>
        </div>

        <div class="form-group">
    <label for="html-snippets"><strong>Insert Snippet or Shortcode:</strong></label>
    <select id="html-snippets" style="width:100%; margin-bottom: 10px;">
        <option value="">Select a snippet or shortcode</option>
        <!-- HTML Snippets -->
        <option value="<div class='alert alert-info'>This is an Info Alert</div>">Info Alert</option>
        <option value="<div class='container'></div>">Container</option>
        <option value="<div class='row'>1</div>">Row</option>
        <!-- Shortcodes -->
        <option value="[welcome_message]">Welcome Message</option>
        <option value="[image_placeholder]">Image Placeholder</option>
        <option value="[simple_table]">Simple Table</option>
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
<?php
// دالة تعرض المقالات بدون تنسيقات
function display_plain_posts() {
    // استعلام لجلب آخر 5 مقالات
    $args = array(
        'post_type' => 'post',  // نوع المقالات
        'posts_per_page' => 5,  // عدد المقالات المطلوب عرضها
    );
    
    // استعلام للحصول على المقالات
    $query = new WP_Query($args);
    
    // بدء مخرجات الـ HTML
    $output = '';

    // التحقق إذا كان هناك مقالات
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post(); // جلب المقالات
            
            // عرض عنوان المقال مع رابط
            $output .= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
            
            // عرض مقتطف المقال أو محتوى كامل
            $output .= '<p>' . wp_strip_all_tags(get_the_excerpt()) . '</p>';
        }
    } else {
        $output .= '<p>No posts found.</p>';
    }
    
    // إعادة ضبط بيانات الاستعلام
    wp_reset_postdata();
    
    return $output; // إعادة النتائج ليتم عرضها بواسطة الشورت كود
}

// إضافة الشورت كود
add_shortcode('plain_posts', 'display_plain_posts');
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editorElement = document.getElementById('custom-html-editor');
    var previewElement = document.getElementById('html-preview');

    if (editorElement) {
        // تهيئة CodeMirror مع إعدادات المسافة
        var codeMirrorEditor = wp.codeEditor.initialize(editorElement, {
            mode: 'htmlmixed',         // دعم HTML و JavaScript و CSS
            lineNumbers: true,         // عرض أرقام الأسطر
            indentUnit: 4,             // عدد المسافات لكل مستوى مسافة بادئة (4 مسافات)
            tabSize: 4,                // حجم التبويب (4 مسافات)
            indentWithTabs: false,     // استخدم المسافات بدلًا من التبويبات
            autoCloseTags: true,       // إغلاق العلامات تلقائيًا
            matchBrackets: true,       // مطابقة الأقواس تلقائيًا
            smartIndent: true,         // التوسيع الذكي بناءً على الكود السابق
            extraKeys: {
                "Tab": function(cm) {  // استخدام المسافات عند الضغط على Tab
                    cm.replaceSelection("    ", "end"); // إدراج 4 مسافات بدل التبويب
                },
                "Enter": "newlineAndIndentContinueMarkdownList"
            }
        });

        // زر إدراج Snippet أو Shortcode
        var insertSnippetBtn = document.getElementById('insert-snippet');
        var htmlSnippets = document.getElementById('html-snippets');

        insertSnippetBtn.addEventListener('click', function () {
            var snippet = htmlSnippets.value;
            if (snippet) {
                // إدراج الكود أو الشورت كود في CodeMirror
                codeMirrorEditor.codemirror.replaceRange(snippet + "\n", codeMirrorEditor.codemirror.getCursor());
            }
        });

        // تحديث المعاينة عند تغيير المحتوى
        codeMirrorEditor.codemirror.on('change', function() {
            var htmlContent = codeMirrorEditor.codemirror.getValue();
            previewElement.innerHTML = htmlContent;
        });
    }
});
</script>
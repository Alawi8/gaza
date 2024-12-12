<div class="wrap">
    <h1>Gaza Page Builder</h1>

    <form id="gaza-form" method="post" action="">
        <?php wp_nonce_field('save_gaza_page', 'gaza_nonce'); ?>

        <?php       // شورت كود يعرض رسالة ترحيبية
        function welcome_message_shortcode()
        {
            return '<p>Welcome to our website!</p>';
        }
        add_shortcode('welcome_message', 'welcome_message_shortcode');

        function image_shortcode()
        {
            return '<img src="https://via.placeholder.com/150" alt="Placeholder Image" />';
        }
        add_shortcode('image_placeholder', 'image_shortcode');

        function table_shortcode()
        {
            return '<table border="1"><tr><th>Header</th></tr><tr><td>Data</td></tr></table>';
        }
        add_shortcode('simple_table', 'table_shortcode'); ?>
        <?php
        function display_page_content_with_shortcodes($content)
        {
            return do_shortcode($content);
        }

        add_filter('the_content', 'display_page_content_with_shortcodes'); ?>


        <input type="hidden" name="page_id" value="<?php echo esc_attr($post_id); ?>">

        <div class="form-group">
            <label for="page-title"><strong>Page Title:</strong></label>
            <input type="text" id="page-title" name="page_title" style="width:100%;"
                value="<?php echo esc_attr($page_title); ?>" required>
        </div>

        <div class="form-group">
            <label><strong>HTML Preview:</strong></label>
            <div id="html-preview" style="border: 1px solid #ccc; padding: 10px; min-height: 200px;"></div>
        </div>

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


        <div class="form-group">
            <label for="media-upload"><strong>Insert Image:</strong></label><br>
            <button type="button" id="upload-image" class="button">Upload Image</button>
        </div>

        <div class="form-group">
            <label for="custom-html-editor"><strong>Page Content (HTML):</strong></label>
            <textarea id="custom-html-editor" name="page_content" rows="15" style="width:100%;"><?php
                                                                                                if (!empty($page_content)) {
                                                                                                    echo esc_textarea($page_content);
                                                                                                }
                                                                                                ?></textarea>
        </div>


        <div class="form-group">
            <button type="submit" name="submit_page" class="button button-primary">Save Page</button>
        </div>
    </form>
</div>
<?php
function display_plain_posts()
{
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5,
    );

    $query = new WP_Query($args);

    $output = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $output .= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';

            $output .= '<p>' . wp_strip_all_tags(get_the_excerpt()) . '</p>';
        }
    } else {
        $output .= '<p>No posts found.</p>';
    }

    wp_reset_postdata();

    return $output;
}

add_shortcode('plain_posts', 'display_plain_posts');
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var editorElement = document.getElementById('custom-html-editor');
        var previewElement = document.getElementById('html-preview');

        if (editorElement) {
            var codeMirrorEditor = wp.codeEditor.initialize(editorElement, {
                mode: 'htmlmixed',
                lineNumbers: true,
                indentUnit: 4,
            tabSize: 4,
                indentWithTabs: false,
                autoCloseTags: true,
                matchBrackets: true,
                smartIndent: true,
                extraKeys: {
                    "Tab": function(cm) {
                        cm.replaceSelection("    ", "end");
                    },
                    "Enter": "newlineAndIndentContinueMarkdownList"
                }
            });

            var insertSnippetBtn = document.getElementById('insert-snippet');
            var htmlSnippets = document.getElementById('html-snippets');

            insertSnippetBtn.addEventListener('click', function() {
                var snippet = htmlSnippets.value;
                if (snippet) {
                    codeMirrorEditor.codemirror.replaceRange(snippet + "\n", codeMirrorEditor.codemirror.getCursor());
                }
            });

            codeMirrorEditor.codemirror.on('change', function() {
                var htmlContent = codeMirrorEditor.codemirror.getValue();
                previewElement.innerHTML = htmlContent;
            });
        }
    });
</script>
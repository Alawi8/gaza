<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Page with Gaza Editor</title>
    <?php wp_head(); // استدعاء الـ CSS والجافا سكريبت الخاصة بووردبريس ?>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        #gaza-editor-wrapper {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #gaza-editor-header {
            padding: 10px;
            background-color: #333;
            color: white;
        }
        #gaza-editor-content {
            flex-grow: 1;
            padding: 20px;
        }
        #gaza-editor-footer {
            padding: 10px;
            background-color: #333;
            color: white;
            text-align: right;
        }
        textarea {
            width: 100%;
            height: 80vh;
        }
    </style>
</head>
<body>
    <div id="gaza-editor-wrapper">
        <div id="gaza-editor-header">
            <h1>Editing: <?php echo esc_html($page_title); ?></h1>
        </div>
        <div id="gaza-editor-content">
            <form method="post">
                <?php wp_nonce_field('gaza_save_page', 'gaza_nonce'); ?>
                <input type="hidden" name="page_id" value="<?php echo esc_attr($post_id); ?>">
                <label for="page_title">Page Title:</label>
                <input type="text" name="page_title" value="<?php echo esc_attr($page_title); ?>" required>

                <label for="page_content">Page Content:</label>
                <textarea name="page_content" required><?php echo esc_textarea($page_content); ?></textarea>

                <input type="submit" name="submit_page" value="Save Page">
            </form>
        </div>
        <div id="gaza-editor-footer">
            <button onclick="window.close();">Close Editor</button>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>

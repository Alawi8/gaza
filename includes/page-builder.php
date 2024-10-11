<?php
// دالة عرض صفحة التحرير
function gaza_admin_page() {
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    $post = get_post($post_id);
    $page_title = $post ? $post->post_title : '';
    $page_content = $post ? $post->post_content : '';

    include plugin_dir_path(__FILE__) . '../templates/admin-page.php'; // استدعاء الصفحة الرئيسية
}

// دالة معالجة النموذج وتحديث المحتوى

// دالة معالجة النموذج وتحديث المحتوى
function gaza_handle_form_submission() {
    if (isset($_POST['submit_page'])) {
        // الحصول على معرف الصفحة
        $page_id = intval($_POST['page_id']);
        
        // تنظيف عنوان الصفحة
        $page_title = sanitize_text_field($_POST['page_title']);

        // إلغاء الفلترة للسماح بحفظ الكلاسات والعناصر HTML بدون قيود
        $page_content = $_POST['page_content']; // بدون wp_kses أو أي فلترة أخرى

        // استبدال محتوى القالب (إذا كنت تستخدم قالباً معيناً)
        $template = get_option('gaza_template', '');
        $page_content = str_replace('{{content}}', $page_content, $template);

        // تحديث الصفحة في قاعدة البيانات
        $updated_page = array(
            'ID'           => $page_id,
            'post_title'   => $page_title,
            'post_content' => $page_content,
        );

        // تحديث الصفحة باستخدام wp_update_post
        wp_update_post($updated_page);

        // حفظ ميتا مفتاح لتحديد أن الصفحة تم تعديلها بواسطة Gaza Editor
        update_post_meta($page_id, '_gaza_modified', '1');

        // إعادة التوجيه إلى قائمة الصفحات بعد التحديث
        wp_redirect(admin_url('edit.php?post_type=page'));
        exit;
    }
}
add_action('admin_init', 'gaza_handle_form_submission');


// إضافة رابط "Edit with Gaza" في صفحة تحرير الصفحات
function gaza_add_edit_link($actions, $post) {
    if ($post->post_type == 'page') {
        $actions['edit_with_gaza'] = '<a href="' . admin_url('admin.php?page=gaza&post_id=' . $post->ID) . '">Edit with Gaza</a>';
    }
    return $actions;
}
add_filter('page_row_actions', 'gaza_add_edit_link', 10, 2);

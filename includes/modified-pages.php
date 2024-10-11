<?php
// دالة لعرض الصفحات المعدلة بواسطة Gaza Editor
function gaza_modified_pages() {
    global $wpdb;

    // استعلام لجلب جميع الصفحات التي تم تعديلها بواسطة Gaza Editor
    $args = array(
        'post_type' => 'page',
        'meta_key' => '_gaza_modified', // افتراض أن هناك ميتا مفتاح مخصص لتحديد الصفحات المعدلة
        'meta_value' => '1',            // القيمة التي تحدد أنها معدلة بواسطة Gaza
        'posts_per_page' => -1,         // جلب جميع الصفحات المعدلة
    );

    $modified_pages = get_posts($args);

    ?>
    <div class="wrap">
        <h1>الصفحات المعدلة بواسطة Gaza Editor</h1>
        <table class="widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th class="manage-column column-title">العنوان</th>
                    <th class="manage-column column-author">المؤلف</th>
                    <th class="manage-column column-date">تاريخ التعديل</th>
                    <th class="manage-column column-actions">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($modified_pages): ?>
                    <?php foreach ($modified_pages as $page): ?>
                        <tr>
                            <td><?php echo esc_html($page->post_title); ?></td>
                            <td><?php echo esc_html(get_the_author_meta('display_name', $page->post_author)); ?></td>
                            <td><?php echo esc_html(get_the_modified_date('F j, Y', $page->ID)); ?></td>
                            <td>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=gaza&post_id=' . $page->ID)); ?>" class="button">تعديل</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">لا توجد صفحات معدلة بواسطة Gaza Editor حتى الآن.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

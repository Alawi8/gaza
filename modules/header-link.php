<?php
function gaza_header_link_page() {
    if (isset($_POST['add_link']) && check_admin_referer('add_cdn_link_nonce')) {
        $new_link = esc_url_raw($_POST['new_link']);
        if (!empty($new_link)) {
            $header_links = get_option('gaza_header_links', array());
            $header_links[] = $new_link;
            update_option('gaza_header_links', $header_links);
        }
    }

    if (isset($_GET['delete_link']) && check_admin_referer('delete_cdn_link_nonce')) {
        $delete_index = intval($_GET['delete_link']);
        $header_links = get_option('gaza_header_links', array());
        if (isset($header_links[$delete_index])) {
            unset($header_links[$delete_index]);
            $header_links = array_values($header_links); 
            update_option('gaza_header_links', $header_links);
        }
    }

    $header_links = get_option('gaza_header_links', array());
    ?>
    <div class="wrap">
        <h1>CDN Link Settings</h1>

        <form method="post" action="">
            <?php wp_nonce_field('add_cdn_link_nonce');?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Add New CDN Link</th>
                    <td>
                        <input type="url" name="new_link" value="" style="width:100%;" placeholder="https://cdn.example.com/file.css" required />
                    </td>
                </tr>
            </table>
            <button type="submit" name="add_link" class="button button-primary">Add CDN Link</button>
        </form>

        <hr>

        <h2>Existing CDN Links</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>CDN Link</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($header_links)): ?>
                    <?php foreach ($header_links as $index => $link): ?>
                        <tr>
                            <td><a href="<?php echo esc_url($link); ?>" target="_blank"><?php echo esc_html($link); ?></a></td>
                            <td>
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=gaza-header-link&delete_link=' . $index), 'delete_cdn_link_nonce'); ?>" class="button button-secondary" onclick="return confirm('Are you sure you want to delete this CDN link?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No CDN links added yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function gaza_add_cdn_links_to_header() {
    $header_links = get_option('gaza_header_links', array());

    if (!empty($header_links)) {
        foreach ($header_links as $link) {
            if (preg_match('/\.css$/', $link)) {
                echo '<link rel="stylesheet" href="' . esc_url($link) . '" />' . "\n";
            } elseif (preg_match('/\.js$/', $link)) {
                echo '<script src="' . esc_url($link) . '"></script>' . "\n";
            }
        }
    }
}
add_action('wp_head', 'gaza_add_cdn_links_to_header');
?>

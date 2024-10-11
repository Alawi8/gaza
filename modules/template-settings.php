<?php
function gaza_template_settings_page() {
    ?>
    <div class="wrap">
        <h1>Template Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('gaza-template-settings-group');
            do_settings_sections('gaza-template-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                <th scope="row">Template HTML</th>
                <td><textarea name="gaza_template" rows="10" style="width:100%;"><?php echo esc_textarea(get_option('gaza_template', '{{content}}')); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

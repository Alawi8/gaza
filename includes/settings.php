<?php
function gaza_register_settings() {
    register_setting('gaza-header-link-settings-group', 'gaza_header_link');
    register_setting('gaza-template-settings-group', 'gaza_template');
}
add_action('admin_init', 'gaza_register_settings');
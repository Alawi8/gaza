<?php
/*
Plugin Name: Gaza
Description: Simple page builder using HTML snippets.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// تضمين الملفات الضرورية
include_once plugin_dir_path(__FILE__) . 'includes/settings.php';
include_once plugin_dir_path(__FILE__) . 'includes/page-builder.php';
include_once plugin_dir_path(__FILE__) . 'modules/header-link.php';
include_once plugin_dir_path(__FILE__) . 'modules/template-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/header-settings.php';
include_once plugin_dir_path(__FILE__) . 'includes/modified-pages.php';

// إضافة ملفات JavaScript وCSS
function gaza_enqueue_admin_scripts()
{
    wp_enqueue_script('gaza-admin-js', plugin_dir_url(__FILE__) . 'assets/js/gaza-admin.js', array('jquery'), '1.0', true);
    wp_enqueue_style('gaza-admin-css', plugin_dir_url(__FILE__) . 'assets/css/gaza-admin.css');
}
add_action('admin_enqueue_scripts', 'gaza_enqueue_admin_scripts');

// إضافة القائمة في لوحة التحكم
function gaza_add_admin_menu()
{
    // إضافة القائمة الرئيسية
    add_menu_page(null , 'Gaza', 'manage_options', 'gaza', 'gaza_admin_page', 'dashicons-editor-code', 6);
    // إضافة القوائم الفرعية
    add_submenu_page('gaza', 'Modified Pages', 'Modified Pages', 'manage_options', 'gaza-modified-pages', 'gaza_modified_pages');
    add_submenu_page('gaza', 'Header Link Settings', 'Header Link', 'manage_options', 'gaza-header-link', 'gaza_header_link_page');
    add_submenu_page('gaza', 'Template Settings', 'Template', 'manage_options', 'gaza-template-settings', 'gaza_template_page');
    add_submenu_page('gaza', 'Settings', 'Settings', 'manage_options', 'gaza-template-settings-page', 'gaza_template_settings_page');
    add_submenu_page('gaza', 'Header Settings', 'Header', 'manage_options', 'gaza-template-header', 'gaza_template_header_page');
    add_submenu_page('gaza', 'Footer Settings', 'Footer', 'manage_options', 'gaza-template-footer', 'gaza_template_footer_page');
}
add_action('admin_menu', 'gaza_add_admin_menu');




function load_code_mirror_editor($hook)
{
    // تأكد من تحميل CodeMirror فقط في الصفحة الخاصة بالباني
    if ($hook != 'toplevel_page_gaza') {
        return;
    }

    // تحميل مكتبة CodeMirror الخاصة بووردبريس
    wp_enqueue_script('wp-codemirror');
    wp_enqueue_style('wp-codemirror');

    // تحميل إعدادات CodeMirror
    wp_enqueue_script('code-editor', includes_url('js/code-editor.min.js'), array('wp-codemirror'), false, true);
    wp_enqueue_style('code-editor', includes_url('css/code-editor.min.css'));

    // تحميل ملفات الإكمال التلقائي الخاصة بـ CodeMirror
    wp_enqueue_script('codemirror-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/show-hint.min.js', array('wp-codemirror'), '5.65.5', true);
    wp_enqueue_script('codemirror-html-hint', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/html-hint.min.js', array('wp-codemirror', 'codemirror-hint'), '5.65.5', true);

    // تحميل CSS الخاص بالإكمال التلقائي
    wp_enqueue_style('codemirror-hint-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/addon/hint/show-hint.min.css', array(), '5.65.5');
}
add_action('admin_enqueue_scripts', 'load_code_mirror_editor');
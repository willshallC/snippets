<?php
/*

Plugin Name: My Custom Post Types Plugin
Description: This plugin adds custom post types to WordPress.
Version: 1.0
Author: Ravi

*/

// Add the settings menu item to the admin dashboard
function custom_post_types_menu() {
    add_menu_page(
        'Custom Post Types Settings',
        'Custom Post Types',
        'manage_options',
        'custom-post-types-settings',
        'custom_post_types_settings_page'
    );
}
add_action('admin_menu', 'custom_post_types_menu');
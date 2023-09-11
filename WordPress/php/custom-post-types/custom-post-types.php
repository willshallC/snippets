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


// Create the settings page content
function custom_post_types_settings_page() { 
    ?>
    <div class="wrap">
        <h2>Custom Post Types Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('custom_post_types_settings_group'); ?>
            <?php do_settings_sections('custom-post-types-settings'); ?>
            <input type="submit" class="button-primary" value="Save Settings">
        </form>
    </div>
    <?php
}
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

// Register custom post types based on user input
function register_custom_post_types() {
    // Get user-defined post types from the settings
    $custom_post_types = get_option('custom_post_types');

    if (!empty($custom_post_types)) {
        foreach ($custom_post_types as $post_type) {
            $labels = array(
                'name' => $post_type,
                'singular_name' => $post_type,
                'menu_name' => $post_type,
            );

            $args = array(
                'labels' => $labels,
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => sanitize_title($post_type)),
            );

            register_post_type(sanitize_title($post_type), $args);
        }
    }
}
add_action('init', 'register_custom_post_types');
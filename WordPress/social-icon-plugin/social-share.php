<?php
/*
Plugin Name: Social Icons
Description: Adds Social Media icon using shortcode anywhere.
Version: 1.0
Author: Ayush Kumar
 Author URI: https://www.willshall.com
*/

// Enqueue Font Awesome CSS, JS, and custom CSS files from CDN
function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3');
    wp_enqueue_script('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js', array(), '5.15.3');
    wp_enqueue_style('social-icon', plugin_dir_url(__FILE__) . 'social-icon.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Create a table in the database when the plugin is activated
function social_icons_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'socialicons';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        url VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'social_icons_activate');

// Add menu page in the WordPress dashboard
function social_icon_menu() {
    add_menu_page(
        'Social Icons',
        'Social Icons',
        'manage_options',
        'social_icon_menu',
        'social_icon_page',
        'dashicons-share',
        20
    );
}
add_action('admin_menu', 'social_icon_menu');
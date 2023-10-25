<?php
/*
Plugin Name: Custom Quick View 
Description: Add a quick view feature to your WordPress site.
Version: 1.0
Author: Ravi
*/


// Add admin menu page for the plugin
function custom_quick_view_menu() {
    add_menu_page(
        'Custom Quick View Settings', // Page title
        'Custom Quick View',         // Menu title
        'manage_options',            // Capability required to access
        'custom-quick-view-settings', // Menu slug
        'custom_quick_view_settings_page', // Callback function to display the page
        'dashicons-cart',            // Icon URL or Dashicon name
        100                          // Menu position
    );
}
add_action('admin_menu', 'custom_quick_view_menu');


// Callback function to display the settings page
function custom_quick_view_settings_page() {
	?>
    <div class="wrap">
		<h1>Custom Quick View Settings</h1>
		<h2>Shortcode : <span style="color:#1877f2;">[latest_products] </span></h2>
    </div>
<?php

}


// Enqueue the JavaScript and CSS for the quick view functionality.
function custom_quick_view_enqueue_scripts() {

// Enqueue JavaScript file
wp_enqueue_script( 'custom-script', plugin_dir_url(__FILE__) . '/quickview.js', array('jquery'), '1.0', true );

//Enqueue CSS file
wp_enqueue_style( 'custom-css', plugin_dir_url(__FILE__) . '/quickview.css', array(), '1.0' );
}
add_action('wp_enqueue_scripts', 'custom_quick_view_enqueue_scripts');


function latest_products_shortcode($attss) {
    // Parse shortcode attributes
    $attss = shortcode_atts(array(
        'per_page' => 3, // Default to 3 products per page
        'pagination' => 'no', // Default to no pagination
    ), $attss);
	
    // Query to retrieve the latest products
    $argss = array(
        'post_type' => 'product',
        'posts_per_page' => $attss['per_page'],
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    );
}
// Register the shortcode
add_shortcode('latest_products', 'latest_products_shortcode');


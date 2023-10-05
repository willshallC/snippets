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
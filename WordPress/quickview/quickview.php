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


function display_latest_products() {
    // Query WooCommerce for the latest 3 products
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        echo '<div class="latest-products">';
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            // Get product tags
            
            ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail(); ?>
                    <h2><?php the_title(); ?></h2>
                    <span class="price"><?php echo $product->get_price_html(); ?></span>
                  
                </a>
            <?php
        }
        echo '</div>';
        wp_reset_postdata();
    }
}


}
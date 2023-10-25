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

    $products = new WP_Query($argss);
    ob_start();
    if ($products->have_posts()) {
        echo '<ul class="latest-products">';
        while ($products->have_posts()) {
             $products->the_post();
            $product_id = get_the_ID(); // Get the product ID
            $permalink = get_permalink(get_the_ID());
            echo '<li class="product">';       
            
			echo '<div class="product-image">';
            $product_image = get_the_post_thumbnail();
			
            echo '<div class="product-image">' . $product_image . '</div>';
			
			echo '<span class="quick-view" data-product-id="' . $product_id . '" data-product-title="' . get_the_title() . '">Quick View</span>';
			
            echo '<h2>' . get_the_title() . '</h2>';
			echo '<p>' . get_the_excerpt() . '</p>';
			
            $price = wc_price(get_post_meta(get_the_ID(), '_price', true));

            echo '<p class="product-price">' .  $price . '</p>';

           			
			$categories = get_the_terms(get_the_ID(), 'product_cat');
			if (!empty($categories)) {
				
				foreach ($categories as $category) {
					$category_link = get_term_link($category);
					if (!is_wp_error($category_link)) {
						echo '<span class="category"> <strong>Category:</strong> <a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a></span>';
					} else {
						echo '<span class="category">' . esc_html($category->name) . '</span>';
					}
				}
				
			}

			$tags = get_the_terms(get_the_ID(), 'product_tag');
			if (!empty($tags)) {
				
				foreach ($tags as $tag) {
					$tag_link = get_term_link($tag);
					if (!is_wp_error($tag_link)) {
						echo '<span class="tag"><strong> Tag: </strong><a href="' . esc_url($tag_link) . '">' . esc_html($tag->name) . '</a></span>';
					} else {
						echo '<span class="tag">' . esc_html($tag->name) . '</span>';
					}
				}
				
			}
			
            echo '</li>';
            echo '<div class="modal-box" data-product-id="' . $product_id . '">';
            
			echo '<div class="modal-content">';
            echo '<div class="modal-cont-wrap">';
			
            			
            echo '<div class="product-img">' . get_the_post_thumbnail() . '</div>';
			
            echo '<div class="modal-right-cont">';
			echo '<span class="close">&times;</span>';
            echo '<h2>' . get_the_title() . '</h2>';			
			echo '<p>' . get_the_excerpt() . '</p>';
			
			$price = wc_price(get_post_meta(get_the_ID(), '_price', true));
			echo '<p class="product-price">' .  $price . '</p>';
			
			echo '<a href="'.$permalink.'">';
			echo '<div class="woocommerce">' . woocommerce_template_loop_add_to_cart() . '</div>'; 
			echo '</a><br>';
			
						
			$categories = get_the_terms(get_the_ID(), 'product_cat');
			if (!empty($categories)) {
				
				foreach ($categories as $category) {
					$category_link = get_term_link($category);
					if (!is_wp_error($category_link)) {
						echo '<span class="category"> <strong>Category:</strong> <a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a></span>';
					} else {
						echo '<span class="category">' . esc_html($category->name) . '</span>';
					}
				}
				
			}

			$tags = get_the_terms(get_the_ID(), 'product_tag');
			if (!empty($tags)) {
				
				foreach ($tags as $tag) {
					$tag_link = get_term_link($tag);
					if (!is_wp_error($tag_link)) {
						echo '<span class="tag"><strong> Tag: </strong><a href="' . esc_url($tag_link) . '">' . esc_html($tag->name) . '</a></span>';
					} else {
						echo '<span class="tag">' . esc_html($tag->name) . '</span>';
					}
				}
				
			}
			
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';    
        }
        echo '</ul>';
        wp_reset_postdata();
    } 
    return ob_get_clean();
}
// Register the shortcode
add_shortcode('latest_products', 'latest_products_shortcode');
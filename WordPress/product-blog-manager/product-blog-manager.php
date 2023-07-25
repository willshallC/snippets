<?php
/**
 * Plugin Name: Product Blog Manager
 * Plugin URI: 
 * Description: Adds a blog selection option to WooCommerce products.
 * Version: 1.0.0
 * Author: Ayush Kumar
 * Author URI: https://www.willshall.com/
 * License: GPL2
 */

// Enqueue stylesheets and scripts
function product_blog_manager_enqueue_scripts() {
    wp_enqueue_style( 'product-blog-manager-styles', plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'product_blog_manager_enqueue_scripts' );


// Enqueue stylesheets and scripts For Admin
function product_blog_manager_enqueue_scripts_admin() {
    wp_enqueue_script( 'product-blog-manager-scripts', plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'jquery', 'select2' ), '', true );
}
add_action( 'admin_enqueue_scripts', 'product_blog_manager_enqueue_scripts_admin' );

// Add a new meta box to the product editor screen
function product_blog_manager_add_meta_box() {
    add_meta_box( 'product-blog-manager-meta-box', 'Product Blog Manager', 'product_blog_manager_meta_box_content', 'product', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'product_blog_manager_add_meta_box' );


// Display the content of the meta box
function product_blog_manager_meta_box_content( $post ) {
    // Retrieve the assigned blogs for the product
    $assigned_blogs = get_post_meta( $post->ID, '_assigned_blogs', true );
    
    // Query all blog posts
    $blog_posts = get_posts( array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    ) );
    
    // Display the blog selection dropdown with search
    echo '<select name="assigned_blogs[]" multiple="multiple" class="product-blog-manager-blog-dropdown" style="width:100%;" data-placeholder="Select blogs...">';
    
    foreach ( $blog_posts as $blog_post ) {
        $selected = in_array( $blog_post->ID, $assigned_blogs ) ? 'selected' : '';
        echo '<option value="' . $blog_post->ID . '" ' . $selected . '>' . $blog_post->post_title . '</option>';
    }
    
    echo '</select>';
    
    // Add a nonce field for security
    wp_nonce_field( 'product_blog_manager_save_meta_box', 'product_blog_manager_nonce' );
}

// Save the meta box content
function product_blog_manager_save_meta_box( $post_id ) {
    // Check if the current user is authorized to save the post
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Verify the nonce field
    if ( ! isset( $_POST['product_blog_manager_nonce'] ) || ! wp_verify_nonce( $_POST['product_blog_manager_nonce'], 'product_blog_manager_save_meta_box' ) ) {
        return;
    }
    
    // Sanitize and save the assigned blog IDs
    if ( isset( $_POST['assigned_blogs'] ) ) {
        $assigned_blogs = array_map( 'intval', $_POST['assigned_blogs'] );
    } else {
        $assigned_blogs = array();
    }
    
    update_post_meta( $post_id, '_assigned_blogs', $assigned_blogs );
}
add_action( 'save_post', 'product_blog_manager_save_meta_box' );

// Display the assigned blogs on the product page
function product_blog_manager_display_assigned_blogs() {
    global $product;
    
    $product_id = $product->get_id();
    $assigned_blogs = get_post_meta( $product_id, '_assigned_blogs', true );
    
    if ( ! empty( $assigned_blogs ) ) {
        echo '<div class="product-blog-manager-assigned-blogs">';
        echo '<h4>Related Blogs</h4>';
        echo '<div class="assigned-blogs-container">';
        
        $blog_counter = 0;
        $row_open = false;
        
        foreach ( $assigned_blogs as $blog_id ) {
            $blog_permalink = get_permalink( $blog_id );
            $blog_title = get_the_title( $blog_id );
            $blog_excerpt = get_the_excerpt( $blog_id );
            $blog_thumbnail = get_the_post_thumbnail_url( $blog_id, 'thumbnail' );
            
            if ( $blog_counter % 3 === 0 ) {
                if ( $row_open ) {
                    echo '</div>'; // Close the previous row
                }
                echo '<div class="assigned-blogs-row">';
                $row_open = true;
            }
            
            echo '<div class="assigned-blog">';
            
            // Display the blog image
            if ( $blog_thumbnail ) {
                echo '<a href="' . $blog_permalink . '"><img src="' . $blog_thumbnail . '" alt="' . $blog_title . '"></a>';
            }
            
            // Display the blog title
            echo '<h5><a href="' . $blog_permalink . '">' . $blog_title . '</a></h5>';
            
            // Display the blog description
            echo '<p>' . wp_trim_words( $blog_excerpt, 20 ) . '...</p>';
            
            // Display the "View More" button
            echo '<a class="view-more-button" href="' . $blog_permalink . '">View More</a>';
            
            echo '</div>';
            
            $blog_counter++;
        }
        
        if ( $row_open ) {
            echo '</div>'; // Close the last row
        }
        
        echo '</div>';
        echo '</div>';
    }
}
add_action( 'woocommerce_after_single_product_summary', 'product_blog_manager_display_assigned_blogs', 30 );

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

function register_custom_taxonomy() {
    $labels = array(
        'name' => 'Custom Categories',
        'singular_name' => 'Custom Category',
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'custom-category'), // Adjust the slug as needed
    );

    register_taxonomy('custom_category', array('your_custom_post_type_slug'), $args);
}
add_action('init', 'register_custom_taxonomy');



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
				 'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'page-attributes'), 
				'taxonomies' => array('custom_category'), // Add your taxonomy slug here
			);

            register_post_type(sanitize_title($post_type), $args);
        }
    }
}

add_action('init', 'register_custom_post_types');



// Register settings for custom post types
function custom_post_types_settings() {
    register_setting('custom_post_types_settings_group', 'custom_post_types', 'sanitize_post_types');
    add_settings_section('custom_post_types_section', 'Custom Post Types', 'custom_post_types_section_callback', 'custom-post-types-settings');
    add_settings_field('custom_post_types_field', 'Enter Custom Post Types (comma separated)', 'custom_post_types_field_callback', 'custom-post-types-settings', 'custom_post_types_section');
}
add_action('admin_init', 'custom_post_types_settings');



// Sanitize user input
function sanitize_post_types($input) {
    $custom_post_types = explode(',', $input);
    $sanitized_types = array();

    foreach ($custom_post_types as $post_type) {
        $sanitized_types[] = sanitize_text_field(trim($post_type));
    }

    return $sanitized_types;
}

// Display custom post types field on the settings page
function custom_post_types_field_callback() {
    $custom_post_types = get_option('custom_post_types');
    $custom_post_types = is_array($custom_post_types) ? implode(', ', $custom_post_types) : '';
    echo "<input type='text' name='custom_post_types' value='" . esc_attr($custom_post_types) . "' />";
}

// Display section description
function custom_post_types_section_callback() {
    echo 'Enter custom post types separated by commas.';
}



function custom_taxonomy_meta_box() {
    add_meta_box(
        'custom_taxonomy_box_id',
        'Custom Categories',
        'custom_taxonomy_box_content',
        'your_custom_post_type_slug', // Replace with your custom post type slug
        'side', // Change the position of the meta box if needed
        'default'
    );
}
add_action('add_meta_boxes', 'custom_taxonomy_meta_box');

function custom_taxonomy_box_content($post) {
    // Display taxonomy input/select field here
    $terms = wp_get_post_terms($post->ID, 'custom_category'); // Replace with your taxonomy name
    $selected = !empty($terms) ? $terms[0]->term_id : 0;
    $taxonomy = get_taxonomy('custom_category'); // Replace with your taxonomy name

    echo '<select name="custom_category">';
    foreach (get_terms('custom_category') as $term) {
        echo '<option value="' . esc_attr($term->term_id) . '" ' . selected($selected, $term->term_id, false) . '>' . esc_html($term->name) . '</option>';
    }
    echo '</select>';
}
<?php
/*
Plugin Name: Products Discount
Plugin URI: https://ravi.redefiningweb.com/
Description: Products Discount Plugin
Version: 1.0
Author: Ravi 
*/

// Add a sub-menu under the "WooCommerce" menu
function custom_woocommerce_discounts_submenu() {
    add_submenu_page(
        'woocommerce',
        'Product Discounts',
        'Product Discounts',
        'manage_options',
        'custom-woocommerce-discounts',
        'custom_woocommerce_discounts_page_callback'
    );
}
add_action('admin_menu', 'custom_woocommerce_discounts_submenu');


function custom_woocommerce_discounts_page_callback() {
    // Check if the form is submitted
    if (isset($_POST['submit'])) {
        // Save the global discount percentage, flat rate, and category-specific discounts in the database
        $global_discount_percentage = floatval($_POST['global_discount_percentage']);
        $flat_rate_discount = floatval($_POST['flat_rate_discount']);

        update_option('product_discount_global_percentage', $global_discount_percentage);
        update_option('product_discount_flat_rate', $flat_rate_discount);

        $category_discounts = $_POST['category_discount'];
        update_option('product_discount_category_percentage', $category_discounts);
    }

    // Get the saved global discount percentage, flat rate, and category-specific discounts from the database
    $global_discount_percentage = get_option('product_discount_global_percentage', 0);
    $flat_rate_discount = get_option('product_discount_flat_rate', 0);
    $category_discounts = get_option('product_discount_category_percentage', array());

    // Add your custom sub-menu page content here
    echo '<div class="wrap">';
    echo '<h1>Product Discounts</h1>';
    // Add your custom settings/options/forms here
    echo '<form method="post">';
    echo '<label for="global_discount_percentage"><h2>Global Discount Percentage:</h2></label>';
    echo '<input type="number" name="global_discount_percentage" id="global_discount_percentage" min="0" max="100" step="0.01" value="' . esc_attr($global_discount_percentage) . '">';
    echo '<br><br>';

    echo '<label for="flat_rate_discount"><h2>Flat Rate Discount:</h2></label>';
    echo '<input type="number" name="flat_rate_discount" id="flat_rate_discount" min="0" step="0.01" value="' . esc_attr($flat_rate_discount) . '">';
    echo '<br>';

    echo '<h2>Category-Specific Discounts:</h2>';
	
    echo '<table>';
    echo '<tr><th>Category</th><th>Discount Percentage</th></tr>';

    // Retrieve all product categories
    $product_categories = get_terms('product_cat', array('hide_empty' => false));

    foreach ($product_categories as $category) {
        $category_id = $category->term_id;
        $category_name = $category->name;
        $category_discount_percentage = isset($category_discounts[$category_id]) ? floatval($category_discounts[$category_id]) : 0;

        echo '<tr>';
        echo '<td>' . esc_html($category_name) . '</td>';
        echo '<td><input type="number" name="category_discount[' . $category_id . ']" min="0" max="100" step="0.01" value="' . esc_attr($category_discount_percentage) . '"></td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<br>';
    echo '<input type="submit" name="submit" value="Save">';
    echo '</form>';
    echo '</div>';
}
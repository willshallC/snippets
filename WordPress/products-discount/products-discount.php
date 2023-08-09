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

// Display the discounted price on the product page
function custom_display_discounted_price($price, $product) {
    $global_discount_percentage = get_option('product_discount_global_percentage', 0);
    $flat_rate_discount = get_option('product_discount_flat_rate', 0);
    $category_discounts = get_option('product_discount_category_percentage', array());

    // Check if the product has a sale price
    $has_sale_price = $product->get_sale_price();
    $regular_price = $product->get_regular_price();



// Check if the product is a simple product
if ($product->is_type('simple')) {
    if ($product->is_on_sale()) {
        echo '<del>' . wc_price($product->get_regular_price()) . '</del>';
        echo '<ins>' . wc_price($product->get_sale_price()) . '</ins>';
    } else {
        echo wc_price($product->get_regular_price());
    }
}



    // Calculate the maximum category-specific discount for the current product
    $max_category_discount = 0;
    $product_categories = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'ids'));

    foreach ($product_categories as $category_id) {
        if (isset($category_discounts[$category_id])) {
            $max_category_discount = max($max_category_discount, floatval($category_discounts[$category_id]));
        }
    }

    // Calculate the maximum discount (percentage-based or flat rate) applicable to the product
    $max_discount = max($global_discount_percentage, $max_category_discount);

    // Calculate the discounted price based on the maximum discount
    if ($max_discount > 0) {
        if ($has_sale_price && $has_sale_price !== $regular_price) {
            // Apply the percentage-based discount to the sale price
            $discounted_price = $has_sale_price - ($has_sale_price * ($max_discount / 100));
        } else {
            // Apply the percentage-based discount to the regular price
            $discounted_price = $regular_price - ($regular_price * ($max_discount / 100));
        }
    } else {
        // No percentage-based discount, apply the flat rate discount if applicable
        $discounted_price = $regular_price - $flat_rate_discount;
    }

    // Ensure the discounted price doesn't go below zero
    $discounted_price = max(0, $discounted_price);

    // For variable products, calculate the minimum and maximum discounted prices among variations
    if ($product->is_type('variable')) {
        $variation_prices = array();

        foreach ($product->get_available_variations() as $variation_data) {
            $variation = wc_get_product($variation_data['variation_id']);
            $regular_variation_price = $variation->get_regular_price();
            $sale_variation_price = $variation->get_sale_price();

            // Calculate the discounted price for each variation
            if ($max_discount > 0) {
                if ($sale_variation_price && $sale_variation_price !== $regular_variation_price) {
                    $discounted_variation_price = $sale_variation_price - ($sale_variation_price * ($max_discount / 100));
                } else {
                    $discounted_variation_price = $regular_variation_price - ($regular_variation_price * ($max_discount / 100));
                }
            } else {
                $discounted_variation_price = $regular_variation_price - $flat_rate_discount;
            }

            // Ensure the discounted variation price doesn't go below zero
            $discounted_variation_price = max(0, $discounted_variation_price);

            $variation_prices[] = $discounted_variation_price;
        }

        // Calculate the minimum and maximum discounted prices for variations
        $min_discounted_price = min($variation_prices);
        $max_discounted_price = max($variation_prices);

        return wc_format_price_range($min_discounted_price, $max_discounted_price);
    }

    // For simple products or non-discounted variable products, return the regular discounted price
    return wc_price($discounted_price);
}
add_filter('woocommerce_get_price_html', 'custom_display_discounted_price', 10, 2);
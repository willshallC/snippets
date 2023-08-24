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

        $category_flat_rate_discounts = array_map('floatval', $_POST['category_flat_rate_discount']);
        update_option('product_category_flat_rate_discounts', $category_flat_rate_discounts);
    } 


    // Get the saved global discount percentage, flat rate, and category-specific discounts from the database
    $global_discount_percentage = get_option('product_discount_global_percentage', 0);
    $flat_rate_discount = get_option('product_discount_flat_rate', 0);
    $category_discounts = get_option('product_discount_category_percentage', array());
    $category_flat_rate_discounts = get_option('product_category_flat_rate_discounts', array());

    // Add your custom sub-menu page content here
    echo '<div class="wrap">';
    echo '<h2 style="font-size:30px;">Product Discounts :</h2>';
    // Add your custom settings/options/forms here
    
    echo '<form method="post">';
    echo '<label for="global_discount_percentage"><h2 style="font-size:20px;">Global Discount Percentage :</h2></label>';
    echo '<input type="number" name="global_discount_percentage" id="global_discount_percentage" min="0" max="100" step="0.01" value="' . esc_attr($global_discount_percentage) . '">';
    echo '<br><br>';

    echo '<label for="flat_rate_discount"><h2 style="font-size:20px;">Global Flat Rate Discount :</h2></label>';
    echo '<input type="number" name="flat_rate_discount" id="flat_rate_discount" min="0" step="0.01" value="' . esc_attr($flat_rate_discount) . '">';
    echo '<br>';

    echo '<h2 style="font-size:20px;">Specific Category Discounts :</h2>';
	
    echo '<table>';
    echo '<tr><th><h3>Category</h3></th><th><h3>Discount Percentage</h3></th><th><h3>Flat Rate Discount</h3></th></tr>';

    // Retrieve all product categories
    $product_categories = get_terms('product_cat', array('hide_empty' => false));

	foreach ($product_categories as $category) {
		$category_id = $category->term_id;
		$category_name = $category->name;
		
		$category_discount_percentage = isset($category_discounts[$category_id]) ? floatval($category_discounts[$category_id]) : 0;
		
		$category_flat_rate_discount = isset($category_flat_rate_discounts[$category_id]) ? floatval($category_flat_rate_discounts[$category_id]) : 0;

		echo '<tr>';
		echo '<td>' . esc_html($category_name) . '</td>';
		echo '<td><input type="number" name="category_discount[' . $category_id . ']" min="0" max="100" step="0.01" value="' . esc_attr($category_discount_percentage) . '"></td>';
		
		echo '<td><input type="number" name="category_flat_rate_discount[' . $category_id . ']" step="0.01" value="' . esc_attr($category_flat_rate_discount) . '"></td>';
		echo '</tr>';
	}

    echo '</table>';
    echo '<br>';
    echo '<input type="submit" name="submit" value="Save">';
    echo '</form>';
    echo '</div>';
}



function custom_display_discounted_price($price, $product) {
    $global_discount_percentage = get_option('product_discount_global_percentage', 0);
    $flat_rate_discount = get_option('product_discount_flat_rate', 0);
    $category_discounts = get_option('product_discount_category_percentage', array());
    $category_flat_rate_discounts = get_option('product_category_flat_rate_discounts', array());

    // Check if the product has a sale price
    $has_sale_price = $product->get_sale_price();
    $regular_price = $product->get_regular_price();



// Calculate the total discount amount based on all applied discounts
if ($product->is_type('simple'))  {

$total_discount = 0;

// Calculate the discount based on the global percentage discount
if ($global_discount_percentage > 0) {
	if ($has_sale_price && $has_sale_price !== $regular_price) {
		$total_discount += ($has_sale_price * ($global_discount_percentage / 100));
	} else {
		$total_discount += ($regular_price * ($global_discount_percentage / 100));
	}
}

// Calculate the discount based on the flat rate discount
if ($has_sale_price && $has_sale_price !== $regular_price) {
	$total_discount += $flat_rate_discount;
} else {
	$total_discount += $flat_rate_discount;
}

// Calculate the discount for category discounts
foreach ($product_categories as $category_id) {
	if (isset($category_discounts[$category_id])) {
		$category_discount_percentage = floatval($category_discounts[$category_id]);
		$category_discount = 0;
		if ($category_discount_percentage > 0) {
			if ($has_sale_price && $has_sale_price !== $regular_price) {
				$category_discount = ($has_sale_price * ($category_discount_percentage / 100));
			} else {
				$category_discount = ($regular_price * ($category_discount_percentage / 100));
			}
		}
		$total_discount += $category_discount;
	}
}

// Display the total discount amount
if ($total_discount > 0) {
	echo '<p class="total-discount">' . sprintf(__('You Save: %s', 'your-text-domain'), wc_price($total_discount)) . '</p>';
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

    // Check if the product is eligible for flat rate category discount
    $eligible_for_category_discount = false;
    foreach ($product_categories as $category_id) {
        if (isset($category_flat_rate_discounts[$category_id])) {
            $eligible_for_category_discount = true;
            break;
        }
    }

    // Calculate the maximum discount (percentage-based or flat rate) applicable to the product
    $max_discount = max($global_discount_percentage, $max_category_discount);

    // Check if any discount is applicable
    if ($max_discount > 0 || $eligible_for_category_discount) {
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
            if ($has_sale_price && $has_sale_price !== $regular_price) {
                // Apply the flat rate discount to the sale price
                $discounted_price = $has_sale_price - $flat_rate_discount;
            } else {
                // Apply the flat rate discount to the regular price
                $discounted_price = $regular_price - $flat_rate_discount;
            }
        }

        // Ensure the discounted price doesn't go below zero
        $discounted_price = max(0, $discounted_price);

        // Apply category flat rate discount if eligible
        if ($eligible_for_category_discount) {
            foreach ($product_categories as $category_id) {
                if (isset($category_flat_rate_discounts[$category_id])) {
                    $category_flat_rate_discount = floatval($category_flat_rate_discounts[$category_id]);
                    $discounted_price -= $category_flat_rate_discount;
                }
            }
        }

        // For variable products, return the minimum and maximum discounted price range
        if ($product->is_type('variable')) {
            $variation_prices = array();

            foreach ($product->get_available_variations() as $variation_data) {
                $variation = wc_get_product($variation_data['variation_id']);
                $sale_variation_price = $variation->get_sale_price();
                $regular_variation_price = $variation->get_regular_price();

                if ($max_discount > 0) {
                    if ($sale_variation_price && $sale_variation_price !== $regular_variation_price) {
                        $discounted_variation_price = $sale_variation_price - ($sale_variation_price * ($max_discount / 100));
                    } else {
                        $discounted_variation_price = $regular_variation_price - ($regular_variation_price * ($max_discount / 100));
                    }
                } else {
                    $discounted_variation_price = $regular_variation_price - $flat_rate_discount;
                }

                $variation_prices[] = $discounted_variation_price;
            }

            // Calculate the minimum and maximum discounted prices for variations
            $min_discounted_price = min($variation_prices);
            $max_discounted_price = max($variation_prices);

            return wc_format_price_range($min_discounted_price, $max_discounted_price);
        }

        // For simple products or non-discounted variable products, return the sale price and the discounted price
        return sprintf('%s <ins>%s</ins>', wc_price($has_sale_price), wc_price($discounted_price));
    }

    // No discount is applicable, show the default WooCommerce behavior
    return $price;
}
add_filter('woocommerce_get_price_html', 'custom_display_discounted_price', 10, 2);


 
// Make sure the discounted price is sent to the cart for eligible products
function custom_set_cart_item_price($cart_object) {
    $global_discount_percentage = get_option('product_discount_global_percentage', 0);
    $flat_rate_discount = get_option('product_discount_flat_rate', 0);
    $category_discounts = get_option('product_discount_category_percentage', array());
    $category_flat_rate_discounts = get_option('product_category_flat_rate_discounts', array());

    foreach ($cart_object->cart_contents as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];

        // Check if the product has a sale price
        $has_sale_price = $product->get_sale_price();
        $regular_price = $product->get_regular_price();

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
            if ($has_sale_price && $has_sale_price !== $regular_price) {
                // Apply the flat rate discount to the sale price
                $discounted_price = $has_sale_price - $flat_rate_discount;
            } else {
                // Apply the flat rate discount to the regular price
                $discounted_price = $regular_price - $flat_rate_discount;
            }
        }

        // Ensure the discounted price doesn't go below zero
        $discounted_price = max(0, $discounted_price);

        // Calculate and apply category flat rate discount
        $category_discount = 0;
        foreach ($product_categories as $category_id) {
            if (isset($category_flat_rate_discounts[$category_id])) {
                $category_discount += floatval($category_flat_rate_discounts[$category_id]);
            }
        }

        // Apply category flat rate discount to the discounted price
        $discounted_price -= $category_discount;

        // Set the discounted price only for eligible products
        if ($product->is_type('simple') || $product->is_type('variation')) {
            $cart_item['data']->set_price($discounted_price);
        }
    }
}
add_action('woocommerce_before_calculate_totals', 'custom_set_cart_item_price');
<style>
	span.price ins {
		display: none !important;
	}
</style>
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
		echo '<label for="global_discount_percentage">
				<h2 style="font-size:20px;">Global Discount Percentage :</h2>
			 </label>';
		echo '<input type="number" name="global_discount_percentage" id="global_discount_percentage" min="0"   max="100" step="0.01" value="' . esc_attr($global_discount_percentage) . '">';

		echo '<label for="flat_rate_discount">
				<h2 style="font-size:20px;">Global Flat Rate Discount :</h2>
			 </label>';
		echo '<input type="number" name="flat_rate_discount" id="flat_rate_discount" min="0" step="0.01" value="' . esc_attr($flat_rate_discount) . '">';


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
	
	if ($product->is_type('simple') || $product->is_type('variation')) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        $has_sale_price = ($sale_price && $sale_price !== $regular_price);

        $max_discount = max($global_discount_percentage, 0);
        $category_ids = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'ids'));

        foreach ($category_ids as $category_id) {
            if (isset($category_discounts[$category_id])) {
                $max_discount = max($max_discount, floatval($category_discounts[$category_id]));
            }
        }
		
		$discounted_price = $regular_price;
		
		if ($max_discount > 0) {
            if ($has_sale_price) {
                $discounted_price = $sale_price - ($sale_price * ($max_discount / 100));
            } else {
                $discounted_price = $regular_price - ($regular_price * ($max_discount / 100));
            }
        } elseif ($has_sale_price) {
            $discounted_price = $sale_price - $flat_rate_discount;
        } else {
            $discounted_price = $regular_price - $flat_rate_discount;
        }

        $discounted_price = max(0, $discounted_price);
		
		foreach ($category_ids as $category_id) {
            if (isset($category_flat_rate_discounts[$category_id])) {
                $discounted_price -= floatval($category_flat_rate_discounts[$category_id]);
            }
        }

        if ($discounted_price < 0) {
            $discounted_price = 0;
        }
				
		$discount_amount = $sale_price - $discounted_price;
        if ($discount_amount > 0) {
            // Display the total discount amount
            $discount_text = 'You Save - ' . wc_price($discount_amount);
            $price = sprintf('<del>%s</del> <ins>%s</ins>  <p class="discount-amount">%s</p>', wc_price($sale_price), wc_price($discounted_price), $discount_text);
        }else {
            // If no discount, just display the price
            //$price = wc_price($discounted_price);
			$price = sprintf('<ins>%s</ins>  <p class="discount-amount">%s</p>', wc_price($sale_price), wc_price($discounted_price), $discount_text);						
        }
    }elseif ($product->is_type('variable')) {
        // For variable products, display the discounted price range
        $global_discount_percentage = get_option('product_discount_global_percentage', 0);
        $flat_rate_discount = get_option('product_discount_flat_rate', 0);	
	
	$discounted_price = $product->get_price();

        if ($global_discount_percentage > 0) {
            $discounted_price -= ($discounted_price * ($global_discount_percentage / 100));
        } else {
            $discounted_price -= $flat_rate_discount;
        }

        $discounted_price = max(0, $discounted_price);

        $price = wc_price($discounted_price);
	
	
        $variation_min_price = $product->get_variation_price('min', true);
        $variation_max_price = $product->get_variation_price('max', true);

        if ($global_discount_percentage > 0) {
            $min_discounted_price = $variation_min_price - ($variation_min_price * ($global_discount_percentage / 100));
            $max_discounted_price = $variation_max_price - ($variation_max_price * ($global_discount_percentage / 100));
        } else {
            $min_discounted_price = $variation_min_price - $flat_rate_discount;
            $max_discounted_price = $variation_max_price - $flat_rate_discount;
        }

        $min_discounted_price = max(0, $min_discounted_price);
        $max_discounted_price = max(0, $max_discounted_price);

        $price = sprintf('%s - %s', wc_price($min_discounted_price), wc_price($max_discounted_price));
    }
	
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

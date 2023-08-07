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
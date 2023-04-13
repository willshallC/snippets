<?php
// Output the Custom field in Product pages
add_action("woocommerce_before_add_to_cart_button", "options_on_single_product", 1);
function options_on_single_product(){
    ?>
        <label for="custom_field">
            <input type="radio" name="custom_field" checked="checked" value="option1"> option 1 <br />
            <input type="radio" name="custom_field" value="option2"> option 2
        </label> <br />
    <?php
}

// Stores the custom field value in Cart object
add_filter( 'woocommerce_add_cart_item_data', 'save_custom_product_field_data', 10, 2 );
function save_custom_product_field_data( $cart_item_data, $product_id ) {
    if( isset( $_REQUEST['custom_field'] ) ) {
        $cart_item_data[ 'custom_field' ] = esc_attr($_REQUEST['custom_field']);
        // below statement make sure every add to cart action as unique line item
        $cart_item_data['unique_key'] = md5( microtime().rand() );
    }
    return $cart_item_data;
}

// Outuput custom Item value in Cart and Checkout pages
add_filter( 'woocommerce_get_item_data', 'output_custom_product_field_data', 10, 2 );
function output_custom_product_field_data( $cart_data, $cart_item ) {
    if( isset( $cart_item['custom_field'] ) ) {
        $cart_data[] = array(
            'key'       => __('Custom Item', 'woocommerce'),
            'value'     => $cart_item['custom_field'],
            'display'   => $cart_item['custom_field'],
        );
    }
    return $cart_data;
}
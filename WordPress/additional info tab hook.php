<<?php 
// Display value on additional Informations tab if NOT empty
function filter_woocommerce_display_product_attributes( $product_attributes, $product ) {
    // Get meta
    $quantity_per_package = $product->get_meta( 'textID' );
    // NOT empty
    if ( ! empty ( $quantity_per_package ) ) {
        $product_attributes[ 'textID' ] = array(
            'label' => __('Custom Field', 'woocommerce '),
            'value' => $quantity_per_package,
        );
    }
    return $product_attributes;
}
add_filter( 'woocommerce_display_product_attributes', 'filter_woocommerce_display_product_attributes', 10, 2 );
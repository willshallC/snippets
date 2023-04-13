function custom_add_to_cart_text( $text, $product ) {
    if ( $product->is_type( 'simple' ) ) {
        $text = __( 'Buy Now', 'woocommerce' );
    } elseif ( $product->is_type( 'variable' ) ) {
        $text = __( 'Select Options', 'woocommerce' );
    }
    return $text;
}
add_filter( 'woocommerce_product_add_to_cart_text', 'custom_add_to_cart_text', 10, 2 );
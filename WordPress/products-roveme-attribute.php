function variation_title_not_include_attributes( $boolean ){
    if ( ! is_cart() )
        $boolean = false;
    return $boolean;
}
add_filter( 'woocommerce_product_variation_title_include_attributes', 'variation_title_not_include_attributes' );

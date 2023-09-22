//Remove reviews from single product tabs
function woo_remove_product_tabs($tabs) {
    unset($tabs['reviews']);  
    return $tabs; 
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
<?php
//add this in function.php file.
function wdm_remove_parent_category_from_url( $args ) {
    $args['rewrite']['hierarchical'] = false;
    return $args;
}

add_filter( 'woocommerce_taxonomy_args_product_cat', 'wdm_remove_parent_category_from_url' );

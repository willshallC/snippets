//Remove reviews from single product tabs
function woo_remove_product_tabs($tabs) {
    unset($tabs['reviews']);  
    return $tabs; 
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

// Add Reviews Below Product Gallery
add_shortcode(
    "wpse_comment_form",
    function ($atts = array(), $content = "") {
        global $product;
      if (is_singular() && post_type_supports(get_post_type(), "comments")) {
        ob_start(); ?>
        <div class="product-reviews">
        <h2 class="review-title" itemprop="headline">
        <?php printf( __( 'Reviews (%d)', 'woocommerce' ), $product->get_review_count() ); ?>
        </h2>
        <?php call_user_func( 'comments_template', 999 ); ?>
        </div>
        <div class="clearfix clear"></div>
        <?php return ob_get_clean();
      }
      return "";
    }, 10, 2);
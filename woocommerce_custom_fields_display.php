function woocommerce_custom_fields_display()
{
  global $post;
  $product = wc_get_product($post->ID);
    $custom_fields_woocommerce_title = $product->get_meta('woocommerce_custom_fields');
  if ($custom_fields_woocommerce_title) {
        printf(
            '<div><label>%s</label><input type="text" id="woocommerce_product_custom_fields_title" name="woocommerce_product_custom_fields_title" value=""></div>',
            esc_html($custom_fields_woocommerce_title)
        );
  }
}
 
add_action('woocommerce_before_add_to_cart_button', 'woocommerce_custom_fields_display');
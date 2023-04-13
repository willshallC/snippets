//Custom product meta box fields

add_action( 'woocommerce_product_options_dimensions', 'custom_product_field' );
function custom_product_field(){

	echo '<div class="custom-field">';
	woocommerce_wp_text_input(
		array(
			'id'      => 'textID',
			'label'   => 'Custom Field',
			'desc_tip' => true,
			'description' => 'Made with Hooks',
		)
	);
	echo '</div>';

}
<?php
function post_shortcode() {
	$args = array(
		
		'post_type'=>'post',
		'posts_per_page' => 3,
		'offset' => 0,
		'orderby' => 'ID',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => array('sports')
			)						
		),
	);
	
	$query = new WP_Query($args);
	
	ob_start();
	if($query->have_posts()):
	
	?>
	<ul>
		<?php
		while($query->have_posts()){
			$query->the_post();			
			echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a>'.get_the_content().'</li>';						
		}
		?>
	</ul>
	<?php
	endif;
	wp_reset_postdata();
	
	$html_post = ob_get_clean();	
	return $html_post; 	
}	
add_shortcode('post_short_code', 'post_shortcode');
<?php
$term        = get_queried_object();
$category_id = empty( $term->term_id ) ? 0 : $term->term_id;    

$args = array(
    'post_type' => 'product',
    'meta_key' => '_featured',
    'meta_value' => 'yes',
    'posts_per_page' => 3,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $category_id
        )
     )
);

$featured_query = new WP_Query( $args );

if ($featured_query->have_posts()) : 

    while ($featured_query->have_posts()) : 

        $featured_query->the_post();

        $product = get_product( $featured_query->post->ID );

        wc_get_template_part( 'content', 'product' );

    endwhile;

endif;
wp_reset_query();
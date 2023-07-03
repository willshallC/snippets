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
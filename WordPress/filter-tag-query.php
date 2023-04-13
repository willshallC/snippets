<?php 
   $args = array(
    'tax_query' => array(
        array(
            'taxonomy' => 'articles_tags',
            'field' => 'slug',
            'terms' => 'special-tag'
        )
    )
);
    $wp_query = new WP_Query($args);
    
    if (have_posts()) :
        while (have_posts()) : the_post();
            echo '<li>';
            the_title();
            echo '</li>';
        endwhile;
    endif;
?>
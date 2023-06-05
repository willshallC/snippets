<?php //Template Name: PAGE AJAX ?>
<?php get_header(); ?>

<div id="ajax-posts-container">
    <?php
    
         $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'post',
            'paged' => $paged,
            'posts_per_page'=> 1,
        );
        $query = new WP_Query($args);
    
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                 the_title();
            endwhile;
        endif;

    ?>
</div>
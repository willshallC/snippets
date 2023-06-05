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
<div id="ajax-pagination">
    <?php $big = 999999999; // need an unlikely integer
		 echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url(get_pagenum_link( $big ) )),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $query->max_num_pages,
			'prev_text'    => __('‹'),
			'next_text'    => __('›'),
		) ); ?>
</div>
<!--add this code in functions file -->

function load_more_posts_ajax_handler() {
    $page = $_POST['page'];

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'paged' => $page,
    );
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

            <?php
        }
        wp_reset_postdata();
    }

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts_ajax_handler');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_ajax_handler');
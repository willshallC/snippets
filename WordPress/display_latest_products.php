<?php
function display_latest_products() {
    // Query WooCommerce for the latest 3 products
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        echo '<div class="latest-products">';
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            // Get product tags
            $product_tags = wp_get_post_terms(get_the_ID(), 'product_tag');
            ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail(); ?>
                    <h2><?php the_title(); ?></h2>
                    <span class="price"><?php echo $product->get_price_html(); ?></span>
                  
                </a>
            <?php
        }
        echo '</div>';
        wp_reset_postdata();
    }
}

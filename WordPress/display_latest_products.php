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
                    <?php
                    // Display product tags
                    if (!empty($product_tags)) {
                        echo '<div class="product-tags">';
                        foreach ($product_tags as $tag) {
                            echo '<span class="product-tag">' . esc_html($tag->name) . '</span>, ';
                        }
                        echo '</div>';
                    }
                    ?>
                </a>
            <?php
        }
        echo '</div>';
        wp_reset_postdata();
    }
}
// Add a shortcode to easily display the latest products
function latest_products_shortcode() {
    ob_start();
    display_latest_products();
    return ob_get_clean();
}
add_shortcode('latest_products', 'latest_products_shortcode');

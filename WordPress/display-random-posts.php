<?php

    // Template Name: test random template

    get_header();
?>

<section class="random-post-sec">
        <div class="custom-container">
            <div class="lastest-hadng">
                <h2>Latest Blogs</h2>
                <div class="see-all">
                    <a href="/blog/" title="Latest Blogs">See All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>
            </div>
            <?php
            $random_args = array(
                'post_type' => 'blog_post',
                'orderby' => 'rand',
                'posts_per_page' => 6, 
            );

            $the_random_query = new Wp_Query($random_args);

            if($the_random_query->have_posts()){
                ?>
                <div class="random-container">
                   <div class="main-random-post">
                    <?php
                    while($the_random_query->have_posts()){?>
                        <div class="random-post">
                            <?php
                            $the_random_query->the_post();
                            $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID,"thumbnail") );
                            $text=preg_replace( "/\\[&hellip;\\]/",'',get_the_excerpt());
                            ?>
                            <a class="post-link" href="<?php the_permalink() ?>">
                            <div class="random-post-image">
                               <img src="<?php echo $feat_image?>" alt="post-thumbnail"/>
                            </div></a>
                            <div class="random-post-content">
                               <div class="author-date"><p><span class="author-name"><?php echo get_the_author(); ?></span> / <?php the_date('F j, Y'); ?></p></div>
							   <a href="<?php the_permalink() ?>"><h2><?php the_title();?></h2></a>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                    </div>
                </div>
                <?php
            }
        ?>
        </div>
    </section>
    
<?php
    get_footer();
?>
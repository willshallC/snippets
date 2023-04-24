<?php 
    function article_init(){
        $labels = array(
            'name' => 'Articles',
            'singular_name' => 'Article',
            'add_new' => 'Add Article',
            'edit_item' => 'Edit Article',   
            'all_items' => 'All Articles',
            'view_item' => 'View Articles',
            
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => 'articles'),
            'query_var' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'trackbacks',
                'custom-fields',
                'comments',
                'revisions',
                'thumbnail',
                'author',
                'page-attributes'
            )
        );

        register_post_type( 'articles', $args );
    }
?>
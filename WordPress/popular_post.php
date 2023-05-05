<?php 

    function count_post_visits(){
        if(is_single()){
            global $post;
            $views = get_post_meta( $post->ID, 'my_post_viewed', true );
            if( $views == '' ) {
                update_post_meta( $post->ID, 'my_post_viewed', '1' );   
            } else {
                $views_no = intval( $views );
                update_post_meta( $post->ID, 'my_post_viewed', ++$views_no );
            }
        }
        
    }
?>
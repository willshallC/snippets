<?php
    add_action( 'wpcf7_init', 'custom_add_form_tag_customlist' );

    function custom_add_form_tag_customlist() {
        wpcf7_add_form_tag( array( 'customlist', 'customlist*' ), 
    'custom_customlist_form_tag_handler', true );
    }
?>
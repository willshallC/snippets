<?php 
function app_post_tags_dropdown() {
    // Get all post tags
    $tags = get_tags();

    // Check if there are any tags
    if ( $tags ) {
        $output = '<select name="app_post_tags" id="app-post-tags">';
        $output .= '<option value="">Select a tag</option>';

        foreach ( $tags as $tag ) {
            $tag_link = get_tag_link( $tag->term_id );
            $output .= '<option value="' . $tag_link . '">' . $tag->name . '</option>';
        }

        $output .= '</select>';
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

        // Enqueue JavaScript
        $output .= '<script>
            var selectTag = document.getElementById("app-post-tags");

            // Retrieve the stored value
            var storedValue = localStorage.getItem("app_post_tags_dropdown");

            if (storedValue) {
                selectTag.value = storedValue;
            }

            selectTag.onchange = function() {
                var url = this.value;
                if (url) {
                    window.location.href = url;
                }

                // Store the selected value
                localStorage.setItem("app_post_tags_dropdown", this.value);
            };
        </script>';

        return $output;
    }

    return 'No tags found.';
}
add_shortcode( 'app_post_tags_dropdown', 'app_post_tags_dropdown' );

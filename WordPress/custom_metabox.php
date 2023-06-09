<?php
// Add a custom metabox to the post editor screen
function add_custom_metabox() {
    add_meta_box(
        'custom_metabox',
        'Custom Metabox',
        'render_custom_metabox',
        'post',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_custom_metabox');

// Render the content of the custom metabox
function render_custom_metabox($post) {
    // Retrieve the existing meta value, if any
    $custom_value = get_post_meta($post->ID, 'custom_metabox_value', true);
    
    // Output the HTML for the metabox
    ?>
    <p>
        <label for="custom_metabox_value">Custom Value:</label>
        <input type="text" id="custom_metabox_value" name="custom_metabox_value" value="<?php echo esc_attr($custom_value); ?>" />
    </p>
    <?php
}

// Save the custom metabox value
function save_custom_metabox($post_id) {
    // Check if the metabox value is set
    if (isset($_POST['custom_metabox_value'])) {
        // Sanitize and save the metabox value
        $custom_value = sanitize_text_field($_POST['custom_metabox_value']);
        update_post_meta($post_id, 'custom_metabox_value', $custom_value);
    }
}
add_action('save_post', 'save_custom_metabox');

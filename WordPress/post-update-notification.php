<?php
// Add this code function.php file
function send_post_update_notification($new_status, $old_status, $post) {
    // Check if the post status is transitioning from 'publish' to 'publish'
    
    if ($old_status === 'publish' && $new_status === 'publish' && !wp_is_post_revision($post)) { 
        // Email subject and message
        $subject = 'Post Updated: ' . $post->post_title;
        $message = 'The following post has been updated on your website:' . "\n\n";
        $message .= 'Title: ' . $post->post_title . "\n";
        $message .= 'Link: ' . get_permalink($post->ID) . "\n";   
        // Get the admin email address 
        $admin_email = get_option('admin_email'); 
        // Send the email to the admin
        wp_mail($admin_email, $subject, $message);
    } 
}
add_action('transition_post_status', 'send_post_update_notification', 10, 3);

?>
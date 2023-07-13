<?php
/*
Plugin Name: Social Icons
Description: Adds Social Media icon using shortcode anywhere.
Version: 1.0
Author: Ayush Kumar
 Author URI: https://www.willshall.com
*/

// Enqueue Font Awesome CSS, JS, and custom CSS files from CDN
function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3');
    wp_enqueue_script('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js', array(), '5.15.3');
    wp_enqueue_style('social-icon', plugin_dir_url(__FILE__) . 'social-icon.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// Create a table in the database when the plugin is activated
function social_icons_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'socialicons';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        url VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'social_icons_activate');

// Add menu page in the WordPress dashboard
function social_icon_menu() {
    add_menu_page(
        'Social Icons',
        'Social Icons',
        'manage_options',
        'social_icon_menu',
        'social_icon_page',
        'dashicons-share',
        20
    );
}
add_action('admin_menu', 'social_icon_menu');

// Callback function to display the table form
function social_icon_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'socialicons';

    // Get existing data from the database
    $links = $wpdb->get_results("SELECT title, url FROM $table_name");

    // Create an associative array to store the existing URLs
    $existing_urls = array();
    foreach ($links as $link) {
        $existing_urls[$link->title] = $link->url;
    }

    // Initialize the URLs with empty values
    $facebook_url = '';
    $instagram_url = '';
    $twitter_url = '';
	$linkedin_url ='';

    // If the URLs exist in the associative array, assign them to the respective variables
    if (isset($existing_urls['Facebook'])) {
        $facebook_url = $existing_urls['Facebook'];
    }

    if (isset($existing_urls['Instagram'])) {
        $instagram_url = $existing_urls['Instagram'];
    }

    if (isset($existing_urls['Twitter'])) {
        $twitter_url = $existing_urls['Twitter'];
    }
	
	if (isset($existing_urls['Linkedin'])) {
        $linkedin_url = $existing_urls['Linkedin'];
    }
    ?>
    <div class="wrap">
        <h1>Social Share</h1>
        <?php
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            echo '<div class="notice notice-success"><p>URLs have been successfully updated.</p></div>';
        }
        ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="social_share_save_data">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">URL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Facebook</strong></td>
                        <td><input type="text" name="facebook_url" value="<?php echo esc_attr($facebook_url); ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Instagram</strong></td>
                        <td><input type="text" name="instagram_url" value="<?php echo esc_attr($instagram_url); ?>"></td>
                    </tr>
                    <tr>
                        <td><strong>Twitter</strong></td>
                        <td><input type="text" name="twitter_url" value="<?php echo esc_attr($twitter_url); ?>"></td>
                    </tr>
					<tr>
                        <td><strong>Linkedin</strong></td>
                        <td><input type="text" name="linkedin_url" value="<?php echo esc_attr($linkedin_url); ?>"></td>
                    </tr>
                </tbody>
            </table>
            <?php submit_button('Save Links'); ?>
        </form>
		
		<div class="shortcode">
			<h3 style="color:red;font-size:20px;font-weight:600;"><strong>Note: Use this shortcode <span style="background-color:lightgrey;padding:5px;">[social_share_icons]</span> to display social icons Anywhere.</strong></h3>			
		</div>
		
    </div>
    <?php
}
<?php
/*
Plugin Name: Social Icons Plugin
Description: Adds Social Media icon using shortcode
Version: 1.0
Author: Ravi Thakur
Author URI: https://ravi.redefiningweb.com/
*/


// Enqueue Font Awesome CSS, JS, and custom CSS files from CDN
function enqueue_font_awesome_file() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3');
    wp_enqueue_script('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js', array(), '5.15.3');
    wp_enqueue_style('social-icon', plugin_dir_url(__FILE__) . 'social-share.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome_file');


// Create a table in the database when the plugin is activated
function social_icon_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'icons';
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
register_activation_hook(__FILE__, 'social_icon_activate');

// Add menu page in the WordPress dashboard
function social_icons_menu() {
    add_menu_page(
        'Social Icons Plugin',
        'Social Icons Plugin',
        'manage_options',
        'social_icon_menu',
        'social_icons_page',
        'dashicons-admin-plugins',
        25
    );
}
add_action('admin_menu', 'social_icons_menu');

// Callback function to display the table form
function social_icons_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'icons';

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
	$whatsaap_url = '';
	$email_url = '';
    $twitter_url = '';
	$linkedin_url ='';

    // If the URLs exist in the associative array, assign them to the respective variables
    if (isset($existing_urls['Facebook'])) {
        $facebook_url = $existing_urls['Facebook'];
    }

    if (isset($existing_urls['Instagram'])) {
        $instagram_url = $existing_urls['Instagram'];
    }


	if (isset($existing_urls['Whatsaap'])) {
        $whatsaap_url = $existing_urls['Whatsaap'];
    }
	
	if (isset($existing_urls['Email'])) {
        $email_url = $existing_urls['Email'];
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
                        <td><strong>Whatsaap</strong></td>
                        <td><input type="text" name="whatsaap_url" value="<?php echo esc_attr($whatsaap_url); ?>"></td>
                    </tr>
					<tr>
                        <td><strong>Email</strong></td>
                        <td><input type="text" name="email_url" value="<?php echo esc_attr($email_url); ?>"></td>
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
		
		<div class="short-code">
			<h4><strong>Note: Use this shortcode <span style="color:blue;"> [social_media_icons] </span></strong></h4>			
		</div>
		
    </div>
    <?php
}

// Save form data to the database
function save_data() {
    if (isset($_POST['facebook_url']) && isset($_POST['instagram_url']) /*&& isset($_POST['twitter_url']) && isset($_POST['linkedin_url']) */) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'icons';
        $facebook_url = sanitize_text_field($_POST['facebook_url']);
        $instagram_url = sanitize_text_field($_POST['instagram_url']);		
		$whatsaap_url = sanitize_text_field($_POST['whatsaap_url']);
        $email_url = sanitize_text_field($_POST['email_url']);
        $twitter_url = sanitize_text_field($_POST['twitter_url']);
        $linkedin_url = sanitize_text_field($_POST['linkedin_url']);

        // Update existing URLs if they exist in the database
        if ($wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE title = 'Facebook'")) {
            $wpdb->update(
                $table_name,
                array('url' => $facebook_url),
                array('title' => 'Facebook')
            );
        } else {
            // Insert a new row for Facebook if it doesn't exist
            $wpdb->insert(
                $table_name,
                array(
                    'title' => 'Facebook',
                    'url' => $facebook_url
                )
            );
        }

        if ($wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE title = 'Instagram'")) {
            $wpdb->update(
                $table_name,
                array('url' => $instagram_url),
                array('title' => 'Instagram')
            );
        } else {
            // Insert a new row for Instagram if it doesn't exist
            $wpdb->insert(
                $table_name,
                array(
                    'title' => 'Instagram',
                    'url' => $instagram_url
                )
            );
        }
	
	
	
	if ($wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE title = 'Whatsaap'")) {
            $wpdb->update(
                $table_name,
                array('url' => $whatsaap_url),
                array('title' => 'Whatsaap')
            );
        } else {
            // Insert a new row for Whatsaap if it doesn't exist
            $wpdb->insert(
                $table_name,
                array(
                    'title' => 'Whatsaap',
                    'url' => $whatsaap_url
                )
            );
        }
		
		
	if ($wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE title = 'Email'")) {
		$wpdb->update(
			$table_name,
			array('url' => $email_url),
			array('title' => 'Email')
		);
	} else {
		// Insert a new row for Email if it doesn't exist
		$wpdb->insert(
			$table_name,
			array(
				'title' => 'Email',
				'url' => $email_url
			)
		);
	}


	     
	   if ($wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE title = 'Twitter'")) {
            $wpdb->update(
                $table_name,
                array('url' => $twitter_url),
                array('title' => 'Twitter')
            );
        } else {
            // Insert a new row for Twitter if it doesn't exist
            $wpdb->insert(
                $table_name,
                array(
                    'title' => 'Twitter',
                    'url' => $twitter_url
                )
            );
        }
		
	
		if ($wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE title = 'Linkedin'")) {
            $wpdb->update(
                $table_name,
                array('url' => $linkedin_url),
                array('title' => 'Linkedin')
            );
        } else {
            // Insert a new row for Twitter if it doesn't exist
            $wpdb->insert(
                $table_name,
                array(
                    'title' => 'Linkedin',
                    'url' => $linkedin_url
                )
            );
        }

        // Redirect back to the page with a success status
        wp_redirect(admin_url('admin.php?page=social_icon_menu&status=success'));
        exit;
    }
}
add_action('admin_post_social_share_save_data', 'save_data');


// Create shortcode for social media icons
function shortcode($atts) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'icons';

    $links = $wpdb->get_results("SELECT title, url FROM $table_name");

    $output = '';

    foreach ($links as $link) {
        if (!empty($link->url)) {
            $icon_class = '';

            // Assign icon classes based on the title
            switch ($link->title) {
                case 'Facebook':
                    $icon_class = 'fab fa-facebook-f'; 
                    break;
                case 'Instagram':
                    $icon_class = 'fab fa-instagram'; 
                    break;
									
				case 'Whatsaap':
                    $icon_class = 'fab fa-whatsapp'; 
                    break;
                case 'Email':
                    $icon_class = 'far fa-envelope';
                    break;
									
                case 'Twitter':
                    $icon_class = 'fab fa-twitter'; 
                    break;
                case 'Linkedin':
                    $icon_class = 'fab fa-linkedin-in'; 
                    break;
					
                // Add more cases for other social media titles
            }

            $output .= '<a href="' . esc_url($link->url) . '" class="custom-social-icon '.$link->title.'"><i class="' . esc_attr($icon_class) . '"></i></a>';
        }
    }

    return $output;
}
add_shortcode('social_media_icons', 'shortcode');

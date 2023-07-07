<?php
/*
Plugin Name: Social Share
Plugin URI: https://ravi.redefiningweb.com/
Description: Displays Social Share icons below every post
Version: 1.0
Author: Ravi 
*/
?>

<?php
function social_share_menu_item(){
  add_submenu_page("options-general.php", "Social Share", "Social Share", "manage_options", "social-share", "social_share_page"); 
}

add_action("admin_menu", "social_share_menu_item");

function social_share_page(){
   ?>
      <div class="wrap">
         <h1>Social Sharing Options</h1>
 
         <form method="post" action="options.php">
            <?php
               settings_fields("social_share_config_section");
 
               do_settings_sections("social-share");
                
               submit_button(); 
            ?>
         </form>
      </div>
   <?php
}

//Social Sharing Settings
function social_share_settings(){
    add_settings_section("social_share_config_section", "", null, "social-share");
 
    add_settings_field("social-share-facebook", "Share With Facebook", "social_share_facebook_checkbox", "social-share", "social_share_config_section");
    
    add_settings_field("social-share-twitter", "Share With Twitter", "social_share_twitter_checkbox", "social-share", "social_share_config_section");
    
    add_settings_field("social-share-linkedin", "Share With LinkedIn", "social_share_linkedin_checkbox", "social-share", "social_share_config_section");
    
    add_settings_field("social-share-reddit", "Share With Reddit", "social_share_reddit_checkbox", "social-share", "social_share_config_section");
    
    add_settings_field("social-share-whatsapp", "Share With WhatsApp", "social_share_whatsapp_checkbox", "social-share", "social_share_config_section");

    add_settings_field("social-share-instagram", "Share With Instagram", "social_share_instagram_checkbox", "social-share", "social_share_config_section");

    add_settings_field("social-share-gmail", "Share With Mail", "social_share_gmail_checkbox", "social-share", "social_share_config_section");
 
    register_setting("social_share_config_section", "social-share-facebook");
    register_setting("social_share_config_section", "social-share-twitter");
    register_setting("social_share_config_section", "social-share-linkedin");
    register_setting("social_share_config_section", "social-share-reddit");
    register_setting("social_share_config_section", "social-share-whatsapp");
    register_setting("social_share_config_section", "social-share-instagram");
    register_setting("social_share_config_section", "social-share-gmail");
}
 
function social_share_facebook_checkbox(){  
   ?>
        <input type="checkbox" name="social-share-facebook" value="1" <?php checked(1, get_option('social-share-facebook'), true); ?> /> Check for Yes
   <?php
}

function social_share_twitter_checkbox()
{  
  ?>
        <input type="checkbox" name="social-share-twitter" value="1" <?php checked(1, get_option('social-share-twitter'), true); ?> /> Check for Yes
   <?php
}

function social_share_linkedin_checkbox()
{  
  ?>
        <input type="checkbox" name="social-share-linkedin" value="1" <?php checked(1, get_option('social-share-linkedin'), true); ?> /> Check for Yes
   <?php
}

function social_share_reddit_checkbox()
{  
?>
        <input type="checkbox" name="social-share-reddit" value="1" <?php checked(1, get_option('social-share-reddit'), true); ?> /> Check for Yes
   <?php
}

function social_share_whatsapp_checkbox()
{  
  ?>
        <input type="checkbox" name="social-share-whatsapp" value="1" <?php checked(1, get_option('social-share-whatsapp'), true); ?> /> Check for Yes
   <?php
}


function social_share_instagram_checkbox()
{  
   ?>
        <input type="checkbox" name="social-share-instagram" value="1" <?php checked(1, get_option('social-share-instagram'), true); ?> /> Check for Yes
   <?php
}

function social_share_gmail_checkbox()
{  
  ?>
        <input type="checkbox" name="social-share-gmail" value="1" <?php checked(1, get_option('social-share-gmail'), true); ?> /> Check for Yes
   <?php
}
 
add_action("admin_init", "social_share_settings");

function add_social_share_icons($content){
    $html = "<br><div class='social-share-wrapper'><div class='share-on'></div>";

    global $post;

    $url = get_permalink($post->ID);
	$title = $post->post_title;
    $url = esc_url($url);

if(get_option("social-share-facebook") == 1){
  $html = $html . "<div class='facebook'><a target='_blank' href='http://www.facebook.com/sharer.php?u=" . $url . "'>Facebook</a></div>";
}

if(get_option("social-share-twitter") == 1){
  $html = $html . "<div class='twitter'><a target='_blank' href='https://twitter.com/share?text=". $title ."&url=" . $url . "'>Twitter</a></div>";
}


if(get_option("social-share-linkedin") == 1){
        $html = $html . "<div class='linkedin'><a target='_blank' href='http://www.linkedin.com/shareArticle?url=" . $url . "'>LinkedIn</a></div>";
    }


if(get_option("social-share-reddit") == 1){
        $html = $html . "<div class='reddit'><a target='_blank' href='http://reddit.com/submit?url=" . $url . "'>Reddit</a></div>";
    }


if(get_option("social-share-whatsapp") == 1){
	$html = $html . "<div class='whatsapp'><a target='_blank' href='https://api.whatsapp.com/send?text=" . $url . "'>WhatsApp</a></div>";
}

if(get_option("social-share-instagram") == 1){
	$html = $html . "<div class='instagram'><a target='_blank' href='https://instagram.com/share?url=" . $url . "'>Instagram</a></div>";
}

if(get_option("social-share-gmail") == 1){
	$html = $html . "<div class='gmail'><a target='_blank' href='mailto:?subject=Coupon" . $url . "'>Mail</a></div>";
}

    $html = $html . "<div class='clear'></div></div>";

    return $content = $content . $html;
}

add_filter("the_content", "add_social_share_icons");

function social_share_style() {
    wp_register_style("social-share-style-file", plugin_dir_url(__FILE__) . "style.css");
    wp_enqueue_style("social-share-style-file");
}

add_action("wp_enqueue_scripts", "social_share_style");

?>
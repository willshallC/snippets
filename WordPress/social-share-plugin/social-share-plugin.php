<?php
/*
Plugin Name: Social Share
Plugin URI: https://ravi.redefiningweb.com/
Description: Displays Social Share icons below every post
Version: 1.0
Author: Ravi 
*/

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

function social_share_settings(){
   add_settings_section("social_share_config_section", "", null, "social-share");

   add_settings_field("social-share-facebook", "Do you want to display Facebook share button?", "social_share_facebook_checkbox", "social-share", "social_share_config_section");
  
   add_settings_field("social-share-twitter", "Do you want to display Twitter share button?", "social_share_twitter_checkbox", "social-share", "social_share_config_section");
  
   add_settings_field("social-share-linkedin", "Do you want to display LinkedIn share button?", "social_share_linkedin_checkbox", "social-share", "social_share_config_section");
  
  //////
   add_settings_field("social-share-reddit", "Do you want to display Reddit share button?", "social_share_reddit_checkbox", "social-share", "social_share_config_section");

   register_setting("social_share_config_section", "social-share-facebook");
   register_setting("social_share_config_section", "social-share-twitter");
   register_setting("social_share_config_section", "social-share-linkedin");
  
  //////
   register_setting("social_share_config_section", "social-share-reddit");
}
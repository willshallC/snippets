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
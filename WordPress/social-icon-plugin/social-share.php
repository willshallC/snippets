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
<?php

    /*
        Plugin Name: Single Custom Icon
        Plugin URI: https://dev.redefiningweb.com
        Description: Icons Plugin
        Author: Gurpreet
        Author URI: https://dev.redefiningweb.com
        Version: 1.0
    */

    if(!defined('ABSPATH')){
        die;
    }

    function single_ikon(){
        if(is_single()){
            ob_start();
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $title = get_the_title();
            // $short_url = 'http://shorturl.co';
            //$url = 'http://fullurl.com';
    
            $twitter_params = 
            '?text=' . urlencode($title) . '+-' .
            '&amp;url=' . urlencode($url) . 
            '&amp;counturl=' . urlencode($url) .
            '';
    
    
            $link = "http://twitter.com/share" . $twitter_params . "";
            ?>
            <style>
                .plugin-icon-div .icon-anchor{
                    padding: 10px;
                }
            </style>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <div class="plugin-icon-div">
                <!-- twitter -->
                <a class="icon-anchor" href="<?php echo $link?>" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                
                <!-- Instagram -->
                <!-- <a class="icon-anchor" href="" target="_blank"><i class="fa-brands fa-instagram"></i></a> -->
    
                <!-- Facebook -->
                <a class="icon-anchor" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url ?>" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
            </div>
            
            <?php
            $res = ob_get_clean();
            return $res;
        }
    }
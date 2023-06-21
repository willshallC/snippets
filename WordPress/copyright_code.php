<?php
   //Add the following code snippet at the end of the functions.php file:

    add_filter('wpcf7_special_mail_tags', 'custom_wpcf7_special_mail_tags', 10, 3);

    function custom_wpcf7_special_mail_tags($output, $name, $html)
    {
        if ('copyright_year' == $name) {
            $output = date('Y');
        }
        return $output;
    } 

    //when you use the [your-message] mail tag in Contact Form 7, it will dynamically replace the [copyright_year] tag with the current year.
    
    Copyright © [copyright_year] Your Company Name. All rights reserved.    
?>


<?php
   add_filter('wpcf7_special_mail_tags', 'custom_wpcf7_special_mail_tags', 10, 3);

   function custom_wpcf7_special_mail_tags($output, $name, $html)
   {
       if ('copyright_year' == $name) {
           $output = date('Y');
       }
       return $output;
   } 
?>
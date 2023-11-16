<!-- add target blank  -->
 jQuery(document).ready(function() {
            jQuery('#menu-brands > li:last-child , .w-nav-list > li:nth-last-child(2)').each(function() {
                jQuery(this).find('a').attr('target' , '_blank');
            });
        });
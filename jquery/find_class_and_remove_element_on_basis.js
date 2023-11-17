<!-- find class and remove element on basis  -->
setInterval(function() {
        jQuery('.kontact-form-gravity .gform_page').each(function() {
            if (jQuery(this).find('.gfield_radio').length > 0) {
                jQuery(this).find('.gform_page_footer').css({
                    'visibility': 'hidden',
                    'position': 'absolute',
                    'z-index': '-1'
                });
            }
        });
}, 10);
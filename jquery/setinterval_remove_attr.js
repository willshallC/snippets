<!-- setinterval remove attr  -->
jQuery(document).ready(function() {
    setInterval(function() {
        jQuery('.archive .site-inner .content-sidebar-wrap div#woocommerce-sidebar').removeClass('sticky-element-original element-is-sticky');
    }, 1);
});
jQuery(document).ready(function($) {
    $('.product-blog-manager-blog-dropdown').select2({
        placeholder: $(this).data('placeholder'),
        allowClear: true
    });
});

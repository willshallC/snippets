<!-- Go on specific element by selecting text after the hash in the URL from url  -->
jQuery(document).ready(function() {
  // Get the text after the hash in the URL
  var hashText = window.location.hash.substring(1);
  // Check if an element with the specified 'rel' attribute exists
  var $targetElement = jQuery('[rel="' + hashText + '"]');
  // If the element is found, set its offset from the top to 100px
  if ($targetElement.length > 0) {
    var offsetTop = $targetElement.offset().top - 10;
    jQuery('html, body').animate({
      scrollTop: offsetTop
    }, 1000);
  }
});
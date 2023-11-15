<!-- Get width and set in div  -->
$(document).ready(function() {
  var screenWidth = $(window).width();
  if (screenWidth > 1290) {
    $('.testi-main').css('max-width', '1290px');
  } else {
        $('.testi-main').css('max-width', screenWidth + 'px');
  }
});
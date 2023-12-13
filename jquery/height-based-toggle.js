jQuery(document).ready(function() {
    // Function to check the position of the div with class .toggle-opendd
    function checkPosition() {
      // Get the position of the .toggle-opendd div
      var position = jQuery('.toggle-opendd').offset().top;
      var positionn = jQuery('.toggle-area-wrapss').offset().top;
      // Calculate the final position with an offset of 30px
      var finalpos = Math.round(position - positionn + 60);
      jQuery('.active-times').css('height', finalpos + 'px');
    }
    // Call the function on document ready
    checkPosition();
    // Call the function on window resize (to handle dynamic changes)
    jQuery(document).on('click','.toggle-main-head', function (){
      setTimeout(function() {
        checkPosition();
    }, 500);
    });
  });
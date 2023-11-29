$(document).ready(function() {
    // Function to truncate text and add Read More button
    function truncateText(element, maxLength) {
      var content = element.html();
      var truncated = content.split(" ").splice(0, maxLength).join(" ");
      element.data('full-text', content); // Save the full content for later use
      element.data('truncated-text', truncated); // Save the truncated text for later use
      element.html(truncated + '... <a href="#" class="read-more">Read More</a>');
          // Truncate only if the content length exceeds the truncation value
          if (content.length > maxLength) {
            var truncated = content.substring(0, maxLength);
            element.data('truncated-text', truncated); // Save the truncated text for later use
            element.html(truncated + '... <a href="#" class="read-more">Read More</a>');
          } else {
            // Use the original content if not truncated
            element.html(content);
          }
    }
    // Apply the function to each element with the class 'feture_body_text'
    $('.review-bodyyy').each(function() {
      truncateText($(this), 35);
    });

});
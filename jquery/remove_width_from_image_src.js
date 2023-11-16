<!-- Remove width from image src  -->
$(document).ready(function() {
	// Select all image elements with URLs containing "-[width]x[height]"
	$("img").each(function() {
		// Get the original image URL
		var originalSrc = $(this).attr("src");
		// Use a regular expression to remove width and height parameters
		var newSrc = originalSrc.replace(/-\d+x\d+/, '');
		// Update the image src attribute with the modified URL
		$(this).attr("src", newSrc);
		$(this).removeAttr('srcset');
	});
}); 
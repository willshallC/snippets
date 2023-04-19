//Add this field in contact form
[hidden thankyouURL id:thankyouURL default:https://domain.com/thank-you/ "https://domain.com/thank-you/"]

//Then add this script
<script>
document.addEventListener( 'wpcf7mailsent', function( event ) {
    var thankyouURL = document.getElementById("thankyouURL").value;
    location = thankyouURL;
}, false );
</script>
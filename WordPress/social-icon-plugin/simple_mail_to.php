<?php
// Function to send an email
function sendEmail($recipient, $subject, $message) {
    $headers = "From: devformtesting@gmail.com"; // Replace with your email address
    return mail($recipient, $subject, $message, $headers);
}

// Example usage
$recipient = "ravi.kumar@willshall.com"; // Replace with the recipient's email address
$subject = "Test Email";
$message = "This is a test email sent from PHP.";

if (sendEmail($recipient, $subject, $message)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send the email. Please check your server configuration.";
}
?>

<?php
// Check for empty fields
if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo 'Please fill out all fields and provide a valid email address.';
  exit;
}

// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Set the recipient email address
$to = 'hexsbeats@gmail.com';

// Set the email subject and message
$email_subject = "Projet - New contact form submission: $subject";
$email_body = "You have received a new message from your website contact form.\n\n" .
              "Name: $name\n" .
              "Email: $email\n" .
              "Message:\n$message";

// Set the email headers
$headers = "From: $email\n";
$headers .= "Reply-To: $email\n";
$headers .= "Content-type: text/plain; charset=UTF-8\n";

// Send the email
if(mail($to, $email_subject, $email_body, $headers)) {
  http_response_code(200);
  echo 'Your message has been sent. Thank you!';
} else {
  http_response_code(500);
  echo 'Oops! Something went wrong and we could not send your message.';
}
?>
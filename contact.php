<?php
/*
  Free contact form processor – no external libraries, no cost
  Uses PHP mail() function – works on most shared hosting
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Invalid request.";
    exit;
}

// Honeypot anti-spam check
if (!empty($_POST['website'])) {
    // Spam bot – show fake success
    echo "success";
    exit;
}

// Get and sanitize form data
$name    = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) ?? '');
$email   = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
$subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING) ?? 'Contact Message');
$message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING) ?? '');

// Validation
if (empty($name) || empty($email) || empty($message)) {
    echo "Please fill in all required fields.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email address.";
    exit;
}

// Recipient
$to = "musaahmadfatima2@gmail.com";

// Email body
$body  = "New contact form submission:\n\n";
$body .= "Name:    $name\n";
$body .= "Email:   $email\n";
$body .= "Subject: $subject\n\n";
$body .= "Message:\n$message\n\n";
$body .= "Sent from: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";
$body .= "Time: " . date('Y-m-d H:i:s') . "\n";

// Headers
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send
if (mail($to, $subject, $body, $headers)) {
    echo "success";
} else {
    echo "Sorry, we could not send your message right now. Please try again or email us directly at info@dawakintofa.com";
}
?>
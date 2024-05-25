<?php
// Include the database configuration file
include 'config.php';

// Get feedback from POST request
$feedback = $_POST['feedback'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO suggestion (feedback) VALUES (?)");
$stmt->bind_param("s", $feedback);

// Execute the statement
if ($stmt->execute()) {
    // Send an email notification
    // $to = 'msahid.cse@gmail.com';
    // $subject = 'New Feedback/Suggestion';
    // $message = "You have received new feedback/suggestion: \n\n" . $feedback;
    // $headers = 'From: webmaster@yourwebsite.com' . "\r\n" .
    //            'Reply-To: webmaster@yourwebsite.com' . "\r\n" .
    //            'X-Mailer: PHP/' . phpversion();

    // mail($to, $subject, $message, $headers);

    echo 'Feedback submitted successfully!';
} else {
    echo 'Error: ' . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>

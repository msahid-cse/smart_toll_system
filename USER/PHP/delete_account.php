<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: user_login.php");
    exit();
}

// Include the database configuration file
include('../../config.php');

// Get the user's license number from the session
$license_number = $_SESSION['user_license_number'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if delete confirmation is received
    if (isset($_POST['confirm_delete'])) {
        // Delete the user's account from the database
        $delete_sql = $conn->prepare("DELETE FROM users WHERE license_number = ?");
        $delete_sql->bind_param("s", $license_number);
        
        if ($delete_sql->execute()) {
            // Account deleted successfully, logout user and redirect to login page
            session_unset();
            session_destroy();
            header("Location: user_login.php");
            exit();
        } else {
            $message = "Error deleting account. Please try again.";
        }

        $delete_sql->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
   <link rel="stylesheet" href="../CSS/delete_account_styles.css">
</head>
<body>
    <div class="container">
        <h1>Delete Account</h1>
        <p>Are you sure you want to delete your account?</p>
        <form method="POST">
            <button type="submit" name="confirm_delete">Delete Account</button>
            <button type="button" onclick="window.location.href='user_dashboard.php'">Cancel</button>
        </form>
        <?php if (isset($message)) { ?>
            <p class="message"><?php echo $message; ?></p>
        <?php } ?>
    </div>
</body>
</html>

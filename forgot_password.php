<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "spacy";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $newpassword = $_POST["newpassword"];
    $confirmnewpassword = $_POST["confirmnewpassword"];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address";
        echo "<script>alert('$message'); window.location.href='forgotPassword.html';</script>";
        exit();
    }

    // Validate password strength
    $passwordPattern = "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/";
    if (!preg_match($passwordPattern, $newpassword)) {
        $message = "Password must have minimum 8 characters, one uppercase character, one number, and one special character";
        echo "<script>alert('$message'); window.location.href='forgotPassword.html';</script>";
        exit();
    }

    // Confirm new password match
    if ($newpassword !== $confirmnewpassword) {
        $message = "Passwords do not match";
        echo "<script>alert('$message'); window.location.href='forgotPassword.html';</script>";
        exit();
    }

    // Check if the user exists
    $checkQuery = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Reset the password
        
        $resetPassword = password_hash($newpassword, PASSWORD_DEFAULT);

        // Update the user's password
        $updateQuery = "UPDATE users SET password='$resetPassword' WHERE email='$email'";
        if ($conn->query($updateQuery) === TRUE) {
            $message = "Your password has been reset. You can login now.";
            echo "<script>alert('$message'); window.location.href='login.html';</script>";
            exit();
        } else {
            $message = "Error updating password: " . $conn->error;
            echo "<script>alert('$message'); window.location.href='forgotPassword.html';</script>";
            exit();
        }
    } else {
        $message = "Email does not exist!";
        echo "<script>alert('$message'); window.location.href='forgotPassword.html';</script>";
        exit();
    }
}

$conn->close();
?>

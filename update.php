<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "spacy";

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $email = $_POST["email"];
    $password = $_POST["password"];
    $new_name = $_POST["new_name"];
    $new_email = $_POST["new_email"];
    
    // Retrieve user's hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE email= ?");
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row["password"];
    
        // Compare hashed passwords
        if (password_verify($password, $storedHashedPassword)) {
            // Update user's name and email
            $update_stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE email=?");
            if (!$update_stmt) {
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
                exit();
            }
            $update_stmt->bind_param("sss", $new_name, $new_email, $email);
            $update_stmt->execute();
            
            if ($update_stmt->affected_rows > 0) {
                echo "<script>alert('Account updated successfully. Please log in with your new email.'); window.location.href='Login.html';</script>";
            } else {
                echo "<script>alert('Failed to update account.'); window.location.href='update.html';</script>";
            }
            
            exit();
        } else {
            // Passwords do not match, update failed
            echo "<script>alert('Incorrect password!'); window.location.href='update.html';</script>";
            exit();
        }
    } else {
        // User does not exist
        echo "<script>alert('User not found!'); window.location.href='signup.html';</script>";
        exit();
    }
    
} else {
    // Invalid request method
    echo "Invalid request method";
}
?>

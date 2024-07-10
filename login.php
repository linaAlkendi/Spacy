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
    
    // Retrieve user's hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE email= ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row["password"];
    
        // Compare hashed passwords
        if (password_verify($password, $storedHashedPassword)) {
            // Passwords match, login successful
            // Redirect to home page
            header("Location: planetPage.html");
            exit();
        } else {
            // Passwords do not match, login failed
            echo "<script>alert('Incorrect password!'); window.location.href='Login.html';</script>";
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
